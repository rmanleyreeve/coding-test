<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class ListRegistered extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'regusers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of registered users';

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
     * @return mixed
     */
    public function handle()
    {
    	// returns a dump of the users table, most recent first
        echo "\nLIST OF REGISTERED USERS\n\nNAME\tEMAIL\tPOSTCODE\n";
		foreach(User::orderBy('id', 'desc')->get() as $u) {
			echo "{$u->name}\t{$u->email}\t{$u->postcode}\n";
		}
		exit;
    }
}
