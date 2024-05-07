<?php

/*
 * This package will be using the Spatie Config File permission.php
 */
return [
    /*
     * This is the route of your home application.
     */
    'home' => 'admin.dashboard',

    /*
     * In case you want to change the route of the user management route.
     */
    'users_index' => 'admin.users',
    'users_management' => 'admin.users-management.index',

    /*
     * In case you want to change the route of the roles management route.
     */
    'roles_index' => 'admin.roles',

    /*
     * In case you want to change the route of the permissions management route.
     */
    'permissions_index' => 'admin.permissions',
    'gravatar_url' => 'https://www.gravatar.com/avatar/',
];
