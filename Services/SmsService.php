<?php

namespace Models;

use NW\WebService\References\Operations\Notification\NotificationEvents;

class SmsService
{



    /**
     * Закрываем конструктор, чтобы реализовать логику негативного сценария, при невозможности использования почтового сервиса
     */
    private function __construct()
    {
    }

    /**
     * @return self|null
     */
    public static function create(): ?self
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
     * @param SmsMessage $message
     * @return bool
     */
    public function sendMessage(SmsMessage $message): bool
    {
        // Тут нужна реализация отправки СМС через конкретный СМС-сервис
        return true;
    }
}