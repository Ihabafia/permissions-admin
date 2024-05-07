<?php

namespace IhabAfia\PermissionsAdmin\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class UserForm extends Form
{
    #[Rule(['required', 'string', 'max:255'])]
    public string $name = '';

    #[Rule(['required', 'email', 'string', 'max:255'])]
    public string $email = '';

    #[Rule(['array', 'min:1'])]
    public array $roles = [];
}
