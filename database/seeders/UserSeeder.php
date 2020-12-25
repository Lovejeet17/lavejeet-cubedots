<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    private $users;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = $this->getUsersData();

        foreach($users as $user) {
            $user = User::create([
                'email' =>  $user['email'],
                'name'  => $user['name'],
                'password'  => $user['password']
            ]);
        }
    }

    public function setUsersData()
    {
        $this->users = [
            [
                'name'  => 'super admin',
                'email' => 'admin@gmail.com',
                'password'  => Hash::make('admin123')
            ],
            [
                'name'  => 'editor',
                'email' => 'editor@gmail.com',
                'password'  => Hash::make('editor123')
            ],
            [
                'name'  => 'reader',
                'email' => 'reader@gmail.com',
                'password'  => Hash::make('reader123')
            ]
        ];
    }

    public function getUsersData()
    {
        $this->setUsersData();
        return $this->users;
    }
}
