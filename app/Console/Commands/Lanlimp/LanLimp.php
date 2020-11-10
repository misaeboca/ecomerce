<?php

namespace App\Console\Commands\Lanlimp;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class LanLimp extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lanlimp:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'init config of client LanLimp';

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
        $tasks[] = [
            'pandora:products-verify',
            'general:generate-category',
            'pandora:products-stores-verify'
        ];

        foreach($tasks as $task)
        {
            $process = new Process(['php', 'artisan', $task]);
            $process->setTimeout(3600);
            $process->disableOutput();
            $process->start();

            $process->wait(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    echo 'ERR > {$task} :' . $buffer;
                } else {
                    echo 'OUT > {$task} :' . $buffer;
                }
            });
        }

    }
}
