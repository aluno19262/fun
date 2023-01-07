<?php
namespace Database\Seeders;

use App\Models\DeclarationTemplateQuestion;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");
        }

        // Confirm roles needed
        if ($this->command->confirm('Create Permissions and Roles for user? [y|N]', true)) {
            // Seed the default permissions
            //$permissions = Permission::defaultPermissions(); // edit to have default permissions
            $permissions = ['accessAsUser','manageApp','accessAsCAC','adminApp','adminFullApp'];

            foreach ($permissions as $perms) {
                Permission::firstOrCreate(['name' => $perms]);
            }

            $this->command->info('Default Permissions added.');
            if ($this->command->confirm('Create default permissions? [y|N]', true)) {
                $roles_array = ['SuperAdmin', 'Direcção', 'Staff', 'CAC', 'Associado']; // edit with default roles
                // add roles
                foreach ($roles_array as $role) {
                    $role = Role::firstOrCreate(['name' => trim($role)]);
                    //edit with the used roles
                    if ($role->name == 'SuperAdmin') {
                        // assign all permissions
                        $role->syncPermissions(Permission::whereIn('name', ['manageApp','adminApp','adminFullApp'])->get());
                        $this->command->info('SuperAdmin granted all the permissions');
                    } elseif($role->name == 'Direcção'){
                        // assign all permissions
                        $role->syncPermissions(Permission::whereIn('name', ['manageApp','adminApp'])->get());
                        $this->command->info('Admin granted almost all permissions');
                    } elseif($role->name == 'Staff'){
                        // assign all permissions
                        $role->syncPermissions(Permission::whereIn('name', ['manageApp'])->get());
                        $this->command->info('Manager granted some permissions');
                    } elseif($role->name == 'Associado'){
                        // for others by default only read access
                        $role->syncPermissions(Permission::whereIn('name', ['accessAsUser'])->get());
                    }
                    elseif($role->name == 'CAC'){
                        // for others by default only read access
                        $role->syncPermissions(Permission::whereIn('name', ['accessAsCAC'])->get());
                    }

                    // create one user for each role
                    //$this->createUser($role);
                }
            }else {
                // Ask for roles from input
                $input_roles = $this->command->ask('Enter roles in comma separate format.', 'Direcção,User');

                // Explode roles
                $roles_array = explode(',', $input_roles);

                // add roles
                foreach ($roles_array as $role) {
                    $role = Role::firstOrCreate(['name' => trim($role)]);

                    if ($role->name == 'Direcção' || $role->name == 'SuperAdmin') {
                        // assign all permissions
                        $role->syncPermissions(Permission::all());
                        $this->command->info('Admin granted all the permissions');
                    } else {
                        // for others by default only read access
                        //$role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get()); //REVER ISTO QUE JÁ NÂO SE USA
                    }

                    // create one user for each role
                    //$this->createUser($role);
                }

                $this->command->info('Roles ' . $input_roles . ' added successfully');
            }

        } else {
            //Role::firstOrCreate(['name' => 'User']);
            //$this->command->info('Added only default user role.');
        }
        if ($this->command->confirm('Do you want to create a superAdmin user account? [y|N]', true)) {
            $this->call(UserSeeder::class);
            $this->command->warn('Password is "12345678"');
            foreach(User::whereIn('id',[1,2,3])->get() as $user){
                $user->assignRole(Role::first()->name);
            }
            //para users da seed de teste
            //membro cac
            /*foreach(User::whereIn('id',[6,9,10,11,12])->get() as $user){
                $user->assignRole('CAC');
            }
            //admin
            foreach(User::whereIn('id',[4,5,6,7,8])->get() as $user){
                $user->assignRole('Admin');
            }*/

            //secretariado
            foreach(User::whereIn('id',[13,14,15])->get() as $user){
                $user->assignRole('Staff');
            }
        }
        if ($this->command->confirm('Do you want to apply all seeds? [y|N]', true)) {
            $this->call(SettingSeeder::class);
            $this->call(DeclarationTemplateSeeder::class);
            $this->call(ProductSeeder::class);
           //$this->call(AssociateSeeder::class);
            $this->call(DeclarationQuestionSeeder::class);
        }
    }

    /**
     * Create a user with given role
     *
     * @param $role
     */
    private function createUser($role)
    {
        $user = User::factory()->create();
        $user->assignRole($role->name);

        if( $role->name == 'Admin' ) {
            $this->command->info('Here is your admin details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "secret"');
        }
    }
}
