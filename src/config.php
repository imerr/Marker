<?php
return [
    /*
     * Location of the marker endpoint for post'ing actions to
     */
    'route' => '/marker',

    /*
     * Configures valid marker types
     */
    'types' => [
        /*'example' => [
            'view' => 'marker.example',
            'validator' => 'numeric|exists:states',
            // or 'validator' => function ($value) { return valid($value);},

            // Maximum amount of values to be stored, for performance reasons. Set to 0 for unlimited
            'max' => 10000,
        ]*/
    ],
];