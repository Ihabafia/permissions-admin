<?php

namespace IhabAfia\PermissionsAdmin;

use IhabAfia\PermissionsAdmin\Commands\PermissionsAdminCommand;
use IhabAfia\PermissionsAdmin\Livewire\PermissionComponent;
use IhabAfia\PermissionsAdmin\Livewire\RoleComponent;
use IhabAfia\PermissionsAdmin\Livewire\UserComponent;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PermissionsAdminServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        parent::boot();

        Livewire::component('user-component', UserComponent::class);
        Livewire::component('permission-component', PermissionComponent::class);
        Livewire::component('role-component', RoleComponent::class);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('permissions-admin')
            ->hasConfigFile()
            ->hasViews()
            //->hasMigration('create_permissions-admin_table')
            ->hasCommand(PermissionsAdminCommand::class);
    }

    public function packageRegistered()
    {
        Route::macro('rolesPermissionsAdmin', function (string $baseUrl = '/') {
            Route::prefix($baseUrl)->group(function () {
                Route::get('users', UserComponent::class)->name('users');
                Route::get('roles', RoleComponent::class)->name('roles');
                Route::get('permissions', PermissionComponent::class)->name('permissions');
            });
        });
    }
}
