<?php

namespace Models;

/**
 * Не наследуемся ни от какого родителя, т.к. Продавцы - это обычно отдельная сущность.
 * Но при этом реализуем интерфейс контрактора
 */
class Seller implements ContractorInterface
{

    private int $id;
    private string $name;

    use CommonGettersTrait;

    /**
     * Метод, вместо функции getResellerEmailFrom() из исходного кода
     *
     * @return string
     */
    public function getEmailFrom()
    {
        // fakes the method
        return 'contractor@example.com';
    }

    /**
     * Метод, вместо функции getEmailsByPermit() из исходного кода
     *
     * @param string $event
     * @return string[]
     */
    public function getEmailsByPermit(string $event)
    {
        // fakes the method
        return ['someemeil@example.com', 'someemeil2@example.com'];
    }

}