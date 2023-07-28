<?php

namespace App\Jobs;

use App\Notifications\JobFail;
use App\Services\BaseService;
use App\Services\CardCodeService;
use Filament\Notifications\Notification;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class AddCardCodeJob implements ShouldQueue
{
    use Batchable,Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    protected Authenticatable $user;

    /**
     * Create a new job instance.
     */
    public function __construct($data, Authenticatable $user)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * @param CardCodeService $cardCodeService
     * @return void
     * @throws Throwable
     */
    public function handle(CardCodeService $cardCodeService): void
    {
        if ($this->batch()->canceled()){
            return;
        }
        $cardCodeService->addToCardCode($this->data);
    }
}
