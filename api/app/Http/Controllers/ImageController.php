<?php

namespace App\Http\Controllers;

use App\Http\Requests\chunkUploadRequest;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImageController extends Controller
{

    public function chunk_upload(chunkUploadRequest $request)
    {
        $file = $request->file('file');
        $path = Storage::disk('local')->path("public/chunks/{$request->filename}");

        File::append($path, $file->get());
        $name = '';
        if ($request->has('is_last') && $request->boolean('is_last')) {
            $name = Str::random() . '_image.' . $request->ext;
            if (Storage::move("public/chunks/{$request->filename}", "public/gallery/{$name}")) {
                $img = Image::create([
                    'filename' => $name,
                ]);
                return response()->json(['id' => $img['id'], 'message' => 'success']);
            } else {
                return response()->json(['id' => null, 'message' => 'ongoing']);
            }
        }
        return response()->json(['id' => null]);
    }


    public function preview_image(Request $request, $file_name)
    {
        if (file_exists(storage_path('/app/public/gallery/' . $file_name))) {
            $pathToFile = storage_path('/app/public/gallery/' . $file_name);
            $ext = pathinfo($pathToFile, PATHINFO_EXTENSION);
            $headers = ['Content-Type' => 'image/' . $ext];
            return response()->file($pathToFile, $headers);
        } else {
            return response(['message' => 'Image Not Found!'], 404);
        }
    }
}
