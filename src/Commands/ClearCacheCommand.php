<?php

namespace Brunocfalcao\Helpers\Commands;

use Illuminate\Console\Command;

class ClearCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:cache {--optimize : Runs optimize at the end}';

    protected $description = 'Cleans all application cache types, deletes log files and storage cache files';

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
        $this->info('Cleaning all caches on your application ...');

        $this->call('route:clear');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('view:clear');

        if ($this->option('optimize')) {
            $this->call('optimize');
        }

        return 0;
    }
}
