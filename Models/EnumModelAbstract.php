<?php

namespace Models;

abstract class EnumModelAbstract
{

    protected int $id;
    protected string $name;

    /**
     * В дочернем классе необходима реализация этого метода, представляющего фактический набор данных модели,
     * для нормальной работы методов текущего абстрактного класса. Есть некоторое нарушение SOLID, но учитывая,
     * что текущий метод абстрактный, такая реализация в "дочке" не причинит вреда для остального функционала.
     * Максимум вред будет только в самой "дочке", по причине самой же ее реализации
     *
     * @return array
     */
    abstract protected static function allAsArray(): array;

    // В дочке реализовать этот метод по образцу, как ниже
//    return [
//            0 => 'name_1',
//            1 => 'name_1',
//            5 => 'name_1'
//    ];

    /**
     * @param int $id
     * @param string $name
     */
    private function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }


    /**
     * @return array[]
     */
    public static function all(): array
    {

        $resultCollection = [];

        foreach (static::allAsArray() as $id => $name) {
            $resultCollection[] = new static($id, $name);
        }

        return $resultCollection;
    }


    /**
     * @param int $id
     * @return static|null
     */
    public static function find(int $id)
    {
        $allAsArray = static::allAsArray();

        if (!isset($allAsArray[$id])) {
            return null;
        }

        return new static($id, $allAsArray[$id]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


}