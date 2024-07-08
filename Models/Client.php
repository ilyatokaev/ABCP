<?php

namespace Models;

/**
 * Не наследуемся ни от какого родителя, т.к. Клиенты - это обычно отдельная сущность.
 * Но при этом реализуем интерфейс контрактора
 */

class Client implements ContractorInterface
{

    private int $id;
    private string $name;
    private string $email;
    private string $mobile;

    /**
     * @return mixed
     */
    public function getMobile()
    {
        $this->mobile = '+71111111111'; // для тестирования
        return $this->mobile;
    }

    use CommonGettersTrait;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        $this->email = 'client@email.org'; // для тестирования
        return $this->email;
    }

}