<?php

namespace Brunocfalcao\Helpers\Commands;

use Illuminate\Console\Command;

class ClearLogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:log';

    protected $description = 'php artisan optimize on stereoids';

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
        file_put_contents(storage_path('logs/laravel.log'), '');

        $this->info('Log cleaned. Filesize:'.filesize(storage_path('logs/laravel.log')));

        return 0;
    }
}
