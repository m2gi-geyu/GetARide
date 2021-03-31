<?php

return [
    'notificationType' => [
        'trip_canceled'         => 'App\Notifications\trip\tripCanceled',
        'trip_request'          => 'App\Notifications\trip\tripRequest',
        'trip_request_canceled' => 'App\Notifications\trip\tripRequestCanceled',
        'trip_request_accepted' => 'App\Notifications\trip\tripRequestAccepted',
        'trip_request_refused'  => 'App\Notifications\trip\tripRequestRefused',
        'new_private_trip'      => 'App\Notifications\trip\newPrivateTrip',
    ],

    'genderType' => [
        //...
    ]
];

