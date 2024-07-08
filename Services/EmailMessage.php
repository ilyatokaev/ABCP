<?php

namespace Models;

class EmailMessage
{

    private string $emailFrom;
    private string $emailTo;
    private string $subject;
    private string $message;


    /**
     * Закрываю конструктор для использования извне
     */
    private function __construct()
    {
    }

    /**
     * @param string $emailFrom
     * @param string $emailTo
     * @param string $subject
     * @param string $message
     * @return self|null
     */
    public static function create(string $emailFrom, string $emailTo, string $subject, string $message): ?self
    {

        if ( !filter_var($emailFrom, FILTER_VALIDATE_EMAIL) || !filter_var($emailTo, FILTER_VALIDATE_EMAIL) ) {
            return null;
        }

        $instance = new self();
        $instance->emailFrom = $emailFrom;
        $instance->emailTo = $emailTo;
        $instance->subject = $subject;
        $instance->message = $message;

        return $instance;
    }


    /**
     * @return string
     */
    public function getEmailFrom(): string
    {
        return $this->emailFrom;
    }

    /**
     * @return string
     */
    public function getEmailTo(): string
    {
        return $this->emailTo;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }


}