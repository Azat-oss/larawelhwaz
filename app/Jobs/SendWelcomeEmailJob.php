<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue // Обязательно имплементируем ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userEmail;
    public $userName;

    // Принимаем данные пользователя
    public function __construct($userEmail, $userName)
    {
        $this->userEmail = $userEmail;
        $this->userName = $userName;
    }

    // Логика выполнения задачи
    public function handle(): void
    {
        // Отправляем письмо
        Mail::to($this->userEmail)->send(new WelcomeMail($this->userName));
    }
}