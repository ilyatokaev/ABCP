<?php

namespace Models;


/**
 * Класс создан только для совместимости с вашим методом отправки email MessagesClient::sendMessage()
 */
class NotificationEvent
{
    const CHANGE_RETURN_STATUS = 'changeReturnStatus';
    const NEW_RETURN_STATUS    = 'newReturnStatus';
}