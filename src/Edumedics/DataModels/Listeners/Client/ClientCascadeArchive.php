<?php


namespace Edumedics\DataModels\Listeners\Client;

use Edumedics\DataModels\Events\Client\ClientArchive;
use Edumedics\DataModels\Listeners\ListenerAppResolver;
use Illuminate\Support\Facades\Log;

class ClientCascadeArchive extends ListenerAppResolver
{
    /**
     * ClientCascadeArchive constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->resolveService('ClientArchivingService');
    }

    /**
     * Handle the event.
     *
     * @param  ClientArchive $event
     * @return void
     */
    public function handle(ClientArchive $event)
    {
        if (isset($this->resolvedService)) {
            try {
                $this->resolvedService->cascadeClientArchive($event->client);
            } catch (\Exception $e) {
                Log::info("Cascade Client Archive Failed: " . $e->getMessage());
            }
        }
    }
}