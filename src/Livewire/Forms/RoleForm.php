<?php

namespace IhabAfia\PermissionsAdmin\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class RoleForm extends Form
{
    #[Rule(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Rule(['array'])]
    public array $permissions = [];
}
