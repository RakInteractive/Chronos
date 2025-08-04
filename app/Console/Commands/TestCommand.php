<?php

namespace App\Console\Commands;

use App\Logging\Chronos;
use Illuminate\Console\Command;
use InvalidArgumentException;

class TestCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        Chronos::info("This is a test log message", labels: [
            'test',
            'log',
            'message',
        ]);
    }
}
