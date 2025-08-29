<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsibleCorporateProductStewardship extends Model
{
    protected $table = 'responsible_corporate_product_stewardship';

    protected $fillable = [
        'responsible_corporate_id',
        'product_stewardship',
        'natural_capital',
    ];

    /**
     * Relationship with the parent corporate record.
     */
    public function corporate()
    {
        return $this->belongsTo(ResponsibleCorporates::class, 'responsible_corporate_id');
    }
}