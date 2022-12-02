<?php

namespace ExtendsSClass\Validate;

interface ValidateArrayParamsInterface
{
    public function validate(array $array):self;

    public function to(string $keyName):self;

    public function isAllBool():bool;

    public function isAllInt():bool;

    public function isAllString():bool;

    public function isAllArray():bool;

    public function isAllObject():bool;

    public function isAllFloat():bool;
}