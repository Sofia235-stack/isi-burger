<?php
namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureMail extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.facture')
                    ->attachData($this->generatePDF(), 'facture.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }

    protected function generatePDF()
    {
        $pdf = PDF::loadView('pdf.facture', ['commande' => $this->commande]);
        return $pdf->output();
    }
}