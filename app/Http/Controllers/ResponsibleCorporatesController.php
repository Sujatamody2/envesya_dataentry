<?php

namespace App\Http\Controllers;

use App\Models\ResponsibleCorporates;
use App\Models\ResponsibleCorporateEnergyMetrics;
use App\Models\ResponsibleCorporateWaterMetrics;
use App\Models\ResponsibleCorporateWasteMetrics;
use App\Models\ResponsibleCorporateEmissionMetrics;
use App\Models\ResponsibleCorporateCsrMetrics;
use App\Models\ResponsibleCorporateProductStewardship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class ResponsibleCorporatesController extends Controller
{
    /**
     * Validation rules for core and metrics fields.
     */
    protected function getValidationRules($corporateId = null)
    {
        return [
            // Core fields
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:responsible_corporates,slug' . ($corporateId ? ',' . $corporateId : ''),
            'short_name' => 'nullable|string|max:255',
            'keyword_for_search' => 'nullable|string|max:255',
            'industry' => 'nullable|string',
            'product_profile_sector' => 'nullable|string|max:255',
            'ho_location' => 'nullable|string|max:255',
            'factory_locations' => 'nullable|string',
            'net_zero_target' => 'nullable|string|max:255',
            'certifications_accreditations' => 'nullable|string|max:255',
            'reporting_formats' => 'nullable|string|max:255',
            'ratings' => 'nullable|string|max:255',
            'assessment_verification' => 'nullable|string|max:255',
            'policy_ems' => 'nullable|string|max:255',
            'org_id' => 'nullable|integer',
            'type' => 'nullable|string|max:255',
            'approval' => 'nullable|string|max:255',

            // Energy Metrics (all nullable)
            'energy_detail' => 'nullable|string',
            'energy_initiative_detail' => 'nullable|string',
            'total_electricity_consumption' => 'nullable|string',
            'total_electricity_consumption_unit' => 'nullable|string|max:25',
            'total_fuel_consumption' => 'nullable|string',
            'total_fuel_consumption_unit' => 'nullable|string|max:25',
            'energy_consumption_through_source' => 'nullable|string',
            'energy_consumption_through_source_unit' => 'nullable|string|max:25',
            'total_renewable_energy_consumption' => 'nullable|string',
            'total_renewable_energy_consumption_unit' => 'nullable|string|max:25',
            'total_non_renewable_energy_consumption' => 'nullable|string',
            'total_non_renewable_energy_consumption_unit' => 'nullable|string|max:25',
            'total_non_renewable_electricity_consumption' => 'nullable|string',
            'total_non_renewable_electricity_consumption_unit' => 'nullable|string|max:25',
            'total_non_renewable_fuel_consumption' => 'nullable|string',
            'total_non_renewable_fuel_consumption_unit' => 'nullable|string|max:25',
            'non_renewable_energy_consumption_through_source' => 'nullable|string',
            'non_renewable_energy_consumption_through_source_unit' => 'nullable|string|max:25',
            'total_energy_consumption' => 'nullable|string',
            'total_energy_consumption_unit' => 'nullable|string|max:25',
            'energy_intensity_per_rupee_turnover' => 'nullable|string',
            'energy_intensity_per_rupee_turnover_unit' => 'nullable|string|max:25',
            'energy_intensity_per_rupee_turnover_ppp' => 'nullable|string',
            'energy_intensity_per_rupee_turnover_ppp_unit' => 'nullable|string|max:25',
            'energy_intensity_physical_output' => 'nullable|string',
            'energy_intensity_physical_output_unit' => 'nullable|string|max:25',
            'energy_intensity' => 'nullable|string',
            'energy_intensity_unit' => 'nullable|string|max:25',
            'renewable_power_percentage' => 'nullable|string',
            'renewable_power_percentage_unit' => 'nullable|string|max:25',
            'specific_energy_consumption' => 'nullable|string',
            'specific_energy_consumption_unit' => 'nullable|string|max:25',

            // Water Metrics (all nullable)
            'water_detail' => 'nullable|string',
            'water_initiative_detail' => 'nullable|string',
            'water_withdrawal_source_surface' => 'nullable|string',
            'water_withdrawal_source_surface_unit' => 'nullable|string|max:25',
            'water_withdrawal_source_ground' => 'nullable|string',
            'water_withdrawal_source_ground_unit' => 'nullable|string|max:25',
            'water_withdrawal_source_thirdparty' => 'nullable|string',
            'water_withdrawal_source_thirdparty_unit' => 'nullable|string|max:25',
            'water_withdrawal_source_sea' => 'nullable|string',
            'water_withdrawal_source_sea_unit' => 'nullable|string|max:25',
            'water_withdrawal_source_other' => 'nullable|string',
            'water_withdrawal_source_other_unit' => 'nullable|string|max:25',
            'total_water_withdrawal' => 'nullable|string',
            'total_water_withdrawal_unit' => 'nullable|string|max:25',
            'total_water_consumption' => 'nullable|string',
            'total_water_consumption_unit' => 'nullable|string|max:25',
            'water_intensity_per_rupee_turnover' => 'nullable|string',
            'water_intensity_per_rupee_turnover_unit' => 'nullable|string|max:25',
            'water_intensity_per_rupee_ppp_turnover' => 'nullable|string',
            'water_intensity_per_rupee_ppp_turnover_unit' => 'nullable|string|max:25',
            'water_intensity_physical_output' => 'nullable|string',
            'water_intensity_physical_output_unit' => 'nullable|string|max:25',
            'water_intensity' => 'nullable|string',
            'water_intensity_unit' => 'nullable|string|max:25',
            'water_discharge_to_surface_water_no_treatment' => 'nullable|string',
            'water_discharge_to_surface_water_no_treatment_unit' => 'nullable|string|max:25',
            'water_discharge_to_surface_water_with_treatment' => 'nullable|string',
            'water_discharge_to_surface_water_with_treatment_unit' => 'nullable|string|max:25',
            'water_discharge_to_ground_water_no_treatment' => 'nullable|string',
            'water_discharge_to_ground_water_no_treatment_unit' => 'nullable|string|max:25',
            'water_discharge_to_ground_water_with_treatment' => 'nullable|string',
            'water_discharge_to_ground_water_with_treatment_unit' => 'nullable|string|max:25',
            'water_discharge_to_sea_water_no_treatment' => 'nullable|string',
            'water_discharge_to_sea_water_no_treatment_unit' => 'nullable|string|max:25',
            'water_discharge_to_sea_water_with_treatment' => 'nullable|string',
            'water_discharge_to_sea_water_with_treatment_unit' => 'nullable|string|max:25',
            'water_discharge_to_thirdparty_water_no_treatment' => 'nullable|string',
            'water_discharge_to_thirdparty_water_no_treatment_unit' => 'nullable|string|max:25',
            'water_discharge_to_thirdparty_water_with_treatment' => 'nullable|string',
            'water_discharge_to_thirdparty_water_with_treatment_unit' => 'nullable|string|max:25',
            'water_discharge_to_other_water_no_treatment' => 'nullable|string',
            'water_discharge_to_other_water_no_treatment_unit' => 'nullable|string|max:25',
            'water_discharge_to_other_water_with_treatment' => 'nullable|string',
            'water_discharge_to_other_water_with_treatment_unit' => 'nullable|string|max:25',
            'total_water_discharged' => 'nullable|string',
            'total_water_discharged_unit' => 'nullable|string|max:25',
            'water_replenishment_percentage' => 'nullable|string',
            'water_replenishment_percentage_unit' => 'nullable|string|max:25',
            'total_water_withdrawal_by_source' => 'nullable|string',
            'total_water_withdrawal_by_source_unit' => 'nullable|string|max:25',
            'specific_water_consumption' => 'nullable|string',
            'specific_water_consumption_unit' => 'nullable|string|max:25',

            // Waste Metrics (all nullable)
            'waste_detail' => 'nullable|string',
            'waste_initiative_detail' => 'nullable|string',
            'plastic_waste' => 'nullable|string',
            'plastic_waste_unit' => 'nullable|string|max:25',
            'e_waste' => 'nullable|string',
            'e_waste_unit' => 'nullable|string|max:25',
            'biological_waste' => 'nullable|string',
            'biological_waste_unit' => 'nullable|string|max:25',
            'construction_waste' => 'nullable|string',
            'construction_waste_unit' => 'nullable|string|max:25',
            'battery_waste' => 'nullable|string',
            'battery_waste_unit' => 'nullable|string|max:25',
            'radioactive_waste' => 'nullable|string',
            'radioactive_waste_unit' => 'nullable|string|max:25',
            'hazardous_waste' => 'nullable|string',
            'hazardous_waste_unit' => 'nullable|string|max:25',
            'non_hazardous_waste' => 'nullable|string',
            'non_hazardous_waste_unit' => 'nullable|string|max:25',
            'waste_intensity_per_rupee_turnover' => 'nullable|string',
            'waste_intensity_per_rupee_turnover_unit' => 'nullable|string|max:25',
            'waste_intensity_ppp' => 'nullable|string',
            'waste_intensity_ppp_unit' => 'nullable|string|max:25',
            'waste_intensity_physical_output' => 'nullable|string',
            'waste_intensity_physical_output_unit' => 'nullable|string|max:25',
            'waste_intensity' => 'nullable|string',
            'waste_intensity_unit' => 'nullable|string|max:25',
            'plastic_waste_recycled' => 'nullable|string',
            'plastic_waste_recycled_unit' => 'nullable|string|max:25',
            'plastic_waste_reused' => 'nullable|string',
            'plastic_waste_reused_unit' => 'nullable|string|max:25',
            'plastic_waste_other_recovery' => 'nullable|string',
            'plastic_waste_other_recovery_unit' => 'nullable|string|max:25',
            'e_waste_recycled' => 'nullable|string',
            'e_waste_recycled_unit' => 'nullable|string|max:25',
            'e_waste_reused' => 'nullable|string',
            'e_waste_reused_unit' => 'nullable|string|max:25',
            'e_waste_other_recovery' => 'nullable|string',
            'e_waste_other_recovery_unit' => 'nullable|string|max:25',
            'biological_waste_recycled' => 'nullable|string',
            'biological_waste_recycled_unit' => 'nullable|string|max:25',
            'biological_waste_reused' => 'nullable|string',
            'biological_waste_reused_unit' => 'nullable|string|max:25',
            'biological_waste_other_recovery' => 'nullable|string',
            'biological_waste_other_recovery_unit' => 'nullable|string|max:25',
            'construction_waste_recycled' => 'nullable|string',
            'construction_waste_recycled_unit' => 'nullable|string|max:25',
            'construction_waste_reused' => 'nullable|string',
            'construction_waste_reused_unit' => 'nullable|string|max:25',
            'construction_waste_other_recovery' => 'nullable|string',
            'construction_waste_other_recovery_unit' => 'nullable|string|max:25',
            'battery_waste_recycled' => 'nullable|string',
            'battery_waste_recycled_unit' => 'nullable|string|max:25',
            'battery_waste_reused' => 'nullable|string',
            'battery_waste_reused_unit' => 'nullable|string|max:25',
            'battery_waste_other_recovery' => 'nullable|string',
            'battery_waste_other_recovery_unit' => 'nullable|string|max:25',
            'radioactive_waste_recycled' => 'nullable|string',
            'radioactive_waste_recycled_unit' => 'nullable|string|max:25',
            'radioactive_waste_reused' => 'nullable|string',
            'radioactive_waste_reused_unit' => 'nullable|string|max:25',
            'radioactive_waste_other_recovery' => 'nullable|string',
            'radioactive_waste_other_recovery_unit' => 'nullable|string|max:25',
            'hazardous_waste_recycled' => 'nullable|string',
            'hazardous_waste_recycled_unit' => 'nullable|string|max:25',
            'hazardous_waste_reused' => 'nullable|string',
            'hazardous_waste_reused_unit' => 'nullable|string|max:25',
            'hazardous_waste_other_recovery' => 'nullable|string',
            'hazardous_waste_other_recovery_unit' => 'nullable|string|max:25',
            'non_hazardous_waste_recycled' => 'nullable|string',
            'non_hazardous_waste_recycled_unit' => 'nullable|string|max:25',
            'non_hazardous_waste_reused' => 'nullable|string',
            'non_hazardous_waste_reused_unit' => 'nullable|string|max:25',
            'non_hazardous_waste_other_recovery' => 'nullable|string',
            'non_hazardous_waste_other_recovery_unit' => 'nullable|string|max:25',
            'plastic_waste_incineration' => 'nullable|string',
            'plastic_waste_incineration_unit' => 'nullable|string|max:25',
            'plastic_waste_landfilling' => 'nullable|string',
            'plastic_waste_landfilling_unit' => 'nullable|string|max:25',
            'plastic_waste_other_disposal' => 'nullable|string',
            'plastic_waste_other_disposal_unit' => 'nullable|string|max:25',
            'e_waste_incineration' => 'nullable|string',
            'e_waste_incineration_unit' => 'nullable|string|max:25',
            'e_waste_landfilling' => 'nullable|string',
            'e_waste_landfilling_unit' => 'nullable|string|max:25',
            'e_waste_other_disposal' => 'nullable|string',
            'e_waste_other_disposal_unit' => 'nullable|string|max:25',
            'biological_waste_incineration' => 'nullable|string',
            'biological_waste_incineration_unit' => 'nullable|string|max:25',
            'biological_waste_landfilling' => 'nullable|string',
            'biological_waste_landfilling_unit' => 'nullable|string|max:25',
            'biological_waste_other_disposal' => 'nullable|string',
            'biological_waste_other_disposal_unit' => 'nullable|string|max:25',
            'construction_waste_incineration' => 'nullable|string',
            'construction_waste_incineration_unit' => 'nullable|string|max:25',
            'construction_waste_landfilling' => 'nullable|string',
            'construction_waste_landfilling_unit' => 'nullable|string|max:25',
            'construction_waste_other_disposal' => 'nullable|string',
            'construction_waste_other_disposal_unit' => 'nullable|string|max:25',
            'battery_waste_incineration' => 'nullable|string',
            'battery_waste_incineration_unit' => 'nullable|string|max:25',
            'battery_waste_landfilling' => 'nullable|string',
            'battery_waste_landfilling_unit' => 'nullable|string|max:25',
            'battery_waste_other_disposal' => 'nullable|string',
            'battery_waste_other_disposal_unit' => 'nullable|string|max:25',
            'radioactive_waste_incineration' => 'nullable|string',
            'radioactive_waste_incineration_unit' => 'nullable|string|max:25',
            'radioactive_waste_landfilling' => 'nullable|string',
            'radioactive_waste_landfilling_unit' => 'nullable|string|max:25',
            'radioactive_waste_other_disposal' => 'nullable|string',
            'radioactive_waste_other_disposal_unit' => 'nullable|string|max:25',
            'hazardous_waste_incineration' => 'nullable|string',
            'hazardous_waste_incineration_unit' => 'nullable|string|max:25',
            'hazardous_waste_landfilling' => 'nullable|string',
            'hazardous_waste_landfilling_unit' => 'nullable|string|max:25',
            'hazardous_waste_other_disposal' => 'nullable|string',
            'hazardous_waste_other_disposal_unit' => 'nullable|string|max:25',
            'non_hazardous_waste_incineration' => 'nullable|string',
            'non_hazardous_waste_incineration_unit' => 'nullable|string|max:25',
            'non_hazardous_waste_landfilling' => 'nullable|string',
            'non_hazardous_waste_landfilling_unit' => 'nullable|string|max:25',
            'non_hazardous_waste_other_disposal' => 'nullable|string',
            'non_hazardous_waste_other_disposal_unit' => 'nullable|string|max:25',
            'waste_by_type' => 'nullable|string',
            'waste_by_type_unit' => 'nullable|string|max:25',
            'waste_by_disposal_method' => 'nullable|string',
            'waste_by_disposal_method_unit' => 'nullable|string|max:25',

            // Emission Metrics (all nullable)
            'emission_detail' => 'nullable|string',
            'emission_initiative_detail' => 'nullable|string',
            'scope_1_emissions' => 'nullable|string',
            'scope_1_emissions_unit' => 'nullable|string|max:25',
            'scope_2_emissions' => 'nullable|string',
            'scope_2_emissions_unit' => 'nullable|string|max:25',
            'specific_emissions_scope_1_2_per_rupee_turnover' => 'nullable|string',
            'specific_emissions_scope_1_2_per_rupee_turnover_unit' => 'nullable|string|max:25',
            'specific_emissions_scope_1_2_intensity_ppp' => 'nullable|string',
            'specific_emissions_scope_1_2_intensity_ppp_unit' => 'nullable|string|max:25',
            'specific_emissions_scope_1_2_intensity_physical_output' => 'nullable|string',
            'specific_emissions_scope_1_2_intensity_physical_output_unit' => 'nullable|string|max:25',
            'total_scope_1_2_emission_intensity' => 'nullable|string',
            'total_scope_1_2_emission_intensity_unit' => 'nullable|string|max:25',
            'scope_3_emissions' => 'nullable|string',
            'scope_3_emissions_unit' => 'nullable|string|max:25',
            'specific_emissions_scope_3_per_rupee_turnover' => 'nullable|string',
            'specific_emissions_scope_3_per_rupee_turnover_unit' => 'nullable|string|max:25',
            'total_scope_3_emission_intensity' => 'nullable|string',
            'total_scope_3_emission_intensity_unit' => 'nullable|string|max:25',
            'no_x' => 'nullable|string',
            'no_x_unit' => 'nullable|string|max:25',
            'so_x' => 'nullable|string',
            'so_x_unit' => 'nullable|string|max:25',
            'particulate_matter' => 'nullable|string',
            'particulate_matter_unit' => 'nullable|string|max:25',
            'pop' => 'nullable|string',
            'pop_unit' => 'nullable|string|max:25',
            'voc' => 'nullable|string',
            'voc_unit' => 'nullable|string|max:25',
            'hazardous_air_pollutants' => 'nullable|string',
            'hazardous_air_pollutants_unit' => 'nullable|string|max:25',
            'other_emission_detail' => 'nullable|string',
            'air_pollutants' => 'nullable|string',
            'air_pollutants_unit' => 'nullable|string|max:25',

            // CSR Metrics (all nullable)
            'csr_for_climate_action' => 'nullable|string',
            'csr_initiative_detail' => 'nullable|string',
            'csr_budget' => 'nullable|string',
            'csr_budget_unit' => 'nullable|string|max:25',

            // Product Stewardship (all nullable)
            'product_stewardship' => 'nullable|string',
            'natural_capital' => 'nullable|string',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $corporates = ResponsibleCorporates::with([
            'energyMetrics',
            'waterMetrics',
            'wasteMetrics',
            'emissionMetrics',
            'csrMetrics',
            'productStewardship'
        ])->get();
        return view('responsible_corporates.index', compact('corporates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('responsible_corporates.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->encodeArrays($request->all());
        $data['slug'] = $data['short_name'];
        $data['entered_by'] = Auth::id();

        // Main record
        $corporate = ResponsibleCorporates::create(Arr::only($data, [
            'name','slug','short_name','keyword_for_search','industry',
            'product_profile_sector','ho_location','factory_locations',
            'net_zero_target','certifications_accreditations','reporting_formats',
            'ratings','assessment_verification','policy_ems','org_id',
            'type','approval','entered_by'
        ]));

        // Related metrics

        $corporate->energyMetrics()->create($data);
        $corporate->waterMetrics()->create($data);
        $corporate->wasteMetrics()->create($data);
        $corporate->emissionMetrics()->create($data);
        $corporate->csrMetrics()->create($data);
        $corporate->productStewardship()->create($data);

        return redirect()->route('responsible-corp-list')->with('success', 'Corporate record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ResponsibleCorporates $responsibleCorporate)
    {
        $responsibleCorporate::with([
            'energyMetrics',
            'waterMetrics',
            'wasteMetrics',
            'emissionMetrics',
            'csrMetrics',
            'productStewardship'
        ])->get();
        return view('responsible_corporates.show', compact('responsibleCorporate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the main model with all its relationships
        $corporateData = ResponsibleCorporates::where('id', $id)->with([
            'energyMetrics',
            'waterMetrics',
            'wasteMetrics',
            'emissionMetrics',
            'csrMetrics',
            'productStewardship'
        ])->first();

        // Handle case where the record is not found
        if (!$corporateData) {
            abort(404, 'Responsible Corporate not found.');
        }

        // Convert the main model object to an array. This is the base for our response.
        $response = $corporateData->toArray();

        // Define the relationships that need to be merged into the main response array.
        // When using toArray(), Laravel converts camelCase relationship names to snake_case keys.
        $relationsToMerge = [
            'energy_metrics',
            'water_metrics',
            'waste_metrics',
            'emission_metrics',
            'csr_metrics',
            'product_stewardship'
        ];

        foreach ($relationsToMerge as $relationKey) {
            // Check if the relationship data exists and is an array
            if (isset($response[$relationKey]) && is_array($response[$relationKey])) {
                // Merge the attributes of the related model into the main response array
                $response = array_merge($response, $response[$relationKey]);
                // Remove the original nested relationship array to keep the final structure clean
                unset($response[$relationKey]);
            }
        }

        // The $response array now has a flat structure with all keys at the top level,
        // which matches the expectations of your Blade view.
        echo $id;
        die;
        return view('responsible_corporates.add', compact('response','id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $this->encodeArrays($request->all());
        $data['entered_by'] = Auth::id();
        // echo $request->listing_id;die;
        $corporate = ResponsibleCorporates::findOrFail($request->listing_id);
        $corporate->update(Arr::only($data, [
            'name','slug','short_name','keyword_for_search','industry',
            'product_profile_sector','ho_location','factory_locations',
            'net_zero_target','certifications_accreditations','reporting_formats',
            'ratings','assessment_verification','policy_ems','org_id',
            'type','approval','entered_by'
        ]));
        echo "<pre>";print_r($corporate);die;

        // Update or create metrics
        $corporate->energyMetrics()->updateOrCreate(['responsible_corporate_id' => $corporate->id], $data);
        $corporate->waterMetrics()->updateOrCreate(['responsible_corporate_id' => $corporate->id], $data);
        $corporate->wasteMetrics()->updateOrCreate(['responsible_corporate_id' => $corporate->id], $data);
        $corporate->emissionMetrics()->updateOrCreate(['responsible_corporate_id' => $corporate->id], $data);
        $corporate->csrMetrics()->updateOrCreate(['responsible_corporate_id' => $corporate->id], $data);
        $corporate->productStewardship()->updateOrCreate(['responsible_corporate_id' => $corporate->id], $data);

        return redirect()->route('responsible-corp-list')->with('success', 'Corporate record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResponsibleCorporates $responsibleCorporate)
    {
        $responsibleCorporate->delete(); // Cascades to related metrics tables due to ON DELETE CASCADE
        return redirect()->route('responsible-corp-list')->with('success', 'Corporate record deleted successfully.');
    }

    private function encodeArrays($data)
    {
        $input = []; // initialize

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Case: array of [year, value] pairs
                if (isset($value[0]['year']) && isset($value[0]['value'])) {
                    $mapped = [];
                    foreach ($value as $row) {
                        if (!empty($row['year']) && !empty($row['value'])) {
                            $mapped[$row['year']] = $row['value'];
                        }
                    }
                    $input[$key] = json_encode($mapped);
                } else {
                    // Generic array (e.g. multi-select checkboxes)
                    $input[$key] = json_encode($value);
                }
            } else {
                // Keep scalar values as-is
                $input[$key] = $value;
            }
        }

        return $input;
    }
}