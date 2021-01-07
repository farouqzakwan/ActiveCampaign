<?php
return [
    'activecampaign_url'    => env('ACTIVECAMPAIGN_URL') ?? false,
    'activecampaign_key'    => env('ACTIVECAMPAIGN_KEY') ?? false,
    'ids' => [
        'list'  => [
            'contact_subscribe' => 1,
            'contact_unsubscribe' => 2,
            'contact_resubscribe' => 4
        ]
    ]
];