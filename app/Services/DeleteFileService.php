<?php

namespace App\Services;

use GuzzleHttp\Client;

class DeleteFileService {

    public function execute($filename)
    {
        $client = new Client([
            'base_uri' => 'http://api.medeirossouza.com',
        ]);

        $client->request('DELETE', '/api/files/'. $filename);

        return;
    }
}
