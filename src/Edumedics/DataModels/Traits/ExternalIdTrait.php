<?php

namespace Edumedics\DataModels\Traits;


use Edumedics\DataModels\Dto\Common\ExternalIdDto;

/**
 * Trait ExternalIdTrait
 * @package Edumedics\DataModels\Traits
 */
trait ExternalIdTrait
{

    /**
     * @param $externalIds
     * @param $type
     * @return null
     */
    public function getExternalIdOfType($externalIds, $type)
    {
        foreach($externalIds as $externalId)
        {
            if(isset($externalId['type']) && $externalId['type'] == $type)
            {
                return isset($externalId['id']) ? $externalId['id'] : null;
            }
        }

        return null;
    }

    /**
     * @param $externalIds
     * @return mixed|null
     */
    public function getExternalIdOfEhr($externalIds)
    {
        foreach($externalIds as $externalId)
        {
            if(isset($externalId['type'])
                && in_array($externalId['type'], ExternalIdDto::$EHR_TYPES)
                && isset($externalId['id']))
            {
                return $externalId;
            }
        }

        return null;
    }
}