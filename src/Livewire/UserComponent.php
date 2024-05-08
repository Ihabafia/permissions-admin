<?php

namespace IhabAfia\PermissionsAdmin\Livewire;

use App\Models\User;
use IhabAfia\PermissionsAdmin\Livewire\Forms\UserForm;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserComponent extends Component
{
    use WithPagination;

    public ?UserForm $userForm;

    public ?string $formAction = null;

    #[Url(history: true)]
    public string $search = '';

    #[Url(history: true)]
    public string $role = '';

    #[Url(history: true)]
    public string $sortBy = 'created_at';

    #[Url(history: true)]
    public string $sortDirection = 'DESC';

    #[Url()]
    public int $perPage = 10;

    public $rolesArray;

    public ?User $selectedUser = null;

    public function mount()
    {
        $this->rolesArray = Role::all();
    }

    #[Computed()]
    public function users()
    {
        return User::search($this->search)
            ->when($this->role !== '', function ($query) {
                $query->whereHas('roles', function ($query) {
                    $query->where('name', 'like', "%{$this->role}%");
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

    public function updateRole(Role $role)
    {
        if (in_array($role->name, $this->userForm->roles)) {
            unset($this->userForm->roles[$role->id]);
        } else {
            $this->userForm->roles[$role->id] = $role->name;
        }
    }

    public function editUser(User $user)
    {
        $this->userForm->name = $user->name;
        $this->userForm->email = $user->email;
        $this->userForm->roles = $user->roles->pluck('name')->toArray();

        if (count($this->userForm->roles) == 0) {
            $this->userForm->roles[3] = 'User';
        }
        $this->selectedUser = $user;
        $this->formAction = 'updateUser';

        $this->dispatch('open-modal', name: 'user-details', title: 'Update User');
    }

    public function updateUser()
    {
        $this->validate();

        $data['email'] = $this->userForm->email;

        if (! config('permissions-admin.disable-user-edit')) {
            $data['name'] = $this->userForm->name;
        }

        $this->selectedUser->update($data);

        $this->selectedUser->syncRoles($this->userForm->roles);

        session()->flash('success', 'User updated successfully.');
        $this->selectedUser = null;

        $this->dispatch('close-modal', name: 'user-details');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
    }

    public function render()
    {
        return view('permissions-admin::livewire.user-component')
            ->layout('permissions-admin::components.livewire-layout');
    }
}
