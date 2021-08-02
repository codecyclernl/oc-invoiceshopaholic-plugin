<?php namespace Codecycler\InvoiceShopaholic\NotifyRules;

use Twig;
use Mail;
use System\Models\MailTemplate;
use Renatio\DynamicPDF\Classes\PDF;
use RainLab\Notify\Classes\ActionBase;
use Renatio\DynamicPDF\Models\Template;
use Lovata\OrdersShopaholic\Models\Order;
use Lovata\OrdersShopaholic\Classes\Item\OrderItem;

class GenerateInvoicePdf extends ActionBase
{
    public function actionDetails()
    {
        return [
            'name' => 'Generate an invoice and send it to the customer',
            'description' => 'Generate an invoice for the given order and send to customer',
            'icon' => 'icon-envelope',
        ];
    }

    public function triggerAction($params)
    {
        $sOrderNumber = $params['order_number'];

        // Get the invoice by order number
        $obOrder = Order::getByNumber($sOrderNumber)->first();

        // Generate PDF by template
        $filename = storage_path('app/uploads/invoice-' . $sOrderNumber . '.pdf');

        //
        $data = array_merge($params, [
            'obOrder' => $obOrder,
            'arOrder' => OrderItem::make($obOrder->id),
        ]);

        //
        if ($this->host->send_invoice) {
            PDF::loadTemplate($this->host->pdf_template, $data)
            ->save($filename);
        }

        //
        Mail::send($this->host->mail_template, $data, function ($message) use ($data, $filename) {
            $twig = new Twig\Environment(new Twig\Loader\ArrayLoader([
                'subject' => $this->host->email_subject,
                'to' => $this->host->email_address,
            ]));

            $message->subject($twig->render('subject', $data));
            $message->to($twig->render('to', $data));

            if ($this->host->send_invoice) {
                $message->attach($filename);
            }
        });
    }

    public function getMailTemplateOptions()
    {
        $codes = array_keys(MailTemplate::listAllTemplates());
        $result = array_combine($codes, $codes);
        return $result;
    }

    public function getPdfTemplateOptions()
    {
        $codes = Template::all()->pluck('code')->toArray();
        $result = array_combine($codes, $codes);
        return $result;
    }

    public function defineFormFields()
    {
        return 'fields.yaml';
    }
}
