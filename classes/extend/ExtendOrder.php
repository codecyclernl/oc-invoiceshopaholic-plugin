<?php namespace Codecycler\InvoiceShopaholic\Classes\Extend;

use Event;
use Lovata\OrdersShopaholic\Models\Order;
use Lovata\OrdersShopaholic\Controllers\Orders;

class ExtendOrder
{
    public function subscribe()
    {
        Event::listen('backend.form.extendFieldsBefore', function ($formWidget) {
            $formWidget->tabs['lazy'] = [
                'Invoice',
            ];
        });

        Event::listen('backend.form.extendFields', function ($formWidget) {
            if (! $formWidget->getController() instanceof Orders) {
                return;
            }

            if (! $formWidget->model instanceof Order) {
                return;
            }

            $formWidget->addTabFields([
                '_invoice' => [
                    'type' => 'partial',
                    'span' => 'full',
                    'tab' => 'Invoice',
                    'path' => '$/codecycler/invoiceshopaholic/partials/order_invoice.htm',
                    'stretch' => true,
                ],
            ]);
        });
    }
}
