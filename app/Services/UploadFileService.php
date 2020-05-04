<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use \Illuminate\Http\UploadedFile;

class UploadFileService
{

    public function execute(UploadedFile $file)
    {
        $filename = Str::uuid() . '.jpg';
        $file->storeAs('public/tmp', $filename);

        $client = new Client([
            'base_uri' => 'http://api.medeirossouza.com',
        ]);

        $client->request('POST', '/api/files', [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen(public_path() . '/storage/tmp/' . $filename, 'r'),
                    'filename' => $filename,
                ]
            ]
        ]);

        Storage::delete('/public/tmp/' . $filename);

        return $filename;
    }
}
