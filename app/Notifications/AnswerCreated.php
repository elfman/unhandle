<?php

namespace App\Notifications;

use App\Models\Answer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AnswerCreated extends Notification
{
    use Queueable;

    protected $answer;

    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $question = $this->answer->question;
        $user = $this->answer->user;
        $link = $question->link('#answer' . $this->answer->id);

        return [
            'answer_id' => $this->answer->id,
            'answer_body' => substr(strip_tags(\Parsedown::instance()->text($this->answer->body)), 0, 100),
            'user_id' => $user->id,
            'user_name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'answer_link' => $link,
            'question_id' => $question->id,
            'question_title' => $question->title,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
