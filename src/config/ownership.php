<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allow Admin Override
    |--------------------------------------------------------------------------
    |
    | This value allows an admin to override the ownership check
    |
    */

    'allow_admin_override' => true,

    'user' => [

        // This value is the method on the User model used to check for admin privileges
        'admin_check' => 'isAdmin',

        // This value is the method on the User model used to check for ownership of the model
        'ownership_check' => 'owns',

    ]

];