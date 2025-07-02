<?php

namespace Database\Seeders;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Invoice::factory()->create([
            'customer_name' => 'Test Name 1',
            'currency' => 'CAD',
            'discount_rate' => 25,
            'status' => InvoiceStatus::DRAFT,
            'issued_at' => Carbon::yesterday(),
            'due_at' => Carbon::tomorrow(),
        ]);

        

        Invoice::factory()->create([
            'customer_name' => 'Test Name 2',
            'currency' => 'USD',
            'discount_rate' => 50,
            'status' => InvoiceStatus::SENT,
            'issued_at' => Carbon::yesterday(),
            'due_at' => Carbon::tomorrow(),
        ]);
    }
}
