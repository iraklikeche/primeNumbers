<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitNumbersRequest;
use App\Jobs\ProcessNumbersJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Request as HttpRequest;

class NumberController extends Controller
{
  public function submitNumbers(SubmitNumbersRequest $request): JsonResponse
    {
      ProcessNumbersJob::dispatch($request->validated()['numbers']);

        return response()->json(['success' => true]);

    }
}
