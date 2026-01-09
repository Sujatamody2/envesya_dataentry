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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

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
        $corporates_exist_names = ResponsibleCorporates::pluck('name')->toArray();
        $corporates_exist_shortnames = ResponsibleCorporates::pluck('name')->toArray();
        return view('responsible_corporates.add', compact('corporates_exist_names','corporates_exist_shortnames'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formToken = $request->input('_token');
        if ($formToken !== session('_token')) {
            return redirect()->route('responsible-corp-list')->with('error', 'Duplicate form submission detected.');
        }
        session()->forget('_token');

        $data = $this->encodeArrays($request->all());
        $data['slug'] = $data['short_name'];
        $data['entered_by'] = Auth::id();
        // echo "<pre>";
        // print_r($data);
        // die;
        try {
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
        } catch (ExceptionType $e) {
            \Log::error('Error creating corporate record: ' . $e->getMessage());
            return redirect()->route('responsible-corp-list')->with('success', 'Corporate record created successfully.');
        }

        
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
        $corporates_exist_names = ResponsibleCorporates::pluck('name')->toArray();
        $corporates_exist_shortnames = ResponsibleCorporates::pluck('short_name')->toArray();

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
            if (isset($response[$relationKey]) && is_array($response[$relationKey]) && !empty($response[$relationKey])) {
                $relationData = $response[$relationKey];

                // Prevent field name collision for product_stewardship
                if ($relationKey === 'product_stewardship' && isset($relationData['product_stewardship'])) {
                    $relationData['product_stewardship_field'] = $relationData['product_stewardship'];
                    unset($relationData['product_stewardship']);
                }

                $response = array_merge($response, $relationData);
                unset($response[$relationKey]);
            }
        }

        // The $response array now has a flat structure with all keys at the top level,
        // which matches the expectations of your Blade view.
        return view('responsible_corporates.add', compact('response','id','corporates_exist_names','corporates_exist_shortnames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $this->encodeArrays($request->all());
        $data['entered_by'] = Auth::id();
        $corporate = ResponsibleCorporates::findOrFail($request->listing_id);
        $corporate->update(Arr::only($data, [
            'name','slug','short_name','keyword_for_search','industry',
            'product_profile_sector','ho_location','factory_locations',
            'net_zero_target','certifications_accreditations','reporting_formats',
            'ratings','assessment_verification','policy_ems','org_id',
            'type','approval','entered_by'
        ]));

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
    public function destroy($id)
    {
        $responsibleCorporate = ResponsibleCorporates::find($id);
        $responsibleCorporate->delete(); // Cascades to related metrics tables due to ON DELETE CASCADE
        return redirect()->route('responsible-corp-list')->with('success', 'Corporate record deleted successfully.');
    }

    private function encodeArrays($data)
    {
        $input = []; // initialize

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                
                    // Generic array (e.g. multi-select checkboxes)
                    $input[$key] = json_encode($value);
                
            } else {
                // Keep scalar values as-is
                $input[$key] = $value;
            }
        }

        return $input;
    }

    public function listing_statusupdateRes($id, $status, Request $request)
    {
        // Check if the user is authorized
        if (Auth::user()->is_admin !== 1) {
            abort(403, 'Unauthorized action.');
        }

        // Find the corporate record with related metrics
        $corporate = ResponsibleCorporates::with([
            'energyMetrics',
            'waterMetrics',
            'wasteMetrics',
            'emissionMetrics',
            'csrMetrics',
            'productStewardship'
        ])->findOrFail($id);

        // Update the approval status
        $corporate->approval = $status;
        $corporate->save();

        // If status is approved (1), sync with external API
        if ($status === '1') {
            try {
                // Prepare the payload by merging core and related metrics
                $payload = [
                    'name' => $corporate->name,
                    'slug' => $corporate->slug,
                    'short_name' => $corporate->short_name,
                    'keyword_search' => $corporate->keyword_for_search,
                    'industry' => $corporate->industry,
                    'product_profile_sector' => $corporate->product_profile_sector,
                    'ho_location' => $corporate->ho_location,
                    'factory_locations' => $corporate->factory_locations,
                    'net_zero_target' => $corporate->net_zero_target,
                    'certifications_accreditations' => $corporate->certifications_accreditations,
                    'reporting_formats' => $corporate->reporting_formats,
                    'ratings' => $corporate->ratings,
                    'assessment_verification' => $corporate->assessment_verification,
                    'policy_ems' => $corporate->policy_ems,
                    // Energy Metrics
                    'energy_detail' => $corporate->energyMetrics->energy_detail ?? null,
                    'energy_initiative_detail' => $corporate->energyMetrics->energy_initiative_detail ?? null,
                    'total_electricity_consumption' => $corporate->energyMetrics->total_electricity_consumption ?? null,
                    'total_electricity_consumption_unit' => $corporate->energyMetrics->total_electricity_consumption_unit ?? null,
                    'total_fuel_consumption' => $corporate->energyMetrics->total_fuel_consumption ?? null,
                    'total_fuel_consumption_unit' => $corporate->energyMetrics->total_fuel_consumption_unit ?? null,
                    'energy_consumption_through_source' => $corporate->energyMetrics->energy_consumption_through_source ?? null,
                    'energy_consumption_through_source_unit' => $corporate->energyMetrics->energy_consumption_through_source_unit ?? null,
                    'total_renewable_energy_consumption' => $corporate->energyMetrics->total_renewable_energy_consumption ?? null,
                    'total_renewable_energy_consumption_unit' => $corporate->energyMetrics->total_renewable_energy_consumption_unit ?? null,
                    'total_non_renewable_energy_consumption' => $corporate->energyMetrics->total_non_renewable_energy_consumption ?? null,
                    'total_non_renewable_energy_consumption_unit' => $corporate->energyMetrics->total_non_renewable_energy_consumption_unit ?? null,
                    'total_non_renewable_electricity_consumption' => $corporate->energyMetrics->total_non_renewable_electricity_consumption ?? null,
                    'total_non_renewable_electricity_consumption_unit' => $corporate->energyMetrics->total_non_renewable_electricity_consumption_unit ?? null,
                    'total_non_renewable_fuel_consumption' => $corporate->energyMetrics->total_non_renewable_fuel_consumption ?? null,
                    'total_non_renewable_fuel_consumption_unit' => $corporate->energyMetrics->total_non_renewable_fuel_consumption_unit ?? null,
                    'non_renewable_energy_consumption_through_source' => $corporate->energyMetrics->non_renewable_energy_consumption_through_source ?? null,
                    'non_renewable_energy_consumption_through_source_unit' => $corporate->energyMetrics->non_renewable_energy_consumption_through_source_unit ?? null,
                    'total_energy_consumption' => $corporate->energyMetrics->total_energy_consumption ?? null,
                    'total_energy_consumption_unit' => $corporate->energyMetrics->total_energy_consumption_unit ?? null,
                    'energy_intensity_per_rupee_turnover' => $corporate->energyMetrics->energy_intensity_per_rupee_turnover ?? null,
                    'energy_intensity_per_rupee_turnover_unit' => $corporate->energyMetrics->energy_intensity_per_rupee_turnover_unit ?? null,
                    'energy_intensity_per_rupee_turnover_ppp' => $corporate->energyMetrics->energy_intensity_per_rupee_turnover_ppp ?? null,
                    'energy_intensity_per_rupee_turnover_ppp_unit' => $corporate->energyMetrics->energy_intensity_per_rupee_turnover_ppp_unit ?? null,
                    'energy_intensity_physical_output' => $corporate->energyMetrics->energy_intensity_physical_output ?? null,
                    'energy_intensity_physical_output_unit' => $corporate->energyMetrics->energy_intensity_physical_output_unit ?? null,
                    'energy_intensity' => $corporate->energyMetrics->energy_intensity ?? null,
                    'energy_intensity_unit' => $corporate->energyMetrics->energy_intensity_unit ?? null,
                    'renewable_power_percentage' => $corporate->energyMetrics->renewable_power_percentage ?? null,
                    'renewable_power_percentage_unit' => $corporate->energyMetrics->renewable_power_percentage_unit ?? null,
                    'specific_energy_consumption' => $corporate->energyMetrics->specific_energy_consumption ?? null,
                    'specific_energy_consumption_unit' => $corporate->energyMetrics->specific_energy_consumption_unit ?? null,
                    // Water Metrics
                    'water_detail' => $corporate->waterMetrics->water_detail ?? null,
                    'water_initiative_detail' => $corporate->waterMetrics->water_initiative_detail ?? null,
                    'water_withdrawal_source_surface' => $corporate->waterMetrics->water_withdrawal_source_surface ?? null,
                    'water_withdrawal_source_surface_unit' => $corporate->waterMetrics->water_withdrawal_source_surface_unit ?? null,
                    'water_withdrawal_source_ground' => $corporate->waterMetrics->water_withdrawal_source_ground ?? null,
                    'water_withdrawal_source_ground_unit' => $corporate->waterMetrics->water_withdrawal_source_ground_unit ?? null,
                    'water_withdrawal_source_thirdparty' => $corporate->waterMetrics->water_withdrawal_source_thirdparty ?? null,
                    'water_withdrawal_source_thirdparty_unit' => $corporate->waterMetrics->water_withdrawal_source_thirdparty_unit ?? null,
                    'water_withdrawal_source_sea' => $corporate->waterMetrics->water_withdrawal_source_sea ?? null,
                    'water_withdrawal_source_sea_unit' => $corporate->waterMetrics->water_withdrawal_source_sea_unit ?? null,
                    'water_withdrawal_source_other' => $corporate->waterMetrics->water_withdrawal_source_other ?? null,
                    'water_withdrawal_source_other_unit' => $corporate->waterMetrics->water_withdrawal_source_other_unit ?? null,
                    'total_water_withdrawal' => $corporate->waterMetrics->total_water_withdrawal ?? null,
                    'total_water_withdrawal_unit' => $corporate->waterMetrics->total_water_withdrawal_unit ?? null,
                    'total_water_consumption' => $corporate->waterMetrics->total_water_consumption ?? null,
                    'total_water_consumption_unit' => $corporate->waterMetrics->total_water_consumption_unit ?? null,
                    'water_intensity_per_rupee_turnover' => $corporate->waterMetrics->water_intensity_per_rupee_turnover ?? null,
                    'water_intensity_per_rupee_turnover_unit' => $corporate->waterMetrics->water_intensity_per_rupee_turnover_unit ?? null,
                    'water_intensity_per_rupee_ppp_turnover' => $corporate->waterMetrics->water_intensity_per_rupee_ppp_turnover ?? null,
                    'water_intensity_per_rupee_ppp_turnover_unit' => $corporate->waterMetrics->water_intensity_per_rupee_ppp_turnover_unit ?? null,
                    'water_intensity_physical_output' => $corporate->waterMetrics->water_intensity_physical_output ?? null,
                    'water_intensity_physical_output_unit' => $corporate->waterMetrics->water_intensity_physical_output_unit ?? null,
                    'water_intensity' => $corporate->waterMetrics->water_intensity ?? null,
                    'water_intensity_unit' => $corporate->waterMetrics->water_intensity_unit ?? null,
                    'water_discharge_to_surface_water_no_treatment' => $corporate->waterMetrics->water_discharge_to_surface_water_no_treatment ?? null,
                    'water_discharge_to_surface_water_no_treatment_unit' => $corporate->waterMetrics->water_discharge_to_surface_water_no_treatment_unit ?? null,
                    'water_discharge_to_surface_water_with_treatment' => $corporate->waterMetrics->water_discharge_to_surface_water_with_treatment ?? null,
                    'water_discharge_to_surface_water_with_treatment_unit' => $corporate->waterMetrics->water_discharge_to_surface_water_with_treatment_unit ?? null,
                    'water_discharge_to_ground_water_no_treatment' => $corporate->waterMetrics->water_discharge_to_ground_water_no_treatment ?? null,
                    'water_discharge_to_ground_water_no_treatment_unit' => $corporate->waterMetrics->water_discharge_to_ground_water_no_treatment_unit ?? null,
                    'water_discharge_to_ground_water_with_treatment' => $corporate->waterMetrics->water_discharge_to_ground_water_with_treatment ?? null,
                    'water_discharge_to_ground_water_with_treatment_unit' => $corporate->waterMetrics->water_discharge_to_ground_water_with_treatment_unit ?? null,
                    'water_discharge_to_sea_water_no_treatment' => $corporate->waterMetrics->water_discharge_to_sea_water_no_treatment ?? null,
                    'water_discharge_to_sea_water_no_treatment_unit' => $corporate->waterMetrics->water_discharge_to_sea_water_no_treatment_unit ?? null,
                    'water_discharge_to_sea_water_with_treatment' => $corporate->waterMetrics->water_discharge_to_sea_water_with_treatment ?? null,
                    'water_discharge_to_sea_water_with_treatment_unit' => $corporate->waterMetrics->water_discharge_to_sea_water_with_treatment_unit ?? null,
                    'water_discharge_to_thirdparty_water_no_treatment' => $corporate->waterMetrics->water_discharge_to_thirdparty_water_no_treatment ?? null,
                    'water_discharge_to_thirdparty_water_no_treatment_unit' => $corporate->waterMetrics->water_discharge_to_thirdparty_water_no_treatment_unit ?? null,
                    'water_discharge_to_thirdparty_water_with_treatment' => $corporate->waterMetrics->water_discharge_to_thirdparty_water_with_treatment ?? null,
                    'water_discharge_to_thirdparty_water_with_treatment_unit' => $corporate->waterMetrics->water_discharge_to_thirdparty_water_with_treatment_unit ?? null,
                    'water_discharge_to_other_water_no_treatment' => $corporate->waterMetrics->water_discharge_to_other_water_no_treatment ?? null,
                    'water_discharge_to_other_water_no_treatment_unit' => $corporate->waterMetrics->water_discharge_to_other_water_no_treatment_unit ?? null,
                    'water_discharge_to_other_water_with_treatment' => $corporate->waterMetrics->water_discharge_to_other_water_with_treatment ?? null,
                    'water_discharge_to_other_water_with_treatment_unit' => $corporate->waterMetrics->water_discharge_to_other_water_with_treatment_unit ?? null,
                    'total_water_discharged' => $corporate->waterMetrics->total_water_discharged ?? null,
                    'total_water_discharged_unit' => $corporate->waterMetrics->total_water_discharged_unit ?? null,
                    'water_replenishment_percentage' => $corporate->waterMetrics->water_replenishment_percentage ?? null,
                    'water_replenishment_percentage_unit' => $corporate->waterMetrics->water_replenishment_percentage_unit ?? null,
                    'total_water_withdrawal_by_source' => $corporate->waterMetrics->total_water_withdrawal_by_source ?? null,
                    'total_water_withdrawal_by_source_unit' => $corporate->waterMetrics->total_water_withdrawal_by_source_unit ?? null,
                    'specific_water_consumption' => $corporate->waterMetrics->specific_water_consumption ?? null,
                    'specific_water_consumption_unit' => $corporate->waterMetrics->specific_water_consumption_unit ?? null,
                    // Waste Metrics
                    'waste_detail' => $corporate->wasteMetrics->waste_detail ?? null,
                    'waste_initiative_detail' => $corporate->wasteMetrics->waste_initiative_detail ?? null,
                    'plastic_waste' => $corporate->wasteMetrics->plastic_waste ?? null,
                    'plastic_waste_unit' => $corporate->wasteMetrics->plastic_waste_unit ?? null,
                    'e_waste' => $corporate->wasteMetrics->e_waste ?? null,
                    'e_waste_unit' => $corporate->wasteMetrics->e_waste_unit ?? null,
                    'biological_waste' => $corporate->wasteMetrics->biological_waste ?? null,
                    'biological_waste_unit' => $corporate->wasteMetrics->biological_waste_unit ?? null,
                    'construction_waste' => $corporate->wasteMetrics->construction_waste ?? null,
                    'construction_waste_unit' => $corporate->wasteMetrics->construction_waste_unit ?? null,
                    'battery_waste' => $corporate->wasteMetrics->battery_waste ?? null,
                    'battery_waste_unit' => $corporate->wasteMetrics->battery_waste_unit ?? null,
                    'radioactive_waste' => $corporate->wasteMetrics->radioactive_waste ?? null,
                    'radioactive_waste_unit' => $corporate->wasteMetrics->radioactive_waste_unit ?? null,
                    'hazardous_waste' => $corporate->wasteMetrics->hazardous_waste ?? null,
                    'hazardous_waste_unit' => $corporate->wasteMetrics->hazardous_waste_unit ?? null,
                    'non_hazardous_waste' => $corporate->wasteMetrics->non_hazardous_waste ?? null,
                    'non_hazardous_waste_unit' => $corporate->wasteMetrics->non_hazardous_waste_unit ?? null,
                    'waste_intensity_per_rupee_turnover' => $corporate->wasteMetrics->waste_intensity_per_rupee_turnover ?? null,
                    'waste_intensity_per_rupee_turnover_unit' => $corporate->wasteMetrics->waste_intensity_per_rupee_turnover_unit ?? null,
                    'waste_intensity_ppp' => $corporate->wasteMetrics->waste_intensity_ppp ?? null,
                    'waste_intensity_ppp_unit' => $corporate->wasteMetrics->waste_intensity_ppp_unit ?? null,
                    'waste_intensity_physical_output' => $corporate->wasteMetrics->waste_intensity_physical_output ?? null,
                    'waste_intensity_physical_output_unit' => $corporate->wasteMetrics->waste_intensity_physical_output_unit ?? null,
                    'waste_intensity' => $corporate->wasteMetrics->waste_intensity ?? null,
                    'waste_intensity_unit' => $corporate->wasteMetrics->waste_intensity_unit ?? null,
                    'plastic_waste_recycled' => $corporate->wasteMetrics->plastic_waste_recycled ?? null,
                    'plastic_waste_recycled_unit' => $corporate->wasteMetrics->plastic_waste_recycled_unit ?? null,
                    'plastic_waste_reused' => $corporate->wasteMetrics->plastic_waste_reused ?? null,
                    'plastic_waste_reused_unit' => $corporate->wasteMetrics->plastic_waste_reused_unit ?? null,
                    'plastic_waste_other_recovery' => $corporate->wasteMetrics->plastic_waste_other_recovery ?? null,
                    'plastic_waste_other_recovery_unit' => $corporate->wasteMetrics->plastic_waste_other_recovery_unit ?? null,
                    'e_waste_recycled' => $corporate->wasteMetrics->e_waste_recycled ?? null,
                    'e_waste_recycled_unit' => $corporate->wasteMetrics->e_waste_recycled_unit ?? null,
                    'e_waste_reused' => $corporate->wasteMetrics->e_waste_reused ?? null,
                    'e_waste_reused_unit' => $corporate->wasteMetrics->e_waste_reused_unit ?? null,
                    'e_waste_other_recovery' => $corporate->wasteMetrics->e_waste_other_recovery ?? null,
                    'e_waste_other_recovery_unit' => $corporate->wasteMetrics->e_waste_other_recovery_unit ?? null,
                    'biological_waste_recycled' => $corporate->wasteMetrics->biological_waste_recycled ?? null,
                    'biological_waste_recycled_unit' => $corporate->wasteMetrics->biological_waste_recycled_unit ?? null,
                    'biological_waste_reused' => $corporate->wasteMetrics->biological_waste_reused ?? null,
                    'biological_waste_reused_unit' => $corporate->wasteMetrics->biological_waste_reused_unit ?? null,
                    'biological_waste_other_recovery' => $corporate->wasteMetrics->biological_waste_other_recovery ?? null,
                    'biological_waste_other_recovery_unit' => $corporate->wasteMetrics->biological_waste_other_recovery_unit ?? null,
                    'construction_waste_recycled' => $corporate->wasteMetrics->construction_waste_recycled ?? null,
                    'construction_waste_recycled_unit' => $corporate->wasteMetrics->construction_waste_recycled_unit ?? null,
                    'construction_waste_reused' => $corporate->wasteMetrics->construction_waste_reused ?? null,
                    'construction_waste_reused_unit' => $corporate->wasteMetrics->construction_waste_reused_unit ?? null,
                    'construction_waste_other_recovery' => $corporate->wasteMetrics->construction_waste_other_recovery ?? null,
                    'construction_waste_other_recovery_unit' => $corporate->wasteMetrics->construction_waste_other_recovery_unit ?? null,
                    'battery_waste_recycled' => $corporate->wasteMetrics->battery_waste_recycled ?? null,
                    'battery_waste_recycled_unit' => $corporate->wasteMetrics->battery_waste_recycled_unit ?? null,
                    'battery_waste_reused' => $corporate->wasteMetrics->battery_waste_reused ?? null,
                    'battery_waste_reused_unit' => $corporate->wasteMetrics->battery_waste_reused_unit ?? null,
                    'battery_waste_other_recovery' => $corporate->wasteMetrics->battery_waste_other_recovery ?? null,
                    'battery_waste_other_recovery_unit' => $corporate->wasteMetrics->battery_waste_other_recovery_unit ?? null,
                    'radioactive_waste_recycled' => $corporate->wasteMetrics->radioactive_waste_recycled ?? null,
                    'radioactive_waste_recycled_unit' => $corporate->wasteMetrics->radioactive_waste_recycled_unit ?? null,
                    'radioactive_waste_reused' => $corporate->wasteMetrics->radioactive_waste_reused ?? null,
                    'radioactive_waste_reused_unit' => $corporate->wasteMetrics->radioactive_waste_reused_unit ?? null,
                    'radioactive_waste_other_recovery' => $corporate->wasteMetrics->radioactive_waste_other_recovery ?? null,
                    'radioactive_waste_other_recovery_unit' => $corporate->wasteMetrics->radioactive_waste_other_recovery_unit ?? null,
                    'hazardous_waste_recycled' => $corporate->wasteMetrics->hazardous_waste_recycled ?? null,
                    'hazardous_waste_recycled_unit' => $corporate->wasteMetrics->hazardous_waste_recycled_unit ?? null,
                    'hazardous_waste_reused' => $corporate->wasteMetrics->hazardous_waste_reused ?? null,
                    'hazardous_waste_reused_unit' => $corporate->wasteMetrics->hazardous_waste_reused_unit ?? null,
                    'hazardous_waste_other_recovery' => $corporate->wasteMetrics->hazardous_waste_other_recovery ?? null,
                    'hazardous_waste_other_recovery_unit' => $corporate->wasteMetrics->hazardous_waste_other_recovery_unit ?? null,
                    'non_hazardous_waste_recycled' => $corporate->wasteMetrics->non_hazardous_waste_recycled ?? null,
                    'non_hazardous_waste_recycled_unit' => $corporate->wasteMetrics->non_hazardous_waste_recycled_unit ?? null,
                    'non_hazardous_waste_reused' => $corporate->wasteMetrics->non_hazardous_waste_reused ?? null,
                    'non_hazardous_waste_reused_unit' => $corporate->wasteMetrics->non_hazardous_waste_reused_unit ?? null,
                    'non_hazardous_waste_other_recovery' => $corporate->wasteMetrics->non_hazardous_waste_other_recovery ?? null,
                    'non_hazardous_waste_other_recovery_unit' => $corporate->wasteMetrics->non_hazardous_waste_other_recovery_unit ?? null,
                    'plastic_waste_incineration' => $corporate->wasteMetrics->plastic_waste_incineration ?? null,
                    'plastic_waste_incineration_unit' => $corporate->wasteMetrics->plastic_waste_incineration_unit ?? null,
                    'plastic_waste_landfilling' => $corporate->wasteMetrics->plastic_waste_landfilling ?? null,
                    'plastic_waste_landfilling_unit' => $corporate->wasteMetrics->plastic_waste_landfilling_unit ?? null,
                    'plastic_waste_other_disposal' => $corporate->wasteMetrics->plastic_waste_other_disposal ?? null,
                    'plastic_waste_other_disposal_unit' => $corporate->wasteMetrics->plastic_waste_other_disposal_unit ?? null,
                    'e_waste_incineration' => $corporate->wasteMetrics->e_waste_incineration ?? null,
                    'e_waste_incineration_unit' => $corporate->wasteMetrics->e_waste_incineration_unit ?? null,
                    'e_waste_landfilling' => $corporate->wasteMetrics->e_waste_landfilling ?? null,
                    'e_waste_landfilling_unit' => $corporate->wasteMetrics->e_waste_landfilling_unit ?? null,
                    'e_waste_other_disposal' => $corporate->wasteMetrics->e_waste_other_disposal ?? null,
                    'e_waste_other_disposal_unit' => $corporate->wasteMetrics->e_waste_other_disposal_unit ?? null,
                    'biological_waste_incineration' => $corporate->wasteMetrics->biological_waste_incineration ?? null,
                    'biological_waste_incineration_unit' => $corporate->wasteMetrics->biological_waste_incineration_unit ?? null,
                    'biological_waste_landfilling' => $corporate->wasteMetrics->biological_waste_landfilling ?? null,
                    'biological_waste_landfilling_unit' => $corporate->wasteMetrics->biological_waste_landfilling_unit ?? null,
                    'biological_waste_other_disposal' => $corporate->wasteMetrics->biological_waste_other_disposal ?? null,
                    'biological_waste_other_disposal_unit' => $corporate->wasteMetrics->biological_waste_other_disposal_unit ?? null,
                    'construction_waste_incineration' => $corporate->wasteMetrics->construction_waste_incineration ?? null,
                    'construction_waste_incineration_unit' => $corporate->wasteMetrics->construction_waste_incineration_unit ?? null,
                    'construction_waste_landfilling' => $corporate->wasteMetrics->construction_waste_landfilling ?? null,
                    'construction_waste_landfilling_unit' => $corporate->wasteMetrics->construction_waste_landfilling_unit ?? null,
                    'construction_waste_other_disposal' => $corporate->wasteMetrics->construction_waste_other_disposal ?? null,
                    'construction_waste_other_disposal_unit' => $corporate->wasteMetrics->construction_waste_other_disposal_unit ?? null,
                    'battery_waste_incineration' => $corporate->wasteMetrics->battery_waste_incineration ?? null,
                    'battery_waste_incineration_unit' => $corporate->wasteMetrics->battery_waste_incineration_unit ?? null,
                    'battery_waste_landfilling' => $corporate->wasteMetrics->battery_waste_landfilling ?? null,
                    'battery_waste_landfilling_unit' => $corporate->wasteMetrics->battery_waste_landfilling_unit ?? null,
                    'battery_waste_other_disposal' => $corporate->wasteMetrics->battery_waste_other_disposal ?? null,
                    'battery_waste_other_disposal_unit' => $corporate->wasteMetrics->battery_waste_other_disposal_unit ?? null,
                    'radioactive_waste_incineration' => $corporate->wasteMetrics->radioactive_waste_incineration ?? null,
                    'radioactive_waste_incineration_unit' => $corporate->wasteMetrics->radioactive_waste_incineration_unit ?? null,
                    'radioactive_waste_landfilling' => $corporate->wasteMetrics->radioactive_waste_landfilling ?? null,
                    'radioactive_waste_landfilling_unit' => $corporate->wasteMetrics->radioactive_waste_landfilling_unit ?? null,
                    'radioactive_waste_other_disposal' => $corporate->wasteMetrics->radioactive_waste_other_disposal ?? null,
                    'radioactive_waste_other_disposal_unit' => $corporate->wasteMetrics->radioactive_waste_other_disposal_unit ?? null,
                    'hazardous_waste_incineration' => $corporate->wasteMetrics->hazardous_waste_incineration ?? null,
                    'hazardous_waste_incineration_unit' => $corporate->wasteMetrics->hazardous_waste_incineration_unit ?? null,
                    'hazardous_waste_landfilling' => $corporate->wasteMetrics->hazardous_waste_landfilling ?? null,
                    'hazardous_waste_landfilling_unit' => $corporate->wasteMetrics->hazardous_waste_landfilling_unit ?? null,
                    'hazardous_waste_other_disposal' => $corporate->wasteMetrics->hazardous_waste_other_disposal ?? null,
                    'hazardous_waste_other_disposal_unit' => $corporate->wasteMetrics->hazardous_waste_other_disposal_unit ?? null,
                    'non_hazardous_waste_incineration' => $corporate->wasteMetrics->non_hazardous_waste_incineration ?? null,
                    'non_hazardous_waste_incineration_unit' => $corporate->wasteMetrics->non_hazardous_waste_incineration_unit ?? null,
                    'non_hazardous_waste_landfilling' => $corporate->wasteMetrics->non_hazardous_waste_landfilling ?? null,
                    'non_hazardous_waste_landfilling_unit' => $corporate->wasteMetrics->non_hazardous_waste_landfilling_unit ?? null,
                    'non_hazardous_waste_other_disposal' => $corporate->wasteMetrics->non_hazardous_waste_other_disposal ?? null,
                    'non_hazardous_waste_other_disposal_unit' => $corporate->wasteMetrics->non_hazardous_waste_other_disposal_unit ?? null,
                    'waste_by_type' => $corporate->wasteMetrics->waste_by_type ?? null,
                    'waste_by_type_unit' => $corporate->wasteMetrics->waste_by_type_unit ?? null,
                    'waste_by_disposal_method' => $corporate->wasteMetrics->waste_by_disposal_method ?? null,
                    'waste_by_disposal_method_unit' => $corporate->wasteMetrics->waste_by_disposal_method_unit ?? null,
                    'total_waste_generated' => $corporate->wasteMetrics->total_waste_generated ?? null,
                    'total_waste_recovered' => $corporate->wasteMetrics->total_waste_recovered ?? null,
                    'total_waste_disposed' => $corporate->wasteMetrics->total_waste_disposed ?? null,
                    'total_waste_generated_unit' => $corporate->wasteMetrics->total_waste_generated_unit ?? null,
                    'total_waste_recovered_unit' => $corporate->wasteMetrics->total_waste_recovered_unit ?? null,
                    'total_waste_disposed_unit' => $corporate->wasteMetrics->total_waste_disposed_unit ?? null,

                    'total_waste_recovered_recycled' => $corporate->wasteMetrics->total_waste_recovered_recycled ?? null,
                    'total_waste_recovered_reused' => $corporate->wasteMetrics->total_waste_recovered_reused ?? null,
                    'total_waste_recovered_other_recovery' => $corporate->wasteMetrics->total_waste_recovered_other_recovery ?? null,
                    'total_waste_recovered_recycled_unit' => $corporate->wasteMetrics->total_waste_recovered_recycled_unit ?? null,
                    'total_waste_recovered_reused_unit' => $corporate->wasteMetrics->total_waste_recovered_reused_unit ?? null,
                    'total_waste_recovered_other_recovery_unit' => $corporate->wasteMetrics->total_waste_recovered_other_recovery_unit ?? null,

                    'total_waste_disposed_recycled' => $corporate->wasteMetrics->total_waste_disposed_recycled ?? null,
                    'total_waste_disposed_reused' => $corporate->wasteMetrics->total_waste_disposed_reused ?? null,
                    'total_waste_disposed_other_recovery' => $corporate->wasteMetrics->total_waste_disposed_other_recovery ?? null,
                    'total_waste_disposed_recycled_unit' => $corporate->wasteMetrics->total_waste_disposed_recycled_unit ?? null,
                    'total_waste_disposed_reused_unit' => $corporate->wasteMetrics->total_waste_disposed_reused_unit ?? null,
                    'total_waste_disposed_other_recovery_unit' => $corporate->wasteMetrics->total_waste_disposed_other_recovery_unit ?? null,
                    // Emission Metrics
                    'emission_detail' => $corporate->emissionMetrics->emission_detail ?? null,
                    'emission_initiative_detail' => $corporate->emissionMetrics->emission_initiative_detail ?? null,
                    'scope_1_emissions' => $corporate->emissionMetrics->scope_1_emissions ?? null,
                    'scope_1_emissions_unit' => $corporate->emissionMetrics->scope_1_emissions_unit ?? null,
                    'scope_2_emissions' => $corporate->emissionMetrics->scope_2_emissions ?? null,
                    'scope_2_emissions_unit' => $corporate->emissionMetrics->scope_2_emissions_unit ?? null,
                    'specific_emissions_scope_1_2_per_rupee_turnover' => $corporate->emissionMetrics->specific_emissions_scope_1_2_per_rupee_turnover ?? null,
                    'specific_emissions_scope_1_2_per_rupee_turnover_unit' => $corporate->emissionMetrics->specific_emissions_scope_1_2_per_rupee_turnover_unit ?? null,
                    'specific_emissions_scope_1_2_intensity_ppp' => $corporate->emissionMetrics->specific_emissions_scope_1_2_intensity_ppp ?? null,
                    'specific_emissions_scope_1_2_intensity_ppp_unit' => $corporate->emissionMetrics->specific_emissions_scope_1_2_intensity_ppp_unit ?? null,
                    'specific_emissions_scope_1_2_intensity_physical_output' => $corporate->emissionMetrics->specific_emissions_scope_1_2_intensity_physical_output ?? null,
                    'specific_emissions_scope_1_2_intensity_physical_output_unit' => $corporate->emissionMetrics->specific_emissions_scope_1_2_intensity_physical_output_unit ?? null,
                    'total_scope_1_2_emission_intensity' => $corporate->emissionMetrics->total_scope_1_2_emission_intensity ?? null,
                    'total_scope_1_2_emission_intensity_unit' => $corporate->emissionMetrics->total_scope_1_2_emission_intensity_unit ?? null,
                    'scope_3_emissions' => $corporate->emissionMetrics->scope_3_emissions ?? null,
                    'scope_3_emissions_unit' => $corporate->emissionMetrics->scope_3_emissions_unit ?? null,
                    'specific_emissions_scope_3_per_rupee_turnover' => $corporate->emissionMetrics->specific_emissions_scope_3_per_rupee_turnover ?? null,
                    'specific_emissions_scope_3_per_rupee_turnover_unit' => $corporate->emissionMetrics->specific_emissions_scope_3_per_rupee_turnover_unit ?? null,
                    'total_scope_3_emission_intensity' => $corporate->emissionMetrics->total_scope_3_emission_intensity ?? null,
                    'total_scope_3_emission_intensity_unit' => $corporate->emissionMetrics->total_scope_3_emission_intensity_unit ?? null,
                    'no_x' => $corporate->emissionMetrics->no_x ?? null,
                    'no_x_unit' => $corporate->emissionMetrics->no_x_unit ?? null,
                    'so_x' => $corporate->emissionMetrics->so_x ?? null,
                    'so_x_unit' => $corporate->emissionMetrics->so_x_unit ?? null,
                    'particulate_matter' => $corporate->emissionMetrics->particulate_matter ?? null,
                    'particulate_matter_unit' => $corporate->emissionMetrics->particulate_matter_unit ?? null,
                    'pop' => $corporate->emissionMetrics->pop ?? null,
                    'pop_unit' => $corporate->emissionMetrics->pop_unit ?? null,
                    'voc' => $corporate->emissionMetrics->voc ?? null,
                    'voc_unit' => $corporate->emissionMetrics->voc_unit ?? null,
                    'hazardous_air_pollutants' => $corporate->emissionMetrics->hazardous_air_pollutants ?? null,
                    'hazardous_air_pollutants_unit' => $corporate->emissionMetrics->hazardous_air_pollutants_unit ?? null,
                    'other_emission_detail' => $corporate->emissionMetrics->other_emission_detail ?? null,
                    'air_pollutants' => $corporate->emissionMetrics->air_pollutants ?? null,
                    'air_pollutants_unit' => $corporate->emissionMetrics->air_pollutants_unit ?? null,
                    // CSR Metrics
                    'csr_for_climate_action' => $corporate->csrMetrics->csr_for_climate_action ?? null,
                    'csr_initiative_detail' => $corporate->csrMetrics->csr_initiative_detail ?? null,
                    'csr_budget' => $corporate->csrMetrics->csr_budget ?? null,
                    'csr_budget_unit' => $corporate->csrMetrics->csr_budget_unit ?? null,
                    // Product Stewardship
                    'product_stewardship' => $corporate->productStewardship->product_stewardship ?? null,
                    'natural_capital' => $corporate->productStewardship->natural_capital ?? null,
                ];

                $response = Http::post('https://uat.envesya.com/api/store-responsible-corporate', $payload);

                if (!$response->successful()) {
                    Log::error('Failed to sync corporate data with external API', [
                        'corporate_id' => $corporate->id,
                        'response_status' => $response->status(),
                        'response_body' => $response->body(),
                    ]);

                    return Redirect::route('responsible-corp-list', ['page' => $request->query('page')])
                        ->with('error', 'Status updated, but failed to sync with external API.');
                }

                Log::info('Successfully synced corporate data with external API', [
                    'corporate_id' => $corporate->id,
                    'response_status' => $response->status(),
                ]);
            } catch (\Exception $e) {
                Log::error('Exception occurred while syncing corporate data', [
                    'corporate_id' => $corporate->id,
                    'error' => $e->getMessage(),
                ]);

                return Redirect::route('responsible-corp-list', ['page' => $request->query('page')])
                    ->with('error', 'Status updated, but an error occurred while syncing with external API.');
            }
        }

        // Redirect back to the listing page with success message
        return Redirect::route('responsible-corp-list', ['page' => $request->query('page')])
            ->with('success', 'Status updated successfully!');
    }
}