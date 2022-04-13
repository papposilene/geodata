<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\City;
use App\Models\Region;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Papposilene\Geodata\Models\Country;

class AddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nominatim's Usage Policy
        // @see https://operations.osmfoundation.org/policies/nominatim/
        $userAgent = env('MAIL_FROM_ADDRESS', new \Exception('No MAIL_FROM_ADDRESS key into you .env'));

        // Drop the table
        DB::table('addresses__')->delete();
        DB::table('geodata__cities')->delete();

        foreach (glob(storage_path('data/addresses/*.json')) as $filename) {
            $file = File::get($filename);
            $json = json_decode($file);

            $country = Country::where('cca3', $json->country_cca3)->firstOrFail();

            foreach ($json->addresses as $data) {
                $isCity = null;
                $isRegion = null;
                $cityPlaceId = null;
                $adminLevels = [];
                $placeId = $data->geolocation->osm_place_id;

                $dataJson = file_get_contents('https://nominatim.openstreetmap.org/details.php?addressdetails=1&format=json&email='.$userAgent.'&place_id=' . $placeId);
                $dataFile = json_decode($dataJson, true);

                $isCity = City::where('country_cca3', $country->cca3)
                    ->where('name_translations', 'like', '%'.$data->address->city.'%')
                    ->first();

                if(!is_null($isCity)) {
                    $city = $isCity;
                } else {
                    $getLevels = $dataFile['address'];
                    foreach($getLevels as $key => $value) {
                        if ($value['osm_type'] === 'R' && ($value['admin_level'] === 8 || $value['admin_level'] === 7 || $value['admin_level'] === 6 || $value['admin_level'] === 4)) {
                            $adminLevels[] = $dataFile['address'][$key]['place_id'];
                        }
                    }

                    krsort($adminLevels);
                    $isRegion = Region::whereIn('osm_place_id', $adminLevels)->orderBy('osm_admin_level', 'asc')->first();

                    $cityName = $data->address->city;
                    $cityJson = file_get_contents('https://nominatim.openstreetmap.org/search.php?limit=1&format=jsonv2&extratags=1&namedetails=1&email='.$userAgent.'&countrycodes='.$data->address->country_cca3.'&city='.urlencode($cityName));
                    $cityData = json_decode($cityJson, true);

                    $translations = [];
                    $getNames = $cityData[0]['namedetails'];
                    $getFiltered = array_filter($getNames, function($key) {
                        return str_starts_with($key, 'name:');
                    }, ARRAY_FILTER_USE_KEY);
                    foreach($getFiltered as $key => $value) {
                        $lang = explode(':', $key);
                        $translations[$lang[1]] = $value;
                    }

                    $cityDisplayName = explode(', ', $cityData[0]['display_name']);
                    $city = City::firstOrCreate(
                        [
                            'country_cca3' => $country->cca3,
                            'osm_place_id' => $cityPlaceId,
                        ],
                        [
                            'region_uuid' => ($isRegion ? $isRegion->uuid : null),
                            'osm_id' => $cityData[0]['osm_id'],
                            'osm_place_id' => $cityData[0]['place_id'],
                            'osm_admin_level' => $cityData[0]['place_rank'],
                            'osm_type' => $cityData[0]['type'],
                            'name_local' => (count($cityDisplayName) > 0 ? $cityDisplayName[0] : $cityData[0]['display_name']),
                            'name_slug' => (count($cityDisplayName) > 0 ? Str::slug($cityDisplayName[0], '-') : Str::slug($cityData[0]['display_name'], '-')),
                            'name_translations' => json_encode($translations, JSON_FORCE_OBJECT),
                            'postcodes' => null,
                            'extra' => [
                                'un_locode' => (array_key_exists('un_locode', $cityData[0]['extratags']) ? $cityData[0]['un_locode'] : null),
                                'wikidata' => (array_key_exists('wikidata', $cityData[0]['extratags']) ? $cityData[0]['extratags']['wikidata'] : null),
                            ],
                        ]
                    );
                }

                $subcategory = Subcategory::where('slug', Str::slug($data->category->type, '-'))
                    ->firstOrFail();

                Address::create([
                    'place_name' => Str::of($data->names->name)->trim(),
                    'place_status' => $data->details->status,
                    'address_number' => (!empty($data->address->number) ? $data->address->number : null),
                    'address_street' => (!empty($data->address->street) ? Str::of($data->address->street)->trim() : null),
                    'address_postcode' => (!empty($data->address->postcode) ? Str::of($data->address->postcode)->trim() : null),
                    //'address_city' => $city->name_translations,
                    'city_uuid' => $city->uuid,
                    'region_uuid' => $city->region_uuid,
                    'country_cca3' => $country->cca3,
                    'address_lat' => (float)$data->geolocation->lat,
                    'address_lon' => (float)$data->geolocation->lon,
                    'description' => Str::of($data->details->description)->trim(),
                    'details' => [
                        'opening_hours' => $data->details->opening_hours,
                        'phone' => $data->details->phone,
                        'website' => $data->details->website,
                        'wikidata' => $data->details->wikidata,
                    ],
                    'subcategory_slug' => $subcategory->slug,
                    'osm_place_id' => (int)$data->geolocation->osm_place_id,
                    'gmap_pluscode' => (string)$data->geolocation->gmaps_pluscode,
                ]);
            }
        }
    }
}
