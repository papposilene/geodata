<?php

return [

    'options' => [

        /*
         * You can decide to activate or desactivate some geodata sets.
         * Continents, subcontinents and countries are amndatory datasets and
         * can not be desactivate.
         */

        'currencies' => true,
        'flags' => false,
        'geometries' => false,
        'topologies' => false,

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
         * The model you want to use as a Currency model needs to implement the
         * `Papposilene\Geodata\Contracts\Currency` contract.
         */

        'currencies' => Papposilene\Geodata\Models\Currency::class,

    ],

];
