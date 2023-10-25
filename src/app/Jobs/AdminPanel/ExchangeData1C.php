<?php

namespace App\Jobs\AdminPanel;

use App\Models\AdminPanel\DataExchange;
use App\Services\AdminPanel\DataEchange1C;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
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
        $timeStart = Carbon::now()->format('Y-m-d H:i:s');

        $m = DataExchange::where('id', $this->id);

        $m->update(['status' => 'run', 'date_start' => $timeStart]);

        try {
            $message = (new DataEchange1C())->exchange();

            $timeEnd = Carbon::now()->format('Y-m-d H:i:s');

            $m->update([
                'status' => 'complete',
                'message' => $message,
                'date_end' => Carbon::now()->format('Y-m-d H:i:s'),
                'time_spent' => $this->getTime($timeStart, $timeEnd),
            ]);

        } catch (\Throwable $th) {

            $m->update([
                'status' => 'error',
                'message' => $th->getMessage(),
                'date_end' => $timeEnd,
                'time_spent' => $this->getTime($timeStart, $timeEnd),
            ]);
        }
    }

    private function getTime($start, $end)
    {
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $end);

        return $from->diff($to)->format('%H:%I:%S');
    }
}
