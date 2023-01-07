<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            //Super Admins
            [
                'id' => 1,
                'name' => 'Fábio',
                'email' => 'fabio.ferreira@noop.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => '$2y$10$MCsGWRkKnp1SmfonLifGd.oCrKJeO5UiaqgQZFc2.YNbEjW3kpdjK', //12345678
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 2,
                'name' => 'João',
                'email' => 'joao.alves@noop.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => '$2y$10$MCsGWRkKnp1SmfonLifGd.oCrKJeO5UiaqgQZFc2.YNbEjW3kpdjK', //12345678
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 3,
                'name' => 'Tiago',
                'email' => 'tiago.carrao@noop.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => '$2y$10$MCsGWRkKnp1SmfonLifGd.oCrKJeO5UiaqgQZFc2.YNbEjW3kpdjK', //12345678
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            //Direção
           /* [
                'id' => 4,
                'name' => 'João Ceregeiro',
                'email' => 'joao@ceregeiro.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('5MBUKE294P'), //5MBUKE294P
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 5,
                'name' => 'Paula Simões',
                'email' => 'pmss@uevora.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('VWUYTQLDG7'), //VWUYTQLDG7
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 6,
                'name' => 'Carlos Correia Dias',
                'email' => 'ccd@lodo.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('BJRE34KD9H'), //BJRE34KD9H
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 7,
                'name' => 'Paula Farrajota',
                'email' => 'pfarrajota@ualg.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('4QDARU6N9Z'), //4QDARU6N9Z
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 8,
                'name' => 'David Flores',
                'email' => 'davidflores@biodesign.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('WBYT9U5V43'), //WBYT9U5V43
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            // CAC
            [
                'id' => 9,
                'name' => 'Jorge Cancela',
                'email' => 'cancela.jorge@gmail.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('CVDGFA683U'), //CVDGFA683U
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 10,
                'name' => 'Carlos Ribas',
                'email' => 'carlos.ribas.lx@gmail.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('JV2EKM9HN5'), //JV2EKM9HN5
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 11,
                'name' => 'Catarina Dias',
                'email' => 'cd7568@yahoo.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('2JGQ4WMV7N'), //2JGQ4WMV7N
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 12,
                'name' => 'Teresa Portela Marques',
                'email' => 'teresamarques@fc.up.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('RL2EAFWK95'), //RL2EAFWK95
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],*/

            //Secretaria
            [
                'id' => 13,
                'name' => 'Elenira Delgado',
                'email' => 'elenira.delgado@apap.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('VMQCA2XWRB'), //VMQCA2XWRB
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 14,
                'name' => 'Ana Palma',
                'email' => 'apoio.administrativo@apap.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('5X6W87RV4B'), //5X6W87RV4B
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 15,
                'name' => 'Maria Aragão',
                'email' => 'apoio.tecnico@apap.pt',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password' => Hash::make('NSQK68RF5A'), //NSQK68RF5A
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }
}
