<?php

namespace Brunocfalcao\Helpers\Commands;

use Illuminate\Console\Command;

class PintCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artisan:pint';

    protected $description = 'Runs pint in an eloquent way';

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
        //
        return 0;
    }
}
