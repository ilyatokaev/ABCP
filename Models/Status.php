<?php

namespace Models;

class Status extends EnumModelAbstract
{

    /**
     * @return string[]
     */
    protected static function allAsArray(): array
    {
        return [
            0 => 'Completed',
            1 => 'Pending',
            2 => 'Rejected',
        ];
    }

}