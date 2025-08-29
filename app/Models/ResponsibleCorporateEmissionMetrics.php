<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsibleCorporateEmissionMetrics extends Model
{
    protected $table = 'responsible_corporate_emission_metrics';

    protected $fillable = [
        'responsible_corporate_id',
        'emission_detail',
        'emission_initiative_detail',
        'scope_1_emissions',
        'scope_1_emissions_unit',
        'scope_2_emissions',
        'scope_2_emissions_unit',
        'specific_emissions_scope_1_2_per_rupee_turnover',
        'specific_emissions_scope_1_2_per_rupee_turnover_unit',
        'specific_emissions_scope_1_2_intensity_ppp',
        'specific_emissions_scope_1_2_intensity_ppp_unit',
        'specific_emissions_scope_1_2_intensity_physical_output',
        'specific_emissions_scope_1_2_intensity_physical_output_unit',
        'total_scope_1_2_emission_intensity',
        'total_scope_1_2_emission_intensity_unit',
        'scope_3_emissions',
        'scope_3_emissions_unit',
        'specific_emissions_scope_3_per_rupee_turnover',
        'specific_emissions_scope_3_per_rupee_turnover_unit',
        'total_scope_3_emission_intensity',
        'total_scope_3_emission_intensity_unit',
        'no_x',
        'no_x_unit',
        'so_x',
        'so_x_unit',
        'particulate_matter',
        'particulate_matter_unit',
        'pop',
        'pop_unit',
        'voc',
        'voc_unit',
        'hazardous_air_pollutants',
        'hazardous_air_pollutants_unit',
        'other_emission_detail',
        'air_pollutants',
        'air_pollutants_unit',
    ];

    /**
     * Relationship with the parent corporate record.
     */
    public function corporate()
    {
        return $this->belongsTo(ResponsibleCorporates::class, 'responsible_corporate_id');
    }
}