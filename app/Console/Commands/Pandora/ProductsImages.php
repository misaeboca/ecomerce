<?php

namespace App\Console\Commands\Pandora;

use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use App\Models\GlobalStatus;
use Intervention\Image\Facades\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class ProductsImages extends Command
{
    private $pandoraUrl = 'http://54.237.51.171/api/';

    private $token = '';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandora:products-images-get {client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get images of products';

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
        $client = $this->argument('client');
        $this->doLogin();
        $productos = Product::whereIdClient($client)->orderBy('id_number', 'desc')->get();
        foreach($productos as $producto)
        {
            echo 'product: ' . $producto['codProduct'] . PHP_EOL;
            $files = $this->downloadFile($producto['codProduct']);

            if(!is_null($files))
            {
                foreach($files as $file)
                {
                    foreach($producto->variations as $v)
                    {
                          ProductImage::create([
                            'product' => $v['product'],
                            'cod' => $v['cod'],
                            'sku' => $v['sku'],
                            'id' => generateLargeUniqueId(),
                            'url' => env('APP_URL') . '/storage/images/' . $file['name'],
                            //'url' => Storage::disk('s3')->url($filename)
                            'width' => $file['width'],
                            'height' => $file['height']
                        ]);
                    }
                }
            }
        }

        echo 'products verified' . PHP_EOL;
        return 0;
    }


    private function doLogin()
    {
        $response = Http::post($this->pandoraUrl . 'Login', [
            'usuario' => 'IntegracaoWebAPI',
            'senha' => '1nt3gr4c40W3b4P1'
        ]);

        if($response->status() == 200) {
            echo 'token obtained' . PHP_EOL;
            $json = $response->json();
            $this->token = $json['token'];
        }
    }

    private function downloadFile($codProduto)
    {
        try
        {
            $this->doLogin();
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])->get($this->pandoraUrl . 'ProdutosFotos/codProduto=' . $codProduto, []);

            if($response->status() == 200)
            {
                $body = $response->json();
                $files = [];
                foreach($body as $b)
                {
                    $img = Image::make($b['conteudoFoto']);
                    $name = generateUniqueId();
                    $fileName = $name . '.jpg';
                    Storage::disk('local')->put('public/images/' . $fileName, $img->encode());
                    $files[] = ['name' => $fileName, 'width' => $img->width(), 'height' => $img->height()];
                }
                return $files;
            }
        } catch (\Exception $e)
        {
            logError($e->getMessage());
            return null;
        }
    }
}
