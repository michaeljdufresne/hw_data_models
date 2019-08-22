<?php

namespace Edumedics\DataModels\DrChrono;

use Illuminate\Support\Facades\Validator;

abstract class BaseModel implements \JsonSerializable
{
    protected $rules = array();

    protected $errors;

    public static function formatDateTime($dateTime = null)
    {
        if (!isset($dateTime) || !($dateTime instanceof \DateTime))
        {
            return null;
        }
        return $dateTime->format("Y-m-d\TH:i:s");
    }

    public static function formatDate($dateTime = null)
    {
        if (!isset($dateTime) || !($dateTime instanceof \DateTime))
        {
            return null;
        }
        return $dateTime->format("Y-m-d");
    }

    public function validate()
    {
        // make a new validator object
        $v = Validator::make($this->jsonSerialize(), $this->rules);

        // check for failure
        if ($v->fails())
        {
            // set errors and return false
            $this->errors = $v->errors()->toArray();
            return false;
        }

        // validation pass
        return true;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    public function __get($k)
    {
        if (!$this->__isset($k)) {
            return NULL;
        }
        return $this->{$k};
    }

    public function __set($k, $v)
    {
        $this->{$k} = $v;
    }

    public function __isset($k)
    {
        return isset($this->$k);
    }

    public function __toString()
    {
        return json_encode($this);
    }

    public function jsonSerialize()
    {
        return (array) $this;
    }

    public function getMultipartDataFields()
    {
        return (array) $this;
    }

}