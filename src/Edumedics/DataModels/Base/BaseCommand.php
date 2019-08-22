<?php


namespace Edumedics\DataModels\Base;


use Edumedics\DataModels\Traits\TenantConnectorTrait;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{

    use TenantConnectorTrait;

    /**
     * BaseCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}