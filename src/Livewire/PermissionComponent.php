<?php

namespace IhabAfia\PermissionsAdmin\Livewire;

use App\Models\Permission;
use App\Models\Role;
use IhabAfia\PermissionsAdmin\Livewire\Forms\PermissionForm;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PermissionComponent extends Component
{
    use WithPagination;

    public ?PermissionForm $permissionForm;

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

    public Collection $rolesArray;

    public ?Permission $selectedPermission = null;

    public function mount()
    {
        $this->rolesArray = Role::where('name', '!=', 'Super Admin')->get();
    }

    #[Computed()]
    public function permissions()
    {
        return Permission::searchPermissions($this->search)
            ->when($this->filter !== '', function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', "{$this->filter}");
                });
            })
            ->with('roles')
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

    public function createPermission()
    {
        $this->resetErrorBag();
        $this->permissionForm->reset();
        $this->formAction = 'storePermission';

        $this->dispatch('open-modal', name: 'permission-details', title: 'Create Permission');
    }

    public function storePermission()
    {
        $this->validate();

        $permission = Permission::create([
            'name' => $this->permissionForm->name,
        ]);

        if ($this->permissionForm->roles) {
            $permission->syncRoles($this->permissionForm->roles);
        }

        session()->flash('success', 'Permission created successfully.');
        $this->permissionForm->reset();

        $this->dispatch('close-modal', name: 'permission-details');
    }

    public function updateRole(Role $role)
    {
        if (in_array($role->name, $this->permissionForm->roles)) {
            unset($this->permissionForm->roles[$role->id]);
        } else {
            $this->permissionForm->roles[$role->id] = $role->name;
        }
    }

    public function editPermission(Permission $permission)
    {
        $this->permissionForm->name = $permission->name;
        $this->permissionForm->roles = $permission->roles->pluck('name')->toArray();

        $this->selectedPermission = $permission;
        $this->formAction = 'updatePermission';

        $this->dispatch('open-modal', name: 'permission-details', title: 'Update Permission');
    }

    public function updatePermission()
    {
        $this->validate();

        $this->selectedPermission->update([
            'name' => $this->permissionForm->name,
        ]);

        $this->selectedPermission->syncRoles($this->permissionForm->roles);

        session()->flash('success', 'Permission updated successfully.');
        $this->selectedPermission = null;

        $this->dispatch('close-modal', name: 'permission-details');
    }

    public function deletePermission(Permission $permission)
    {
        $permission->delete();
    }

    public function render()
    {
        return view('permissions-admin::livewire.permission-component')
            ->layout('permissions-admin::components.livewire-layout');
    }
}
