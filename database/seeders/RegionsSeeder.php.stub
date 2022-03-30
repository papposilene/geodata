<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
            $json = json_decode($file);

            foreach ($json as $data) {
                $country = Country::where('cca2', strtolower($name))->first();

                // Get all translations for the administrative levels
                $translations = array_filter(json_decode($data->all_tags, true), function($key) {
                    return str_starts_with($key, 'name:');
                }, ARRAY_FILTER_USE_KEY);
                foreach($translations as $key => $value) {
                    $lang = explode(':', $key);
                    $translations[] = [$lang[1] => $value];
                }

                Region::create([
                    'country_cca2' => (string) $country->cca2,
                    'country_cca3' => (string) $country->cca3,
                    'region_cca2' => (string) $country->cca2,
                    'osm_place_id' => (int) $country->osm_id,
                    'admin_level' => (int) $country->admin_level,
                    'name_loc' => (string) $country->local_name,
                    'name_eng' => (string) $country->name_en,
                    'name_translations' => $translations,
                    'extra' => [
                        'wikidata' => $data->all_tags->wikidata,
                    ],
                ]);
            }
        }
    }
}
