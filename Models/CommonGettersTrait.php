<?php

namespace Models;

/**
 * Т.к. пока нет четкого описания, каждого из классов-моделей, реализующих интерфейс контрактора, полагаем, что у них одинаковая
 * реализация некоторых методов. Когда или если дело дойдет до реальной реализации этих классов, то при необходимости
 * можно будет сделать кастомную реализацию этих методов
 */
trait CommonGettersTrait
{

    /**
     * @param int $contractorId
     * @return CommonGettersTrait
     */
    public static function getById(int $contractorId): self
    {
        $instance = new static($contractorId); // fakes the getById method
        $instance->id = $contractorId; // Для тестирования
        $instance->name = 'Имя_объекта_с_id_' . $contractorId . '_класса_' . static::class . '_для_тестирования'; // Для тестирования

        return $instance;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->name . ' ' . $this->id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}