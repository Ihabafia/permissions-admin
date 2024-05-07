<?php

namespace IhabAfia\PermissionsAdmin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IhabAfia\PermissionsAdmin\PermissionsAdmin
 */
class PermissionsAdmin extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \IhabAfia\PermissionsAdmin\PermissionsAdmin::class;
    }
}
