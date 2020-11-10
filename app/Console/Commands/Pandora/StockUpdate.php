<?php

namespace App\Console\Commands\Pandora;

use App\Models\Admin\Client;
use App\Models\Admin\Store;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class StockUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandora:stock-update {client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update stock of products';

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
        $client = $this->argument("client");
        $pandora = Client::whereSlug($client)->first();

        $stores = Store::whereIdClient($pandora->id)->get();
        $processes = [];
        $processesIds = [];
        foreach($stores as $store)
        {
            $process = new Process(['php', 'artisan', 'pandora:stock-store', $store->id]);
            $process->setTimeout(36000);
            //$process->disableOutput();
            $process->start();
            $processes[] = $process;
            $processesIds[] = $process->getPid();
            $process->wait(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    echo 'ERR > '.$buffer;
                } else {
                    echo 'OUT > '.$buffer;
                }
            });
        }

        echo 'stock verified' . PHP_EOL;
        return 0;
    }
}
