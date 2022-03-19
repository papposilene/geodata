<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Papposilene\Geodata\Models\City;
use Papposilene\Geodata\Models\Country;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Drop the tables
        DB::table('geodata__cities')->delete();

        $replaceCca3 = [
            'CYN' => 'CYP',
            'SOL' => 'SOM',
        ];

        foreach (glob(storage_path('data/geodata/cities/*.json')) as $filename) {
            $file = File::get($filename);
            $json = json_decode($file);

            foreach ($json as $data) {
                $cca3 = $replaceCca3[$data->cca3] ?? $data->cca3;
                $country = Country::where('cca3', $cca3)->first();

                City::create([
                    'country_cca3' => $country->cca3,
                    'state' => ($data->adm1name ? $data->adm1name : null),
                    'name' => $data->name,
                    'lat' => (float) $data->latitude,
                    'lon' => (float) $data->longitude,
                    'postcodes' => null,
                    'extra' => json_encode([
                        'ne_id' => $data->ne_id,
                        'wikidata' => $data->wikidataid,
                        'wof_id' => $data->wof_id,
                    ], JSON_FORCE_OBJECT),
                ]);
            }
        }
    }
}
