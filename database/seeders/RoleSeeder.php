<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = $this->getroles();
        foreach($roles as $role) {
            $role = Role::updateOrCreate([
                'name'  => $role
            ]);
        }
    }

    public function setroles()
    {
        $this->roles = ['super admin', 'editor', 'reader'];
    }

    public function getroles()
    {
        $this->setroles();
        return $this->roles;
    }
}
