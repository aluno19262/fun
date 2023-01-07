<?php

namespace App\Console\Commands;

use App\Models\Associate;
use App\Notifications\NewUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;

class SendNewUserEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:new_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = 0;
        $associates = Associate::whereNotNull('user_id')->whereHas('user', function($q){
            $q->whereHas('roles', function($i){
                $i->whereNotIn('name', ['SuperAdmin','Direcção','Staff','CAC']);
            });
        })->get();
        foreach($associates as $associate){
            $user = $associate->user;
            $password = Random::generate(8);
            $user->password = Hash::make($password);
            if($user->save()){
                $count++;
                $user->notify(new NewUser($user,$password));
            }
        }
        echo "foram enviados $count emails";
    }
}
