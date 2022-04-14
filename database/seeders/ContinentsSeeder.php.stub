<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Papposilene\Geodata\Models\Continent;

class ContinentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(storage_path('data/geodata/countries/continents.json'));
        $json = json_decode($file);

        foreach ($json as $data) {
            $continent = Continent::where('name', $data->name)->firstOrFail();
            $continent->slug = Str::slug($data->name, '-');
            $continent->replaceTranslations('translations', (array) $data->translations);
            $continent->save();
        }
    }
}
