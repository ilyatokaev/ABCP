<?php

namespace Models;

/**
 * Простая абстракция для однотипных моделей. На данный момент таких моделей 2: Complaint и Consumption
 */
abstract class SimpleModelAbstract
{
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Метод имитирует поиск объекта по его id
     *
     * @param int $id
     * @return static|null
     */
    public static function find(int $id)
    {
        // fake method

        return new static(); // только для имитации возврата объекта текущего класса
    }


    /**
     * @return string
     */
    public function getNumber(): string
    {
        // fake method
        return '';
    }

}