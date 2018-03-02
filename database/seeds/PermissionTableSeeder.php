<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions=[
            [
                'name'=>'see_roles',
                'display_name'=>'View Roles',
                'description'=>'User can see Role List'
            ],
            [
                'name'=>'add_roles',
                'display_name'=>'Create Roles',
                'description'=>'User can create Roles'
            ],
            [
                'name'=>'edit_roles',
                'display_name'=>'Edit Roles',
                'description'=>'User can edit Roles'
            ],
            [
                'name'=>'delete_roles',
                'display_name'=>'Delete Roles',
                'description'=>'User can delete Roles'
            ],
            [
                'name'=>'see_permission',
                'display_name'=>'View permission',
                'description'=>'User can see permission List'
            ],
            [
                'name'=>'add_permission',
                'display_name'=>'Create Roles',
                'description'=>'User can create Roles'
            ],
            [
                'name'=>'edit_permission',
                'display_name'=>'Edit permission',
                'description'=>'User can edit permission'
            ],
            [
                'name'=>'delete_permission',
                'display_name'=>'Delete permission',
                'description'=>'User can delete permission'
            ],
            [
                'name'=>'see_user',
                'display_name'=>'View Users',
                'description'=>'User can see Users List'
            ],
            [
                'name'=>'add_user',
                'display_name'=>'Create Users',
                'description'=>'User can create Users'
            ],
            [
                'name'=>'edit_user',
                'display_name'=>'Edit Users',
                'description'=>'User can edit Users'
            ],
            [
                'name'=>'delete_user',
                'display_name'=>'Delete Users',
                'description'=>'User can delete Users'
            ],
            [
                'name'=>'see_department',
                'display_name'=>'View department',
                'description'=>'User can see department List'
            ],
            [
                'name'=>'add_department',
                'display_name'=>'Create department',
                'description'=>'User can create department'
            ],
            [
                'name'=>'edit_department',
                'display_name'=>'Edit department',
                'description'=>'User can edit department'
            ],
            [
                'name'=>'delete_department',
                'display_name'=>'Delete department',
                'description'=>'User can delete department'
            ]
        ];
        foreach ($permissions as $key=>$value){
            \App\Permission::create($value);
        }
    }
}
