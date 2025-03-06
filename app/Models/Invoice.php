<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    /**
     * Get the items for this invoice.
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the admin who created this invoice.
     */
    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /**
     * Get the status text
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            1 => 'pending',
            2 => 'paid',
            3 => 'canceled'
        ];

        return $statuses[$this->status] ?? 'unknown';
    }
}
