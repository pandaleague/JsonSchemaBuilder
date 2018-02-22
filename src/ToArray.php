<?php

namespace PandaLeague\JsonSchemaBuilder;

use Illuminate\Contracts\Support\Arrayable;

trait ToArray
{
    public function toArray()
    {
        $data = [];
        $r = new \ReflectionClass($this);
        $properties = $r->getProperties();

        foreach ($properties as $property)
        {
            $property->setAccessible(true);
            $value = $property->getValue($this);
            if(is_object($value)) {
                if ($value instanceof Arrayable) {
                    $value = $value->toArray();
                    $data[$property->getName()] = $value;
                }
            }
            elseif ($property->getName() == 'links' && !is_null($value)) {
                $data[$property->getName()] = $value;
            }
            elseif (is_array($value)) {

                foreach ($value as $key => $v) {
                    if(is_object($v)) {
                        if ($v instanceof Arrayable) {
                            $v = $v->toArray();
                            $data[$property->getName()][$key] = $v;
                        }
                    } elseif (!is_array($v)) {
                        $data[$property->getName()][$key] = $v;
                    }
                }
            }
            elseif (!is_null($value)) {
                if ($property->getName() == 'ref') {
                    $data['$ref'] = $value;
                } else {
                    $data[$property->getName()] = $value;
                }
            }
        }

        return $data;
    }
}