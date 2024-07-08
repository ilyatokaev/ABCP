<?php

namespace Models;


use Fake_entities\MessagesClient;
use Fake_entities\NotificationManager;
use Templates\Template;

class Complaint extends SimpleModelAbstract
{

    public Seller $reseller;
    public Client $client;


    /**
     * Отправка уведомлений о Новой "заявке" (с использованием "нового почтового сервиса")
     *
     * @param Template $template
     * @return array
     */
    public function notifyContactorsAboutNew(Template $template): array
    {

        return [
            'notificationEmployeeByEmail' => $this->notifyEmployeesByEmail($template),
            'notificationClientByEmail' => false,
            'notificationClientBySms' => [
                'isSent' => false,
                'message' => ''
            ]
        ];

    }

    /**
     * Отправка уведомлений об изменении статуса по "заявке"
     *
     * @param Template $template
     * @param int $differencesTo для совместимости со старым сервисом отправки SMS
     * @return array
     */
    public function notifyContactorsAboutChangeStatus(Template $template, int $differencesTo): array
    {

        return [
            'notificationEmployeeByEmail' => $this->notifyEmployeesByEmail($template),
            'notificationClientByEmail' => $this->notifyClientByEmail($template),
            'notificationClientBySms' => $this->notifyClientByMobile($template, $differencesTo)
        ];

    }

    /**
     * Отправка уведомлений сотрудникам на email НОВЫЙ МЕТОД (для приближения к соответствию SOLID)
     *
     * @return false
     */
    private function notifyEmployeesByEmail(Template $template): bool
    {

        $emailsTo = $this->reseller->getEmailsByPermit('tsGoodsReturn');
        if (!is_array($emailsTo) || count($emailsTo) < 1) {
            return false;
        }

        $emailFrom = $this->reseller->getEmailFrom();
        if (!isset($emailFrom)) {
            return false;
        }

        $emailService = EmailService::create();


        foreach ($emailsTo as $emailTo) {

            $emailMessage = EmailMessage::create(
                $emailFrom,
                $emailTo,
                __('complaintEmployeeEmailSubject', $template->getData(), $this->reseller->getId()),
                __('complaintEmployeeEmailBody', $template->getData(), $this->reseller->getId())
            );

            if (!$emailService->sendMessage($emailMessage)){
                return false;
            }

        }


        return true;
    }

    /**
     * Отправка уведомлений клиентам на email НОВЫЙ МЕТОД (для приближения к соответствию SOLID)
     *
     * @return false
     */
    private function notifyClientByEmail(Template $template): bool
    {

        $emailTo = $this->client->getEmail();
        if (!isset($emailTo)) {
            return false;
        }

        $emailFrom = $this->reseller->getEmailFrom();
        if (!isset($emailFrom)) {
            return false;
        }

        $emailService = EmailService::create();

        $emailMessage = EmailMessage::create(
            $emailFrom,
            $emailTo,
            __('complaintEmployeeEmailSubject', $template->getData(), $this->reseller->getId()),
            __('complaintEmployeeEmailBody', $template->getData(), $this->reseller->getId())
        );

        if (!$emailService->sendMessage($emailMessage)){
            return false;
        }

        return true;
    }


    /**
     * Оставляем старый метод отправки SMS, т.к. не понятно, какой текст сообщения формировать
     *
     * @param Template $template
     * @param int $differencesTo
     * @return array
     */
    public function notifyClientByMobile(Template $template, int $differencesTo): array
    {

        $mobile = $this->client->getMobile();
        if (!isset($mobile)){
            return [
                'isSent' => false,
                'message' => 'mobile not defined',
            ];
        }

        // Последний параметр передаю null для соответствия сигнатуре, т.к. в первоначальном коде туда передавалась
        // какая-то переменная $error, которая нигде не определена
        $serviceResult = NotificationManager::send($this->reseller->getId(), $this->client->getId(), NotificationEvent::CHANGE_RETURN_STATUS
            , $differencesTo, $template->getData(), null);


        // Из первоначального кода не ясно, как обрабатывать результат работы сервиса отправки СМС. Поэтому делаю такую реализацию
        if (!$serviceResult) {
            return [
                'isSent' => false,
                'message' => 'unknown error',
            ];
        }

        return [
            'isSent' => true,
            'message' => 'Тестовое сообщение отправлено',
        ];

    }


    /**
     * Отправка уведомлений о Новой "заявке" (с использованием "старого класса для отправки уведомления через email")
     *
     * @param Template $template
     * @return array
     */
    public function notifyContactorsAboutNewComplaintOldMethod(Template $template): array
    {

        return [
            'notificationEmployeeByEmail' => $this->notifyEmployeesByEmailOldMethod($template),
            'notificationClientByEmail' => false,
            'notificationClientBySms' => [
                'isSent' => false,
                'message' => ''
            ]
        ];

    }


    /**
     * Отправка уведомлений всем контракторам старым методом
     *
     * @param Template $template
     * @param string $differencesTo Для совместимости со старым методом
     * @return array
     */
    public function notifyContactorsAboutChangeStatusOldMethod(Template $template, string $differencesTo): array
    {
        $result = [
            'notificationEmployeeByEmail' => $this->notifyEmployeesByEmailOldMethod($template),
            'notificationClientByEmail'   => $this->notifyClientByEmailOldMethod($template, $differencesTo),
            'notificationClientBySms'     => $this->notifyClientByMobile($template, $differencesTo)
        ];

        return $result;
    }




    /**
     * Отправка уведомлений сотрудникам на email. Старый ваш метод, гна случай если у него есть подкапотная логика,
     * критично необходимая для каких то еще манипуляций. Но вызывает сомнение его работоспособность, т.к. в вашем коде,
     * при отправке сообщения на email клиента, он используется с другой сигнатурой
     *
     * @return false
     */
    private function notifyEmployeesByEmailOldMethod(Template $template): bool
    {

        $emailsTo = $this->reseller->getEmailsByPermit('tsGoodsReturn');
        if (!is_array($emailsTo) || count($emailsTo) < 1) {
            return false;
        }

        $emailFrom = $this->reseller->getEmailFrom();
        if (!isset($emailFrom)) {
            return false;
        }


        foreach ($emailsTo as $emailTo) {
            MessagesClient::sendMessage([
                0 => [
                    $emailFrom,
                    $emailTo,
                    __('complaintEmployeeEmailSubject', $template->getData(), $this->reseller->getId()),
                    __('complaintEmployeeEmailBody', $template->getData(), $this->reseller->getId())
                ]
            ], $this->reseller->getId(), NotificationEvent::CHANGE_RETURN_STATUS);
        }

        return true;
    }


    /**
     * Отправка уведомлений клиентам на email. Старый ваш метод, гна случай если у него есть подкапотная логика,
     * критично необходимая для каких то еще манипуляций. Но вызывает сомнение его работоспособность, т.к. в вашем коде,
     * при отправке сообщения на email-ы сотрудников, он используется с другой сигнатурой
     *
     * @return false
     */
    private function notifyClientByEmailOldMethod(Template $template, int $differencesTo): bool
    {

        $emailTo = $this->client->getEmail();
        if (!isset($emailTo)) {
            return false;
        }

        $emailFrom = $this->reseller->getEmailFrom();
        if (!isset($emailFrom)) {
            return false;
        }

        MessagesClient::sendMessage([
            0 => [
                $emailFrom,
                $emailTo,
                __('complaintEmployeeEmailSubject', $template->getData(), $this->reseller->getId()),
                __('complaintEmployeeEmailBody', $template->getData(), $this->reseller->getId())
            ]
        ], $this->reseller->getId(), $this->client->getId(), NotificationEvent::CHANGE_RETURN_STATUS, $differencesTo);

        return true;
    }

}