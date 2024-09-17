<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmSubmission extends Notification
{
    use Queueable;

    protected $user;
    protected $regarding;
    protected $submission;

    /**
     * Create a new notification instance.
     */

    public function __construct($user, $regarding, $submission) 
    {
        $this->user = $user;
        $this->submission = $submission;
        $this->regarding = $regarding;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/submissions/' . $this->submission->id);

        return (new MailMessage)
            ->greeting('Hello pengawas!')
            ->line('Ada pengajuan baru!!')
            ->line("$this->regarding")
            ->line("Oleh user dengan nip $this->user")
            ->line('Silahkan klik tombol dibawah ini untuk melihat detail pengajuan')
            ->action('Pengajuan Baru', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'submission_id' => $this->submission->id,
            'user' => $this->user,
            'message' => $this->regarding
        ];
    }
}
