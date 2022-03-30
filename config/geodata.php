<?php

return [

    'options' => [

        /**
         * You can decide to activate or desactivate some geodata sets.
         * Continents, subcontinents, countries, cities and currencies
         * are mandatory datasets and can not be desactivate.
         */

        'flags' => true,

    ],

    'models' => [

        /**
         * The model you want to use as a Continent model needs to implement the
         * `Papposilene\Geodata\Models\Continent` model.
         */
        'continents' => Papposilene\Geodata\Models\Continent::class,

        /**
         * The model you want to use as a Subcontinent model needs to implement the
         * `Papposilene\Geodata\Models\Subcontinent` model.
         */
        'subcontinents' => Papposilene\Geodata\Models\Subcontinent::class,

        /**
         * The model you want to use as a Country model needs to implement the
         * `Papposilene\Geodata\Models\Country` model.
         */
        'countries' => Papposilene\Geodata\Models\Country::class,

        /**
         * The model you want to use as a Region model needs to implement the
         * `Papposilene\Geodata\Models\Region` model.
         */

        'regions' => Papposilene\Geodata\Models\Region::class,

        /**
         * The model you want to use as a City model needs to implement the
         * `Papposilene\Geodata\Models\City` model.
         */
        'cities' => Papposilene\Geodata\Models\City::class,

        /**
         * The model you want to use as a Currency model needs to implement the
         * `Papposilene\Geodata\Models\Currency` model.
         */

        //'currencies' => Papposilene\Geodata\Models\Currency::class,

    ],

];
