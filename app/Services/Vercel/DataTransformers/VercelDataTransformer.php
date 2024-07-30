<?php

namespace App\Services\Vercel\DataTransformers;

class VercelDataTransformer
{
    protected array $nestedArray = [];

    public function transform(array $data): array
    {
        foreach ($data['items'] as $item) {

            [$ip, $pathSegments, $fileName] = $this->parseUrlSegments($item['fileUrl']);

            $this->addSegmentsToNestedArray($ip, $pathSegments, $fileName);
        }

        return $this->nestedArray;
    }

    protected function parseUrlSegments($url): array
    {
        $parsedUrl = parse_url($url);
        $ip = $parsedUrl['host'];
        $pathSegments = explode('/', ltrim($parsedUrl['path'], '/'));
        $fileName = ! empty(end($pathSegments)) ? array_pop($pathSegments) : null;

        return [$ip, $pathSegments, $fileName];
    }

    protected function addSegmentsToNestedArray($ip, $pathSegments, $fileName)
    {
        $pointer = &$this->nestedArray[$ip];

        foreach ($pathSegments as $segment) {
            if (! empty($segment)) {
                $pointer = &$this->getOrCreateNestedArray($pointer, $segment);
            }
        }

        if ($fileName !== null) {
            $pointer[] = $fileName;
        }
    }

    protected function &getOrCreateNestedArray(&$array, string $key): array
    {
        if (is_array($array)) {
            foreach ($array as &$subArray) {
                if (isset($subArray[$key]) && is_array($subArray[$key])) {
                    return $subArray[$key];
                }
            }
        }

        $array[] = [$key => []];

        return $array[count($array) - 1][$key];
    }
}
