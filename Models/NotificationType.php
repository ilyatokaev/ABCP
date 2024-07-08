<?php

namespace Models;

class NotificationType extends EnumModelAbstract
{

    /**
     * @return string[]
     */
    protected static function allAsArray(): array
    {

        return [
            1 => 'TYPE_NEW',
            2 => 'TYPE_CHANGE',
        ];

    }
}