<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Papposilene\Geodata\Models\Country;
use Papposilene\Geodata\Models\Region;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Drop the tables
        DB::table('geodata__regions')->delete();

        foreach (glob(storage_path('data/geodata/administrative-levels/*.json')) as $filename) {
            $file = File::get($filename);
            $name = File::name($filename);
            $json = json_decode($file, true);

            $country = Country::where('cca3', $name)->firstOrFail();

            foreach ($json as $data) {
                Region::create([
                    'country_cca2' => $country->cca2,
                    'country_cca3' => $country->cca3,
                    'region_cca2' => $data['region_cca2'],
                    'osm_id' => $data['osm_id'],
                    'osm_place_id' => $data['osm_place_id'],
                    'osm_admin_level' => $data['osm_admin_level'],
                    'osm_type' => $data['osm_type'],
                    'name_loc' => $data['name_loc'],
                    'name_eng' => $data['name_eng'],
                    'name_translations' => json_encode($data['name_translations'], JSON_FORCE_OBJECT),
                    'extra' => [
                        'un_locode' => (array_key_exists('un_locode', $data['extra']) ? $data['extra']['un_locode'] : null),
                        'wikidata' => (array_key_exists('wikidata', $data['extra']) ? $data['extra']['wikidata'] : null),
                    ],
                ]);
            }
        }
    }
}
