<?php

namespace PandaLeague\JsonSchemaBuilder;

trait BaseObjectType
{
    protected $properties = [];
    protected $additionalProperties;
    protected $required;
    protected $minProperties;
    protected $maxProperties;
    protected $dependencies = [];
    protected $patternProperties = [];


    public function property(string $name, Type $type): parent
    {
        $this->properties[$name] = $type;
        return $this;
    }

    public function additionalProperties($add) : parent
    {
        if (! is_bool($add) && ! $add instanceof Type) {
            throw new \InvalidArgumentException('AdditionalProperties should be a bool or an object');
        }

        $this->additionalProperties = $add;
        return $this;
    }

    public function required(array $required) : parent
    {
        foreach ($required as $field) {
            if (!is_string($field)) {
                throw new \InvalidArgumentException('Required must be an array of strings');
            }
        }
        $this->required = $required;
        return $this;
    }

    public function size(?int $min, ?int $max) : parent
    {
        $this->minProperties = $min;
        $this->maxProperties = $max;

        return $this;
    }

    public function propertyDependency(string $from, array $to) : parent
    {
        if (!isset($this->properties[$from])) {
            throw new \InvalidArgumentException('You must first set the property "'.$from.'"');
        }

        foreach ($to as $t) {
            if (!isset($this->properties[$t])) {
                throw new \InvalidArgumentException('You must first set the property "'.$t.'"');
            }
        }

        $this->dependencies[$from] = $to;

        return $this;
    }

    public function schemaDependency(string $from, array $to) : parent
    {
        if (!isset($this->properties[$from])) {
            throw new \InvalidArgumentException('You must first set the property "'.$from.'"');
        }

        $this->dependencies[$from] = $to;
        return $this;
    }

    public function patternProperty(string $pattern, Type $type): parent
    {
        $this->patternProperties[$pattern] = $type;
        return $this;
    }
}