<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Roles List
    </h2>
</x-slot>

<div>
    <x-permissions-admin::flash-message />
    <section class="">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-0">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative sm:rounded-lg overflow-hidden">
                <div class="flex items-center justify-between d py-4">
                    <div class="flex w-1/4">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                     fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <input
                                class="dark:bg-gray-700 bg-gray-50 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full pl-10 p-2 "
                                wire:model.live.debounce.400ms="search"
                                id="search"
                                name="search"
                                type="text"
                                placeholder="Search"
                            >
                        </div>
                    </div>
                    <div class="flex space-x-0">
                        <div class="flex space-x-0 items-center">
                            <label class="w-40 text-sm font-medium text-gray-900 dark:text-gray-300">User Type :</label>
                            <select
                                wire:model.live="filter"
                                class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 ">
                                <option value="">All</option>
                                <option value="Admin">Admin</option>
                                <option value="User">User</option>
                            </select>
                        </div>
                        <div>
                            <x-permissions-admin::forms.button-color
                                wire:click="createRole"
                                color="sky"
                            >
                                Create Role
                            </x-permissions-admin::forms.button-color>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-xs font-bold text-gray-700 dark:text-gray-200 uppercase bg-gray-50 dark:bg-gray-700">
                        <tr class="border-y dark:border-gray-400">
                            <th scope="col" class="px-4 py-3">Id</th>
                            <th scope="col" class="px-4 py-3" wire:click="setSortBy('name')">
                                <x-permissions-admin::data-sort-field lable="Name" field="name" :sort-by="$sortBy"
                                                                      :sort-direction="$sortDirection"/>
                            </th>
                            <th scope="col" class="px-4 py-3">Permissions</th>
                            <th scope="col" class="px-4 py-3">
                                Actions<span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($this->roles as $role)
                                <tr
                                    wire:key="{{ $role->id }}"
                                    class="border-b dark:border-gray-400">
                                    <td scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $role->id }}
                                    </td>
                                    <td scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {!! \IhabAfia\PermissionsAdmin\Helpers\Helper::getRolesBadges($role->name) !!}
                                    </td>
                                    <td class="px-4 py-3 text-green-500">
                                        {!! $role->permissions->pluck('name')->implode(', ') !!}
                                    </td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button
                                            wire:click="editRole({{$role->id}})"
                                            class="px-3 py-1 bg-sky-500 hover:bg-sky-600 text-white rounded-tl rounded-bl">
                                            Edit
                                        </button>
                                        <button
                                            onclick="confirm('Are you sure you want to delete {{ $role->name }}?') || event.stopImmediatePropagation()"
                                            wire:click="deleteRole({{$role->id}})"
                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-tr rounded-br">X
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="pt-4 px-0">
                    <div class="flex">
                        <div class="flex space-x-2 items-center mb-3">
                            <label class="w-32 text-sm font-medium text-gray-900 dark:text-gray-100">Per Page</label>
                            <select
                                wire:model.live="perPage"
                                class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5 ">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    {{ $this->roles->links() }}
                </div>
            </div>
        </div>
    </section>
    <x-permissions-admin::modal name="role-details" action="{{$formAction}}">
        <x-slot:body>
            <form class="p-4 md:p-5 overflow-y-scroll max-h-96">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <x-permissions-admin::forms.input wire:model="roleForm.name"
                                                          name="roleForm.name"
                                                          label="Role Name"
                        />
                    </div>

                    <fieldset class="border border-lg rounded dark:ring-2 dark:ring-gray-400 grid grid-cols-2 col-span-2 mt-2">
                        <legend class="ml-2 px-3 bg-gray-700 font-extrabold">Permissions</legend>

                        <div class="grid gap-y-4 py-4 grid-cols-2 col-span-2" >
                            @foreach($permissionsArray as $permission)
                                <div class="relative flex items-start pl-4 col-span-1 sm:col-span-1">
                                    <div class="flex h-6 items-center">
                                        <input
                                            wire:model="roleForm.permissions"
                                            value="{{$permission->name}}"
                                            type="checkbox"
                                            id="permission-{{$permission->id}}"
                                            class="h-4 w-4 rounded border-gray-300 text-teal-600 focus:ring-teal-600"
                                        >
                                    </div>
                                    <div class="ml-3 text-sm leading-6">
                                        <label for="permission-{{$permission->id}}" class="font-medium text-gray-900 dark:text-gray-100">{{ $permission->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

                    @error('permissionForm.roles')
                    <div class="grid grid-cols-2 col-span-2 dark:text-red-500 -mt-3">{{ $message }}</div>
                    @enderror
                </div>
            </form>
        </x-slot:body>
    </x-permissions-admin::modal>
</div>
@push('scripts')
<script>
    window.addEventListener('livewire:load', () => {
        document.querySelector('input').focus()
    })
</script>
@endpush
