<?php

namespace IhabAfia\PermissionsAdmin\Helpers;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class Helper
{
    public static function allRoleNamesArray(string $as = 'select')
    {
        $roles = Role::all()->pluck('name')->toArray();

        if ($as == 'array') {
            return $roles;
        }

        $collection = collect([]);
        $select = [];

        foreach ($roles as $label) {
            $select[$label] = $label;
            $collection->push($label);
        }

        if ($as == 'select') {
            return $select;
        }

        if ($as == 'string') {
            return $collection->implode(',');
        }

        return 'Not Supported as: '.$as;
    }

    public static function getRolesBadges(Collection|string $roles): string
    {
        if (is_string($roles)) {
            $string = $roles;
            $roles = [];
            $roles[] = (object) ['name' => $string];
        }

        $badges = '';
        foreach ($roles as $role) {
            $badege = match ($role->name) {
                'Super Admin' => '<span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-gray-800">
  <svg class="h-1.5 w-1.5 fill-purple-400" viewBox="0 0 6 6" aria-hidden="true">
    <circle cx="3" cy="3" r="3" />
  </svg>
  Super Admin
</span>',
                'Admin' => '<span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-gray-800">
  <svg class="h-1.5 w-1.5 fill-yellow-400" viewBox="0 0 6 6" aria-hidden="true">
    <circle cx="3" cy="3" r="3" />
  </svg>
  Admin
</span>',
                default => '<span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-gray-800">
  <svg class="h-1.5 w-1.5 fill-green-400" viewBox="0 0 6 6" aria-hidden="true">
    <circle cx="3" cy="3" r="3" />
  </svg>
  '.$role->name.'
</span>',
            };

            $badges .= $badege;
        }

        return $badges;
    }
}
