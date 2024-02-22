<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PintCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pint:format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Pint is an opinionated PHP code style fixer for minimalists';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        exec('./vendor/bin/pint');

        return Command::SUCCESS;
    }
}
