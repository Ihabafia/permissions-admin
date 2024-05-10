<?php

namespace IhabAfia\PermissionsAdmin\Models;

use IhabAfia\PermissionsAdmin\Traits\HasPermissionAdmin;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasPermissionAdmin;
}
