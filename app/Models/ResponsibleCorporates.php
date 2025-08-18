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
        'total_energy_consumption_unit',
        'total_renewable_energy_consumption',
        'total_renewable_energy_consumption_unit',
        'total_non_renewable_energy_consumption',
        'total_non_renewable_energy_consumption_unit',
        'renewable_power_percentage',
        'renewable_power_percentage_unit',
        'total_electricity_consumption',
        'total_electricity_consumption_unit',
        'total_fuel_consumption',
        'total_fuel_consumption_unit',
        'specific_energy_consumption',
        'specific_energy_consumption_unit',
        'energy_intensity_per_rupee_turnover',
        'energy_intensity_per_rupee_turnover_unit',
        'water_detail',
        'water_replenishment_percentage',
        'water_replenishment_percentage_unit',
        'total_water_withdrawal',
        'total_water_withdrawal_unit',
        'total_water_withdrawal_by_source',
        'total_water_withdrawal_by_source_unit',
        'total_water_consumption',
        'total_water_consumption_unit',
        'total_water_discharged',
        'total_water_discharged_unit',
        'water_intensity_per_rupee_turnover',
        'water_intensity_per_rupee_turnover_unit',
        'specific_water_consumption',
        'specific_water_consumption_unit',
        'waste_detail',
        'hazardous_waste',
        'hazardous_waste_unit',
        'non_hazardous_waste',
        'non_hazardous_waste_unit',
        'waste_by_type',
        'waste_by_type_unit',
        'waste_by_disposal_method',
        'waste_by_disposal_method_unit',
        'waste_intensity_per_rupee_turnover',
        'waste_intensity_per_rupee_turnover_unit',
        'waste_intensity_physical_output',
        'waste_intensity_physical_output_unit',
        'product_stewardship',
        'emission_detail',
        'scope_1_emissions',
        'scope_1_emissions_unit',
        'scope_2_emissions',
        'scope_2_emissions_unit',
        'scope_3_emissions',
        'scope_3_emissions_unit',
        'total_scope_1_2_emission_intensity',
        'total_scope_1_2_emission_intensity_unit',
        'specific_emissions_scope_1_2_per_rupee_turnover',
        'specific_emissions_scope_1_2_per_rupee_turnover_unit',
        'air_pollutants',
        'air_pollutants_unit',
        'hazardous_air_pollutants',
        'hazardous_air_pollutants_unit',
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
