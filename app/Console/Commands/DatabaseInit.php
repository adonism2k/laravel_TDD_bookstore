<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DatabaseInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initiate SQLite Database';

    /**
     * Database name
     *
     * @var string
     */
    protected $databaseName = 'database.sqlite';

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
        if (Storage::disk('db')->exists($this->databaseName)) {
            $this->info('Database already exists!');
        } else {
            Storage::disk('db')->put($this->databaseName, '');
            
            $this->info('Database created!');
        }
    }
}
