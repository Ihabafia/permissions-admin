<?php

namespace IhabAfia\PermissionsAdmin\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class PermissionForm extends Form
{
    #[Rule(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Rule(['array'])]
    public array $roles = [];
}
