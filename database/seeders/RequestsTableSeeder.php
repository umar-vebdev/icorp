<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Request as RequestModel;

class RequestsTableSeeder extends Seeder
{
    public function run(): void
    {

        for ($i = 1; $i <= 5; $i++) {
            $date = Carbon::now()->subDays(rand(0, 10));
            $countToday = DB::table('requests')->whereDate('created_at', $date)->count() + 1;
            $requestNumber = $date->format('Ymd') . '-' . str_pad($countToday, 3, '0', STR_PAD_LEFT);

                $request = RequestModel::create([
                'name' => 'Аптека №' . $i,
                'request_number' => $requestNumber,
                'total_amount' => 0, 
                'status' => 'draft',
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}