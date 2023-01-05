<?php

namespace Services;

use Symfony\Bridge\Twig\Mime\BodyRenderer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Mailer\EventListener\MessageListener;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Twig\Environment as TwigEnvironment;

class MailService
{
    public static function send(TwigEnvironment $twig, string $from, string $to, string $subject, string $text, string $templatePath, array $templateVariables): void
    {

        $messageListener = new MessageListener(null, new BodyRenderer($twig));

        $eventDispatcher = new EventDispatcher();
        $eventDispatcher->addSubscriber($messageListener);

        $transport = Transport::fromDsn('smtp://' . $_ENV['EMAIL_USERNAME'] . ':' . $_ENV['EMAIL_PASSWORD'] . '@' . $_ENV['EMAIL_HOST'] . ':' . $_ENV['EMAIL_PORT'] . '?' . $_ENV['EMAIL_OPTIONS'], $eventDispatcher);
        $mailer = new Mailer($transport, null, $eventDispatcher);

        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text($text)
            ->htmlTemplate($templatePath)
            ->context($templateVariables);
        $mailer->send($email);
    }
}
