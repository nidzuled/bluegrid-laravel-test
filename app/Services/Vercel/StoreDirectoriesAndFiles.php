<?php

namespace App\Services\Vercel;

use App\Models\Directory;
use App\Models\File;

class StoreDirectoriesAndFiles
{
    public function handle(array $data)
    {
        foreach ($data['items'] as $item) {

            [$directoryNames, $fileName] = $this->parseUrlSegments($item['fileUrl']);

            $this->storeDirectoriesAndFiles($directoryNames, $fileName);
        }
    }

    protected function parseUrlSegments($url): array
    {
        $parsedUrl = parse_url($url);
        $directoryNames = explode('/', ltrim($parsedUrl['path'], '/'));
        $fileName = ! empty(end($directoryNames)) ? array_pop($directoryNames) : null;

        return [$directoryNames, $fileName];
    }

    protected function storeDirectoriesAndFiles($directoryNames, $fileName)
    {
        if (count($directoryNames) === 0) {
            if ($fileName !== null) {
                File::firstOrCreate(['name' => $fileName, 'directory_id' => null]);
            }

            return;
        }

        if (! empty($directoryNames[0])) {
            $directory = Directory::firstOrCreate(['name' => $directoryNames[0], 'parent_id' => null]);
            array_shift($directoryNames);
        }

        foreach ($directoryNames as $directoryName) {
            if (! empty($directoryName)) {
                $directory = Directory::firstOrCreate(['name' => $directoryNames[0], 'parent_id' => $directory->id]);
            }
        }

        if ($fileName !== null) {
            File::firstOrCreate(['name' => $fileName, 'directory_id' => $directory->id]);
        }
    }
}
