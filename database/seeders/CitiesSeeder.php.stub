<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Papposilene\Geodata\Models\City;
use Papposilene\Geodata\Models\Country;
use Papposilene\Geodata\Models\Region;

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

        foreach (glob(storage_path('data/geodata/cities/*.json')) as $filename) {
            $file = File::get($filename);
            $name = File::name($filename);
            $json = json_decode($file, true);

            $country = Country::where('cca2', strtolower(Str::substr($name, 0, 2)))->first();

            foreach ($json as $data) {
                $parents = explode(',', $data['parents']);
                foreach($parents as $parent) {
                    $cleanParent[] = intval(preg_replace('/\D/', '', $parent));
                }

                $region = Region::whereIn('osm_id', $cleanParent)
                    ->orderBy('osm_admin_level', 'desc')->first();

                if(is_null($region)) { continue; }

                $translations = [];
                $getNames = $data['all_tags'];
                $getFiltered = array_filter($getNames, function($key) {
                    return str_starts_with($key, 'name:');
                }, ARRAY_FILTER_USE_KEY);
                foreach($getFiltered as $key => $value) {
                    $lang = explode(':', $key);
                    $translations = [$lang[1] => $value];
                }

                City::create([
                    'country_cca3' => $country->cca3,
                    'region_uuid' => (!empty($region) ? $region->uuid : null),
                    'osm_id' => intval(preg_replace('/\D/', '', $data['osm_id'])),
                    'osm_admin_level' => intval($data['admin_level']),
                    'osm_parents' => $cleanParent,
                    'osm_type' => (!is_null($data['boundary']) ? Str::slug($data['boundary'], '_') : null),
                    'name_loc' => $data['local_name'],
                    'name_eng' => (!is_null($data['name_en']) ? $data['name_en'] : $data['name']),
                    'name_translations' => json_encode($translations, JSON_FORCE_OBJECT),
                    'postcodes' => (array_key_exists('postal_code', $data['all_tags']) ? $data['all_tags']['postal_code'] : null),
                    'extra' => [
                        'wikidata' => (array_key_exists('wikidata', $data['all_tags']) ? $data['all_tags']['wikidata'] : null),
                    ],
                ]);
            }
        }
    }
}
