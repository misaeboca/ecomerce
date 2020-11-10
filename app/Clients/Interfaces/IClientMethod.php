<?php

namespace App\Clients\Interfaces;

interface IClientMethod
{
    public function getIdClient();

    public function verifyStock($sku);

    public function verifyStockLocal($sku); //single stock by product, cod and sku

    public function verifyStocksLocal($sku); //stock for one product with all variations

    public function notifyOrder($data);

    public function notifyRefund($data);
}
