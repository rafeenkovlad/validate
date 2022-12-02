<?php

namespace ExtendsSClass\Validate;

class TypeParams extends Type
{
    private static ?string $currentCheckType;
    private static $currentCheckValue;
    public array $bool = [];
    public array $int = [];
    public array $string = [];
    public array $array = [];
    public array $object = [];
    public array $float = [];
    public array $null = [];

    public function __construct(?array $params, ?string $chekType, ?string $name)
    {
        foreach ($params as $key=>$type) {
            if (is_bool($type)) {
                if (is_string($key)) {
                    $this->bool[$key] = $type;
                    continue;
                }
                $this->bool[] = $type;
                continue;
            }
            if (is_int($type)) {
                if (is_string($key)) {
                    $this->int[$key] = $type;
                    continue;
                }
                $this->int[] = $type;
                continue;
            }
            if (is_string($type)) {
                if (is_string($key)) {
                    $this->string[$key] = $type;
                    continue;
                }
                $this->string[] = $type;
                continue;
            }
            if (is_array($type)) {
                $this->array[key($type)] = $type[key($type)];
                continue;
            }
            //TODO
            if (is_object($type)) {
                $this->object[] = (array)$type;
                continue;
            }
            if (is_float($type)) {
                if (is_string($key)) {
                    $this->float[$key] = $type;
                    continue;
                }
                $this->float[] = $type;
                continue;
            }
            if (is_null($type)) {
                $this->null[] = $type;
            }
        }

        self::$currentCheckType = $chekType;
        if ($chekType !==null) {
            self::$currentCheckValue = [$name  => $params[$name]];
        }
    }

    private function validateParams(?string $type):bool
    {
        if (empty($this->{$type})) {
            throw new \RuntimeException(key(self::$currentCheckValue).' => '.self::$currentCheckValue[key(self::$currentCheckValue)].' не является значением '.$type);
        }
        return true;
    }

    public function isInt():bool
    {
        return $this->validateParams(self::INT);
    }

    public function isBool():bool
    {
        return $this->validateParams(self::BOOL);
    }

    public function isString():bool
    {
        return $this->validateParams(self::STRING);
    }

    public function isArray():bool
    {
        return $this->validateParams(self::ARRAY);
    }

    public function isObject():bool
    {
        return $this->validateParams(self::OBJECT);
    }

    public function isFloat():bool
    {
        return $this->validateParams(self::FLOAT);
    }
}
