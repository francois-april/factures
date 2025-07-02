<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'currency',
        'discount_rate',
        'status',
        'issued_at',
        'due_at'
    ];

    /**
     * @return HasMany<InvoiceLine>
     */
    public function invoiceLines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class, 'invoice_id');
    }
}
