<?php

namespace App\Notifications;

use App\Models\Answer;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentCreated extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
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
        $commentable = $this->comment->commentable;
        if ($commentable instanceof Answer) {
            $question = $commentable->question;
        } else {
            $question = $commentable;
        }
        $user = $this->comment->user;

        return [
            'comment_id' => $this->comment->id,
            'comment_body' => substr(strip_tags(\Parsedown::instance()->text($this->comment->body)), 0, 100),
            'user_id' => $user->id,
            'user_name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'comment_link' => $question->link('#comment' . $this->comment->id),
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
