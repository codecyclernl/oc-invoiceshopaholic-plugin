<?php namespace Codecycler\InvoiceShopaholic;

use Backend;
use System\Classes\PluginBase;
use Codecycler\InvoiceShopaholic\NotifyRules\GenerateInvoicePdf;

/**
 * InvoiceShopaholic Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'InvoiceShopaholic',
            'description' => 'No description provided yet...',
            'author'      => 'Codecycler',
            'icon'        => 'icon-leaf'
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
