<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $roles=[
            [
                'name'=>'developer',
                'display_name'=>'Supper developer',
                'description'=>'developer for the system'
            ],[
                'name'=>'head_of_department',
                'display_name'=>'Head of Department',
                'description'=>'Head of Department for the system'
            ],[
                'name'=>'supervisor',
                'display_name'=>'Supervisor of Students',
                'description'=>'Supervisor of Students for the system'
            ],[
                'name'=>'student',
                'display_name'=>'Student of Department',
                'description'=>'Student of Department for the system'
            ]
        ];

        foreach ($roles as $key=>$value){
           $role= \App\Role::create($value);
           if ($role->name=='developer'){
               $permissions=\App\Permission::all();
               foreach ($permissions as $value) {
                   $role->attachPermission($value->id);

               }
           }
        }
    }
}
