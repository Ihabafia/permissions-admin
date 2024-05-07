<?php

/*
 * This package will be using the Spatie Config File permission.php
 */
return [
    /*
     * This is the route of your home application for admins.
     */
    'admin-home' => 'dashboard',

    /*
     * This is the route of your home application for users (it can be the same as the above).
     */
    'user-home' => 'dashboard',

    /*
     * This is the route of your user profile.
     */
    'user-profile' => 'user/profile',

    /*
     * In case you want to change the route of the user management route.
     */
    'users-index' => 'users',

    /*
     * In case you want to change the route of the roles management route.
     */
    'roles-index' => 'roles',

    /*
     * In case you want to change the route of the permissions management route.
     */
    'permissions-index' => 'permissions',

    /*
     * Using Gravatar in the Users list (Pending)
     */
    'use-gravatar' => false,

    /*
     * The url to Gravatar website. (Pending)
     */
    'gravatar_url' => 'https://www.gravatar.com/avatar/',
];
