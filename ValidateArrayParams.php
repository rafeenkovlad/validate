<?php

namespace ExtendsSClass\Validate;

use ReflectionClass;
use RuntimeException;

class ValidateArrayParams extends Type implements ValidateArrayParamsInterface
{
    private TypeParams $type;

    private function validateArrayParams(string $type):bool
    {
        foreach ($this->type as $typeName => $param) {
            if ($typeName !== $type && count($param)>0) {
                return false;
            }
        }

        return true;
    }

    public function validate(?array $array):self
    {
        $this->type = new TypeParams($array, null, null);
        return $this;
    }

    public function to(string $keyName):self
    {
        $array = $this->type->array[$keyName];
        if (!is_array($this->type->array[$keyName])) {
            $array = [$this->type->array[$keyName]];
        }
        $this->type = new TypeParams($array, null, null);

        return $this;
    }

    public function toValue(string $name):TypeParams
    {
        foreach ($this->type as $type => $value) {
            if ($type === self::ARRAY) {
                continue;
            }

            if (key($value) === $name) {
                return new TypeParams($value, $type, $name);
            }
        }
        throw new RuntimeException('key with name ['.$name.'] not exists');
    }

    public function isAllBool():bool
    {
        return $this->validateArrayParams(self::BOOL);
    }

    public function isAllInt():bool
    {
        return $this->validateArrayParams(self::INT);
    }

    public function isAllString():bool
    {
        return $this->validateArrayParams(self::STRING);
    }

    public function isAllArray():bool
    {
        return $this->validateArrayParams(self::ARRAY);
    }

    public function isAllObject():bool
    {
        return $this->validateArrayParams(self::OBJECT);
    }

    public function isAllFloat():bool
    {
        return $this->validateArrayParams(self::FLOAT);
    }
}
