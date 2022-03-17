<?php

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
            $continent = Continent::firstOrCreate(
                [
                    'name' => $data->region
                ],
                [
                    'slug' => Str::slug($data->region, '-'),
                ]
            );

            $subcontinent = Subcontinent::firstOrCreate(
                [
                    'name' => $data->subregion
                ],
                [
                    'slug' => Str::slug($data->subregion, '-'),
                    'continent_id' => $continent->id,
                ]
            );

            Country::create([
                'continent_id'      => $continent->id,
                'subcontinent_id'   => $subcontinent->id,
                // Various identifiant codes
                'cca2'              => $data->cca2,
                'cca3'              => $data->cca3,
                'ccn3'              => $data->ccn3,
                'cioc'              => $data->cioc,
                // Name, common and formal, in english
                'name_eng_common'   => addslashes($data->name->common),
                'name_eng_formal'   => addslashes($data->name->official),
                // Centered geolocation (for mainland if necessary)
                'lat'               => (float) $data->latlng[1],
                'lon'               => (float) $data->latlng[0],
                // Borders
                'landlocked'        => (bool) ($data->landlocked === true ? 'true' : 'false'),
                'neighbourhood'     => (empty($data->borders) ? 'null' : json_encode($data->borders, JSON_FORCE_OBJECT)),
                // Geopolitc status
                'status'            => $data->status,
                'independent'       => (bool) ($data->independent === true ? 'true' : 'false'),
                'un_member'         => (bool) ($data->unMember === true ? 'true' : 'false'),
                // Flag
                'flag'              => $data->flag,
                // Extra
                'idd'               => json_encode($data->idd, JSON_FORCE_OBJECT),
                'capital'           => json_encode($data->capital, JSON_FORCE_OBJECT),
                'currencies'        => json_encode($data->currencies, JSON_FORCE_OBJECT),
                'demonyms'          => json_encode($data->demonyms, JSON_FORCE_OBJECT),
                'languages'         => json_encode($data->languages, JSON_FORCE_OBJECT),
                'name_native'       => json_encode($data->name->native, JSON_FORCE_OBJECT),
                'name_translations' => json_encode($data->translations, JSON_FORCE_OBJECT)
            ]);
        }
    }
}
