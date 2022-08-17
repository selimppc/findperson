<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Services\CsvReader;

class PersonDataSeeder extends Seeder
{
    const CHUNK_SIZE = 1000;

    /**
     * Run the database seeds.
     *
     * @param CsvReader $csvReader
     * @return void
     */
    public function run(CsvReader $csvReader): void
    {
        $dataFileKey = config('config.CSV_DATA_FILE_KEY');
        $dataFile = resource_path($dataFileKey);
        $result = $csvReader->decode($dataFile);
        $this->bulkInsert($result);
        echo "= DONE =";
    }

    /**
     * @param array $result
     * @return void
     */
    private function bulkInsert(array $result): void
    {
        $chunkedData = $this->chunkData($result);
        foreach ($chunkedData as $data)
        {
            echo "inserting ".self::CHUNK_SIZE."...";
            $this->insertToTable($data);
        }
    }

    /**
     * @param $data
     * @return void
     */
    private function insertToTable($data): void
    {
        DB::disableQueryLog();
        foreach ($data as $item) {
            if (isset($item['Birthday'])){
                DB::table('persons')->insert([
                    'id' => $item['ID'],
                    'email' => $item['Email Address'] ?? '',
                    'name' => $item['Name'] ?? '',
                    'birth_date' => $item['Birthday'],
                    'phone' => $item['Phone'] ?? '',
                    'ip' => $item['IP'] ?? '',
                    'country' => $item['Country'] ?? '',
                    'created_at' => now(),
                ]);
            }
        }

    }

    /**
     * @param array $result
     * @return array
     */
    private function chunkData(array $result): array
    {
        return array_chunk($result, self::CHUNK_SIZE);
    }

}
