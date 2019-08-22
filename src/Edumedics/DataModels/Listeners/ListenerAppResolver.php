<?php


namespace Edumedics\DataModels\Listeners;

use Edumedics\DataModels\Traits\ServiceResolver;
use Illuminate\Container\Container;

abstract class ListenerAppResolver
{

    use ServiceResolver;

    /**
     * @var static
     */
    public $app;

    /**
     * @var
     */
    public $resolvedService;

    /**
     * ListenerAppResolver constructor.
     */
    public function __construct()
    {
        $this->app = Container::getInstance();
    }
}