<?php

namespace Models;

class SmsMessage
{

    private string $targetPhoneNumber;
    private string $message;

    /**
     * Закрываю конструктор для использования извне
     */
    private function __construct()
    {
    }

    /**
     * @param string $message
     * @return self|null
     */
    public static function create(string $targetPhoneNumber, string $message): self
    {

        $instance = new self();
        $instance->targetPhoneNumber = $targetPhoneNumber;
        $instance->message = $message;

        return $instance;
    }


    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


    /**
     * @return string
     */
    public function getTargetPhoneNumber(): string
    {
        return $this->targetPhoneNumber;
    }



}