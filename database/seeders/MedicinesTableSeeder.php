<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Request;
use App\Models\Medicine;

class MedicinesTableSeeder extends Seeder
{
    public function run()
    {
        $requests = Request::all();

        foreach ($requests as $request) {
            $medicineCount = rand(2, 5);

            for ($i = 1; $i <= $medicineCount; $i++) {
                Medicine::create([
                    'request_id' => $request->id,
                    'name' => 'Лекарство ' . $i,
                    'price' => rand(50, 500),  
                    'quantity' => rand(1, 10),  
                ]);
            }
        }
    }
}
