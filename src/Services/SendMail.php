<?php

namespace App\Services;

use Dompdf\Dompdf;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendMail
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(
        Address $from,
        string $to,
        string $subject,
        string $template,
        array $context
    ): void {
        // Création de l'email avec le contenu Twig
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/$template.html.twig")
            ->context($context);

        // Envoi de l'email
        $this->mailer->send($email);
    }

    public function imageToBase64($path)
    {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

   /*  public function sendWithAttachment(
        Address $from,
        string $to,
        string $subject,
        string $template,
        array $context,
        Dompdf $pdf
    ): void {
        // Création de l'email avec le contenu Twig et la pièce jointe
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/$template.html.twig")
            ->context($context)
            ->attach($pdf->output(), 'Facture.pdf', 'application/pdf');

        // Envoi de l'email
        $this->mailer->send($email);
    } */
}
