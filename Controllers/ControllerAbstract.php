<?php

namespace Controllers;

abstract class ControllerAbstract
{
    abstract public function doOperation(): array;

    /**
     * @param string $pName
     * @return array|null
     */
    public static function getRequest(string $pName): ?array
    {

        if (!isset($_REQUEST[$pName])) {
            return null;
        }

        return $_REQUEST[$pName];
    }

    /**
     * Для тестирования использовать этот метод с вхардкоженными данными
     * @param string $pName
     * @return array
     */
    public static function getTestRequest(string $pName): ?array
    {

        $testRequest = [
            'data' => [
                'resellerId' => 12,
                'clientId' => 10,
                'creatorId' => 8,
                'expertId' => 23,
                'notificationType' => 2,
                'complaintId' => 44,
                'consumptionId' => 2,
                'agreementNumber' => 122,
                'date' => '',
                'differences' => [
                    'to' => 22,
                    'from' => 33,
                ],
            ]
        ];

        if (!isset($testRequest[$pName])) {
            return null;
        }

        return $testRequest[$pName];

    }

}