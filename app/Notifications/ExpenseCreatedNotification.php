<?php

namespace App\Notifications;

use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ExpenseCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Expense $expense)
    {
        $this->connection = 'database'; 
    }
    public function via($notifiable)
    {
        return ["mail"];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Despesa Cadastrada')
            ->greeting('Olá ' . $this->expense->user->name)
            ->line('Uma nova despesa foi criada :')
            ->line('Descrição: ' . $this->expense->description)
            ->line('Valor: ' . 'R$'.$this->expense->amount)
            ->line('Data: ' . $this->expense->expense_date)
            ->line('Obrigado por usar nosso sistema!');
    }

}
