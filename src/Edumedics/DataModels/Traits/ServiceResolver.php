<?php
namespace Edumedics\DataModels\Traits;

trait ServiceResolver
{
    /**
     * @param $serviceName
     */
    public function resolveService($serviceName)
    {
        try
        {
            $this->resolvedService = $this->app->make($serviceName);
            if ($this->resolvedService instanceof \Exception)
            {
                $this->resolvedService = null;
            }
        }
        catch (\Exception $e)
        {
            $this->resolvedService = null;
        }
    }
}