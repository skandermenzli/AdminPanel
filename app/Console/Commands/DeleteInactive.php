<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteInactive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all inactive users in the DB ';

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
        $users = User::where('status',0)
                     ->get();
        foreach ($users as $user){
            $user->roles()->detach();
            $user->delete();
        }
    }
}
