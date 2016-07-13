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
        'example' => [
            'view' => 'marker.example',
            'validator' => 'numeric|exists:examples',
            // or 'validator' => function ($value) { return valid($value);},

            // Maximum amount of values to be stored, for performance reasons. Set to 0 for unlimited
            'max' => 10000,
            // options/actions for this type
            'options' => [
                'some.example.route' => [
                    'name' => 'some.example.translation_key', // translation key
                    // [optional] extra parameters passed to route() call
                    'routeParam' => [],
                    // [optional] nested actions, will show actions of another typ in a nested menu
                    // only shows one level of nesting
                    // nested action will be appended at a GET action parameter
                    // for example: user is selected
                    // "select articles >" "delete"
                    //                     "recover"
                    'nested' => 'othertype',
                    // [optional] display condition
                    'condition' => function () {
                        return true;
                    }
                ]
            ]
        ]
    ],

];