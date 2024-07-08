<?php

namespace Controllers;

use Contexts\TsControllerContext;
use Exception;

class TsController extends ControllerAbstract
{

    /**
     * @throws Exception
     */
    public function doOperation(): array
    {

//        $data = self::getRequest('data'); // На бою раскомментарит ь и закомментарить тестовый метод ниже строчкой
        $data = self::getTestRequest('data'); // На бою закомментарить и раскомментарить метод выше строчкой

        if (!isset($data)) {
            throw new Exception("data parameter missing", 400);
        }


        self::validateData($data);
        $context = new TsControllerContext($data);


        // Сейчас настроено для использования вашего метода MessagesClient::sendMessage()
        if ($context->notificationType->getName() === 'TYPE_NEW') {
            $result = $context->complaint->notifyContactorsAboutNewComplaintOldMethod($context->template); // Использовать для применения старого вашего метода отправки email-уведомлений MessagesClient::sendMessage()
        } elseif ($context->notificationType->getName() === 'TYPE_CHANGE') {
            $result = $context->complaint->notifyContactorsAboutChangeStatusOldMethod($context->template, $context->differencesTo); // Использовать для применения старого вашего метода отправки email-уведомлений MessagesClient::sendMessage()
        } else {
            throw new Exception('unknown notification type', 400);
        }


        // Для иллюстрации, как бы я делал, при проектировании "почти с нуля", для приближения к SOLID, можно раскоментарить if-блок ниже, а if-блок выше - закоментарить
//        if ($context->notificationType->getName() === 'TYPE_NEW') {
//            $result = $context->complaint->notifyContactorsAboutNew($context->template); // Использовать для применения нового метода отправки уведомлений (имеется в виду, использование какого то абстрактного почтового сервиса, приближенного к SOLID)
//        } elseif ($context->notificationType->getName() === 'TYPE_CHANGE') {
//            $result = $context->complaint->notifyContactorsAboutChangeStatus($context->template, $context->differencesTo); // Использовать для применения нового метода отправки уведомлений (имеется в виду, использование какого то абстрактного почтового сервиса, приближенного к SOLID)
//        } else {
//            throw new Exception('unknown notification type', 400);
//        }


        return $result;

    }


    /**
     * @param $data
     * @return void
     * @throws Exception
     */
    public static function validateData($data)
    {

        if (!is_array($data)) {
            throw new Exception('data param is not array type');
        }

        $needleParams = [
            'resellerId',
            'clientId',
            'creatorId',
            'expertId',
            'notificationType',
            'complaintId',
            'consumptionId',
            'agreementNumber',
            'date',
        ];

        if (isset($data['notificationType']) && $data['notificationType'] = 2){
            if (!isset($data['differences']['to'])){
                throw new Exception("differences.to parameter missing");
            }
            if (!isset($data['differences']['from'])){
                throw new Exception("differences.from parameter missing");
            }
        }

        foreach ($needleParams as $param) {
            if (!isset($data[$param])) {
                throw new Exception("{$param} parameter missing");
            }
        }

    }
}