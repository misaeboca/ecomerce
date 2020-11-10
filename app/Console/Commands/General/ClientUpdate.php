<?php

namespace App\Console\Commands\General;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class ClientUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "client:update {client}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "update config of client";

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

        $tasks = [
            "{$client}:products-get",//Se obtienen todos los productos
            "{$client}:products-images-get",//Se obtienen las imagenes de los productos
            "{$client}:products-stores-verify",//Se verifican los productos por tienda
            "{$client}:stock-update",//Se actualiza el stock por tienda
            "{$client}:products-disable",//Se deshabilitan productos invalidos
            "general:generate-category",//Se genera el arbol de categorias,
            "general:products-category",//Se genera enlaza cada categorias con su producto
        ];

        foreach($tasks as $task)
        {
            $process = new Process(["php", "artisan", $task, $client]);
            $process->setTimeout(3600);
            //$process->disableOutput();
            $process->start();

            $process->wait(function ($type, $buffer) use($task) {
                if (Process::ERR === $type) {
                    echo "ERR > {$task} :" . $buffer;
                } else {
                    echo "OUT > {$task} :" . $buffer;
                }
            });
        }
    }

}
