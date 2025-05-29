<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckPrimeJob implements ShouldQueue
{
 use InteractsWithQueue, Queueable, SerializesModels;

    public int|float $number;

    public function __construct(int|float $number)
    {
        $this->number = $number;
    }

    public function handle(): void
    {
        if ($this->isPrime($this->number)) {
            Log::channel('prime')->info("{$this->number}: number found at " . now());
        }
    }

    protected function isPrime(int|float $n): bool
    {
        if (!is_int($n) || $n < 2) return false;
        if (in_array($n, [2, 3])) return true;
        if ($n % 2 === 0) return false;

        for ($i = 3, $max = sqrt($n); $i <= $max; $i += 2) {
            if ($n % $i === 0) {
                return false;
            }
        }

        return true;
    }
}
