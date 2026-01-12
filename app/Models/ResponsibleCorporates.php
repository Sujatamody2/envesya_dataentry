<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsibleCorporates extends Model
{
    protected $table = 'responsible_corporates';

    protected $fillable = [
        'name',
        'slug',
        'short_name',
        'keyword_for_search',
        'industry',
        'product_profile_sector',
        'ho_location',
        'factory_locations',
        'net_zero_target',
        'certifications_accreditations',
        'reporting_formats',
        'ratings',
        'assessment_verification',
        'policy_ems',
        'org_id',
        'type',
        'approval',
        'entered_by',
        'api_push_site',
        'pushed_to_uat',
        'pushed_to_production',
        'uat_push_date',
        'production_push_date',
        'uat_push_response',
        'production_push_response',
    ];

    /**
     * One-to-one relationship with energy metrics.
     */
    public function energyMetrics()
    {
        return $this->hasOne(ResponsibleCorporateEnergyMetrics::class, 'responsible_corporate_id');
    }

    /**
     * One-to-one relationship with water metrics.
     */
    public function waterMetrics()
    {
        return $this->hasOne(ResponsibleCorporateWaterMetrics::class, 'responsible_corporate_id');
    }

    /**
     * One-to-one relationship with waste metrics.
     */
    public function wasteMetrics()
    {
        return $this->hasOne(ResponsibleCorporateWasteMetrics::class, 'responsible_corporate_id');
    }

    /**
     * One-to-one relationship with emission metrics.
     */
    public function emissionMetrics()
    {
        return $this->hasOne(ResponsibleCorporateEmissionMetrics::class, 'responsible_corporate_id');
    }

    /**
     * One-to-one relationship with CSR metrics.
     */
    public function csrMetrics()
    {
        return $this->hasOne(ResponsibleCorporateCsrMetrics::class, 'responsible_corporate_id');
    }

    /**
     * One-to-one relationship with product stewardship.
     */
    public function productStewardship()
    {
        return $this->hasOne(ResponsibleCorporateProductStewardship::class, 'responsible_corporate_id');
    }

    /**
     * Relationship with the user who entered the record.
     */
    public function enteredBy()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }
}