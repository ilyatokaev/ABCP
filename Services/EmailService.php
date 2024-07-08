<?php

namespace Models;

use NW\WebService\References\Operations\Notification\NotificationEvents;

class EmailService
{



    /**
     * Закрываем конструктор, чтобы реализовать логику негативного сценария, при невозможности использования почтового сервиса
     */
    private function __construct()
    {
    }

    /**
     * @return EmailService|null
     */
    public static function create(): ?EmailService
    {

        // негативный сценарий при невозможности использования почтового сервиса (на бою false заменить реальным критерием)
        if (false) {
            return null;
        }

        return new self();
    }


    /**
     * В качестве текущего сервиса прикрутил какой-то ваш класс MessagesClient
     *
     * @param EmailMessage $message
     * @return bool
     */
    public function sendMessage(EmailMessage $message): bool
    {

        // Тут нужна реализация отправки письма через конкретный Email-сервис
        return true;
    }
}