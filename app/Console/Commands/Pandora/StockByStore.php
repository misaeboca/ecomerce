<?php

namespace App\Console\Commands\Pandora;

use DB;
use App\Models\Admin\Store;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Constraint\Count;
use SebastianBergmann\CodeCoverage\Report\PHP;

class StockByStore extends Command
{
    private $pandoraUrl = 'http://54.237.51.171/api/';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandora:stock-store {store}';

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
        $s = $this->argument('store');
        $store = Store::whereId($s)->first();

        echo 'getting token for store: ' . $store->sigla . PHP_EOL;
        $response = Http::post($this->pandoraUrl . 'Login', [
            'usuario' => 'IntegracaoWebAPI',
            'senha' => '1nt3gr4c40W3b4P1'
        ]);

        $json = $response->json();
        $token = $json['token'];

        echo 'getting stock for store: ' . $store->sigla . PHP_EOL;
        $response2 = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get($this->pandoraUrl . 'EstoqueProdutos/Filial=' . $store->sigla, []);
        echo 'code: ' . $response2->status() . PHP_EOL;
        if($response2->status() == 200)
        {
            $body = $response2->json();
            $updates = [];
            DB::disableQueryLog();
            foreach($body as $b)
            {
                try {
                    $codProducto = explode('-', $b['produto']);
                    $codProducto2 = explode($b['produto'], $b['sku']);
                    $cod = isset($codProducto[1]) ? $codProducto[1] : 'U';
                    $sku = isset($codProducto2[1]) ? $codProducto2[1] : 'U';
                    $updates [] = "UPDATE stores_products SET stock = " . intval($b['qtde']) . " WHERE id_store = " . '"' . $store->id  . '"' . " AND product = " . '"' . $codProducto[0] . '"' . " AND sku = " . '"' . $sku . '"' . " AND cod = " . '"' . $cod . '"';
                } catch (\Exception $e) {
                    logError('PandoraStockVerify@handle: ' . $e->getMessage());
                    return;
                }
            }

            foreach($updates as $update)
            {
                DB::update(DB::raw($update));
            }
            echo 'end store '. PHP_EOL;
            //DB::update(implode(';',$update));
        }

        return 0;
    }
}
