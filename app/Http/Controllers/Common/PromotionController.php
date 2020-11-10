<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Promotion\GetRequest;
use App\Models\GlobalStatus;
use App\Models\Common\Product;
use App\Models\Common\Promotion;
use App\Models\Common\PromotionProduct;
use App\Models\Common\StoreProduct;

class PromotionController extends Controller
{
    public function getPromotion(GetRequest $request)
    {
        $data = $request->all();

        $date = date('Y-m-d');
        $promotion = Promotion::whereDate('start', '<=', $date)
        ->whereDate('end', '>=', $date)
        ->first();

        if($promotion)
        {
            $pp = PromotionProduct::whereIdStore($data['id_store'])->whereIdPromotion($promotion->id)->pluck('product');
            unset($promotion->id);
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
            )->whereStatus(GlobalStatus::STATUS_ACTIVE)
            ->whereIn('sku', $pp)
            ->with(['variations', 'images'])
            ->get();

            foreach($products as $product)
            {
                $sp = StoreProduct::select(['sku', 'cod', 'stock'])
                ->whereIdStore($data['id_store'])
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


            $promotion->products = $products;
            return response()->json(['state' => 'success', 'response' => ['promotion' => $promotion]], 200);
        }
        return response()->json(['state' => 'fail', 'response' => []], 200);
    }

    public function getPromotionNull(GetRequest $request)
    {
        $data = $request->all();

        return response()->json(['state' => 'fail', 'response' => []], 200);
    }

}
