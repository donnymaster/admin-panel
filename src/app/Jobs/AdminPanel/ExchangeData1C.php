<?php

namespace App\Jobs\AdminPanel;

use App\Models\AdminPanel\DataExchange;
use App\Services\AdminPanel\DataEchange1C;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExchangeData1C implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id = null;

    /**
     * Create a new job instance.
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new DataEchange1C())->exchange();

        $m = DataExchange::where('id', $this->id);

        $m->update(['status' => 'complete']);
    }
}
