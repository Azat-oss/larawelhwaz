<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    // Передаем имя пользователя в конструктор
    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Добро пожаловать на наш сайт!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome', // Представление, которое мы создадим на Шаге 3
        );
    }
}