<?php namespace Codecycler\InvoiceShopaholic;

use Backend;
use System\Classes\PluginBase;
use Codecycler\InvoiceShopaholic\NotifyRules\GenerateInvoicePdf;

/**
 * InvoiceShopaholic Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = [
        'Codecycler.NotifyShopaholic',
        'RainLab.Notify',
        'Lovata.Shopaholic',
        'Lovata.OrdersShopaholic',
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Invoice for Shopaholic',
            'description' => 'Adds a send invoice action to the notify plugin',
            'author'      => 'Codecycler',
            'icon'        => 'icon-bell-o',
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
    }

    public function registerNotificationRules()
    {
        return [
            'actions' => [
                GenerateInvoicePdf::class,
            ],
        ];
    }
}
