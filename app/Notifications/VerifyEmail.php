<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyEmail extends VerifyEmailBase
{
    // use Queueable;

    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }
        return (new MailMessage)
            ->subject('Verifiasi Email')
            ->line('Silahkan klik tombol dibawah untuk memverifikasi email anda.')
            ->action(
                'Verifikasi Email',
                $this->verificationUrl($notifiable)
            )
            ->line('Jika kamu tidak membuat akun, tidak ada tindakan yang lain yang diperlukan.');
    }
}
