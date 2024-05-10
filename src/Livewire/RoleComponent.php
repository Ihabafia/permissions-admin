<?php

namespace IhabAfia\PermissionsAdmin\Livewire;

use IhabAfia\PermissionsAdmin\Livewire\Forms\RoleForm;
use IhabAfia\PermissionsAdmin\Models\Permission;
use IhabAfia\PermissionsAdmin\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class RoleComponent extends Component
{
    use WithPagination;

    public ?RoleForm $roleForm;

    public ?string $formAction = null;

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $filter = '';

    #[Url(history: true)]
    public string $sortBy = 'created_at';

    #[Url(history: true)]
    public string $sortDirection = 'DESC';

    #[Url()]
    public int $perPage = 10;

    public Collection $permissionsArray;

    public ?Role $selectedRole = null;

    public function mount()
    {
        $this->permissionsArray = Permission::all();
    }

    #[Computed()]
    public function roles()
    {
        return Role::searchRoles($this->search)
            ->where('name', '!=', 'Super Admin')
            ->when($this->filter !== '', function ($query) {
                $query->where('name', 'like', "%{$this->filter}%");
            })
            ->with('permissions')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setSortBy($field)
    {
        if ($this->sortBy == $field) {
            $this->sortDirection = $this->sortDirection == 'ASC' ? 'DESC' : 'ASC';

            return;
        }

        $this->sortBy = $field;
        $this->sortDirection = 'DESC';
    }

    public function createRole()
    {
        $this->resetErrorBag();
        $this->roleForm->reset();
        $this->formAction = 'storeRole';

        $this->dispatch('open-modal', name: 'role-details', title: 'Create Role');
    }

    public function storeRole()
    {
        $this->validate();

        $role = Role::create([
            'name' => $this->roleForm->name,
        ]);

        if ($this->roleForm->permissions) {
            $role->syncPermissions($this->roleForm->permissions);
        }

        session()->flash('success', 'Role created successfully.');
        $this->roleForm->reset();

        $this->dispatch('close-modal', name: 'role-details');
    }

    public function editRole(Role $role)
    {
        $this->resetErrorBag();
        $this->roleForm->name = $role->name;
        $this->roleForm->permissions = $role->permissions->pluck('name')->toArray();

        $this->selectedRole = $role;
        $this->formAction = 'updateRole';

        $this->dispatch('open-modal', name: 'role-details', title: 'Update Role');
    }

    public function updateRole()
    {
        $this->validate();

        $this->selectedRole->update([
            'name' => $this->roleForm->name,
        ]);

        $this->selectedRole->syncPermissions($this->roleForm->permissions);

        session()->flash('success', 'Role updated successfully.');

        $this->dispatch('close-modal', name: 'role-details');
    }

    public function updatePermission(Permission $permission)
    {
        if (in_array($permission->name, $this->roleForm->permissions)) {
            unset($this->roleForm->permissions[$permission->id]);
        } else {
            $this->roleForm->permissions[$permission->id] = $permission->name;
        }
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
    }

    public function render()
    {
        return view('permissions-admin::livewire.role-component')
            ->layout('permissions-admin::components.livewire-layout');
    }
}
