<?php

namespace Models;

interface ContractorInterface
{
    public static function getById(int $contractorId): self; // поиск экземпляра по его уникальному id (например по первичному ключу, но необязательно именно по нему)
    public function getFullName(): string; // формирование полного имени
    public function getId(): int;

}