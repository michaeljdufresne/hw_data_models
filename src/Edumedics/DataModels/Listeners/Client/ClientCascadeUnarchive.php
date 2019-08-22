<?php


namespace Edumedics\DataModels\Listeners\Client;

use Edumedics\DataModels\Events\Client\ClientUnarchive;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class ClientCascadeUnarchive extends ListenerAppResolver
{
    /**
     * ClientCascadeUnarchive constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->resolveService('ClientArchivingService');
    }

    /**
     * Handle the event.
     *
     * @param  ClientUnarchive $event
     * @return void
     */
    public function handle(ClientUnarchive $event)
    {
        if (isset($this->resolvedService)) {
            try {
                $this->resolvedService->cascadeClientUnarchive($event->client);
            } catch (\Exception $e) {
                Log::info("Cascade Client Unarchive Failed: " . $e->getMessage());
            }
        }
    }
}