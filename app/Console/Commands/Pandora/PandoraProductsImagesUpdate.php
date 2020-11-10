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
use Illuminate\Database\Eloquent\Model;

class PandoraProductsImagesUpdate extends Command
{
    private $pandoraUrl = 'http://54.237.51.171/api/';

    private $token = '';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pandora:products-images-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'verify images update of products';

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
        $this->doLogin();

        $productos = Product::whereStatus(GlobalStatus::STATUS_ACTIVE)->orderBy('id_number', 'desc')->get();
        foreach($productos as $producto)
        {
            echo 'product: ' . $producto['sku'] . PHP_EOL;
            $files = $this->downloadFile($producto['sku']);
            $product = $producto['sku'];
            $cod = null;
            $sku = null;

            if(is_null($files)) {//verifico uniendo el producto con campo el codigo
                foreach($producto->variations as $v) {
                    echo 'product: ' . $v['product'] . '-' . $v['cod'] . PHP_EOL;
                    $files = $this->downloadFile($v['product'] . '-' . $v['cod']);

                    if(is_null($files)) {//verifico uniendo el producto con el codigo y el sku
                        echo 'product: ' . $v['product'] . '-' . $v['cod'] . $v['sku']. PHP_EOL;
                        $files = $this->downloadFile($v['product'] . '-' . $v['cod'] . $v['sku'] );
                        $sku = $v['sku'];
                    }
                    else {
                        $product = $v['product'];
                        $cod = $v['cod'];
                    }
                }
            }

            if(!is_null($files)) {

                //verifico si existe
                $exists_pro= ProductImage::where('product', $product)->exists();

                //update
                if($exists_pro){
                    $products_images = ProductImage::where('product', $product)->get();


                    $this->info("Update Image");

                    foreach ($products_images  as $key=>$pro) {

                        if(count($files) == 1){
                            $pro->url = env('APP_URL') . '/storage/images/' .  $files[0]['name'];
                            $pro->width = $files[0]['width'];
                            $pro->height = $files[0]['height'];

                            $pro->save();

                        }elseif(count($files) == count($products_images)){

                            for ($i=0; $i < count($files); $i++) {
                                $pro->url = env('APP_URL') . '/storage/images/' .  $files[$i]['name'];
                                $pro->width = $files[$i]['width'];
                                $pro->height = $files[$i]['height'];

                                $pro->save();
                            }
                        }else{

                            $k = 0;
                            for ($i=0; $i < count($files); $i++) {
                                if($i == $k){
                                    $pro->url = env('APP_URL') . '/storage/images/' .  $files[$i]['name'];
                                    $pro->width = $files[$i]['width'];
                                    $pro->height = $files[$i]['height'];

                                    $pro->save();
                                }
                            }
                        }

                    }

                }else{
                    $this->info("New Image");
                    foreach($files as $file) {
                        ProductImage::create([
                            'product' => $product,
                            'cod' => $cod,
                            'sku' => $sku,
                            'id' => generateLargeUniqueId(),
                            'url' => env('APP_URL') . '/storage/images/' . $file['name'],
                            //'url' => Storage::disk('s3')->url($filename)
                            'width' => $file['width'],
                            'height' => $file['height']
                        ]);
                    }
                }

            }
            else {
                logError('not image: ' . $producto['sku'] );
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
            } else
            {
                logError('token expired: when using sku ' . $codProduto);
                $this->doLogin();
                return $this->downloadFile($codProduto);
            }
        } catch (\Exception $e)
        {
            logError($e->getMessage());
            return null;
        }
    }
}
