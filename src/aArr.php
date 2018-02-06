<?php

namespace PandaLeague\JsonSchemaBuilder;

class aArr extends Type
{
    use BaseType;

    protected $items;
    protected $additionalItems;
    protected $minItems;
    protected $maxItems;
    protected $uniqueItems;

    public function __construct()
    {
        parent::__construct('array');
    }

    public function items($items, bool $additionalItems = null) : aArr
    {
        if (is_array($items)) {
            foreach ($items as $item) {
                if (!$item instanceof Type) {
                    throw new \InvalidArgumentException('Items array must be a Type object');
                }
            }
            $this->additionalItems = $additionalItems;
        } elseif (!$items instanceof Type) {
            throw new \InvalidArgumentException('Items array must be a Type object');
        }

        $this->items = $items;

        return $this;
    }

    public function size(int $min = null, int $max = null) : aArr
    {
        if (!is_null($min) && $min < 0) {
            throw new \InvalidArgumentException('Minimum value must be greater than 0');
        }

        if (!is_null($max) && $max < 0) {
            throw new \InvalidArgumentException('Maximum value must be greater than 0');
        }

        $this->minItems = $min;
        $this->maxItems = $max;

        return $this;
    }

    public function uniqueItems(bool $isUnique) : aArr
    {
        $this->uniqueItems = $isUnique;
        return $this;
    }
}