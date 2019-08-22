<?php


namespace Edumedics\DataModels\Traits;


use Illuminate\Support\Facades\Crypt;

/**
 * Trait Encryptable
 * @package Edumedics\DataModels\Traits
 */
trait Encryptable
{

    /**
     * @param $key
     * @return mixed|string
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (in_array($key, $this->encrypted))
        {
            $value = Crypt::decrypt($value);
        }
        return $value;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypted))
        {
            $value = Crypt::encrypt($value);
        }

        return parent::setAttribute($key, $value);
    }
}