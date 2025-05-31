<?php

namespace App\Contracts;

interface FillValuesOnCreationInterface
{
    public static function createWithValues($data);
}
