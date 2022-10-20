<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel , WithHeadingRow
{
    public $users;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct()
    {
        $this->users = collect();
    }
    public function model(array $row)
    {
        $user = User::updateOrCreate(
            ['email'=>$row['email']],

            [
                'name' => $row['name'],
                'last_name' => $row['last_name'],
                'phone' => $row['phone'],
                'status' => $row['status'],
                'function' => $row['function'],
                'password' => Hash::make('password')
            ]

        );
        $user->syncRoles(explode(",",$row['roles']));

        $this->users->push($user);
        return $user;
    }
}
