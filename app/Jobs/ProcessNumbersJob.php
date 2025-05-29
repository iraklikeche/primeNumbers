<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
        foreach ($this->numbers as $number) {
            if (is_numeric($number) && floor($number) == $number && $this->isPrime($number)) {
                Log::channel('prime')->info("{$number}: number found at " . now()->toDateTimeString());
            }
        }
    }

    private function isPrime($number): bool
    {
        if ($number <= 1) {
            return false;
        }

        if ($number == 2) {
            return true;
        }

        if ($number % 2 == 0) {
            return false;
        }

        for ($i = 3; $i <= sqrt($number); $i += 2) {
            if ($number % $i == 0) {
                return false;
            }
        }

        return true;
    }
    
}