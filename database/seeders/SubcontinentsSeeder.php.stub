<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Papposilene\Geodata\Models\Subcontinent;

class SubcontinentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(storage_path('data/geodata/countries/subcontinents.json'));
        $json = json_decode($file);

        foreach ($json as $data) {
            $subcontinent = Subcontinent::where('name', $data->name)->firstOrFail();
            $subcontinent->slug = Str::slug($data->name, '-');
            $subcontinent->replaceTranslations('translations', (array) $data->translations);
            $subcontinent->save();
        }
    }
}
