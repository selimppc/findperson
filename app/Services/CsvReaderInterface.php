<?php

namespace App\Services;

interface CsvReaderInterface
{
    public function decode(string $file): mixed;
}
