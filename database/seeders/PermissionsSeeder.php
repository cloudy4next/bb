<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $arrayOfPermissionNames = [
                         //post
                        "access post",
                        "create post",
                        "update post",
                        "delete post",

                         //projects
                         "access projects",
                         "create projects",
                         "update projects",
                        "delete projects",
                         //notice
                         "access notice",
                         "create notice",
                         "update notice",
                         "delete notice",
                         //circulars
                         "access circulars",
                         "create circulars",
                         "update circulars",
                         "delete circulars",
                         //news
                         "access news",
                         "create news",
                         "update news",
                         "delete news",
                         //articles
                         "access articles",
                         "create articles",
                         "update articles",
                         "delete articles",
                         //queries
                         "access queries",
                         "create queries",
                         "update queries",
                         "delete queries",
                         //common_sys
                         "access common_sys",
                         "create common_sys",
                         "update common_sys",
                         "delete common_sys",

                        // ....
                        ];

        $permissions = collect($arrayOfPermissionNames)->map(function (
            $permission
            ) {
            return ["name" => $permission, "guard_name" => "api"];
        });

        Permission::insert($permissions->toArray());

        // create role & give it permissions
        Role::create(["name" => "super"])->givePermissionTo(Permission::all());
        Role::create(["name" => "gg"])->givePermissionTo(['access post',"update post"]);

        // Assign roles to users (in this case for user id -> 1 & 2)
        User::find(3)->assignRole('super');
        User::find(4)->assignRole('gg');
    }
}