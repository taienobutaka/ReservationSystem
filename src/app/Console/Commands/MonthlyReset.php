<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MonthlyReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:monthly-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly reset command';

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
        // コマンドの処理内容
        $this->info('Monthly reset command executed successfully.');
        return 0;
    }
}
