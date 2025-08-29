<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsibleCorporateEnergyMetrics extends Model
{
    protected $table = 'responsible_corporate_energy_metrics';

    protected $fillable = [
        'responsible_corporate_id',
        'energy_detail',
        'energy_initiative_detail',
        'total_electricity_consumption',
        'total_electricity_consumption_unit',
        'total_fuel_consumption',
        'total_fuel_consumption_unit',
        'energy_consumption_through_source',
        'energy_consumption_through_source_unit',
        'total_renewable_energy_consumption',
        'total_renewable_energy_consumption_unit',
        'total_non_renewable_energy_consumption',
        'total_non_renewable_energy_consumption_unit',
        'total_non_renewable_electricity_consumption',
        'total_non_renewable_electricity_consumption_unit',
        'total_non_renewable_fuel_consumption',
        'total_non_renewable_fuel_consumption_unit',
        'non_renewable_energy_consumption_through_source',
        'non_renewable_energy_consumption_through_source_unit',
        'total_energy_consumption',
        'total_energy_consumption_unit',
        'energy_intensity_per_rupee_turnover',
        'energy_intensity_per_rupee_turnover_unit',
        'energy_intensity_per_rupee_turnover_ppp',
        'energy_intensity_per_rupee_turnover_ppp_unit',
        'energy_intensity_physical_output',
        'energy_intensity_physical_output_unit',
        'energy_intensity',
        'energy_intensity_unit',
        'renewable_power_percentage',
        'renewable_power_percentage_unit',
        'specific_energy_consumption',
        'specific_energy_consumption_unit',
    ];

    /**
     * Relationship with the parent corporate record.
     */
    public function corporate()
    {
        return $this->belongsTo(ResponsibleCorporates::class, 'responsible_corporate_id');
    }
}