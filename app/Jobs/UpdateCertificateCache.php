<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Certificate;
use Illuminate\Support\Facades\Log;

class UpdateCertificateCache implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public function handle(): void
    {
        $cacheKey = 'certificates_name_series';
        $cached = Cache::get($cacheKey) ?? [];
        $allCertificates = Certificate::select('id', 'name', 'series')->get()->toArray();
        
        if (!$cached || count($cached) !== count($allCertificates)) {
            Cache::forget($cacheKey);
            Cache::put($cacheKey, $allCertificates, now()->addMinutes(1));
        }
    }
}