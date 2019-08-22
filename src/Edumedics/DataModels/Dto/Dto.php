<?php


namespace Edumedics\DataModels\Dto;

/**
 * Class Dto
 * @package Edumedics\DataModels\Dto
 */
abstract class Dto
{

    /**
     * @var
     */
    protected $fillable = [];

    /**
     * @param null $dataArray
     * @return mixed
     */
    abstract public function populate($dataArray = null);

    /**
     * @param null $dateTime
     * @return string|null
     */
    public function formatDateTime($dateTime = null)
    {
        if (!isset($dateTime) || !($dateTime instanceof \DateTime)) {
            return null;
        }
        return $dateTime->format("Y-m-d\TH:i:s");
    }

    /**
     * @param null $dateTime
     * @return string|null
     */
    public function formatDate($dateTime = null)
    {
        if (!isset($dateTime) || !($dateTime instanceof \DateTime)) {
            return null;
        }
        return $dateTime->format("Y-m-d");
    }

    /**
     * @param $k
     * @return |null
     */
    public function __get($k)
    {
        if (!$this->__isset($k)) {
            return NULL;
        }
        return $this->{$k};
    }

    /**
     * @param $k
     * @param $v
     */
    public function __set($k, $v)
    {
        $this->{$k} = $v;
    }

    /**
     * @param $k
     * @return bool
     */
    public function __isset($k)
    {
        return isset($this->$k);
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return (array)$this;
    }

    /**
     * @param $obj
     * @return array|null
     */
    public function jsonSerializeObject($obj = null)
    {
        if (isset($obj) && $obj instanceof Dto)
        {
            return $obj->jsonSerialize();
        }
        return null;
    }

    /**
     * @param int $options
     * @return false|string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * @param null $attributes
     * @return $this
     */
    public function fill($attributes = null)
    {
        if (isset($attributes) && is_array($attributes))
        {
            foreach ($attributes as $key => $value) {
                if ($this->isFillable($key)) {
                    $this->{$key} = $value;
                }
            }
        }
        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    public function isFillable($key)
    {
        if (isset($key))
        {
            if (in_array($key, $this->fillable)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return $this->{$key};
    }

    /**
     * @param null $array
     * @return array|null
     */
    public function jsonSerializeArray($array = null)
    {
        if (isset($array) && is_array($array))
        {
            $arrSerialized = [];
            foreach ($array as $item) {
                $arrSerialized[] = isset($item) ? $item->jsonSerialize() : null;
            }
            return $arrSerialized;
        }
        return null;
    }

}
