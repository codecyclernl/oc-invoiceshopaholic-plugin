<?php

Route::get('/shopaholic/invoice/pdf/{invoiceId}', function ($invoiceId) {
    if (! BackendAuth::getUser()) {
        return '';
    }

    //
    $obOrder = \Lovata\OrdersShopaholic\Models\Order::find($invoiceId);

    if (! $obOrder) {
        return '';
    }

    //
    $data = [
        'obOrder' => $obOrder,
        'arOrder' => \Lovata\OrdersShopaholic\Classes\Item\OrderItem::make($obOrder->id),
    ];

    //
    $pdf = \Renatio\DynamicPDF\Classes\PDF::loadTemplate('default-invoice-template', $data);

    //
    return $pdf->stream($obOrder->order_number);
})->middleware('web');
