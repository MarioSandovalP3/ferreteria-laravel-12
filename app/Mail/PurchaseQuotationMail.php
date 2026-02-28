<?php

namespace App\Mail;

use App\Models\PurchaseQuotation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\Store;

class PurchaseQuotationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customMessage;
    public $customSubject;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public PurchaseQuotation $quotation,
        ?string $customMessage = null,
        ?string $customSubject = null
    ) {
        $this->customMessage = $customMessage;
        $this->customSubject = $customSubject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $store = Store::first();
        $storeName = $store ? $store->name : config('mail.from.name');
        
        return new Envelope(
            from: new Address(config('mail.from.address'), $storeName),
            subject: $this->customSubject ?? ('Solicitud de Cotización - ' . $this->quotation->rfq_number),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.purchase-quotation-custom',
            with: [
                'quotation' => $this->quotation,
                'customMessage' => $this->customMessage ?? "Estimado/a proveedor,\n\nAdjunto encontrará nuestra solicitud de cotización.\n\nPor favor, envíenos su cotización con los precios y disponibilidad.\n\nGracias.",
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $store = Store::first();
        $pdf = \PDF::loadView('pdfs.purchase-quotation', [
            'quotation' => $this->quotation,
            'store' => $store
        ]);
        
        return [
            Attachment::fromData(fn () => $pdf->output(), $this->quotation->rfq_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
