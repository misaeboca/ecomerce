<?php

namespace App\Http\Controllers\Common;

use DB;
use App\Clients\Interfaces\IClientMethod;
use App\Models\Common\Product;
use App\Http\Requests\Common\Product\ListFeaturedsRequest;
use App\Http\Requests\Common\Product\ListRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Store\ListCategoryRequest;
use App\Models\Admin\Category;
use App\Models\GlobalStatus;
use App\Models\Admin\StoreProduct;
use App\Models\Common\Store;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(Request $request)
    {
    }

    public function getStock(ListRequest $request, IClientMethod $clientMethod)
    {
        $data = $request->all();

        if(isset($data['cod']) || isset($data['sku']))
        {
            $stock = $clientMethod->verifyStockLocal([
                'product' => $data['product'],
                'sku' => isset($data['sku']) ? $data['sku'] : null,
                'cod' => isset($data['cod']) ? $data['cod'] : null,
                'store' => $data['id_store']
            ]);
        }
        else {
            $stock = $clientMethod->verifyStocksLocal([
                'product' => $data['product'],
                'store' => $data['id_store']
            ]);
        }

        return response()->json(['state' => 'success', 'response' => $stock], 200);
    }

    public function getProduct(ListRequest $request)
    {
        $data = $request->all();
        $products = Product::whereSku($data['product'])
        ->whereStatus(GlobalStatus::STATUS_ACTIVE)
        ->with(['variations', 'images'])
        ->first();

        if(isset($data['id_store']))
        {
            $sp = StoreProduct::select(['sku', 'cod', 'stock'])
            ->whereIdStore($data['id_store'])
            ->where('product', '=', $data['product'])
            ->get();

            $products->variations->each(function ($item, $key) use ($sp) {
                foreach($sp as $s)
                {
                    if(($s->cod == $item->cod) && ($s->sku == $item->sku) )
                    {
                        $item->stock = $s->stock;
                        return;
                    }
                };
            });

        }

        return response()->json(['state' => 'success', 'response' => $products], 200);
    }

    public function getList(ListRequest $request)
    {
        $data = $request->all();
        $products = Product::whereStatus(GlobalStatus::STATUS_ACTIVE)
        ->where(function($query) use ($data) {
            $query->where('products.name', 'like', '%' . $data['search'] . '%' )
                  ->orWhere('products.sku',  'like', '%' . $data['search'] . '%' );
        });

        if(isset($data['id_store']))
        {
            $sp = StoreProduct::select('product')->whereIdStore($data['id_store'])->get()->orderBy('launch', 'desc')->toArray();
            $products = $products->whereIn('sku', $sp);
            //$products = $products->join('stores_products as sp', 'sp.sku', '=', 'products.sku')->where('sp.id_store', '=', $data['id_store']);
        }

        $products = $products->orderBy('products.id_number', $data['sort'])
        ->with(['variations', 'images'])
        ->paginate($data['paginate']);
        return response()->json(['state' => 'success', 'response' => $products], 200);
    }

    public function getListFeatureds(ListFeaturedsRequest $request)
    {
        $data = $request->all();

        $products = Product::with('images')->join('products_featureds as pf', 'pf.sku', '=', 'products.sku');

        if(isset($data['id_store']))
        {
            $products = $products->join('stores_products as sp', 'sp.sku', '=', 'products.sku')->where('sp.id_store', '=', $data['id_store']);
        }

        $products = $products ->orderBy('products.created_at', $data['sort'])
        ->get()
        ->groupBy('group');

        return response()->json(['state' => 'success', 'response' => $products], 200);
    }

    public function getListByCategory(ListCategoryRequest $request)
    {
        $data = $request->all();
        $params = explode('/', $data['category']);

        $category = Category::whereSlug($params[0])->first();

        foreach($params as $key => $param)
        {
            if($key > 0)
            {
                $category = Category::whereIdCategory($category->id)->whereSlug($param)->first();
            }
        }

        $category->update([
            'quantity' => $category->quantity + 1
        ]);

        $store = Store::whereId($data['id_store'])->first();

        //productos ordenados por fecha de lanzamiento del cliente {client} de la tienda {id_store} de la categoria {category->id}
        $page = $data['page'] > 0 ? $data['page'] - 1 : 0;
        $query = "SELECT sub.sku as sku FROM (
            SELECT p.sku from products as p
            INNER JOIN products_variations as pv ON p.sku = pv.product
            INNER JOIN stores_products as sp ON sp.product = p.sku
            INNER JOIN products_categories as pc ON pc.product = p.sku
            WHERE id_client = '{$store->id_client}'
            AND sp.id_store = '{$store->id}'
            AND pc.id_category = '{$category->id}')
        AS sub GROUP BY sub.sku limit {$data['paginate']} offset {$page}";

        $skusArray = DB::select($query);
        $skus = [];
        foreach($skusArray as $sku)
        {
            $skus [] = $sku->sku;
        }

        $products = Product::whereStatus(GlobalStatus::STATUS_ACTIVE)
        ->where('name', 'like', '%' . $data['search'] . '%' )
        ->whereIn('sku', $skus)
        ->with(['variations', 'images'])
        ->orderBy('id_number', $data['sort'])
        ->paginate($data['paginate']);

        return response()->json(['state' => 'success', 'response' => $products], 200);
    }
}
