<?php

namespace Database\Seeders;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\InvoiceLine;
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

        InvoiceLine::factory()->count(3)->for(
            Invoice::factory()->create([
                'status' => InvoiceStatus::SENT,
                'issued_at' => Carbon::yesterday(),
                'due_at' => Carbon::tomorrow(),
            ])
        );

        InvoiceLine::factory()->count(5)->for(
            Invoice::factory()->create([
                'status' => InvoiceStatus::DRAFT,
                'issued_at' => Carbon::yesterday(),
                'due_at' => Carbon::tomorrow(),
            ])
        );
    }
}
