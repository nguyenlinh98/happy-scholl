<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class EmailNotifyCustomer extends VerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->subject(Lang::get('メールアドレス認証'))
            ->line(Lang::get('この度はハピスクにご登録いただき、誠にありがとうございます。'))
            ->line(Lang::get('==================================='))
            ->line(Lang::get('まだ登録手続きは完了しておりません'))
            ->line(Lang::get('==================================='))
            ->line(Lang::get('以下のURLにアクセスし、メールアドレス認証を完了していただきますよう、お願いいたします。'))
            ->line(Lang::get('アドレス'))
            ->action(Lang::get('メールアドレス認証'), $verificationUrl)
            ->line(Lang::get('メールアドレス認証後、アプリにてパスワードの設定をお願いいたします。'))
            ->line(Lang::get('───────────────────────────────────'))
            ->line(Lang::get('株式会社H.S.P'))
            ->line(Lang::get('〒104-0031 東京都中央区京橋1-6-13-7F'))
            ->line(Lang::get('───────────────────────────────────'))
            ->line(Lang::get('以上'));
    }
}
