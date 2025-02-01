<?php

namespace App\Services;

use App\Models\Picture;
use App\Models\Ville;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use App\Exceptions\ImmoApiException;
use function PHPUnit\Framework\isEmpty;

class VilleService
{
    
    //Create Ville
    function CreateVille($name, $image)
    {
        //Verify if ville with this name exist or not
        $foundVille = Ville::where(DB::raw('lower(name)'),Str::lower($name))->first();
        if ($foundVille) {
            throw new ImmoApiException("Une ville existe déjà avec ce nom. Veillez corriger puis réesayer!");
        }
        $ville = new Ville();
        $ville->name = $name;
        //Add picture to database
        if ($image) {
            $filename = Str::random(32) . "." . $image->getClientOriginalExtension();
            $path = $image->move('files/', $filename);

            $picture = Picture::create([
                'name' => $filename,
                'path' => $path
            ]);
            $ville->picture_id = $picture->id;
        }

        $ville->save();
        return $ville;
    }


    //Show all villes
    function ShowVille($inputData)
    {
        $is_paginated = $inputData["is_paginated"] ?? false;
        $per_page = $inputData["per_page"] ?? 10;
        if ($is_paginated) {
            if (array_key_exists('search', $inputData)) {
                $search = $inputData["search"];
                $ville = Ville::where('name', 'like', "%$search%")
                    ->with('quartiers')
                    ->orderBy('created_at', 'DESC')
                    ->paginate($per_page);
            } else {
                $ville = Ville::with('quartiers', 'picture')->orderBy('created_at', 'DESC')->paginate($per_page);
            }
        } else {
            $ville = Ville::with('quartiers')->orderBy('id', 'ASC')->get();
        }

        return  $ville;
    }

    //Show single ville
    function ShowSingleVille($id)
    {
        $ville = Ville::with('quartiers', 'picture')->where('id', '=', $id)->get();

        return $ville;
    }


    //Delete ville
    function DeleteVille($id)
    {
        $idVille = Ville::where('id', '=', $id)->get();
        if ($idVille->isEmpty()) {
            throw new ImmoApiException("Cette ville n'existe pas. Veuillez corriger puis réessayer");
        }

        $foundVille = $idVille->first();
        $picture = Picture::where('id', $foundVille->picture_id)->first();
        if ($picture) {
            //Delete the picture in the storage
            $filePath = public_path()."/".$picture->path;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            //Delete the picture
            $picture->delete();
        }

        $foundVille->delete();
        return $foundVille;
    }

    // //Update Ville
    function UpdateVille($id, $name, $image){
        $ville = Ville::find($id);
        if (!$ville) {
            throw new ImmoApiException("Cette ville n'existe pas. Veuillez corriger puis réessayer");
        }
        $ville->id = $id;
        $ville->name = $name;
        //Add picture to database

        //Insert file to database
        if ($image) {
            // foreach ($request->file('images') as $image) {
            $filename = Str::random(32) . "." . $image->getClientOriginalExtension();
            $path = $image->move('files/', $filename);

            $picture = Picture::create([
                'name' => $filename,
                'path' => $path
            ]);
            $ville->picture_id = $picture->id;
        }

        return $ville;
    }
}
