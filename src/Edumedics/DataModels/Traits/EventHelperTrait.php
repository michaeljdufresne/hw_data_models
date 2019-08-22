<?php

namespace Edumedics\DataModels\Traits;


use Edumedics\DataModels\Events\Event;


trait EventHelperTrait
{

    /**
     * @param Event $event
     * @return object
     * @throws \ReflectionException
     */
    public static function deepCopy(Event $event)
    {
        $copy = (new \ReflectionClass(get_class($event)))->newInstanceWithoutConstructor();

        foreach ($event as $k => $v)
        {
            if (is_object($v) || (is_array($v)))
            {
                $copy->{$k} = unserialize(serialize($v));
            }
            else
            {
                $copy->{$k} = $v;
            }
        }

        return $copy;
    }

    /**
     * @return string
     */
    public static function getEnvConfig()
    {
        $tenantSchema = config('database.connections.pgsql_tenant.schema');
        return !empty($tenantSchema)? $tenantSchema : '';
    }

}