<?php

namespace PandaLeague\JsonSchemaBuilder;

trait BaseType
{
    protected $id;
    protected $schema;
    protected $title;
    protected $description;
    protected $default;
    protected $enum;
    protected $anyOf;
    protected $allOf;
    protected $oneOf;
    protected $not;
    protected $links;
    protected $ref;
    protected $readOnly;
    protected $writeOnly;
    protected $nullable;

    public function id(string $id) : parent
    {
        $this->id = $id;
        return $this;
    }

    public function schema($schema) : parent
    {
        $this->schema = $schema;
        return $this;
    }

    public function title(string $title) : parent
    {
        $this->title = $title;
        return $this;
    }

    public function description(string $description) : parent
    {
        $this->description = $description;
        return $this;
    }

    public function enum(array $enum) : parent
    {
        switch ($this->type)
        {
            case 'string' :
                foreach ($enum as $val) {
                    if (!is_string($val)) {
                        throw new \InvalidArgumentException('All enum values must be a string');
                    }
                }
                break;
            case 'boolean':
            case 'array':
                throw new \InvalidArgumentException('enum not available for array or boolean types');
                break;
            case 'number':
                foreach ($enum as $val) {
                    if (!is_numeric($val)) {
                        throw new \InvalidArgumentException('All enum values must be a number');
                    }
                }
                break;
        }

        $this->enum = $enum;

        return $this;
    }

    public function anyOf(array $items) : parent
    {
        foreach ($items as $a) {
            if (!$a instanceof Type) {
                throw new \InvalidArgumentException('Array must contain elements of type Type');
            }
        }
        $this->anyOf = $items;
        return $this;
    }

    public function allOf(array $items) : parent
    {
        foreach ($items as $a) {
            if (!$a instanceof Type) {
                throw new \InvalidArgumentException('Array must contain elements of type Type');
            }
        }
        $this->allOf = $items;
        return $this;
    }

    public function oneOf(array $items) : parent
    {
        foreach ($items as $a) {
            if (!$a instanceof Type) {
                throw new \InvalidArgumentException('Array must contain elements of type Type');
            }
        }
        $this->oneOf = $items;
        return $this;
    }

    public function not(Type $type) : parent
    {
        $this->not = $type;
        return $this;
    }

    public function link(string $rel, string $href, string $title = '', string $method = 'GET') : parent
    {
        if (!in_array(
            $rel,
            ['self', 'create', 'edit', 'delete', 'replace', 'first', 'last', 'next', 'prev', 'collection', 'latest-version', 'search', 'up']
        )) {
            throw new \InvalidArgumentException('Invalid link relation type');
        }

        if (!in_array($method, ['GET', 'POST', 'DELETE', 'PUT', 'PATCH', 'HEAD', 'CONNECT', 'OPTIONS', 'TRACE'])) {
            throw new \InvalidArgumentException('Invalid http method');
        }

        if (is_null($this->links)) {
            $this->links = [];
        }
        $this->links[] = [
            'rel'    => $rel,
            'href'   => $href,
            'title'  => $title,
            'method' => $method
        ];

        return $this;
    }

    public function ref(string $path) : parent
    {
        $this->ref = $path;
        return $this;
    }

    public function writeOnly(bool $state): parent
    {
        $this->writeOnly = $state;

        return $this;
    }

    public function readOnly(bool $state): parent
    {
        $this->readOnly = $state;

        return $this;
    }

    public function nullable(bool $state): parent
    {
        $this->nullable = $state;

        return $this;
    }
}
