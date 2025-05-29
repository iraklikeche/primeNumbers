<?php

namespace App\Jobs;

use Illuminate\Bus\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;

class ProcessNumbersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $numbers;

    public function __construct(array $numbers)
    {
        $this->numbers = $numbers;
    }

    public function handle()
    {
        $chunks = array_chunk($this->numbers, 300);
        $jobs = [];

        foreach ($chunks as $chunk) {
            $jobs[] = new ProcessNumberChunkJob($chunk);
        }

        Bus::batch($jobs)->dispatch();
    }
}