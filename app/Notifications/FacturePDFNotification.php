<?php
//
//namespace App\Notifications;
//
//use App\Models\Commande;
//use Barryvdh\DomPDF\Facade\Pdf;
//use Illuminate\Notifications\Notification;
//use Illuminate\Notifications\Messages\MailMessage;
//
//class FacturePDFNotification extends Notification
//{
//    protected $commande;
//
//    public function __construct(Commande $commande)
//    {
//        $this->commande = $commande;
//    }
//
//    public function via($notifiable)
//    {
//        return ['mail'];
//    }
//
//    public function toMail($notifiable)
//    {
//        $pdf = Pdf::loadView('factures.pdf', ['commande' => $this->commande]);
//
//        return (new MailMessage)
//            ->subject('Votre facture pour la commande #' . $this->commande->id)
//            ->line('Votre commande est prête. Vous pouvez télécharger votre facture ci-dessous.')
//            ->attachData($pdf->output(), 'facture_' . $this->commande->id . '.pdf', [
//                'mime' => 'application/pdf',
//            ]);
//    }
//}


namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class FacturePDFNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Générer le PDF et le sauvegarder temporairement
        $pdf = Pdf::loadView('factures.pdf', ['commande' => $this->commande]);
        $pdfPath = 'factures/facture_' . $this->commande->id . '.pdf';
        Storage::disk('local')->put($pdfPath, $pdf->output());

        return (new MailMessage)
            ->subject('Votre facture pour la commande #' . $this->commande->id)
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Votre commande est prête. Vous trouverez ci-joint la facture en PDF.')
            ->line('Merci d\'avoir choisi ISI BURGER 🍔 !')
            ->attach(storage_path('app/' . $pdfPath))
            ->salutation('À très bientôt, L\'équipe ISI BURGER');
    }
}

