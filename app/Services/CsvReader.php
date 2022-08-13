<?php

namespace App\Services;

use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CsvReader implements CsvReaderInterface
{
    const FORMAT = 'csv';

    /**
     * @param string $file
     * @return mixed
     */
    public function decode(string $file): mixed
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);
        return $serializer->decode(file_get_contents($file), self::FORMAT);
    }

}
