<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'users-list',
           'users-create',
           'users-edit',
           'users-delete',
           'company-list',
           'company-create',
           'company-edit',
           'company-delete',           
           'form-list',
           'form-create',
           'form-edit',
           'form-delete',
           'question-list',
           'question-create',
           'question-edit',
           'question-delete',
           
        //    'assign-list',
        //    'assign-create',
        //    'assign-edit',
        //    'assign-delete',
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}