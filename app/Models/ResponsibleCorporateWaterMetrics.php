<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsibleCorporateWaterMetrics extends Model
{
    protected $table = 'responsible_corporate_water_metrics';

    protected $fillable = [
        'responsible_corporate_id',
        'water_detail',
        'water_initiative_detail',
        'water_withdrawal_source_surface',
        'water_withdrawal_source_surface_unit',
        'water_withdrawal_source_ground',
        'water_withdrawal_source_ground_unit',
        'water_withdrawal_source_thirdparty',
        'water_withdrawal_source_thirdparty_unit',
        'water_withdrawal_source_sea',
        'water_withdrawal_source_sea_unit',
        'water_withdrawal_source_other',
        'water_withdrawal_source_other_unit',
        'total_water_withdrawal',
        'total_water_withdrawal_unit',
        'total_water_consumption',
        'total_water_consumption_unit',
        'water_intensity_per_rupee_turnover',
        'water_intensity_per_rupee_turnover_unit',
        'water_intensity_per_rupee_ppp_turnover',
        'water_intensity_per_rupee_ppp_turnover_unit',
        'water_intensity_physical_output',
        'water_intensity_physical_output_unit',
        'water_intensity',
        'water_intensity_unit',
        'water_discharge_to_surface_water_no_treatment',
        'water_discharge_to_surface_water_no_treatment_unit',
        'water_discharge_to_surface_water_with_treatment',
        'water_discharge_to_surface_water_with_treatment_unit',
        'water_discharge_to_ground_water_no_treatment',
        'water_discharge_to_ground_water_no_treatment_unit',
        'water_discharge_to_ground_water_with_treatment',
        'water_discharge_to_ground_water_with_treatment_unit',
        'water_discharge_to_sea_water_no_treatment',
        'water_discharge_to_sea_water_no_treatment_unit',
        'water_discharge_to_sea_water_with_treatment',
        'water_discharge_to_sea_water_with_treatment_unit',
        'water_discharge_to_thirdparty_water_no_treatment',
        'water_discharge_to_thirdparty_water_no_treatment_unit',
        'water_discharge_to_thirdparty_water_with_treatment',
        'water_discharge_to_thirdparty_water_with_treatment_unit',
        'water_discharge_to_other_water_no_treatment',
        'water_discharge_to_other_water_no_treatment_unit',
        'water_discharge_to_other_water_with_treatment',
        'water_discharge_to_other_water_with_treatment_unit',
        'total_water_discharged',
        'total_water_discharged_unit',
        'water_replenishment_percentage',
        'water_replenishment_percentage_unit',
        'total_water_withdrawal_by_source',
        'total_water_withdrawal_by_source_unit',
        'specific_water_consumption',
        'specific_water_consumption_unit',
    ];

    /**
     * Relationship with the parent corporate record.
     */
    public function corporate()
    {
        return $this->belongsTo(ResponsibleCorporates::class, 'responsible_corporate_id');
    }
}