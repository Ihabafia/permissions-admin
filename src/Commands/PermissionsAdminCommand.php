<?php

namespace IhabAfia\PermissionsAdmin\Commands;

use Illuminate\Console\Command;

class PermissionsAdminCommand extends Command
{
    public $signature = 'permissions-admin';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
