<?php

namespace Models;


class Employee implements ContractorInterface
{
    private int $id;

    private int $type;
    private string $name;
    private string $email;
    private string $mobile;

    use CommonGettersTrait;


    /**
     * Закрываю конструктор для использования извне, т.к. в текущем кейсе не предполагается создание объектов
     * дочерних классов, а возможен только поиск этих объектов про id
     *
     * @param int $contractorId
     */
    private function __construct(int $contractorId)
    {
        $this->id = $contractorId;
        // fakes the __construct method
    }


}