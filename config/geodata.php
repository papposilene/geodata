<?php

return [

    'options' => [

        /*
         * You can decide to activate or desactivate some geodata sets.
         * Continents, subcontinents, countries, cities and currencies
         * are mandatory datasets and can not be desactivate.
         */

        'flags' => true,

    ],

    'models' => [

        /*
         * The model you want to use as a Continent model needs to implement the
         * `Papposilene\Geodata\Contracts\Continent` contract.
         */

        'continents' => Papposilene\Geodata\Models\Continent::class,

        /*
         * The model you want to use as a Subcontinent model needs to implement the
         * `Papposilene\Geodata\Contracts\Subcontinent` contract.
         */

        'subcontinents' => Papposilene\Geodata\Models\Subcontinent::class,

        /*
         * The model you want to use as a Country model needs to implement the
         * `Papposilene\Geodata\Contracts\Country` contract.
         */

        'countries' => Papposilene\Geodata\Models\Country::class,

        /*
         * The model you want to use as a City model needs to implement the
         * `Papposilene\Geodata\Contracts\City` contract.
         */

        'cities' => Papposilene\Geodata\Models\City::class,

        /*
         * The model you want to use as a Currency model needs to implement the
         * `Papposilene\Geodata\Contracts\Currency` contract.
         */

        'currencies' => Papposilene\Geodata\Models\Currency::class,

    ],

];
