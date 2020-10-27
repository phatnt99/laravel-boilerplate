<?php

namespace App\Console\Commands;

use App\Queries\UserQuery;
use Illuminate\Console\Command;

class testC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:f';

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
    public function handle(UserQuery $query)
    {
        dd($query->filter()->get());

        return 0;
    }
}
