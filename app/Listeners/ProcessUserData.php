<?php

namespace App\Listeners;

use App\Events\UserDataAdded;
use App\Services\CardCodeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessUserData implements ShouldQueue
{
    protected CardCodeService $cardCodeService;

    /**
     * Create the event listener.
     */
    public function __construct(CardCodeService $cardCodeService)
    {
        $this->cardCodeService = $cardCodeService;
    }

    /**
     * Handle the event.
     */
    public function handle(UserDataAdded $event): void
    {
        $this->cardCodeService->getDataAddQueue($event);
    }
}
