<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsibleCorporateCsrMetrics extends Model
{
    protected $table = 'responsible_corporate_csr_metrics';

    protected $fillable = [
        'responsible_corporate_id',
        'csr_for_climate_action',
        'csr_initiative_detail',
        'csr_budget',
        'csr_budget_unit',
    ];

    /**
     * Relationship with the parent corporate record.
     */
    public function corporate()
    {
        return $this->belongsTo(ResponsibleCorporates::class, 'responsible_corporate_id');
    }
}