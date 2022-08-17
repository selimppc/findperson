<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Services\CsvReader;

class PersonDataSeeder extends Seeder
{

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

        $data = [];
        foreach ($result as $item){
            if (isset($item['Birthday'])) {
                $person =[
                    'id' => $item['ID'],
                    'email' => $item['Email Address'] ?? '',
                    'name' => $item['Name'] ?? '',
                    'birth_date' => $item['Birthday'],
                    'phone' => $item['Phone'] ?? '',
                    'ip' => $item['IP'] ?? '',
                    'country' => $item['Country'] ?? '',
                    'created_at' => now(),
                ];
                $data[] = $person;
            }
        }
        DB::table('persons')->insert($data);
    }
}
