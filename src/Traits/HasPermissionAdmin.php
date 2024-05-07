<?php

namespace IhabAfia\PermissionsAdmin\Traits;

trait HasPermissionAdmin
{
    public function getGravatar(): string
    {
        return config('permission-admin.gravatar_url').md5($this->email);
    }

    public function getAllRoleNames(string $as = 'string'): array|string|null
    {
        $roles = $this->getRoleNames()->toArray();

        if ($as == 'array') {
            return $roles;
        }

        $collection = collect([]);
        $array = [];

        foreach ($roles as $key => $label) {
            $array[$label] = $label;
            $collection->push($label);
        }

        if ($as == 'select') {
            return $array;
        }

        if ($as == 'string') {
            return $collection->implode(',');
        }

        return 'Not Supported as: '.$as;
    }

    public function getFirstRoleName()
    {
        return $this->getAllRoleNames('array')[0] ?? null;
    }

    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }

    public function scopeSearchPermissions($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhereHas('roles', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%");
            });
    }

    public function scopeSearchRoles($query, $value)
    {
        $query->where('name', 'like', "%{$value}%")
            ->orWhereHas('permissions', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%");
            });
    }
}
