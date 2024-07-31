<?php

namespace App\Console\Commands;

use App\Enums\Permissions;
use App\Enums\Roles;
use App\Models\District;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class ImportSystemRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:system-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            foreach (Roles::values() as $value => $name) {
                Role::updateOrCreate(
                    ['id' => $value],
                    [
                        'id' => $value,
                        'name' => $name,
                        'guard_name' => 'web'
                    ]
                );
            }
            foreach (Permissions::values() as $value => $name) {
                Permission::updateOrCreate(
                    ['id' => $value],
                    [
                        'id' => $value,
                        'name' => $name,
                        'guard_name' => 'web'
                    ]
                );
            }
            DB::commit();
            $this->info('Create roles and permission successfully.');
        }catch (Exception $exception){
            DB::rollBack();
            $this->error('Failed',$exception);
        }

    }
}
