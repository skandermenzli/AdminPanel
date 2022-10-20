<?php

namespace App\Console\Commands;

use App\Jobs\SendEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MailAfter2Days extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:after2days';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send welcome mail to users after 2 days of their accounts creation';

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
        //$users = User::where('created_at',Carbon::now()->subDays(2)->toDateTimeString())->get();
        $users = User::whereDate('created_at',Carbon::now()->subDays(2)->format('Y-m-d'))->get();

        foreach ($users as $user){
            dispatch(new SendEmail($user));
        }

    }
}
