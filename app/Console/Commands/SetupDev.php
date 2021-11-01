<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build out better';

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
          // this is info that i need to archive into a better note system JC-NOTES:WK42DAY25
        //$storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $path = base_path('.env');
        $env = '.example';
        // check if we set up env then set up database
        if (file_exists($path)) {
            if ($this->confirm('Deploy new Database?', true)) {
                if (file_exists('database/database.sqlite')) {
                    $this->info('existing database will be overwritten');
                }

                if (!file_exists('database/database.sqlite')) {
                    touch('database/database.sqlite', strtotime('-1 days'));
                }

                file_put_contents($path, str_replace(
                    'DB_DATABASE='.env('DB_DATABASE'), 'DB_DATABASE='.database_path().'/database.sqlite', file_get_contents($path)
                ));

                // this isnt correct  but it is just stand in.
              $this->callSilently('migrate:fresh');
              // beed ti run some yarn

                return 0;
            }
        }else{
            $this->output->error('missing env file, Run Generator');


            // this isnt going this walkout
          exec("cp .env$env .env" );



            return 1;
        }

        return 1;
    }

}
