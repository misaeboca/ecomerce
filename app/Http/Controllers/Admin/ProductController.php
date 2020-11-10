<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Clients\Interfaces\IClientMethod;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\AddCategoryRequest;
use App\Http\Requests\Admin\Product\AddImageRequest;
use App\Http\Requests\Admin\Product\DeleteCategoryRequest;
use App\Http\Requests\Admin\Product\DeleteImageRequest;
use App\Http\Requests\Admin\Product\ListFeaturedsRequest;
use App\Http\Requests\Admin\Product\ListRequest;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Requests\Admin\Product\TrashRequest;
use App\Http\Requests\Admin\Product\RestoreRequest;
use App\Http\Requests\Admin\Product\StatusRequest;
use App\Models\Admin\Category;
use App\Models\Admin\ProductCategory;
use App\Models\GlobalStatus;
use App\Models\Admin\ProductVariation;
use App\Models\Admin\Store;
use App\Models\Admin\StoreProduct;

class ProductController extends Controller
{

    private $clientMethod;

    public function __construct(IClientMethod $clientMethod)
    {
        $this->clientMethod = $clientMethod;
    }

    public function getProduct(ListRequest $request)
    {
        $data = $request->all();
        $products = Product::where('sku', '=', $data['product'])
        ->whereIdClient($this->clientMethod->getIdClient())
        ->with(['variations', 'images', 'categories'])
        ->withTrashed()
        ->first();

        if(!$data['user']->hasRole(['root', 'master']))//los productos del la tienda asociada al user logueado
        {
            $sp = StoreProduct::select(['sku', 'cod', 'stock'])
            ->whereIdStore($data['user']->store_user->id_store)
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

        return response()->json(['state' => 'success', 'response' => ['data' => $products]], 200);
    }

    public function getList(ListRequest $request)
    {
        $data = $request->all();
        $products = Product::select(
            [
                "name",
                "sku",
                "html_description",
                "html_short_description",
                "sale_price",
                "categories",
                "type",
                "material",
                "theme",
                "tags",
                "weight",
                "height",
                "width",
                "length",
                "title",
                "desc",
                "manufacturer",
                "status",
                "created_at",
            ]
        )
        ->whereIdClient($this->clientMethod->getIdClient())
        ->where(function($query) use ($data) {
            $query->where('name', 'like', '%' . $data['search'] . '%' )
                  ->orWhere('sku',  'like', '%' . $data['search'] . '%' );
        })
        ->with(['variations', 'images'])
        ->withTrashed();

        if(isset($data['status']) && $data['status'] != 'all')
        {
            $products = $products->where('status', $data['status']);
        }

        $products = $products
        ->orderBy('id_number', $data['sort'])
        ->paginate($data['paginate']);

        if(!$data['user']->hasRole(['root', 'master']))//los productos del la tienda asociada al user logueado
        {
            foreach($products as $product)
            {
                $sp = StoreProduct::select(['sku', 'cod', 'stock'])
                ->whereIdStore($data['user']->store_user->id_store)
                ->where('product', '=', $product['sku'])
                ->get();

                $product->variations->each(function ($item, $key) use ($sp) {
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
        }

        return response()->json(['state' => 'success', 'response' => $products], 200);
    }

    public function geFulltList(ListRequest $request)
    {
        $data = $request->all();
        $products = Product::select(
            [
                "name",
                "sku",
                "html_description",
                "html_short_description",
                "sale_price",
                "categories",
                "type",
                "material",
                "theme",
                "tags",
                "weight",
                "height",
                "width",
                "length",
                "title",
                "desc",
                "manufacturer",
                "status",
                "created_at",
            ]
        )
        ->whereIdClient($this->clientMethod->getIdClient())
        ->where(function($query) use ($data) {
            $query->where('name', 'like', '%' . $data['search'] . '%' )
                  ->orWhere('sku',  'like', '%' . $data['search'] . '%' );
        })
        ->with(['variations', 'images'])
        ->withTrashed();

        if(isset($data['status']) && $data['status'] != 'all')
        {
            $products = $products->where('status', $data['status']);
        }

        $products = $products
        ->orderBy('id_number', $data['sort'])
        ->paginate($data['paginate']);

        if(!$data['user']->hasRole(['root', 'master']))//los productos del la tienda asociada al user logueado
        {
            foreach($products as $product)
            {
                $sp = StoreProduct::select(['sku', 'cod', 'stock'])
                ->whereIdStore($data['user']->store_user->id_store)
                ->where('product', '=', $product['sku'])
                ->get();

                $product->variations->each(function ($item, $key) use ($sp) {
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
        }


        return response()->json(['state' => 'success', 'response' => $products], 200);
    }

    public function getListFeatureds(ListFeaturedsRequest $request)
    {
        $data = $request->all();
        $products = Product::withTrashed()
        ->whereIdClient($this->clientMethod->getIdClient())
        ->where('name', 'like', '%' . $data['search'] . '%' )
        ->whereStatus(GlobalStatus::STATUS_ACTIVE)
        ->with('images');

        if(!$data['user']->hasRole(['root', 'master']))//los productos del la tienda asociada al user logueado
        {
            $products = $products->join('stores_products as sp', 'sp.sku', '=', 'products.sku')->where('sp.id_store', '=', $data['user']->store_user->id_store);
        }

        $products = $products->join('products_featureds as pf', 'pf.sku', '=', 'products.sku')
        ->orderBy('products.created_at', $data['sort'])
        ->get()
        ->groupBy('group');

        return response()->json(['state' => 'success', 'response' => $products], 200);
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['status'] = GlobalStatus::STATUS_ACTIVE;
            $data['id_client'] = $this->clientMethod->getIdClient();
            $categories = $data['categories'];
            unset($data['categories']);
            Product::create($data);

            $mainCategories = explode(',', $categories);//for main categories cat1>cat1a, \n cat2>cat2a>cat2b, \n cat3
            foreach ($mainCategories as $mainCategory)
            {
                $categories = explode('>', $mainCategory);//for subcategories cat1>cat1a
                foreach($categories as $category)
                {
                    $cat = Category::whereSlug($category)->first();
                    ProductCategory::create([
                        'product' => $data['sku'],
                        'id_category' => $cat->id
                    ]);
                }
            }

            $pv =  ProductVariation::create([
                'product' => $data['sku'],
                'cod' => 'U',
                'sku' => 'U',
                'price' => isset($data['price']) ? $data['price'] : 0,
                'description' => isset($data['description']) ? $data['description'] : null,
                'ean13' => isset($data['ean13']) ? $data['ean13'] : null,
                'launch' => isset($data['launch']) ? $data['launch'] : date('Y-m-d'),
            ]);

            $stores = Store::whereidClient($this->clientMethod->getIdClient())->get();

            foreach($stores as $store)
            {
                StoreProduct::insert([
                    'id_store' => $store->id,
                    'product' => $pv['product'],
                    'cod' => $pv['cod'],
                    'sku' => $pv['sku']
                ]);
            }

            DB::commit();
            return response()->json(['state' => 'success', 'response' => ['data' => []]], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ProductController@store: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }

    public function update(UpdateRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $sku = $data['product'];
            $user = $data['user'];
            unset($data['product'], $data['user']);

            Product::whereIdClient($this->clientMethod->getIdClient())
            ->whereSku($sku)
            ->update($data);

            $pv = ProductVariation::whereProduct($sku)
            ->whereCod(isset($data['cod']) ? $data['cod'] : 'U')
            ->whereSku(isset($data['sku']) ? $data['sku'] : 'U')
            ->first();

            $pv->update([
                'price' => isset($data['price']) ? $data['price'] : $pv->price,
                'description' => isset($data['description']) ? $data['description'] : $pv->description,
                'ean13' => isset($data['ean13']) ? $data['ean13'] : $pv->ean13,
                'launch' => isset($data['launch']) ? $data['launch'] : $pv->launch,
            ]);
            DB::commit();
            return response()->json(['state' => 'success', 'response' => ['data' => []]], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ProductController@update: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }

    public function trash(TrashRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $sku = $data['product'];
            unset($data['product']);
            Product::whereIdClient($this->clientMethod->getIdClient())->whereSku($sku)->update(['status' => 'trash']);
            Product::whereIdClient($this->clientMethod->getIdClient())->whereSku($sku)->delete();
            DB::commit();
            return response()->json(['state' => 'success', 'response' => ['data' => []]], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ProductController@trash: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }

    public function restore(RestoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $sku = $data['sku'];
            unset($data['sku']);
            Product::whereIdClient($this->clientMethod->getIdClient())->withTrashed()->whereSku($sku)->restore();
            Product::whereIdClient($this->clientMethod->getIdClient())->whereSku($sku)->update(['status' => GlobalStatus::STATUS_ACTIVE]);
            DB::commit();
            return response()->json(['state' => 'success', 'response' => ['data' => []]], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ProductController@restore: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }

    public function addImage(AddImageRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $urls = $data['urls'];
            $productImages = [];
            foreach($urls as $url) {
                $productImages [] = ProductImage::create([
                    'id' => generateUniqueId(),
                    'product' => $data['product'],
                    'cod' => isset($data['cod']) ? $data['cod'] : 'U',
                    'sku' => isset($data['sku']) ? $data['sku'] : 'U',
                    'url' => $url['url'],
                    'height' => isset($data['height']) ? $data['height'] : 0,
                    'width' => isset($data['width']) ? $data['width'] : 0
                ]);
            }

            DB::commit();
            return response()->json(['state' => 'success', 'response' => ['data' => $productImages]], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ProductController@addImage: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }

    public function deleteImage(DeleteImageRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $id = $data['id_image'];
            $sku = $data['product'];
            ProductImage::whereid($id)->whereProduct($sku)->delete();
            DB::commit();
            return response()->json(['state' => 'success'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ProductController@deleteImage: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }

    public function addCategory(AddCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $cat = Category::whereId($data['id_category'])->whereIdClient($this->clientMethod->getIdClient())->first();
            if($cat && ProductCategory::whereIdCategory($data['id_category'])->whereProduct($data['product'])->count() == 0)
            {
                ProductCategory::create($data);
            }

            DB::commit();
            return response()->json(['state' => 'success', 'response' => ['data' => []]], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ProductController@addCategory: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }

    public function deleteCategory(DeleteCategoryRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            ProductCategory::whereIdCategory($data['id_category'])->whereProduct($data['product'])->delete();
            DB::commit();
            return response()->json(['state' => 'success'], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ProductController@deleteCategory: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }

    public function setStatus(StatusRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $product = Product::whereIdClient($this->clientMethod->getIdClient())->whereSku($data['product'])->first();

            $product->update([
                'status' => $product['status'] == GlobalStatus::STATUS_ACTIVE ? GlobalStatus::STATUS_INACTIVE : GlobalStatus::STATUS_ACTIVE
            ]);

            DB::commit();
            return response()->json(['state' => 'success',  'response' => ['data' => $product]], 200);
        }catch (\Exception $e) {
            DB::rollback();
            logError('ProductController@setStatus: ' . $e->getMessage());
            return response()->json(['state' => 'fail'], 401);
        }
    }
}
