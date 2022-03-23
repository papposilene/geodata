<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Papposilene\Geodata\Models\Continent;
use Papposilene\Geodata\Models\Country;
use Papposilene\Geodata\Models\Subcontinent;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Drop the tables
        DB::table('geodata__continents')->delete();
        DB::table('geodata__subcontinents')->delete();
        DB::table('geodata__countries')->delete();

        $file = File::get(storage_path('data/geodata/countries/countries.json'));
        $json = json_decode($file);

        foreach ($json as $data) {
            if (property_exists($data, 'geo')) {
                $region = $data->geo->region;
                $subregion = $data->geo->subregion;
                $landlocked = $data->geo->landlocked;
                $independent = (bool) ($data->geo->independent === true ? true : false);
                $lat = $data->geo->latlng[1];
                $lon = $data->geo->latlng[0];
            } else {
                $region = $data->region;
                $subregion = $data->subregion;
                $landlocked = $data->landlocked;
                $independent = (bool) ($data->independent === true ? true : false);
                $lat = $data->latlng[1];
                $lon = $data->latlng[0];
            }

            $flag = '🏳️';
            if (property_exists($data, 'flag')) {
                $flag = $data->flag;
            }
            if (property_exists($data, 'flag') && property_exists($data->flag, 'emoji')) {
                $flag = $data->flag->emoji;
            }

            if (property_exists($data, 'dialling')) {
                $dialling = json_encode($data->dialling, JSON_FORCE_OBJECT);
            }
            elseif (property_exists($data, 'callingCodes')) {
                $dialling = json_encode($data->callingCodes, JSON_FORCE_OBJECT);
            }
            else {
                $dialling = null;
            }

            $continent = Continent::firstOrCreate(
                [
                    'name' => $region
                ],
                [
                    'slug' => Str::slug($region, '-'),
                ]
            );

            $subcontinent = Subcontinent::firstOrCreate(
                [
                    'name' => $subregion
                ],
                [
                    'slug' => Str::slug($subregion, '-'),
                    'continent_id' => $continent->id,
                ]
            );

            Country::create([
                'continent_id'      => $continent->id,
                'subcontinent_id'   => $subcontinent->id,
                // Various identifiant codes
                'cca2'              => strtolower($data->cca2),
                'cca3'              => strtolower($data->cca3),
                'ccn3'              => (is_string($data->ccn3) ? strtolower($data->ccn3) : null),
                // Name, common and formal, in english
                'name_eng_common'   => addslashes($data->name->common),
                'name_eng_formal'   => addslashes($data->name->official),
                // Centered geolocation (for mainland if necessary)
                'lat'               => (float) $lat,
                'lon'               => (float) $lon,
                // Borders
                'landlocked'        => (bool) $landlocked,
                'neighbourhood'     => (empty($data->borders) ? 'null' : json_encode($data->borders, JSON_FORCE_OBJECT)),
                // Geopolitc status
                'status'            => $data->status,
                'independent'       => $independent,
                // Flag
                'flag'              => $flag,
                // Extra
                'dialling'          => $dialling,
                'currencies'        => json_encode($data->currencies, JSON_FORCE_OBJECT),
                'capital'           => json_encode($data->capital, JSON_FORCE_OBJECT),
                'demonyms'          => json_encode($data->demonyms, JSON_FORCE_OBJECT),
                'languages'         => json_encode($data->languages, JSON_FORCE_OBJECT),
                'name_native'       => json_encode($data->name->native, JSON_FORCE_OBJECT),
                'name_translations' => json_encode($data->translations, JSON_FORCE_OBJECT),
                'extra' => json_encode([
                    'un_member' => (property_exists($data, 'un_member') && $data->un_member ? true : false),
                    'eu_member' => (property_exists($data, 'eu_member') ? true : false),
                    'wikidata' => (property_exists($data, 'wikidataid') ? $data->wikidataid : null),
                    'woe_id' => (property_exists($data, 'woe_id') ? $data->woe_id : null),
                ], JSON_FORCE_OBJECT),
            ]);
        }
    }
}
