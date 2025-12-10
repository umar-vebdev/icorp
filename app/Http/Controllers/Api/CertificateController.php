<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Certificate;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Can;
use App\Jobs\UpdateCertificateCache;

use function PHPUnit\Framework\isEmpty;

class CertificateController extends Controller
{
    // getCertificate
    public function getCertificates()
    {
        $cacheKey = 'certificates_names';

        $result = Cache::remember($cacheKey, 10, function()
        {
            return Certificate::pluck('name');
        });

        return response()->json($result);
    }


    //showCertificate
    public function showCertificate($id)
    {
        $cacheKey = 'certificates_all_' . ($id);

        $result = Certificate::where('id', $id)->get();

        return response()->json($result);
    }


    // searchCertificate
    public function searchCertificate(Request $request)
{
    $validated = $request->validate([
        'query' => 'required|max:255'
    ]);

    $query = mb_strtolower(trim($validated['query']));

    $cacheKey = 'certificates_name_series';

    $cached = Cache::get($cacheKey);

    if(empty($cached)){
        UpdateCertificateCache::dispatchSync();
        
        $cached = Cache::get($cacheKey);

        if(empty($cached)) {
            return response()->json([
                'message' => 'Подаждите, данные обновляются'
            ]);
        }
    }

    $result = array_filter($cached, function ($item) use ($query) {
        return str_contains(mb_strtolower($item['name']), $query)
            || str_contains(mb_strtolower($item['series']), $query);
    });

    return response()->json($result);
}   

    //store
    public function store(Request $request)
    {
        $validated = $request->validate([
            
            'name' => 'required|string',
            'series' => 'required|string',
            'date_of_issue' => 'required|date',
            'validity_period' => 'required|date',
            'INN' => 'nullable|string',
            'best_before_date' => 'required|date',
            'manufacturer' => 'required|string',
        ]);
    
        $certificate = Certificate::create($validated);
    
        return response()->json($certificate, 201);
    }


    //update
    public function update(Request $request, $id)
    {
        $certificate = Certificate::find($id);
    
        if(!$certificate) {
            return response()->json([
                'message' => 'Сертификат не найден'
            ], 404);
        }
    
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'series' => 'sometimes|string|max:50',
            'date_of_issue' => 'sometimes|date',
            'validity_period' => 'sometimes|date',
            'INN' => 'nullable|string|max:255',
            'best_before_date' => 'sometimes|date',
            'manufacturer' => 'sometimes|string|max:255'
        ]);
    
        $certificate->update($validated);
    
        return response()->json($certificate);
    }
    


    //destroy
    public function destroy(string $id)
    {
        $certificate = Certificate::find($id);

        if(!$certificate) {
            return response()->json([
                'messege' => 'Сертификат не найден'
            ], 404);
        }

        $certificate->delete();

        return response()->json([
            'messege' => 'Сертификат удален'
        ]);
    }
}
