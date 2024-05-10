<?php

namespace IhabAfia\PermissionsAdmin\Models;

use IhabAfia\PermissionsAdmin\Traits\HasPermissionAdmin;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Traits\HasRoles;

class Role extends SpatieRole
{
    use HasPermissionAdmin;
    use HasRoles;
}
