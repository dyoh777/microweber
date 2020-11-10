<?php

namespace MicroweberPackages\User\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MicroweberPackages\Notification\Channels\AppMailChannel;
use MicroweberPackages\Option\Facades\Option;


class NewRegistration extends Notification implements ShouldQueue
{
    use Queueable;
    use InteractsWithQueue, SerializesModels;

    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', AppMailChannel::class]; //return [AppMailChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = new MailMessage();

        $templateId = Option::getValue('new_user_registration_mail_template', 'users');
        $template = get_mail_template_by_id($templateId, 'new_user_registration');

        if ($template) {

            $loader = new \Twig\Loader\ArrayLoader([
                'mailNewRegistration' => $template['message'],
            ]);
            $twig = new \Twig\Environment($loader);
            $parsedEmail = $twig->render('mailNewRegistration', [
                    'email' => $notifiable->getEmailForPasswordReset(),
                    'username' => $notifiable->username,
                    'url' => url('/'),
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
            $mail->subject($template['subject']);
            $mail->view('app::email.simple', ['content' => $parsedEmail]);
        } else {
            $mail->line('Thank you for your registration.');
            $mail->action('Visit our website', url('/'));
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->user;
    }

    public function message()
    {
        $notif = array();
        $notif['module'] = 'users';
        $notif['rel_type'] = 'users';
        $notif['title'] = 'New user registration';
        $notif['description'] = 'You have new user registration';
        $notif['content'] = 'You have new user registered with the username [{{username}}] and id [{{user_id}}]';

        return $notif;
    }
}
