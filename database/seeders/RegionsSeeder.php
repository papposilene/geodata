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

        $file = File::get(storage_path('data/geodata/administrative-levels/*.json'));
        $json = json_decode($file);

        foreach ($json as $data) {

            Country::create([
                'continent_slug'      => $continent->slug,
                'subcontinent_slug'   => $subcontinent->slug,
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
