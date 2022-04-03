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

            $country = Country::where('cca2', strtolower(Str::substr($name, 0, 2)))->first();

            foreach ($json as $data) {
                $translations = [];
                $getNames = $data['all_tags'];
                $getFiltered = array_filter($getNames, function($key) {
                    return str_starts_with($key, 'name:');
                }, ARRAY_FILTER_USE_KEY);
                foreach($getFiltered as $key => $value) {
                    $lang = explode(':', $key);
                    $translations = [$lang[1] => $value];
                }

                Region::create([
                    'country_cca2' => $country->cca2,
                    'country_cca3' => $country->cca3,
                    'region_cca2' => (array_key_exists('ISO3166-2', $data['all_tags']) ? $data['all_tags']['ISO3166-2'] : null),
                    'osm_id' => intval(preg_replace('/\D/', '', $data['osm_id'])),
                    'osm_place_id' => null,
                    'osm_admin_level' => intval($data['admin_level']),
                    'osm_type' => (!is_null($data['boundary']) ? Str::slug($data['boundary'], '_') : $data['unknown']),
                    'name_loc' => $data['local_name'],
                    'name_eng' => (!is_null($data['name_en']) ? $data['name_en'] : $data['name']),
                    'name_translations' => json_encode($translations, JSON_FORCE_OBJECT),
                    'extra' => [
                        'wikidata' => (array_key_exists('wikidata', $data['all_tags']) ? $data['all_tags']['wikidata'] : null),
                    ],
                ]);
            }
        }
    }
}
