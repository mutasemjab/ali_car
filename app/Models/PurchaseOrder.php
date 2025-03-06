<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'created_by');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function isConverted()
    {
        return $this->invoice()->exists();
    }

    /**
     * Get the status text
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            1 => 'purchase_order',
            2 => 'converted_to_invoice'
        ];

        return $statuses[$this->status] ?? 'unknown';
    }
}
