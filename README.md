# This package for an admin of Spatie Laravel Permission package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ihabafia/permissions-admin.svg?style=flat-square)](https://packagist.org/packages/ihabafia/permissions-admin)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/ihabafia/permissions-admin/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/ihabafia/permissions-admin/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/ihabafia/permissions-admin/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/ihabafia/permissions-admin/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ihabafia/permissions-admin.svg?style=flat-square)](https://packagist.org/packages/ihabafia/permissions-admin)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.
This package is a cool livewire GUI for [Spatie Laravel Permission](https://github.com/spatie/laravel-permission) **(not included)**, and it will help you to:
- Create role.
- Create permission.
- Assign role to user.
- Give permission to role.
- Assign role to permission.
- Remove permission from role.

All this via 3 livewire components that will show you the information in a dynamic table which is searchable, sortable and filtered.

## Installation

You can install the package via composer:

```bash
composer require ihabafia/permissions-admin
```

### Additional Steps for installation
1. This package is depend on [Spatie Laravel Permission](https://github.com/spatie/laravel-permission), to install it if you didn't already:
```bash
composer require spatie/laravel-permission
```
2. [Livewire](https://github.com/livewire/livewire) is required, to install it if you didn't already:
```bash
composer require livewire/livewire 
```
3. You need to create and empty ```App\Models\Role``` and ```App\Models\Permission``` class and add ```HasPermissionAdmin``` trait as follows:
```php
namespace App\Models;

use IhabAfia\PermissionsAdmin\Traits\HasPermissionAdmin;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasPermissionAdmin;
}

````
```php
namespace App\Models;

use IhabAfia\PermissionsAdmin\Traits\HasPermissionAdmin;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasPermissionAdmin;
}
````
**These classes will not affect your application since these classes extends the original class.**

4. You need to add ```HasPermissionAdmin``` trait in your ```User::class``` like follows:
```php
namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use IhabAfia\PermissionsAdmin\Traits\HasPermissionAdmin;

class User extends Authenticatable
{
    use HasRoles;
    use HasPermissionAdmin;
    ...
}
````
This trait is needed for adding the search functionality to the 3 models.

5. Finally, you need to use this route in ```web.php```
```php
Route::rolesPermissionsAdmin();
```

You might need to publish the config file to change routes with:

```bash
php artisan vendor:publish --tag="permissions-admin-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="permissions-admin-views"
```

## Testing

```bash
Need Help
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ihab Abou Afia](https://github.com/Ihabafia)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
