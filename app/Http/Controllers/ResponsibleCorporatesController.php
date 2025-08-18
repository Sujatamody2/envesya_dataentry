<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResponsibleCorporates;
use Illuminate\Support\Facades\Http;

class ResponsibleCorporatesController extends Controller
{
    public function __construct()
    {
        $this->data = [];
    }

    public function index()
    {
        $this->data['industry'] = [];
        $this->data['subsegment'] = [];
        $this->data['industry_arr'] = [];
        $this->data['segment_arr'] = [];
        $this->data['fin_type_arr'] = [];
        return view('responsible_corporates.add', $this->data);
    }

    public function create_responsible_corporate(Request $request)
    {
        if ($request->all()) {
            $data_l = [
                'name' => $request->input('name'),
                'slug' => str_replace(' ', '-', strtolower($request->input('name'))),
                'short_name' => $request->input('short_name'),
                'keyword_for_search' => $request->input('keyword_search'),
                'industry' => json_encode($request->input('industry', [])),
                'product_profile_sector' => $request->input('product_profile_sector'),
                'ho_location' => $request->input('ho_location'),
                'factory_locations' => $request->input('factory_locations'),
                'net_zero_target' => $request->input('net_zero_target'),
                'certifications_accreditations' => $request->input('certifications_accreditations'),
                'reporting_formats' => $request->input('reporting_formats'),
                'ratings' => $request->input('ratings'),
                'assessment_verification' => $request->input('assessment_verification'),
                'policy_ems' => $request->input('policy_ems'),
                'energy_detail' => nl2br($request->input('energy_detail')),
                'total_energy_consumption' => $this->encode_data($request->input('total_energy_consumption', [])),
                'total_energy_consumption_unit' => $request->input('total_energy_consumption_unit'),
                'total_renewable_energy_consumption' => $this->encode_data($request->input('total_renewable_energy_consumption', [])),
                'total_renewable_energy_consumption_unit' => $request->input('total_renewable_energy_consumption_unit'),
                'total_non_renewable_energy_consumption' => $this->encode_data($request->input('total_non_renewable_energy_consumption', [])),
                'total_non_renewable_energy_consumption_unit' => $request->input('total_non_renewable_energy_consumption_unit'),
                'renewable_power_percentage' => $this->encode_data($request->input('renewable_power_percentage', [])),
                'renewable_power_percentage_unit' => $request->input('renewable_power_percentage_unit'),
                'total_electricity_consumption' => $this->encode_data($request->input('total_electricity_consumption', [])),
                'total_electricity_consumption_unit' => $request->input('total_electricity_consumption_unit'),
                'total_fuel_consumption' => $this->encode_data($request->input('total_fuel_consumption', [])),
                'total_fuel_consumption_unit' => $request->input('total_fuel_consumption_unit'),
                'specific_energy_consumption' => $this->encode_data($request->input('specific_energy_consumption', [])),
                'specific_energy_consumption_unit' => $request->input('specific_energy_consumption_unit'),
                'energy_intensity_per_rupee_turnover' => $this->encode_data($request->input('energy_intensity_per_rupee_turnover', [])),
                'energy_intensity_per_rupee_turnover_unit' => $request->input('energy_intensity_per_rupee_turnover_unit'),
                'water_detail' => nl2br($request->input('water_detail')),
                'water_replenishment_percentage' => $this->encode_data($request->input('water_replenishment_percentage', [])),
                'water_replenishment_percentage_unit' => $request->input('water_replenishment_percentage_unit'),
                'total_water_withdrawal' => $this->encode_data($request->input('total_water_withdrawal', [])),
                'total_water_withdrawal_unit' => $request->input('total_water_withdrawal_unit'),
                'total_water_withdrawal_by_source' => $this->encode_data($request->input('total_water_withdrawal_by_source', [])),
                'total_water_withdrawal_by_source_unit' => $request->input('total_water_withdrawal_by_source_unit'),
                'total_water_consumption' => $this->encode_data($request->input('total_water_consumption', [])),
                'total_water_consumption_unit' => $request->input('total_water_consumption_unit'),
                'total_water_discharged' => $this->encode_data($request->input('total_water_discharged', [])),
                'total_water_discharged_unit' => $request->input('total_water_discharged_unit'),
                'water_intensity_per_rupee_turnover' => $this->encode_data($request->input('water_intensity_per_rupee_turnover', [])),
                'water_intensity_per_rupee_turnover_unit' => $request->input('water_intensity_per_rupee_turnover_unit'),
                'specific_water_consumption' => $this->encode_data($request->input('specific_water_consumption', [])),
                'specific_water_consumption_unit' => $request->input('specific_water_consumption_unit'),
                'waste_detail' => nl2br($request->input('waste_detail')),
                'hazardous_waste' => $this->encode_data($request->input('hazardous_waste', [])),
                'hazardous_waste_unit' => $request->input('hazardous_waste_unit'),
                'non_hazardous_waste' => $this->encode_data($request->input('non_hazardous_waste', [])),
                'non_hazardous_waste_unit' => $request->input('non_hazardous_waste_unit'),
                'waste_by_type' => $this->encode_data($request->input('waste_by_type', [])),
                'waste_by_type_unit' => $request->input('waste_by_type_unit'),
                'waste_by_disposal_method' => $this->encode_data($request->input('waste_by_disposal_method', [])),
                'waste_by_disposal_method_unit' => $request->input('waste_by_disposal_method_unit'),
                'waste_intensity_per_rupee_turnover' => $this->encode_data($request->input('waste_intensity_per_rupee_turnover', [])),
                'waste_intensity_per_rupee_turnover_unit' => $request->input('waste_intensity_per_rupee_turnover_unit'),
                'waste_intensity_physical_output' => $this->encode_data($request->input('waste_intensity_physical_output', [])),
                'waste_intensity_physical_output_unit' => $request->input('waste_intensity_physical_output_unit'),
                'product_stewardship' => nl2br($request->input('product_stewardship')),
                'emission_detail' => nl2br($request->input('emission_detail')),
                'scope_1_emissions' => $this->encode_data($request->input('scope_1_emissions', [])),
                'scope_1_emissions_unit' => $request->input('scope_1_emissions_unit'),
                'scope_2_emissions' => $this->encode_data($request->input('scope_2_emissions', [])),
                'scope_2_emissions_unit' => $request->input('scope_2_emissions_unit'),
                'scope_3_emissions' => $this->encode_data($request->input('scope_3_emissions', [])),
                'scope_3_emissions_unit' => $request->input('scope_3_emissions_unit'),
                'total_scope_1_2_emission_intensity' => $this->encode_data($request->input('total_scope_1_2_emission_intensity', [])),
                'total_scope_1_2_emission_intensity_unit' => $request->input('total_scope_1_2_emission_intensity_unit'),
                'specific_emissions_scope_1_2_per_rupee_turnover' => $this->encode_data($request->input('specific_emissions_scope_1_2_per_rupee_turnover', [])),
                'specific_emissions_scope_1_2_per_rupee_turnover_unit' => $request->input('specific_emissions_scope_1_2_per_rupee_turnover_unit'),
                'air_pollutants' => $this->encode_data($request->input('air_pollutants', [])),
                'air_pollutants_unit' => $request->input('air_pollutants_unit'),
                'hazardous_air_pollutants' => $this->encode_data($request->input('hazardous_air_pollutants', [])),
                'hazardous_air_pollutants_unit' => $request->input('hazardous_air_pollutants_unit'),
                'natural_capital' => $request->input('natural_capital'),
                'csr_for_climate_action' => $request->input('csr_for_climate_action'),
                'org_id' => 0,
                'type' => 'free',
                'approval' => 0,
                'entered_by' => auth()->id()
            ];

            ResponsibleCorporates::create($data_l);

            return redirect()->route('responsible-corp-list')->withFlashSuccess('Responsible Corporate created successfully!');
        }
    }

    public function listing(Request $request)
    {
        $filter = $request->query('filter');

        $resp = ResponsibleCorporates::with('enteredByUser')
            ->where('type', 'free');

        if (auth()->user()->is_admin != '1') {
            $resp->where('entered_by', auth()->id());
        }

        if (!empty($filter)) {
            if (strcasecmp($filter, 'Pending') === 0) {
                $approval = 0;
            } elseif (strcasecmp($filter, 'Approved') === 0) {
                $approval = 1;
            } elseif (strcasecmp($filter, 'Rejected') === 0) {
                $approval = 2;
            } elseif (strcasecmp($filter, 'Reviewed') === 0) {
                $approval = 3;
            } else {
                $approval = '';
            }

            $resp->where(function($q) use($filter, $approval){
                $q->orWhere('name', 'like', '%'.$filter.'%')
                  ->orWhere('short_name', 'like', '%'.$filter.'%');

                if ($approval !== '') {
                    $q->orWhere('approval', $approval);
                }
            });
        }

        $resp = $resp->orderBy('id', 'desc')->paginate(10)->onEachSide(5);

        return view('responsible_corporates.list', [
            'response' => $resp,
            'filter' => $filter
        ]);
    }

    public function updateresponsiblecorporate($id, Request $request)
    {
        $corporate = ResponsibleCorporates::findOrFail($id);

        if (auth()->user()->is_admin != '1' && $corporate->entered_by != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $this->data['response'] = $corporate->toArray();
        $this->data['industry'] = [];
        $this->data['subsegment'] = [];
        $this->data['industry_arr'] = [];
        $this->data['segment_arr'] = [];
        $this->data['fin_type_arr'] = [];

        return view('responsible_corporates.add', $this->data);
    }

    public function updatingresponsiblecorporate(Request $request, $id)
    {
        $corporate = ResponsibleCorporates::findOrFail($id);

        if (auth()->user()->is_admin != '1' && $corporate->entered_by != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $data_l = [
            'name' => $request->input('name'),
            'slug' => str_replace(' ', '-', strtolower($request->input('name'))),
            'short_name' => $request->input('short_name'),
            'keyword_for_search' => $request->input('keyword_search'),
            'industry' => json_encode($request->input('industry', [])),
            'product_profile_sector' => $request->input('product_profile_sector'),
            'ho_location' => $request->input('ho_location'),
            'factory_locations' => $request->input('factory_locations'),
            'net_zero_target' => $request->input('net_zero_target'),
            'certifications_accreditations' => $request->input('certifications_accreditations'),
            'reporting_formats' => $request->input('reporting_formats'),
            'ratings' => $request->input('ratings'),
            'assessment_verification' => $request->input('assessment_verification'),
            'policy_ems' => $request->input('policy_ems'),
            'energy_detail' => nl2br($request->input('energy_detail')),
            'total_energy_consumption' => $this->encode_data($request->input('total_energy_consumption', [])),
            'total_energy_consumption_unit' => $request->input('total_energy_consumption_unit'),
            'total_renewable_energy_consumption' => $this->encode_data($request->input('total_renewable_energy_consumption', [])),
            'total_renewable_energy_consumption_unit' => $request->input('total_renewable_energy_consumption_unit'),
            'total_non_renewable_energy_consumption' => $this->encode_data($request->input('total_non_renewable_energy_consumption', [])),
            'total_non_renewable_energy_consumption_unit' => $request->input('total_non_renewable_energy_consumption_unit'),
            'renewable_power_percentage' => $this->encode_data($request->input('renewable_power_percentage', [])),
            'renewable_power_percentage_unit' => $request->input('renewable_power_percentage_unit'),
            'total_electricity_consumption' => $this->encode_data($request->input('total_electricity_consumption', [])),
            'total_electricity_consumption_unit' => $request->input('total_electricity_consumption_unit'),
            'total_fuel_consumption' => $this->encode_data($request->input('total_fuel_consumption', [])),
            'total_fuel_consumption_unit' => $request->input('total_fuel_consumption_unit'),
            'specific_energy_consumption' => $this->encode_data($request->input('specific_energy_consumption', [])),
            'specific_energy_consumption_unit' => $request->input('specific_energy_consumption_unit'),
            'energy_intensity_per_rupee_turnover' => $this->encode_data($request->input('energy_intensity_per_rupee_turnover', [])),
            'energy_intensity_per_rupee_turnover_unit' => $request->input('energy_intensity_per_rupee_turnover_unit'),
            'water_detail' => nl2br($request->input('water_detail')),
            'water_replenishment_percentage' => $this->encode_data($request->input('water_replenishment_percentage', [])),
            'water_replenishment_percentage_unit' => $request->input('water_replenishment_percentage_unit'),
            'total_water_withdrawal' => $this->encode_data($request->input('total_water_withdrawal', [])),
            'total_water_withdrawal_unit' => $request->input('total_water_withdrawal_unit'),
            'total_water_withdrawal_by_source' => $this->encode_data($request->input('total_water_withdrawal_by_source', [])),
            'total_water_withdrawal_by_source_unit' => $request->input('total_water_withdrawal_by_source_unit'),
            'total_water_consumption' => $this->encode_data($request->input('total_water_consumption', [])),
            'total_water_consumption_unit' => $request->input('total_water_consumption_unit'),
            'total_water_discharged' => $this->encode_data($request->input('total_water_discharged', [])),
            'total_water_discharged_unit' => $request->input('total_water_discharged_unit'),
            'water_intensity_per_rupee_turnover' => $this->encode_data($request->input('water_intensity_per_rupee_turnover', [])),
            'water_intensity_per_rupee_turnover_unit' => $request->input('water_intensity_per_rupee_turnover_unit'),
            'specific_water_consumption' => $this->encode_data($request->input('specific_water_consumption', [])),
            'specific_water_consumption_unit' => $request->input('specific_water_consumption_unit'),
            'waste_detail' => nl2br($request->input('waste_detail')),
            'hazardous_waste' => $this->encode_data($request->input('hazardous_waste', [])),
            'hazardous_waste_unit' => $request->input('hazardous_waste_unit'),
            'non_hazardous_waste' => $this->encode_data($request->input('non_hazardous_waste', [])),
            'non_hazardous_waste_unit' => $request->input('non_hazardous_waste_unit'),
            'waste_by_type' => $this->encode_data($request->input('waste_by_type', [])),
            'waste_by_type_unit' => $request->input('waste_by_type_unit'),
            'waste_by_disposal_method' => $this->encode_data($request->input('waste_by_disposal_method', [])),
            'waste_by_disposal_method_unit' => $request->input('waste_by_disposal_method_unit'),
            'waste_intensity_per_rupee_turnover' => $this->encode_data($request->input('waste_intensity_per_rupee_turnover', [])),
            'waste_intensity_per_rupee_turnover_unit' => $request->input('waste_intensity_per_rupee_turnover_unit'),
            'waste_intensity_physical_output' => $this->encode_data($request->input('waste_intensity_physical_output', [])),
            'waste_intensity_physical_output_unit' => $request->input('waste_intensity_physical_output_unit'),
            'product_stewardship' => nl2br($request->input('product_stewardship')),
            'emission_detail' => nl2br($request->input('emission_detail')),
            'scope_1_emissions' => $this->encode_data($request->input('scope_1_emissions', [])),
            'scope_1_emissions_unit' => $request->input('scope_1_emissions_unit'),
            'scope_2_emissions' => $this->encode_data($request->input('scope_2_emissions', [])),
            'scope_2_emissions_unit' => $request->input('scope_2_emissions_unit'),
            'scope_3_emissions' => $this->encode_data($request->input('scope_3_emissions', [])),
            'scope_3_emissions_unit' => $request->input('scope_3_emissions_unit'),
            'total_scope_1_2_emission_intensity' => $this->encode_data($request->input('total_scope_1_2_emission_intensity', [])),
            'total_scope_1_2_emission_intensity_unit' => $request->input('total_scope_1_2_emission_intensity_unit'),
            'specific_emissions_scope_1_2_per_rupee_turnover' => $this->encode_data($request->input('specific_emissions_scope_1_2_per_rupee_turnover', [])),
            'specific_emissions_scope_1_2_per_rupee_turnover_unit' => $request->input('specific_emissions_scope_1_2_per_rupee_turnover_unit'),
            'air_pollutants' => $this->encode_data($request->input('air_pollutants', [])),
            'air_pollutants_unit' => $request->input('air_pollutants_unit'),
            'hazardous_air_pollutants' => $this->encode_data($request->input('hazardous_air_pollutants', [])),
            'hazardous_air_pollutants_unit' => $request->input('hazardous_air_pollutants_unit'),
            'natural_capital' => $request->input('natural_capital'),
            'csr_for_climate_action' => $request->input('csr_for_climate_action'),
        ];

        $corporate->update($data_l);

        $page = $request->query('page');

        return redirect()->route('responsible-corp-list', compact('page'))->withFlashSuccess('Responsible Corporate updated successfully!');
    }

    public function deleteresponsiblecorporate($id, Request $request)
    {
        $corporate = ResponsibleCorporates::findOrFail($id);

        if (auth()->user()->is_admin != '1' && $corporate->entered_by != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $corporate->delete();

        $page = $request->query('page');

        return redirect()->route('responsible-corp-list', compact('page'))->withFlashSuccess('Responsible Corporate deleted successfully!');
    }

    public function listing_statusupdateRes($id, $status, Request $request)
    {
        if (auth()->user()->is_admin != '1') {
            abort(403, 'Unauthorized action.');
        }

        $corporate = ResponsibleCorporates::findOrFail($id);
        $corporate->approval = $status;
        $corporate->save();

        if ($status == '1') {
            $response = Http::post('https://uat.envesya.com/api/store-responsible-corporate', [
                'name' => $corporate->name,
                'slug' => $corporate->slug,
                'short_name' => $corporate->short_name,
                'keyword_search' => $corporate->keyword_for_search, // match receiving API param name
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
                'energy_detail' => $corporate->energy_detail,
                'total_energy_consumption' => $corporate->total_energy_consumption,
                'total_energy_consumption_unit' => $corporate->total_energy_consumption_unit,
                'total_renewable_energy_consumption' => $corporate->total_renewable_energy_consumption,
                'total_renewable_energy_consumption_unit' => $corporate->total_renewable_energy_consumption_unit,
                'total_non_renewable_energy_consumption' => $corporate->total_non_renewable_energy_consumption,
                'total_non_renewable_energy_consumption_unit' => $corporate->total_non_renewable_energy_consumption_unit,
                'renewable_power_percentage' => $corporate->renewable_power_percentage,
                'renewable_power_percentage_unit' => $corporate->renewable_power_percentage_unit,
                'total_electricity_consumption' => $corporate->total_electricity_consumption,
                'total_electricity_consumption_unit' => $corporate->total_electricity_consumption_unit,
                'total_fuel_consumption' => $corporate->total_fuel_consumption,
                'total_fuel_consumption_unit' => $corporate->total_fuel_consumption_unit,
                'specific_energy_consumption' => $corporate->specific_energy_consumption,
                'specific_energy_consumption_unit' => $corporate->specific_energy_consumption_unit,
                'energy_intensity_per_rupee_turnover' => $corporate->energy_intensity_per_rupee_turnover,
                'energy_intensity_per_rupee_turnover_unit' => $corporate->energy_intensity_per_rupee_turnover_unit,
                'water_detail' => $corporate->water_detail,
                'water_replenishment_percentage' => $corporate->water_replenishment_percentage,
                'water_replenishment_percentage_unit' => $corporate->water_replenishment_percentage_unit,
                'total_water_withdrawal' => $corporate->total_water_withdrawal,
                'total_water_withdrawal_unit' => $corporate->total_water_withdrawal_unit,
                'total_water_withdrawal_by_source' => $corporate->total_water_withdrawal_by_source,
                'total_water_withdrawal_by_source_unit' => $corporate->total_water_withdrawal_by_source_unit,
                'total_water_consumption' => $corporate->total_water_consumption,
                'total_water_consumption_unit' => $corporate->total_water_consumption_unit,
                'total_water_discharged' => $corporate->total_water_discharged,
                'total_water_discharged_unit' => $corporate->total_water_discharged_unit,
                'water_intensity_per_rupee_turnover' => $corporate->water_intensity_per_rupee_turnover,
                'water_intensity_per_rupee_turnover_unit' => $corporate->water_intensity_per_rupee_turnover_unit,
                'specific_water_consumption' => $corporate->specific_water_consumption,
                'specific_water_consumption_unit' => $corporate->specific_water_consumption_unit,
                'waste_detail' => $corporate->waste_detail,
                'hazardous_waste' => $corporate->hazardous_waste,
                'hazardous_waste_unit' => $corporate->hazardous_waste_unit,
                'non_hazardous_waste' => $corporate->non_hazardous_waste,
                'non_hazardous_waste_unit' => $corporate->non_hazardous_waste_unit,
                'waste_by_type' => $corporate->waste_by_type,
                'waste_by_type_unit' => $corporate->waste_by_type_unit,
                'waste_by_disposal_method' => $corporate->waste_by_disposal_method,
                'waste_by_disposal_method_unit' => $corporate->waste_by_disposal_method_unit,
                'waste_intensity_per_rupee_turnover' => $corporate->waste_intensity_per_rupee_turnover,
                'waste_intensity_per_rupee_turnover_unit' => $corporate->waste_intensity_per_rupee_turnover_unit,
                'waste_intensity_physical_output' => $corporate->waste_intensity_physical_output,
                'waste_intensity_physical_output_unit' => $corporate->waste_intensity_physical_output_unit,
                'product_stewardship' => $corporate->product_stewardship,
                'emission_detail' => $corporate->emission_detail,
                'scope_1_emissions' => $corporate->scope_1_emissions,
                'scope_1_emissions_unit' => $corporate->scope_1_emissions_unit,
                'scope_2_emissions' => $corporate->scope_2_emissions,
                'scope_2_emissions_unit' => $corporate->scope_2_emissions_unit,
                'scope_3_emissions' => $corporate->scope_3_emissions,
                'scope_3_emissions_unit' => $corporate->scope_3_emissions_unit,
                'total_scope_1_2_emission_intensity' => $corporate->total_scope_1_2_emission_intensity,
                'total_scope_1_2_emission_intensity_unit' => $corporate->total_scope_1_2_emission_intensity_unit,
                'specific_emissions_scope_1_2_per_rupee_turnover' => $corporate->specific_emissions_scope_1_2_per_rupee_turnover,
                'specific_emissions_scope_1_2_per_rupee_turnover_unit' => $corporate->specific_emissions_scope_1_2_per_rupee_turnover_unit,
                'air_pollutants' => $corporate->air_pollutants,
                'air_pollutants_unit' => $corporate->air_pollutants_unit,
                'hazardous_air_pollutants' => $corporate->hazardous_air_pollutants,
                'hazardous_air_pollutants_unit' => $corporate->hazardous_air_pollutants_unit,
                'natural_capital' => $corporate->natural_capital,
                'csr_for_climate_action' => $corporate->csr_for_climate_action,
            ]);
            \Log::info($response);

            if (!$response->successful()) {
                // handle error, maybe log it
                \Log::error('Failed to send corporate to other DB', [
                    'corporate_id' => $corporate->id,
                    'response' => $response->body(),
                ]);
            }
        }

        $page = $request->query('page');

        return redirect()->route('responsible-corp-list', compact('page'))->withFlashSuccess('Status updated successfully!');
    }

    private function encode_data($data)
    {
        $result = [];
        if (!empty($data)) {
            foreach ($data as $item) {
                if (isset($item['year'], $item['value']) && !empty($item['year'])) {
                    $result[$item['year']] = $item['value'];
                }
            }
        }
        return json_encode($result);
    }
}