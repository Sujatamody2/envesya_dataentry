<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsibleCorporates extends Model
{
    use HasFactory;
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
        'energy_detail',
        'total_energy_consumption',
        'total_renewable_energy_consumption',
        'total_non_renewable_energy_consumption',
        'renewable_power_percentage',
        'total_electricity_consumption',
        'total_fuel_consumption',
        'specific_energy_consumption',
        'energy_intensity_per_rupee_turnover',
        'water_detail',
        'water_replenishment_percentage',
        'total_water_withdrawal',
        'total_water_withdrawal_by_source',
        'total_water_consumption',
        'total_water_discharged',
        'water_intensity_per_rupee_turnover',
        'specific_water_consumption',
        'waste_detail',
        'hazardous_waste',
        'non_hazardous_waste',
        'waste_by_type',
        'waste_by_disposal_method',
        'waste_intensity_per_rupee_turnover',
        'waste_intensity_physical_output',
        'product_stewardship',
        'emission_detail',
        'scope_1_emissions',
        'scope_2_emissions',
        'scope_3_emissions',
        'total_scope_1_2_emission_intensity',
        'specific_emissions_scope_1_2_per_rupee_turnover',
        'air_pollutants',
        'hazardous_air_pollutants',
        'natural_capital',
        'csr_for_climate_action',
        'org_id',
        'type',
        'approval',
        'entered_by'
    ];

    public function enteredByUser()
    {
        return $this->belongsTo(User::class, 'entered_by');
    }
}
