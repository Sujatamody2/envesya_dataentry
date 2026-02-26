@extends('layouts.app')

@section('content')
<style>
   .w-fit {
      width: fit-content;
   }
   .add-row-btn, .remove-row-btn {
      padding: 5px 10px;
      margin-left: 10px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
   } 
   .add-row-btn {
      background-color: #28a745;
      color: white;
   }
   .add-row-btn:hover {
      background-color: #218838;
   }
   .remove-row-btn {
      background-color: #dc3545;
      color: white;
   }
   .remove-row-btn:hover {
      background-color: #c82333;
   }
   ul {
      padding:0;
      margin:0;
   }
   .form-group label {
      margin: 3px 0;
   }
   .incrementable-section > label {
      margin: 3px 0;
   }
   .nav-tabs .nav-link {
      color: #495057;
   }
   .nav-tabs .nav-link.active {
      color: #007bff;
      font-weight: bold;
   }
   .error {
      font-size:12px;
      color: red;
   }
</style>

<div class="container">
   <div class="card mt-4">
      <div class="card-header"><?php echo (isset($response)) ? "Edit" : "Add" ?> Responsible Corporate</div>
      <div class="card-body">
         <?php if (isset($response)) { ?>
         <form action="<?php echo route('responsible-corp-updating', $id); ?>" page="<?php echo (isset($response)) ? 'edit' : 'add'; ?>" method="post" class="form-horizontal">
            <input type="hidden" name="listing_id" value="<?php echo (isset($id) && $id) ? $id : ''; ?>">
            <input type="hidden" name="slug" value="<?php echo (isset($response['slug']) && $response['slug']) ? $response['slug'] : ''; ?>">
            <input type="hidden" name="org_id" value="<?php echo (isset($response['org_id']) && $response['org_id']) ? $response['org_id'] : ''; ?>">
         <?php } else { ?>
            <form action="<?php echo route('responsible-corp-add'); ?>" method="post" class="form-horizontal">
         <?php } ?>
         @csrf

         <!-- Bootstrap Tabs -->
         <ul class="nav nav-tabs" id="corporateTabs" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="company-tab" data-toggle="tab" href="#company" role="tab" aria-controls="company" aria-selected="true">Company Detail</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="energy-tab" data-toggle="tab" href="#energy" role="tab" aria-controls="energy" aria-selected="false">Energy</a>
            </li>
            <li class="nav-item">
               <a class="nav-link " id="water-tab" data-toggle="tab" href="#water" role="tab" aria-controls="water" aria-selected="false">Water</a>
            </li>
            <li class="nav-item">
               <a class="nav-link " id="waste-tab" data-toggle="tab" href="#waste" role="tab" aria-controls="waste" aria-selected="false">Waste</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="emission-tab" data-toggle="tab" href="#emission" role="tab" aria-controls="emission" aria-selected="false">Emission</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="natural-capital-tab" data-toggle="tab" href="#natural-capital" role="tab" aria-controls="natural-capital" aria-selected="false">Natural Capital</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="csr-tab" data-toggle="tab" href="#csr" role="tab" aria-controls="csr" aria-selected="false">CSR for Climate Change</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="product-stewardship-tab" data-toggle="tab" href="#product-stewardship" role="tab" aria-controls="product-stewardship" aria-selected="false">Product Stewardship</a>
            </li>
         </ul>

         <!-- Tab Content -->
         <div class="tab-content" id="corporateTabsContent">
            <!-- Company Detail Tab -->
            <div class="tab-pane fade show active" id="company" role="tabpanel" aria-labelledby="company-tab">
               <div class="row mt-3">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="usr">Legal Name</label>
                        <span id="listing_name_error"></span>
                        <input type="text" class="form-control" name="name" placeholder="Legal Name" value="{{(isset($response['name']) && $response['name'] != '') ? $response['name'] : ''}}" id="name" required>
                        
                        @if($errors->has('name'))
                        <ul class="parsley-errors-list filled">
                           @foreach($errors->get('name') as $error)
                           <li class="parsley-required">{{ $error }}</li>
                           @endforeach
                        </ul>
                        @endif
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="usr">Short Name</label>
                        <span id="listing_short_name_error"></span>
                        <input type="text" class="form-control" name="short_name" placeholder="Short Name" value="{{(isset($response['short_name']) && $response['short_name'] != '') ? $response['short_name'] : ''}}" id="short_name" required oninput="this.value=this.value.replace(/[/?@,]/g,'');">
                        
                        @if($errors->has('short_name'))
                        <ul class="parsley-errors-list filled">
                           @foreach($errors->get('short_name') as $error)
                           <li class="parsley-required">{{ $error }}</li>
                           @endforeach
                        </ul>
                        @endif
                     </div>
                  </div>
               </div>

               <div class="form-group">
                  <label for="search_key">Search Keyword</label>
                  <input type="text" class="form-control" name="keyword_search" placeholder="Search Keyword" value="{{(isset($response['keyword_search']) && $response['keyword_search'] != '') ? $response['keyword_search'] : ''}}" id="keyword_search">
                  @if($errors->has('keyword_search'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('keyword_search') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="form-group pl-0 ind_sub_cls">
                  <label for="usr">Industry</label>
                  <select name="industry[]" class="chzn-select form-control" data-placeholder="Choose Industries..." id="ind_cls" multiple>
                     <option value="">Select</option>
                  </select>
                  @if($errors->has('industry'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('industry') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="form-group">
                  <label for="usr">Product Profile/Sector</label>
                  <input type="text" class="form-control" name="product_profile_sector" value="{{(isset($response['product_profile_sector']) && $response['product_profile_sector'] != '') ? $response['product_profile_sector'] : ''}}" placeholder="Product Profile/Sector" id="product_profile_sector">
                  @if($errors->has('product_profile_sector'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('product_profile_sector') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="form-group">
                  <label for="usr">Head Office</label>
                  <input type="text" class="form-control" name="ho_location" value="{{(isset($response['ho_location']) && $response['ho_location'] != '') ? $response['ho_location'] : ''}}" placeholder="Headquarter" id="ho_location">
                  @if($errors->has('ho_location'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('ho_location') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               {{-- <div class="form-group">
                  <label for="usr">Factory Locations</label>
                  <input type="text" class="form-control" name="factory_locations" value="{{(isset($response['factory_locations']) && $response['factory_locations'] != '') ? $response['factory_locations'] : ''}}" placeholder="Location" id="factory_locations">
                  @if($errors->has('factory_locations'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('factory_locations') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div> --}}

               <div class="incrementable-section" data-field="factory_locations">
                  <label for="usr">Factory Locations</label>
                  <ul>
                     <?php 
                     $count = 0;
                     $factoryLocations = isset($response['factory_locations']) ? json_decode($response['factory_locations'], true) : [];
                     foreach ($factoryLocations as $location) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group col-md-10">
                                 <input type="text" class="form-control" name="factory_locations[<?php echo $count; ?>]" placeholder="Location" id="factory_locations_<?php echo $count; ?>" value="<?php echo htmlspecialchars($location); ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                     <?php 
                           $count++; 
                     } 
                     ?>
                  </ul>
                  <button type="button" class="btn add-row-btn" data-field="factory_locations">+</button>
                  @if($errors->has('factory_locations'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('factory_locations') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="form-group">
                  <label for="usr">Net Zero Target</label>
                  <input type="text" class="form-control" name="net_zero_target" value="{{(isset($response['net_zero_target']) && $response['net_zero_target'] != '') ? $response['net_zero_target'] : ''}}" placeholder="Net Zero Target" id="net_zero_target">
                  @if($errors->has('net_zero_target'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('net_zero_target') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="form-group">
                  <label for="usr">Certifications and Accreditations</label>
                  <input type="text" class="form-control" name="certifications_accreditations" value="{{(isset($response['certifications_accreditations']) && $response['certifications_accreditations'] != '') ? $response['certifications_accreditations'] : ''}}" placeholder="Certifications and Accreditations" id="certifications_accreditations">
                  @if($errors->has('certifications_accreditations'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('certifications_accreditations') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="form-group">
                  <label for="usr">Reporting Formats</label>
                  <input type="text" class="form-control" name="reporting_formats" value="{{(isset($response['reporting_formats']) && $response['reporting_formats'] != '') ? $response['reporting_formats'] : ''}}" placeholder="Reporting Formats" id="reporting_formats">
                  @if($errors->has('reporting_formats'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('reporting_formats') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="form-group">
                  <label for="usr">Ratings</label>
                  <input type="text" class="form-control" name="ratings" value="{{(isset($response['ratings']) && $response['ratings'] != '') ? $response['ratings'] : ''}}" placeholder="Ratings" id="ratings">
                  @if($errors->has('ratings'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('ratings') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="form-group">
                  <label for="usr">Assessment and Verification</label>
                  <input type="text" class="form-control" name="assessment_verification" value="{{(isset($response['assessment_verification']) && $response['assessment_verification'] != '') ? $response['assessment_verification'] : ''}}" placeholder="Assessment and Verification" id="assessment_verification">
                  @if($errors->has('assessment_verification'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('assessment_verification') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="form-group">
                  <label for="usr">Policy and EMS</label>
                  <input type="text" class="form-control" name="policy_ems" value="{{(isset($response['policy_ems']) && $response['policy_ems'] != '') ? $response['policy_ems'] : ''}}" placeholder="Policy and EMS" id="policy_ems">
                  @if($errors->has('policy_ems'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('policy_ems') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>
            </div>

            <!-- Energy Tab -->
            <div class="tab-pane fade" id="energy" role="tabpanel" aria-labelledby="energy-tab">
               <div class="form-group mt-3">
                  <label for="usr">Energy Detail</label>
                  <textarea name="energy_detail" id="energy_detail" rows="5" class="form-control" placeholder="Energy Detail">{{ isset($response['energy_detail']) ? $response['energy_detail'] : "" }}</textarea>
                  @if($errors->has('energy_detail'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('energy_detail') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="incrementable-section mt-3" data-field="energy_initiative_detail">
                  <label>Initiatives Undertaken for Energy</label>
                  <ul>
                     <?php
                     $count = 0;
                     $initiativeDetails = isset($response['energy_initiative_detail']) ? json_decode($response['energy_initiative_detail'], true) : [];
                     foreach ($initiativeDetails as $item) { ?>
                           <li class="d-flex" style="gap:10px;">
                              <div class="form-group" style="flex:1">
                                 <label>Initiative Undertaken</label>
                                 <textarea class="form-control no-editor" name="energy_initiative_detail[<?php echo $count; ?>][undertaken]" rows="3" placeholder="Initiative Undertaken" id="energy_initiative_detail_<?php echo $count; ?>_undertaken"><?php echo htmlspecialchars($item['undertaken'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:1">
                                 <label>Details of the Initiative</label>
                                 <textarea class="form-control no-editor" name="energy_initiative_detail[<?php echo $count; ?>][details]" rows="3" placeholder="Details of the Initiative" id="energy_initiative_detail_<?php echo $count; ?>_details"><?php echo htmlspecialchars($item['details'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:1">
                                 <label>Outcome of the Initiative</label>
                                 <textarea class="form-control no-editor" name="energy_initiative_detail[<?php echo $count; ?>][outcome]" rows="3" placeholder="Outcome of the Initiative" id="energy_initiative_detail_<?php echo $count; ?>_outcome"><?php echo htmlspecialchars($item['outcome'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:0 0 fit-content">
                                 <button type="button" class="btn remove-row-btn mt-4" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                     <?php 
                           $count++; 
                     } 
                     ?>
                  </ul>
                  <button type="button" class="btn add-row-btn" data-field="energy_initiative_detail">+ Add Initiative</button>
                  @if($errors->has('energy_initiative_detail'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('energy_initiative_detail') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <h6>Renewable Sources</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="total_electricity_consumption">
                        <label for="usr">Electricity</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_electricity_consumption_unit" placeholder="Unit" id="total_electricity_consumption_unit" value="{{ isset($response['total_electricity_consumption_unit']) ? $response['total_electricity_consumption_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_electricity_consumption']) ? json_decode($response['total_electricity_consumption'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="total_electricity_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_electricity_consumption_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="total_electricity_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_electricity_consumption_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_electricity_consumption">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="total_fuel_consumption">
                        <label for="usr">Fuel</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_fuel_consumption_unit" placeholder="Unit" id="total_fuel_consumption_unit" value="{{ isset($response['total_fuel_consumption_unit']) ? $response['total_fuel_consumption_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_fuel_consumption']) ? json_decode($response['total_fuel_consumption'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_fuel_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_fuel_consumption_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_fuel_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_fuel_consumption_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_fuel_consumption">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="energy_consumption_through_source">
                        <label for="usr">Other sources</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="energy_consumption_through_source_unit" placeholder="Unit" id="energy_consumption_through_source_unit" value="{{ isset($response['energy_consumption_through_source_unit']) ? $response['energy_consumption_through_source_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['energy_consumption_through_source']) ? json_decode($response['energy_consumption_through_source'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="energy_consumption_through_source[<?php echo $count; ?>][year]" placeholder="Year" id="energy_consumption_through_source_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="energy_consumption_through_source[<?php echo $count; ?>][value]" placeholder="Value" id="energy_consumption_through_source_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="energy_consumption_through_source">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="total_renewable_energy_consumption">
                        <label for="usr">Total renewable energy</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_renewable_energy_consumption_unit" placeholder="Unit" id="total_renewable_energy_consumption_unit" value="{{ isset($response['total_renewable_energy_consumption_unit']) ? $response['total_renewable_energy_consumption_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_renewable_energy_consumption']) ? json_decode($response['total_renewable_energy_consumption'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_renewable_energy_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_renewable_energy_consumption_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_renewable_energy_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_renewable_energy_consumption_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="total_renewable_energy_consumption">+</button>
                     </div>
                  </li>
               </ol>
               <h6>Non-Renewable Sources</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="total_non_renewable_electricity_consumption">
                        <label for="usr">Electricity</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_non_renewable_electricity_consumption_unit" placeholder="Unit" id="total_non_renewable_electricity_consumption_unit" value="{{ isset($response['total_non_renewable_electricity_consumption_unit']) ? $response['total_non_renewable_electricity_consumption_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_non_renewable_electricity_consumption']) ? json_decode($response['total_non_renewable_electricity_consumption'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_non_renewable_electricity_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_non_renewable_electricity_consumption_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_non_renewable_electricity_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_non_renewable_electricity_consumption_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_non_renewable_electricity_consumption">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="total_non_renewable_fuel_consumption">
                        <label for="usr">Fuel</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_non_renewable_fuel_consumption_unit" placeholder="Unit" id="total_non_renewable_fuel_consumption_unit" value="{{ isset($response['total_non_renewable_fuel_consumption_unit']) ? $response['total_non_renewable_fuel_consumption_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_non_renewable_fuel_consumption']) ? json_decode($response['total_non_renewable_fuel_consumption'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_non_renewable_fuel_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_non_renewable_fuel_consumption_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_non_renewable_fuel_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_non_renewable_fuel_consumption_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_non_renewable_fuel_consumption">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="non_renewable_energy_consumption_through_source">
                        <label for="usr">Other sources</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="non_renewable_energy_consumption_through_source_unit" placeholder="Unit" id="non_renewable_energy_consumption_through_source_unit" value="{{ isset($response['non_renewable_energy_consumption_through_source_unit']) ? $response['non_renewable_energy_consumption_through_source_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['non_renewable_energy_consumption_through_source']) ? json_decode($response['non_renewable_energy_consumption_through_source'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="non_renewable_energy_consumption_through_source[<?php echo $count; ?>][year]" placeholder="Year" id="non_renewable_energy_consumption_through_source_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="non_renewable_energy_consumption_through_source[<?php echo $count; ?>][value]" placeholder="Value" id="non_renewable_energy_consumption_through_source_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="non_renewable_energy_consumption_through_source">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="total_non_renewable_energy_consumption">
                        <label for="usr">Total non-renewable energy</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_non_renewable_energy_consumption_unit" placeholder="Unit" id="total_non_renewable_energy_consumption_unit" value="{{ isset($response['total_non_renewable_energy_consumption_unit']) ? $response['total_non_renewable_energy_consumption_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_non_renewable_energy_consumption']) ? json_decode($response['total_non_renewable_energy_consumption'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_non_renewable_energy_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_non_renewable_energy_consumption_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_non_renewable_energy_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_non_renewable_energy_consumption_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="total_non_renewable_energy_consumption">+</button>
                     </div>
                  </li>
               </ol>
               <div class="incrementable-section" data-field="total_energy_consumption">
                  <h6>Total Energy Consumed</h6>
                  <div class="form-group w-fit">
                     <input type="text" class="form-control" name="total_energy_consumption_unit" placeholder="Unit" id="total_energy_consumption_unit" value="{{ isset($response['total_energy_consumption_unit']) ? $response['total_energy_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_energy_consumption']) ? json_decode($response['total_energy_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2 w-100">
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_energy_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_energy_consumption_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                        </div>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_energy_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_energy_consumption_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";
                  ?>
                  <button type="button" class="btn add-row-btn" data-field="total_energy_consumption">+</button>
               </div>
               <div class="incrementable-section" data-field="renewable_power_percentage">
                  <h6>Renewable Power %</h6>
                  <div class="form-group w-fit">
                     <input type="text" class="form-control" name="renewable_power_percentage_unit" placeholder="Unit" id="renewable_power_percentage_unit" value="{{ isset($response['renewable_power_percentage_unit']) ? $response['renewable_power_percentage_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['renewable_power_percentage']) ? json_decode($response['renewable_power_percentage'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2 w-100">
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="renewable_power_percentage[<?php echo $count; ?>][year]" placeholder="Year" id="renewable_power_percentage_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                        </div>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="renewable_power_percentage[<?php echo $count; ?>][value]" placeholder="Value" id="renewable_power_percentage_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>"; ?>
                  <button type="button" class="btn add-row-btn" data-field="renewable_power_percentage">+</button>
               </div>
               <h6>Intensity Metrics</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="energy_intensity_per_rupee_turnover">
                        <label for="usr">Energy Intensity per Rupee of Turnover</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="energy_intensity_per_rupee_turnover_unit" placeholder="Unit" id="energy_intensity_per_rupee_turnover_unit" value="{{ isset($response['energy_intensity_per_rupee_turnover_unit']) ? $response['energy_intensity_per_rupee_turnover_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['energy_intensity_per_rupee_turnover']) ? json_decode($response['energy_intensity_per_rupee_turnover'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="energy_intensity_per_rupee_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="energy_intensity_per_rupee_turnover_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="energy_intensity_per_rupee_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="energy_intensity_per_rupee_turnover_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="energy_intensity_per_rupee_turnover">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="energy_intensity_physical_output">
                        <label for="usr">Energy intensity in terms of physical output</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="energy_intensity_physical_output_unit" placeholder="Unit" id="energy_intensity_physical_output_unit" value="{{ isset($response['energy_intensity_physical_output_unit']) ? $response['energy_intensity_physical_output_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['energy_intensity_physical_output']) ? json_decode($response['energy_intensity_physical_output'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="energy_intensity_physical_output[<?php echo $count; ?>][year]" placeholder="Year" id="energy_intensity_physical_output_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="energy_intensity_physical_output[<?php echo $count; ?>][value]" placeholder="Value" id="energy_intensity_physical_output_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="energy_intensity_physical_output">+</button>
                     </div>
                  </li>
               </ol>
            </div>

            <!-- Water Tab -->
            <div class="tab-pane fade" id="water" role="tabpanel" aria-labelledby="water-tab">
               <div class="form-group mt-3">
                  <label for="usr">Water Detail</label>
                  <textarea name="water_detail" id="water_detail" rows="5" class="form-control" placeholder="Water Detail">{{ isset($response['water_detail']) ? $response['water_detail'] : "" }}</textarea>
                  @if($errors->has('water_detail'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('water_detail') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="incrementable-section mt-3" data-field="water_initiative_detail">
                  <h6>Initiatives Undertaken for Water</h6>
                  <ul>
                     <?php
                     $count = 0;
                     $initiativeDetails = isset($response['water_initiative_detail']) ? json_decode($response['water_initiative_detail'], true) : [];
                     foreach ($initiativeDetails as $item) { ?>
                           <li class="d-flex" style="gap:10px;">
                              <div class="form-group" style="flex:1">
                                 <label>Initiative Undertaken</label>
                                 <textarea class="form-control no-editor" name="water_initiative_detail[<?php echo $count; ?>][undertaken]" rows="3" placeholder="Initiative Undertaken" id="water_initiative_detail_<?php echo $count; ?>_undertaken"><?php echo htmlspecialchars($item['undertaken'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:1">
                                 <label>Details of the Initiative</label>
                                 <textarea class="form-control no-editor" name="water_initiative_detail[<?php echo $count; ?>][details]" rows="3" placeholder="Details of the Initiative" id="water_initiative_detail_<?php echo $count; ?>_details"><?php echo htmlspecialchars($item['details'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:1">
                                 <label>Outcome of the Initiative</label>
                                 <textarea class="form-control no-editor" name="water_initiative_detail[<?php echo $count; ?>][outcome]" rows="3" placeholder="Outcome of the Initiative" id="water_initiative_detail_<?php echo $count; ?>_outcome"><?php echo htmlspecialchars($item['outcome'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:0 0 fit-content">
                                 <button type="button" class="btn remove-row-btn mt-4" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                     <?php 
                           $count++; 
                     } 
                     ?>
                  </ul>
                  <button type="button" class="btn add-row-btn" data-field="water_initiative_detail">+ Add Initiative</button>
                  @if($errors->has('water_initiative_detail'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('water_initiative_detail') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>
               <h6>Source</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="water_withdrawal_source_surface">
                        <label for="usr">Surface Water</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="water_withdrawal_source_surface_unit" placeholder="Unit" id="water_withdrawal_source_surface_unit" value="{{ isset($response['water_withdrawal_source_surface_unit']) ? $response['water_withdrawal_source_surface_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $waterDetail = isset($response['water_withdrawal_source_surface']) ? json_decode($response['water_withdrawal_source_surface'], true) : [];
                        echo "<ul>";
                        foreach ($waterDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_withdrawal_source_surface[<?php echo $count; ?>][year]" placeholder="Year" id="water_withdrawal_source_surface_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_withdrawal_source_surface[<?php echo $count; ?>][value]" placeholder="Value" id="water_withdrawal_source_surface_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="water_withdrawal_source_surface">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="water_withdrawal_source_ground">
                        <label for="usr">Groundwater</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="water_withdrawal_source_ground_unit" placeholder="Unit" id="water_withdrawal_source_ground_unit" value="{{ isset($response['water_withdrawal_source_ground_unit']) ? $response['water_withdrawal_source_ground_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $waterDetail = isset($response['water_withdrawal_source_ground']) ? json_decode($response['water_withdrawal_source_ground'], true) : [];
                        echo "<ul>";
                        foreach ($waterDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_withdrawal_source_ground[<?php echo $count; ?>][year]" placeholder="Year" id="water_withdrawal_source_ground_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_withdrawal_source_ground[<?php echo $count; ?>][value]" placeholder="Value" id="water_withdrawal_source_ground_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="water_withdrawal_source_ground">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="water_withdrawal_source_thirdparty">
                        <label for="usr">Purchased water</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="water_withdrawal_source_thirdparty_unit" placeholder="Unit" id="water_withdrawal_source_thirdparty_unit" value="{{ isset($response['water_withdrawal_source_thirdparty_unit']) ? $response['water_withdrawal_source_thirdparty_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $waterDetail = isset($response['water_withdrawal_source_thirdparty']) ? json_decode($response['water_withdrawal_source_thirdparty'], true) : [];
                        echo "<ul>";
                        foreach ($waterDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_withdrawal_source_thirdparty[<?php echo $count; ?>][year]" placeholder="Year" id="water_withdrawal_source_thirdparty_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_withdrawal_source_thirdparty[<?php echo $count; ?>][value]" placeholder="Value" id="water_withdrawal_source_thirdparty_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="water_withdrawal_source_thirdparty">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="water_withdrawal_source_sea">
                        <label for="usr">Seawater / desalinated water</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="water_withdrawal_source_sea_unit" placeholder="Unit" id="water_withdrawal_source_sea_unit" value="{{ isset($response['water_withdrawal_source_sea_unit']) ? $response['water_withdrawal_source_sea_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $waterDetail = isset($response['water_withdrawal_source_sea']) ? json_decode($response['water_withdrawal_source_sea'], true) : [];
                        echo "<ul>";
                        foreach ($waterDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_withdrawal_source_sea[<?php echo $count; ?>][year]" placeholder="Year" id="water_withdrawal_source_sea_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_withdrawal_source_sea[<?php echo $count; ?>][value]" placeholder="Value" id="water_withdrawal_source_sea_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="water_withdrawal_source_sea">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="water_withdrawal_source_other">
                        <label for="usr">Other sources</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="water_withdrawal_source_other_unit" placeholder="Unit" id="water_withdrawal_source_other_unit" value="{{ isset($response['water_withdrawal_source_other_unit']) ? $response['water_withdrawal_source_other_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $waterDetail = isset($response['water_withdrawal_source_other']) ? json_decode($response['water_withdrawal_source_other'], true) : [];
                        echo "<ul>";
                        foreach ($waterDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_withdrawal_source_other[<?php echo $count; ?>][year]" placeholder="Year" id="water_withdrawal_source_other_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_withdrawal_source_other[<?php echo $count; ?>][value]" placeholder="Value" id="water_withdrawal_source_other_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="water_withdrawal_source_other">+</button>
                     </div>
                  </li>
               </ol>
               <div class="incrementable-section" data-field="total_water_withdrawal">
                  <h6>Total</h6>
                  <div class="form-group w-fit">
                     <input type="text" class="form-control" name="total_water_withdrawal_unit" placeholder="Unit" id="total_water_withdrawal_unit" value="{{ isset($response['total_water_withdrawal_unit']) ? $response['total_water_withdrawal_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_water_withdrawal']) ? json_decode($response['total_water_withdrawal'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2 w-100">
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_water_withdrawal[<?php echo $count; ?>][year]" placeholder="Year" id="total_water_withdrawal_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                        </div>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_water_withdrawal[<?php echo $count; ?>][value]" placeholder="Value" id="total_water_withdrawal_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="total_water_withdrawal">+</button>
               </div>

               <div class="incrementable-section" data-field="total_water_consumption">
                  <h6>Consumption</h6>
                  <div class="form-group w-fit">
                     <input type="text" class="form-control" name="total_water_consumption_unit" placeholder="Unit" id="total_water_consumption_unit" value="{{ isset($response['total_water_consumption_unit']) ? $response['total_water_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_water_consumption']) ? json_decode($response['total_water_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2 w-100">
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_water_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_water_consumption_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                        </div>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_water_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_water_consumption_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="total_water_consumption">+</button>
               </div>
               <h6>Water discharged</h6>
               <ol>
                  <li>
                     <h6>To Surface Water</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="water_discharge_to_surface_water_no_treatment">
                              <label for="usr">No Treatment</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_discharge_to_surface_water_no_treatment_unit" placeholder="Unit" id="water_discharge_to_surface_water_no_treatment_unit" value="{{ isset($response['water_discharge_to_surface_water_no_treatment_unit']) ? $response['water_discharge_to_surface_water_no_treatment_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $waterDetail = isset($response['water_discharge_to_surface_water_no_treatment']) ? json_decode($response['water_discharge_to_surface_water_no_treatment'], true) : [];
                              echo "<ul>";
                              foreach ($waterDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_surface_water_no_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_surface_water_no_treatment_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_surface_water_no_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_surface_water_no_treatment_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="water_discharge_to_surface_water_no_treatment">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="water_discharge_to_surface_water_with_treatment">
                              <label for="usr">With Treatment</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_discharge_to_surface_water_with_treatment_unit" placeholder="Unit" id="water_discharge_to_surface_water_with_treatment_unit" value="{{ isset($response['water_discharge_to_surface_water_with_treatment_unit']) ? $response['water_discharge_to_surface_water_with_treatment_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $waterDetail = isset($response['water_discharge_to_surface_water_with_treatment']) ? json_decode($response['water_discharge_to_surface_water_with_treatment'], true) : [];
                              echo "<ul>";
                              foreach ($waterDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_surface_water_with_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_surface_water_with_treatment_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_surface_water_with_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_surface_water_with_treatment_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="water_discharge_to_surface_water_with_treatment">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>To Groundwater</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="water_discharge_to_ground_water_no_treatment">
                              <label for="usr">No Treatment</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_discharge_to_ground_water_no_treatment_unit" placeholder="Unit" id="water_discharge_to_ground_water_no_treatment_unit" value="{{ isset($response['water_discharge_to_ground_water_no_treatment_unit']) ? $response['water_discharge_to_ground_water_no_treatment_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $waterDetail = isset($response['water_discharge_to_ground_water_no_treatment']) ? json_decode($response['water_discharge_to_ground_water_no_treatment'], true) : [];
                              echo "<ul>";
                              foreach ($waterDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_ground_water_no_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_ground_water_no_treatment_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_ground_water_no_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_ground_water_no_treatment_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="water_discharge_to_ground_water_no_treatment">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="water_discharge_to_ground_water_with_treatment">
                              <label for="usr">With Treatment</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_discharge_to_ground_water_with_treatment_unit" placeholder="Unit" id="water_discharge_to_ground_water_with_treatment_unit" value="{{ isset($response['water_discharge_to_ground_water_with_treatment_unit']) ? $response['water_discharge_to_ground_water_with_treatment_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $waterDetail = isset($response['water_discharge_to_ground_water_with_treatment']) ? json_decode($response['water_discharge_to_ground_water_with_treatment'], true) : [];
                              echo "<ul>";
                              foreach ($waterDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_ground_water_with_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_ground_water_with_treatment_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_ground_water_with_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_ground_water_with_treatment_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="water_discharge_to_ground_water_with_treatment">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>To Seawater</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="water_discharge_to_sea_water_no_treatment">
                              <label for="usr">No Treatment</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_discharge_to_sea_water_no_treatment_unit" placeholder="Unit" id="water_discharge_to_sea_water_no_treatment_unit" value="{{ isset($response['water_discharge_to_sea_water_no_treatment_unit']) ? $response['water_discharge_to_sea_water_no_treatment_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $waterDetail = isset($response['water_discharge_to_sea_water_no_treatment']) ? json_decode($response['water_discharge_to_sea_water_no_treatment'], true) : [];
                              echo "<ul>";
                              foreach ($waterDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_sea_water_no_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_sea_water_no_treatment_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_sea_water_no_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_sea_water_no_treatment_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="water_discharge_to_sea_water_no_treatment">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="water_discharge_to_sea_water_with_treatment">
                              <label for="usr">With Treatment</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_discharge_to_sea_water_with_treatment_unit" placeholder="Unit" id="water_discharge_to_sea_water_with_treatment_unit" value="{{ isset($response['water_discharge_to_sea_water_with_treatment_unit']) ? $response['water_discharge_to_sea_water_with_treatment_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $waterDetail = isset($response['water_discharge_to_sea_water_with_treatment']) ? json_decode($response['water_discharge_to_sea_water_with_treatment'], true) : [];
                              echo "<ul>";
                              foreach ($waterDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_sea_water_with_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_sea_water_with_treatment_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_sea_water_with_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_sea_water_with_treatment_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="water_discharge_to_sea_water_with_treatment">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Sent to Third Parties</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="water_discharge_to_thirdparty_water_no_treatment">
                              <label for="usr">No Treatment</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_no_treatment_unit" placeholder="Unit" id="water_discharge_to_thirdparty_water_no_treatment_unit" value="{{ isset($response['water_discharge_to_thirdparty_water_no_treatment_unit']) ? $response['water_discharge_to_thirdparty_water_no_treatment_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $waterDetail = isset($response['water_discharge_to_thirdparty_water_no_treatment']) ? json_decode($response['water_discharge_to_thirdparty_water_no_treatment'], true) : [];
                              echo "<ul>";
                              foreach ($waterDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_no_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_thirdparty_water_no_treatment_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_no_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_thirdparty_water_no_treatment_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="water_discharge_to_thirdparty_water_no_treatment">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="water_discharge_to_thirdparty_water_with_treatment">
                              <label for="usr">With Treatment</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_with_treatment_unit" placeholder="Unit" id="water_discharge_to_thirdparty_water_with_treatment_unit" value="{{ isset($response['water_discharge_to_thirdparty_water_with_treatment_unit']) ? $response['water_discharge_to_thirdparty_water_with_treatment_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $waterDetail = isset($response['water_discharge_to_thirdparty_water_with_treatment']) ? json_decode($response['water_discharge_to_thirdparty_water_with_treatment'], true) : [];
                              echo "<ul>";
                              foreach ($waterDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_with_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_thirdparty_water_with_treatment_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_with_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_thirdparty_water_with_treatment_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="water_discharge_to_thirdparty_water_with_treatment">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Other channels</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="water_discharge_to_other_water_no_treatment">
                              <label for="usr">No Treatment</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_discharge_to_other_water_no_treatment_unit" placeholder="Unit" id="water_discharge_to_other_water_no_treatment_unit" value="{{ isset($response['water_discharge_to_other_water_no_treatment_unit']) ? $response['water_discharge_to_other_water_no_treatment_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $waterDetail = isset($response['water_discharge_to_other_water_no_treatment']) ? json_decode($response['water_discharge_to_other_water_no_treatment'], true) : [];
                              echo "<ul>";
                              foreach ($waterDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_other_water_no_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_other_water_no_treatment_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_other_water_no_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_other_water_no_treatment_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="water_discharge_to_other_water_no_treatment">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="water_discharge_to_other_water_with_treatment">
                              <label for="usr">With Treatment</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_discharge_to_other_water_with_treatment_unit" placeholder="Unit" id="water_discharge_to_other_water_with_treatment_unit" value="{{ isset($response['water_discharge_to_other_water_with_treatment_unit']) ? $response['water_discharge_to_other_water_with_treatment_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $waterDetail = isset($response['water_discharge_to_other_water_with_treatment']) ? json_decode($response['water_discharge_to_other_water_with_treatment'], true) : [];
                              echo "<ul>";
                              foreach ($waterDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_other_water_with_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_other_water_with_treatment_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="water_discharge_to_other_water_with_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_other_water_with_treatment_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="water_discharge_to_other_water_with_treatment">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
               </ol>
               <div class="incrementable-section" data-field="total_water_discharged">
                  <h6>Total Water Discharged</h6>
                  <div class="form-group w-fit">
                     <input type="text" class="form-control" name="total_water_discharged_unit" placeholder="Unit" id="total_water_discharged_unit" value="{{ isset($response['total_water_discharged_unit']) ? $response['total_water_discharged_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_water_discharged']) ? json_decode($response['total_water_discharged'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2 w-100">
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_water_discharged[<?php echo $count; ?>][year]" placeholder="Year" id="total_water_discharged_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                        </div>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_water_discharged[<?php echo $count; ?>][value]" placeholder="Value" id="total_water_discharged_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="total_water_discharged">+</button>
               </div>
               <h6>Intensity Metrics</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="water_intensity_per_rupee_turnover">
                        <label for="usr">Water Intensity per Rupee of Turnover</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="water_intensity_per_rupee_turnover_unit" placeholder="Unit" id="water_intensity_per_rupee_turnover_unit" value="{{ isset($response['water_intensity_per_rupee_turnover_unit']) ? $response['water_intensity_per_rupee_turnover_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['water_intensity_per_rupee_turnover']) ? json_decode($response['water_intensity_per_rupee_turnover'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_intensity_per_rupee_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="water_intensity_per_rupee_turnover_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_intensity_per_rupee_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="water_intensity_per_rupee_turnover_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="water_intensity_per_rupee_turnover">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="water_intensity_physical_output">
                        <label for="usr">Water Intensity in Terms of Physical Output</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="water_intensity_physical_output_unit" placeholder="Unit" id="water_intensity_physical_output_unit" value="{{ isset($response['water_intensity_physical_output_unit']) ? $response['water_intensity_physical_output_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $waterDetail = isset($response['water_intensity_physical_output']) ? json_decode($response['water_intensity_physical_output'], true) : [];
                        echo "<ul>";
                        foreach ($waterDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_intensity_physical_output[<?php echo $count; ?>][year]" placeholder="Year" id="water_intensity_physical_output_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="water_intensity_physical_output[<?php echo $count; ?>][value]" placeholder="Value" id="water_intensity_physical_output_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="water_intensity_physical_output">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="water_replenishment_percentage">
                        <label for="usr">Water Replenishment % of Consumption</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="water_replenishment_percentage_unit" placeholder="Unit" id="water_replenishment_percentage_unit" value="{{ isset($response['water_replenishment_percentage_unit']) ? $response['water_replenishment_percentage_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['water_replenishment_percentage']) ? json_decode($response['water_replenishment_percentage'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_replenishment_percentage[<?php echo $count; ?>][year]" placeholder="Year" id="water_replenishment_percentage_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="water_replenishment_percentage[<?php echo $count; ?>][value]" placeholder="Value" id="water_replenishment_percentage_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="water_replenishment_percentage">+</button>
                     </div>
                  </li>
               </ol>

            </div>

            <!-- Waste Tab -->
            <div class="tab-pane fade" id="waste" role="tabpanel" aria-labelledby="waste-tab">
               <div class="form-group mt-3">
                  <label for="usr">Waste Detail</label>
                  <textarea name="waste_detail" id="waste_detail" rows="5" class="form-control" placeholder="Waste Detail">{{ isset($response['waste_detail']) ? $response['waste_detail'] : "" }}</textarea>
                  @if($errors->has('waste_detail'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('waste_detail') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>
               <div class="incrementable-section mt-3" data-field="waste_initiative_detail">
                  <h6>Initiatives Undertaken for Waste</h6>
                  <ul>
                     <?php
                     $count = 0;
                     $initiativeDetails = isset($response['waste_initiative_detail']) ? json_decode($response['waste_initiative_detail'], true) : [];
                     foreach ($initiativeDetails as $item) { ?>
                           <li class="d-flex" style="gap:10px">
                              <div class="form-group" style="flex:1">
                                 <label>Initiative Undertaken</label>
                                 <textarea class="form-control no-editor" name="waste_initiative_detail[<?php echo $count; ?>][undertaken]" rows="3" placeholder="Initiative Undertaken" id="waste_initiative_detail_<?php echo $count; ?>_undertaken"><?php echo htmlspecialchars($item['undertaken'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:1">
                                 <label>Details of the Initiative</label>
                                 <textarea class="form-control no-editor" name="waste_initiative_detail[<?php echo $count; ?>][details]" rows="3" placeholder="Details of the Initiative" id="waste_initiative_detail_<?php echo $count; ?>_details"><?php echo htmlspecialchars($item['details'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:1">
                                 <label>Outcome of the Initiative</label>
                                 <textarea class="form-control no-editor" name="waste_initiative_detail[<?php echo $count; ?>][outcome]" rows="3" placeholder="Outcome of the Initiative" id="waste_initiative_detail_<?php echo $count; ?>_outcome"><?php echo htmlspecialchars($item['outcome'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:0 0 fit-content">
                                 <button type="button" class="btn remove-row-btn mt-4" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                     <?php 
                           $count++; 
                     } 
                     ?>
                  </ul>
                  <button type="button" class="btn add-row-btn" data-field="waste_initiative_detail">+ Add Initiative</button>
                  @if($errors->has('waste_initiative_detail'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('waste_initiative_detail') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>
               <h6>Waste Generated</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="plastic_waste">
                        <label for="usr">Plastic Waste</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="plastic_waste_unit" placeholder="Unit" id="plastic_waste_unit" value="{{ isset($response['plastic_waste_unit']) ? $response['plastic_waste_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $wasteDetail = isset($response['plastic_waste']) ? json_decode($response['plastic_waste'], true) : [];
                        echo "<ul>";
                        foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="plastic_waste[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="plastic_waste[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="plastic_waste">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="e_waste">
                        <label for="usr">E-Waste</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="e_waste_unit" placeholder="Unit" id="e_waste_unit" value="{{ isset($response['e_waste_unit']) ? $response['e_waste_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $wasteDetail = isset($response['e_waste']) ? json_decode($response['e_waste'], true) : [];
                        echo "<ul>";
                        foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="e_waste[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="e_waste[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="e_waste">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="biological_waste">
                        <label for="usr">Biomedical Waste</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="biological_waste_unit" placeholder="Unit" id="biological_waste_unit" value="{{ isset($response['biological_waste_unit']) ? $response['biological_waste_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $wasteDetail = isset($response['biological_waste']) ? json_decode($response['biological_waste'], true) : [];
                        echo "<ul>";
                        foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="biological_waste[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="biological_waste[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="biological_waste">+ </button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="construction_waste">
                        <label for="usr">Construction Waste</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="construction_waste_unit" placeholder="Unit" id="construction_waste_unit" value="{{ isset($response['construction_waste_unit']) ? $response['construction_waste_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $wasteDetail = isset($response['construction_waste']) ? json_decode($response['construction_waste'], true) : [];
                        echo "<ul>";
                        foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="construction_waste[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="construction_waste[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="construction_waste">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="battery_waste">
                        <label for="usr">Battery Waste</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="battery_waste_unit" placeholder="Unit" id="battery_waste_unit" value="{{ isset($response['battery_waste_unit']) ? $response['battery_waste_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $wasteDetail = isset($response['battery_waste']) ? json_decode($response['battery_waste'], true) : [];
                        echo "<ul>";
                        foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="battery_waste[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="battery_waste[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="battery_waste">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="radioactive_waste">
                        <label for="usr">Radioactive Waste</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="radioactive_waste_unit" placeholder="Unit" id="radioactive_waste_unit" value="{{ isset($response['radioactive_waste_unit']) ? $response['radioactive_waste_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $wasteDetail = isset($response['radioactive_waste']) ? json_decode($response['radioactive_waste'], true) : [];
                        echo "<ul>";
                        foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="radioactive_waste[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                 </div>
                                 <div class="form-group w-fit">
                                    <input type="text" class="form-control" name="radioactive_waste[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                 </div>
                                 <div class="form-group col-md-2">
                                    <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                 </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";
                        ?>
                        <button type="button" class="btn add-row-btn" data-field="radioactive_waste">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="hazardous_waste">
                        <label for="usr">Other Hazardous Waste</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="hazardous_waste_unit" placeholder="Unit" id="hazardous_waste_unit" value="{{ isset($response['hazardous_waste_unit']) ? $response['hazardous_waste_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['hazardous_waste']) ? json_decode($response['hazardous_waste'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="hazardous_waste[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="hazardous_waste[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="hazardous_waste">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="non_hazardous_waste">
                        <label for="usr">Other Non-Hazardous Waste</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="non_hazardous_waste_unit" placeholder="Unit" id="non_hazardous_waste_unit" value="{{ isset($response['non_hazardous_waste_unit']) ? $response['non_hazardous_waste_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['non_hazardous_waste']) ? json_decode($response['non_hazardous_waste'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="non_hazardous_waste[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="non_hazardous_waste[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="non_hazardous_waste">+</button>
                     </div>
                  </li>
               </ol>
               <div class="incrementable-section" data-field="total_waste_generated">
                  <h6>Total waste generated</h6>
                  <div class="form-group w-fit">
                     <input type="text" class="form-control" name="total_waste_generated_unit" placeholder="Unit" id="total_waste_generated_unit" value="{{ isset($response['total_waste_generated_unit']) ? $response['total_waste_generated_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_waste_generated']) ? json_decode($response['total_waste_generated'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2 w-100">
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_waste_generated[<?php echo $count; ?>][year]" placeholder="Year" id="total_waste_generated_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                        </div>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_waste_generated[<?php echo $count; ?>][value]" placeholder="Value" id="total_waste_generated_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="total_waste_generated">+</button>
               </div>
               <h6>Waste Recovered</h6>
               <ol>
                  <li>
                     <h6>Plastic waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="plastic_waste_recycled">
                              <label for="usr">Recycled</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="plastic_waste_recycled_unit" placeholder="Unit" id="plastic_waste_recycled_unit" value="{{ isset($response['plastic_waste_recycled_unit']) ? $response['plastic_waste_recycled_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['plastic_waste_recycled']) ? json_decode($response['plastic_waste_recycled'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="plastic_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_recycled_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="plastic_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_recycled_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="plastic_waste_recycled">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="plastic_waste_reused">
                              <label for="usr">Re-used</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="plastic_waste_reused_unit" placeholder="Unit" id="plastic_waste_reused_unit" value="{{ isset($response['plastic_waste_reused_unit']) ? $response['plastic_waste_reused_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['plastic_waste_reused']) ? json_decode($response['plastic_waste_reused'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="plastic_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_reused_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="plastic_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_reused_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="plastic_waste_reused">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="plastic_waste_other_recovery">
                              <label for="usr">Recovered</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="plastic_waste_other_recovery_unit" placeholder="Unit" id="plastic_waste_other_recovery_unit" value="{{ isset($response['plastic_waste_other_recovery_unit']) ? $response['plastic_waste_other_recovery_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['plastic_waste_other_recovery']) ? json_decode($response['plastic_waste_other_recovery'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="plastic_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="plastic_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="plastic_waste_other_recovery">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>E-waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="e_waste_recycled">
                              <label for="usr">Recycled</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="e_waste_recycled_unit" placeholder="Unit" id="e_waste_recycled_unit" value="{{ isset($response['e_waste_recycled_unit']) ? $response['e_waste_recycled_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['e_waste_recycled']) ? json_decode($response['e_waste_recycled'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="e_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_recycled_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="e_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_recycled_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="e_waste_recycled">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="e_waste_reused">
                              <label for="usr">Re-used</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="e_waste_reused_unit" placeholder="Unit" id="e_waste_reused_unit" value="{{ isset($response['e_waste_reused_unit']) ? $response['e_waste_reused_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['e_waste_reused']) ? json_decode($response['e_waste_reused'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="e_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_reused_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="e_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_reused_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="e_waste_reused">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="e_waste_other_recovery">
                              <label for="usr">Recovered</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="e_waste_other_recovery_unit" placeholder="Unit" id="e_waste_other_recovery_unit" value="{{ isset($response['e_waste_other_recovery_unit']) ? $response['e_waste_other_recovery_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['e_waste_other_recovery']) ? json_decode($response['e_waste_other_recovery'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="e_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="e_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="e_waste_other_recovery">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Biomedical Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="biological_waste_recycled">
                              <label for="usr">Recycled</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="biological_waste_recycled_unit" placeholder="Unit" id="biological_waste_recycled_unit" value="{{ isset($response['biological_waste_recycled_unit']) ? $response['biological_waste_recycled_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['biological_waste_recycled']) ? json_decode($response['biological_waste_recycled'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="biological_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_recycled_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="biological_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_recycled_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="biological_waste_recycled">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="biological_waste_reused">
                              <label for="usr">Re-used</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="biological_waste_reused_unit" placeholder="Unit" id="biological_waste_reused_unit" value="{{ isset($response['biological_waste_reused_unit']) ? $response['biological_waste_reused_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['biological_waste_reused']) ? json_decode($response['biological_waste_reused'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="biological_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_reused_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="biological_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_reused_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="biological_waste_reused">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="biological_waste_other_recovery">
                              <label for="usr">Recovered</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="biological_waste_other_recovery_unit" placeholder="Unit" id="biological_waste_other_recovery_unit" value="{{ isset($response['biological_waste_other_recovery_unit']) ? $response['biological_waste_other_recovery_unit'] : "" }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['biological_waste_other_recovery']) ? json_decode($response['biological_waste_other_recovery'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="biological_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="biological_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="biological_waste_other_recovery">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Construction Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="construction_waste_recycled">
                              <label for="usr">Recycled</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="construction_waste_recycled_unit" placeholder="Unit" id="construction_waste_recycled_unit" value="{{ isset($response['construction_waste_recycled_unit']) ? $response['construction_waste_recycled_unit'] : '' }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['construction_waste_recycled']) ? json_decode($response['construction_waste_recycled'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="construction_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_recycled_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="construction_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_recycled_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="construction_waste_recycled">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="construction_waste_reused">
                              <label for="usr">Re-used</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="construction_waste_reused_unit" placeholder="Unit" id="construction_waste_reused_unit" value="{{ isset($response['construction_waste_reused_unit']) ? $response['construction_waste_reused_unit'] : '' }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['construction_waste_reused']) ? json_decode($response['construction_waste_reused'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="construction_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_reused_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="construction_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_reused_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="construction_waste_reused">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="construction_waste_other_recovery">
                              <label for="usr">Recovered</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="construction_waste_other_recovery_unit" placeholder="Unit" id="construction_waste_other_recovery_unit" value="{{ isset($response['construction_waste_other_recovery_unit']) ? $response['construction_waste_other_recovery_unit'] : '' }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['construction_waste_other_recovery']) ? json_decode($response['construction_waste_other_recovery'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="construction_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="construction_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="construction_waste_other_recovery">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Battery Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="battery_waste_recycled">
                              <label for="usr">Recycled</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="battery_waste_recycled_unit" placeholder="Unit" id="battery_waste_recycled_unit" value="{{ isset($response['battery_waste_recycled_unit']) ? $response['battery_waste_recycled_unit'] : '' }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['battery_waste_recycled']) ? json_decode($response['battery_waste_recycled'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="battery_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_recycled_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="battery_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_recycled_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="battery_waste_recycled">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="battery_waste_reused">
                              <label for="usr">Re-used</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="battery_waste_reused_unit" placeholder="Unit" id="battery_waste_reused_unit" value="{{ isset($response['battery_waste_reused_unit']) ? $response['battery_waste_reused_unit'] : '' }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['battery_waste_reused']) ? json_decode($response['battery_waste_reused'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="battery_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_reused_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="battery_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_reused_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="battery_waste_reused">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="battery_waste_other_recovery">
                              <label for="usr">Recovered</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="battery_waste_other_recovery_unit" placeholder="Unit" id="battery_waste_other_recovery_unit" value="{{ isset($response['battery_waste_other_recovery_unit']) ? $response['battery_waste_other_recovery_unit'] : '' }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['battery_waste_other_recovery']) ? json_decode($response['battery_waste_other_recovery'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="battery_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="battery_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="battery_waste_other_recovery">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Radioactive Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="radioactive_waste_recycled">
                              <label for="usr">Recycled</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="radioactive_waste_recycled_unit" placeholder="Unit" id="radioactive_waste_recycled_unit" value="{{ isset($response['radioactive_waste_recycled_unit']) ? $response['radioactive_waste_recycled_unit'] : '' }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['radioactive_waste_recycled']) ? json_decode($response['radioactive_waste_recycled'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="radioactive_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_recycled_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="radioactive_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_recycled_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="radioactive_waste_recycled">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="radioactive_waste_reused">
                              <label for="usr">Re-used</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="radioactive_waste_reused_unit" placeholder="Unit" id="radioactive_waste_reused_unit" value="{{ isset($response['radioactive_waste_reused_unit']) ? $response['radioactive_waste_reused_unit'] : '' }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['radioactive_waste_reused']) ? json_decode($response['radioactive_waste_reused'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="radioactive_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_reused_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="radioactive_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_reused_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="radioactive_waste_reused">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="radioactive_waste_other_recovery">
                              <label for="usr">Recovered</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="radioactive_waste_other_recovery_unit" placeholder="Unit" id="radioactive_waste_other_recovery_unit" value="{{ isset($response['radioactive_waste_other_recovery_unit']) ? $response['radioactive_waste_other_recovery_unit'] : '' }}">
                              </div>
                              <?php 
                              $count = 0;
                              $wasteDetail = isset($response['radioactive_waste_other_recovery']) ? json_decode($response['radioactive_waste_other_recovery'], true) : [];
                              echo "<ul>";
                              foreach ($wasteDetail as $year => $value) { ?>
                                 <li class="d-flex gap-2 w-100">
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="radioactive_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                       </div>
                                       <div class="form-group w-fit">
                                          <input type="text" class="form-control" name="radioactive_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                       </div>
                                       <div class="form-group col-md-2">
                                          <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                       </div>
                                 </li>
                              <?php 
                                 $count++; 
                              } 
                              echo "</ul>";
                              ?>
                              <button type="button" class="btn add-row-btn" data-field="radioactive_waste_other_recovery">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Other Hazardous Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="hazardous_waste_recycled">
                              <label for="usr">Recycled</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="hazardous_waste_recycled_unit" placeholder="Unit" id="hazardous_waste_recycled_unit" value="{{ isset($response['hazardous_waste_recycled_unit']) ? $response['hazardous_waste_recycled_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['hazardous_waste_recycled']) ? json_decode($response['hazardous_waste_recycled'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_recycled_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_recycled_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="hazardous_waste_recycled">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="hazardous_waste_reused">
                              <label for="usr">Re-used</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="hazardous_waste_reused_unit" placeholder="Unit" id="hazardous_waste_reused_unit" value="{{ isset($response['hazardous_waste_reused_unit']) ? $response['hazardous_waste_reused_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['hazardous_waste_reused']) ? json_decode($response['hazardous_waste_reused'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_reused_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_reused_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="hazardous_waste_reused">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="hazardous_waste_other_recovery">
                              <label for="usr">Recovered</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="hazardous_waste_other_recovery_unit" placeholder="Unit" id="hazardous_waste_other_recovery_unit" value="{{ isset($response['hazardous_waste_other_recovery_unit']) ? $response['hazardous_waste_other_recovery_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['hazardous_waste_other_recovery']) ? json_decode($response['hazardous_waste_other_recovery'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="hazardous_waste_other_recovery">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Other Non-hazardous Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="non_hazardous_waste_recycled">
                              <label for="usr">Recycled</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="non_hazardous_waste_recycled_unit" placeholder="Unit" id="non_hazardous_waste_recycled_unit" value="{{ isset($response['non_hazardous_waste_recycled_unit']) ? $response['non_hazardous_waste_recycled_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['non_hazardous_waste_recycled']) ? json_decode($response['non_hazardous_waste_recycled'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_recycled_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_recycled_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="non_hazardous_waste_recycled">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="non_hazardous_waste_reused">
                              <label for="usr">Re-used</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="non_hazardous_waste_reused_unit" placeholder="Unit" id="non_hazardous_waste_reused_unit" value="{{ isset($response['non_hazardous_waste_reused_unit']) ? $response['non_hazardous_waste_reused_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['non_hazardous_waste_reused']) ? json_decode($response['non_hazardous_waste_reused'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_reused_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_reused_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="non_hazardous_waste_reused">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="non_hazardous_waste_other_recovery">
                              <label for="usr">Recovered</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="non_hazardous_waste_other_recovery_unit" placeholder="Unit" id="non_hazardous_waste_other_recovery_unit" value="{{ isset($response['non_hazardous_waste_other_recovery_unit']) ? $response['non_hazardous_waste_other_recovery_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['non_hazardous_waste_other_recovery']) ? json_decode($response['non_hazardous_waste_other_recovery'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="non_hazardous_waste_other_recovery">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
               </ol>
               
               <h6>Total waste recovered</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="total_waste_recovered_recycled">
                        <label for="usr">Recycled</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_waste_recovered_recycled_unit" placeholder="Unit" id="total_waste_recovered_recycled_unit" value="{{ isset($response['total_waste_recovered_recycled_unit']) ? $response['total_waste_recovered_recycled_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_waste_recovered_recycled']) ? json_decode($response['total_waste_recovered_recycled'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_recovered_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="total_waste_recovered_recycled_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_recovered_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="total_waste_recovered_recycled_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_waste_recovered_recycled">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="total_waste_recovered_reused">
                        <label for="usr">Re-used</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_waste_recovered_reused_unit" placeholder="Unit" id="total_waste_recovered_reused_unit" value="{{ isset($response['total_waste_recovered_reused_unit']) ? $response['total_waste_recovered_reused_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_waste_recovered_reused']) ? json_decode($response['total_waste_recovered_reused'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_recovered_reused[<?php echo $count; ?>][year]" placeholder="Year" id="total_waste_recovered_reused_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_recovered_reused[<?php echo $count; ?>][value]" placeholder="Value" id="total_waste_recovered_reused_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_waste_recovered_reused">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="total_waste_recovered_other_recovery">
                        <label for="usr">Recovered</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_waste_recovered_other_recovery_unit" placeholder="Unit" id="total_waste_recovered_other_recovery_unit" value="{{ isset($response['total_waste_recovered_other_recovery_unit']) ? $response['total_waste_recovered_other_recovery_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_waste_recovered_other_recovery']) ? json_decode($response['total_waste_recovered_other_recovery'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_recovered_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="total_waste_recovered_other_recovery_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_recovered_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="total_waste_recovered_other_recovery_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_waste_recovered_other_recovery">+</button>
                     </div>
                  </li>

                  <li>
                     <div class="incrementable-section" data-field="total_waste_recovered">
                        <label for="usr">Total Waste recovered</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_waste_recovered_unit" placeholder="Unit" id="total_waste_recovered_unit" value="{{ isset($response['total_waste_recovered_unit']) ? $response['total_waste_recovered_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_waste_recovered']) ? json_decode($response['total_waste_recovered'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_recovered[<?php echo $count; ?>][year]" placeholder="Year" id="total_waste_recovered_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_recovered[<?php echo $count; ?>][value]" placeholder="Value" id="total_waste_recovered_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_waste_recovered">+</button>
                     </div>
                  </li>

               </ol>
                  
               <h6>Waste Disposed by Nature of Disposal Method </h6>
               <ol>
                  <li>
                     <h6>Plastic Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="plastic_waste_incineration">
                              <label for="usr">Incineration</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="plastic_waste_incineration_unit" placeholder="Unit" id="plastic_waste_incineration_unit" value="{{ isset($response['plastic_waste_incineration_unit']) ? $response['plastic_waste_incineration_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['plastic_waste_incineration']) ? json_decode($response['plastic_waste_incineration'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="plastic_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_incineration_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="plastic_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_incineration_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="plastic_waste_incineration">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="plastic_waste_landfilling">
                              <label for="usr">Landfilling</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="plastic_waste_landfilling_unit" placeholder="Unit" id="plastic_waste_landfilling_unit" value="{{ isset($response['plastic_waste_landfilling_unit']) ? $response['plastic_waste_landfilling_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['plastic_waste_landfilling']) ? json_decode($response['plastic_waste_landfilling'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="plastic_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="plastic_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="plastic_waste_landfilling">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="plastic_waste_other_disposal">
                              <label for="usr">Others</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="plastic_waste_other_disposal_unit" placeholder="Unit" id="plastic_waste_other_disposal_unit" value="{{ isset($response['plastic_waste_other_disposal_unit']) ? $response['plastic_waste_other_disposal_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['plastic_waste_other_disposal']) ? json_decode($response['plastic_waste_other_disposal'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="plastic_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="plastic_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="plastic_waste_other_disposal">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>E-Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="e_waste_incineration">
                              <label for="usr">Incineration</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="e_waste_incineration_unit" placeholder="Unit" id="e_waste_incineration_unit" value="{{ isset($response['e_waste_incineration_unit']) ? $response['e_waste_incineration_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['e_waste_incineration']) ? json_decode($response['e_waste_incineration'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="e_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_incineration_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="e_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_incineration_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="e_waste_incineration">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="e_waste_landfilling">
                              <label for="usr">Landfilling</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="e_waste_landfilling_unit" placeholder="Unit" id="e_waste_landfilling_unit" value="{{ isset($response['e_waste_landfilling_unit']) ? $response['e_waste_landfilling_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['e_waste_landfilling']) ? json_decode($response['e_waste_landfilling'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="e_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="e_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="e_waste_landfilling">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="e_waste_other_disposal">
                              <label for="usr">Others</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="e_waste_other_disposal_unit" placeholder="Unit" id="e_waste_other_disposal_unit" value="{{ isset($response['e_waste_other_disposal_unit']) ? $response['e_waste_other_disposal_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['e_waste_other_disposal']) ? json_decode($response['e_waste_other_disposal'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="e_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="e_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="e_waste_other_disposal">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Biomedical Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="biological_waste_incineration">
                              <label for="usr">Incineration</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="biological_waste_incineration_unit" placeholder="Unit" id="biological_waste_incineration_unit" value="{{ isset($response['biological_waste_incineration_unit']) ? $response['biological_waste_incineration_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['biological_waste_incineration']) ? json_decode($response['biological_waste_incineration'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="biological_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_incineration_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="biological_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_incineration_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="biological_waste_incineration">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="biological_waste_landfilling">
                              <label for="usr">Landfilling</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="biological_waste_landfilling_unit" placeholder="Unit" id="biological_waste_landfilling_unit" value="{{ isset($response['biological_waste_landfilling_unit']) ? $response['biological_waste_landfilling_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['biological_waste_landfilling']) ? json_decode($response['biological_waste_landfilling'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="biological_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="biological_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="biological_waste_landfilling">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="biological_waste_other_disposal">
                              <label for="usr">Others</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="biological_waste_other_disposal_unit" placeholder="Unit" id="biological_waste_other_disposal_unit" value="{{ isset($response['biological_waste_other_disposal_unit']) ? $response['biological_waste_other_disposal_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['biological_waste_other_disposal']) ? json_decode($response['biological_waste_other_disposal'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="biological_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="biological_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="biological_waste_other_disposal">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Construction Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="construction_waste_incineration">
                              <label for="usr">Incineration</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="construction_waste_incineration_unit" placeholder="Unit" id="construction_waste_incineration_unit" value="{{ isset($response['construction_waste_incineration_unit']) ? $response['construction_waste_incineration_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['construction_waste_incineration']) ? json_decode($response['construction_waste_incineration'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="construction_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_incineration_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="construction_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_incineration_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="construction_waste_incineration">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="construction_waste_landfilling">
                              <label for="usr">Landfilling</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="construction_waste_landfilling_unit" placeholder="Unit" id="construction_waste_landfilling_unit" value="{{ isset($response['construction_waste_landfilling_unit']) ? $response['construction_waste_landfilling_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['construction_waste_landfilling']) ? json_decode($response['construction_waste_landfilling'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="construction_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="construction_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="construction_waste_landfilling">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="construction_waste_other_disposal">
                              <label for="usr">Others</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="construction_waste_other_disposal_unit" placeholder="Unit" id="construction_waste_other_disposal_unit" value="{{ isset($response['construction_waste_other_disposal_unit']) ? $response['construction_waste_other_disposal_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['construction_waste_other_disposal']) ? json_decode($response['construction_waste_other_disposal'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="construction_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="construction_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="construction_waste_other_disposal">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Battery Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="battery_waste_incineration">
                              <label for="usr">Incineration</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="battery_waste_incineration_unit" placeholder="Unit" id="battery_waste_incineration_unit" value="{{ isset($response['battery_waste_incineration_unit']) ? $response['battery_waste_incineration_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['battery_waste_incineration']) ? json_decode($response['battery_waste_incineration'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="battery_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_incineration_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="battery_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_incineration_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="battery_waste_incineration">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="battery_waste_landfilling">
                              <label for="usr">Landfilling</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="battery_waste_landfilling_unit" placeholder="Unit" id="battery_waste_landfilling_unit" value="{{ isset($response['battery_waste_landfilling_unit']) ? $response['battery_waste_landfilling_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['battery_waste_landfilling']) ? json_decode($response['battery_waste_landfilling'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="battery_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="battery_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="battery_waste_landfilling">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="battery_waste_other_disposal">
                              <label for="usr">Others</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="battery_waste_other_disposal_unit" placeholder="Unit" id="battery_waste_other_disposal_unit" value="{{ isset($response['battery_waste_other_disposal_unit']) ? $response['battery_waste_other_disposal_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['battery_waste_other_disposal']) ? json_decode($response['battery_waste_other_disposal'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="battery_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="battery_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="battery_waste_other_disposal">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Radioactive Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="radioactive_waste_incineration">
                              <label for="usr">Incineration</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="radioactive_waste_incineration_unit" placeholder="Unit" id="radioactive_waste_incineration_unit" value="{{ isset($response['radioactive_waste_incineration_unit']) ? $response['radioactive_waste_incineration_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['radioactive_waste_incineration']) ? json_decode($response['radioactive_waste_incineration'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="radioactive_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_incineration_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="radioactive_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_incineration_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="radioactive_waste_incineration">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="radioactive_waste_landfilling">
                              <label for="usr">Landfilling</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="radioactive_waste_landfilling_unit" placeholder="Unit" id="radioactive_waste_landfilling_unit" value="{{ isset($response['radioactive_waste_landfilling_unit']) ? $response['radioactive_waste_landfilling_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['radioactive_waste_landfilling']) ? json_decode($response['radioactive_waste_landfilling'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="radioactive_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="radioactive_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="radioactive_waste_landfilling">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="radioactive_waste_other_disposal">
                              <label for="usr">Others</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="radioactive_waste_other_disposal_unit" placeholder="Unit" id="radioactive_waste_other_disposal_unit" value="{{ isset($response['radioactive_waste_other_disposal_unit']) ? $response['radioactive_waste_other_disposal_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['radioactive_waste_other_disposal']) ? json_decode($response['radioactive_waste_other_disposal'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="radioactive_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="radioactive_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="radioactive_waste_other_disposal">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Other Hazardous Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="hazardous_waste_incineration">
                              <label for="usr">Incineration</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="hazardous_waste_incineration_unit" placeholder="Unit" id="hazardous_waste_incineration_unit" value="{{ isset($response['hazardous_waste_incineration_unit']) ? $response['hazardous_waste_incineration_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['hazardous_waste_incineration']) ? json_decode($response['hazardous_waste_incineration'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_incineration_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_incineration_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="hazardous_waste_incineration">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="hazardous_waste_landfilling">
                              <label for="usr">Landfilling</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="hazardous_waste_landfilling_unit" placeholder="Unit" id="hazardous_waste_landfilling_unit" value="{{ isset($response['hazardous_waste_landfilling_unit']) ? $response['hazardous_waste_landfilling_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['hazardous_waste_landfilling']) ? json_decode($response['hazardous_waste_landfilling'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="hazardous_waste_landfilling">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="hazardous_waste_other_disposal">
                              <label for="usr">Others</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="hazardous_waste_other_disposal_unit" placeholder="Unit" id="hazardous_waste_other_disposal_unit" value="{{ isset($response['hazardous_waste_other_disposal_unit']) ? $response['hazardous_waste_other_disposal_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['hazardous_waste_other_disposal']) ? json_decode($response['hazardous_waste_other_disposal'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="hazardous_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="hazardous_waste_other_disposal">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
                  <li>
                     <h6>Other Non-Hazardous Waste</h6>
                     <ol type="i">
                        <li>
                           <div class="incrementable-section" data-field="non_hazardous_waste_incineration">
                              <label for="usr">Incineration</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="non_hazardous_waste_incineration_unit" placeholder="Unit" id="non_hazardous_waste_incineration_unit" value="{{ isset($response['non_hazardous_waste_incineration_unit']) ? $response['non_hazardous_waste_incineration_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['non_hazardous_waste_incineration']) ? json_decode($response['non_hazardous_waste_incineration'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_incineration_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_incineration_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="non_hazardous_waste_incineration">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="non_hazardous_waste_landfilling">
                              <label for="usr">Landfilling</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="non_hazardous_waste_landfilling_unit" placeholder="Unit" id="non_hazardous_waste_landfilling_unit" value="{{ isset($response['non_hazardous_waste_landfilling_unit']) ? $response['non_hazardous_waste_landfilling_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['non_hazardous_waste_landfilling']) ? json_decode($response['non_hazardous_waste_landfilling'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="non_hazardous_waste_landfilling">+</button>
                           </div>
                        </li>
                        <li>
                           <div class="incrementable-section" data-field="non_hazardous_waste_other_disposal">
                              <label for="usr">Others</label>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="non_hazardous_waste_other_disposal_unit" placeholder="Unit" id="non_hazardous_waste_other_disposal_unit" value="{{ isset($response['non_hazardous_waste_other_disposal_unit']) ? $response['non_hazardous_waste_other_disposal_unit'] : '' }}">
                              </div>
                              <ul>
                                 <?php 
                                 $count = 0;
                                 $wasteDetail = isset($response['non_hazardous_waste_other_disposal']) ? json_decode($response['non_hazardous_waste_other_disposal'], true) : [];
                                 foreach ($wasteDetail as $year => $value) { ?>
                                       <li class="d-flex gap-2 w-100">
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                                          </div>
                                          <div class="form-group w-fit">
                                             <input type="text" class="form-control" name="non_hazardous_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                                          </div>
                                          <div class="form-group col-md-2">
                                             <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                                          </div>
                                       </li>
                                 <?php 
                                       $count++; 
                                 } ?>
                              </ul>
                              <button type="button" class="btn add-row-btn" data-field="non_hazardous_waste_other_disposal">+</button>
                           </div>
                        </li>
                     </ol>
                  </li>
               </ol>
               <h6>Total Waste Disposed</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="total_waste_disposed_recycled">
                        <label for="usr">Incineration</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_waste_disposed_recycled_unit" placeholder="Unit" id="total_waste_disposed_recycled_unit" value="{{ isset($response['total_waste_disposed_recycled_unit']) ? $response['total_waste_disposed_recycled_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_waste_disposed_recycled']) ? json_decode($response['total_waste_disposed_recycled'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_disposed_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="total_waste_disposed_recycled_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_disposed_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="total_waste_disposed_recycled_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_waste_disposed_recycled">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="total_waste_disposed_reused">
                        <label for="usr">Landfilling</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_waste_disposed_reused_unit" placeholder="Unit" id="total_waste_disposed_reused_unit" value="{{ isset($response['total_waste_disposed_reused_unit']) ? $response['total_waste_disposed_reused_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_waste_disposed_reused']) ? json_decode($response['total_waste_disposed_reused'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_disposed_reused[<?php echo $count; ?>][year]" placeholder="Year" id="total_waste_disposed_reused_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_disposed_reused[<?php echo $count; ?>][value]" placeholder="Value" id="total_waste_disposed_reused_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_waste_disposed_reused">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="total_waste_disposed_other_recovery">
                        <label for="usr">Others</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_waste_disposed_other_recovery_unit" placeholder="Unit" id="total_waste_disposed_other_recovery_unit" value="{{ isset($response['total_waste_disposed_other_recovery_unit']) ? $response['total_waste_disposed_other_recovery_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_waste_disposed_other_recovery']) ? json_decode($response['total_waste_disposed_other_recovery'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_disposed_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="total_waste_disposed_other_recovery_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_disposed_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="total_waste_disposed_other_recovery_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_waste_disposed_other_recovery">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="total_waste_disposed">
                        <label for="usr">Total Waste disposed</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_waste_disposed_unit" placeholder="Unit" id="total_waste_disposed_unit" value="{{ isset($response['total_waste_disposed_unit']) ? $response['total_waste_disposed_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_waste_disposed']) ? json_decode($response['total_waste_disposed'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_disposed[<?php echo $count; ?>][year]" placeholder="Year" id="total_waste_disposed_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_waste_disposed[<?php echo $count; ?>][value]" placeholder="Value" id="total_waste_disposed_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="total_waste_disposed">+</button>
                     </div>
                  </li>
               </ol>
               <h6>Intensity Metrics</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="waste_intensity_per_rupee_turnover">
                        <label for="usr">Waste Intensity per Rupee of Turnover</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="waste_intensity_per_rupee_turnover_unit" placeholder="Unit" id="waste_intensity_per_rupee_turnover_unit" value="{{ isset($response['waste_intensity_per_rupee_turnover_unit']) ? $response['waste_intensity_per_rupee_turnover_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['waste_intensity_per_rupee_turnover']) ? json_decode($response['waste_intensity_per_rupee_turnover'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="waste_intensity_per_rupee_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="waste_intensity_per_rupee_turnover_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="waste_intensity_per_rupee_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="waste_intensity_per_rupee_turnover_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="waste_intensity_per_rupee_turnover">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="waste_intensity_physical_output">
                        <label for="usr">Waste Intensity in Terms of Physical Output</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="waste_intensity_physical_output_unit" placeholder="Unit" id="waste_intensity_physical_output_unit" value="{{ isset($response['waste_intensity_physical_output_unit']) ? $response['waste_intensity_physical_output_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['waste_intensity_physical_output']) ? json_decode($response['waste_intensity_physical_output'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="waste_intensity_physical_output[<?php echo $count; ?>][year]" placeholder="Year" id="waste_intensity_physical_output_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="waste_intensity_physical_output[<?php echo $count; ?>][value]" placeholder="Value" id="waste_intensity_physical_output_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="waste_intensity_physical_output">+</button>
                     </div>
                  </li>
               </ol>
            </div>

            <!-- Emission Tab -->
            <div class="tab-pane fade" id="emission" role="tabpanel" aria-labelledby="emission-tab">
               <div class="form-group mt-3">
                  <label for="usr">Emission Detail</label>
                  <textarea name="emission_detail" id="emission_detail" rows="5" class="form-control" placeholder="Emission Detail">{{ isset($response['emission_detail']) ? $response['emission_detail'] : "" }}</textarea>
                  @if($errors->has('emission_detail'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('emission_detail') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>
               <div class="incrementable-section mt-3" data-field="emission_initiative_detail">
                  <h6>Initiatives Undertaken for Emission</h6>
                  <ul>
                     <?php
                     $count = 0;
                     $initiativeDetails = isset($response['emission_initiative_detail']) ? json_decode($response['emission_initiative_detail'], true) : [];
                     foreach ($initiativeDetails as $item) { ?>
                           <li class="d-flex" style="gap:10px">
                              <div class="form-group" style="1">
                                 <label>Initiative Undertaken</label>
                                 <textarea class="form-control no-editor" name="emission_initiative_detail[<?php echo $count; ?>][undertaken]" row="3" placeholder="Initiative Undertaken" id="emission_initiative_detail_<?php echo $count; ?>_undertaken"><?php echo htmlspecialchars($item['undertaken'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:1">
                                 <label>Details of the Initiative</label>
                                 <textarea class="form-control no-editor" name="emission_initiative_detail[<?php echo $count; ?>][details]" rows="3" placeholder="Details of the Initiative" id="emission_initiative_detail_<?php echo $count; ?>_details"><?php echo htmlspecialchars($item['details'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:1">
                                 <label>Outcome of the Initiative</label>
                                 <textarea class="form-control no-editor" name="emission_initiative_detail[<?php echo $count; ?>][outcome]" rows="3" placeholder="Outcome of the Initiative" id="emission_initiative_detail_<?php echo $count; ?>_outcome"><?php echo htmlspecialchars($item['outcome'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:0 0 fit-content">
                                 <button type="button" class="btn remove-row-btn mt-4" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                     <?php 
                           $count++; 
                     } 
                     ?>
                  </ul>
                  <button type="button" class="btn add-row-btn" data-field="emission_initiative_detail">+ Add Initiative</button>
                  @if($errors->has('emission_initiative_detail'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('emission_initiative_detail') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="incrementable-section" data-field="scope_1_emissions">
                  <h6>Scope 1</h6>
                  <div class="form-group w-fit">
                     <input type="text" class="form-control" name="scope_1_emissions_unit" placeholder="Unit" id="scope_1_emissions_unit" value="{{ isset($response['scope_1_emissions_unit']) ? $response['scope_1_emissions_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['scope_1_emissions']) ? json_decode($response['scope_1_emissions'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2 w-100">
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="scope_1_emissions[<?php echo $count; ?>][year]" placeholder="Year" id="scope_1_emissions_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                        </div>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="scope_1_emissions[<?php echo $count; ?>][value]" placeholder="Value" id="scope_1_emissions_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="scope_1_emissions">+</button>
               </div>

               <div class="incrementable-section" data-field="scope_2_emissions">
                  <h6>Scope 2</h6>
                  <div class="form-group w-fit">
                     <input type="text" class="form-control" name="scope_2_emissions_unit" placeholder="Unit" id="scope_2_emissions_unit" value="{{ isset($response['scope_2_emissions_unit']) ? $response['scope_2_emissions_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['scope_2_emissions']) ? json_decode($response['scope_2_emissions'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2 w-100">
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="scope_2_emissions[<?php echo $count; ?>][year]" placeholder="Year" id="scope_2_emissions_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                        </div>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="scope_2_emissions[<?php echo $count; ?>][value]" placeholder="Value" id="scope_2_emissions_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="scope_2_emissions">+</button>
               </div>

               <div class="incrementable-section" data-field="scope_3_emissions">
                  <h6>Scope 3</h6>
                  <div class="form-group w-fit">
                     <input type="text" class="form-control" name="scope_3_emissions_unit" placeholder="Unit" id="scope_3_emissions_unit" value="{{ isset($response['scope_3_emissions_unit']) ? $response['scope_3_emissions_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['scope_3_emissions']) ? json_decode($response['scope_3_emissions'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2 w-100">
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="scope_3_emissions[<?php echo $count; ?>][year]" placeholder="Year" id="scope_3_emissions_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                        </div>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="scope_3_emissions[<?php echo $count; ?>][value]" placeholder="Value" id="scope_3_emissions_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="scope_3_emissions">+</button>
               </div>
               <h6>Intensity Metrics</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="specific_emissions_scope_1_2_per_rupee_turnover">
                        <label for="usr">Scope 1 + 2 Emission Intensity per Rupee of Turnover</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="specific_emissions_scope_1_2_per_rupee_turnover_unit" placeholder="Unit" id="specific_emissions_scope_1_2_per_rupee_turnover_unit" value="{{ isset($response['specific_emissions_scope_1_2_per_rupee_turnover_unit']) ? $response['specific_emissions_scope_1_2_per_rupee_turnover_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['specific_emissions_scope_1_2_per_rupee_turnover']) ? json_decode($response['specific_emissions_scope_1_2_per_rupee_turnover'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="specific_emissions_scope_1_2_per_rupee_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="specific_emissions_scope_1_2_per_rupee_turnover_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="specific_emissions_scope_1_2_per_rupee_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="specific_emissions_scope_1_2_per_rupee_turnover_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="specific_emissions_scope_1_2_per_rupee_turnover">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="specific_emissions_scope_1_2_intensity_physical_output">
                        <label for="usr">Scope 1 + 2 Emission Intensity per Unit of Physical Output</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="specific_emissions_scope_1_2_intensity_physical_output_unit" placeholder="Unit" id="specific_emissions_scope_1_2_intensity_physical_output_unit" value="{{ isset($response['specific_emissions_scope_1_2_intensity_physical_output_unit']) ? $response['specific_emissions_scope_1_2_intensity_physical_output_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['specific_emissions_scope_1_2_intensity_physical_output']) ? json_decode($response['specific_emissions_scope_1_2_intensity_physical_output'], true) : [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="specific_emissions_scope_1_2_intensity_physical_output[<?php echo $count; ?>][year]" placeholder="Year" id="specific_emissions_scope_1_2_intensity_physical_output_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="specific_emissions_scope_1_2_intensity_physical_output[<?php echo $count; ?>][value]" placeholder="Value" id="specific_emissions_scope_1_2_intensity_physical_output_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>"; ?>
                        <button type="button" class="btn add-row-btn" data-field="specific_emissions_scope_1_2_intensity_physical_output">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="specific_emissions_scope_3_per_rupee_turnover">
                        <label for="usr">Scope 3 Emission Intensity per Rupee of Turnover</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="specific_emissions_scope_3_per_rupee_turnover_unit" placeholder="Unit" id="specific_emissions_scope_3_per_rupee_turnover_unit" value="{{ isset($response['specific_emissions_scope_3_per_rupee_turnover_unit']) ? $response['specific_emissions_scope_3_per_rupee_turnover_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['specific_emissions_scope_3_per_rupee_turnover']) ? json_decode($response['specific_emissions_scope_3_per_rupee_turnover'], true) : [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="specific_emissions_scope_3_per_rupee_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="specific_emissions_scope_3_per_rupee_turnover_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="specific_emissions_scope_3_per_rupee_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="specific_emissions_scope_3_per_rupee_turnover_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>"; ?>
                        <button type="button" class="btn add-row-btn" data-field="specific_emissions_scope_3_per_rupee_turnover">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="total_scope_3_emission_intensity">
                        <label for="usr">Scope 3 Emission Intensity per Unit of Physical Output</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="total_scope_3_emission_intensity_unit" placeholder="Unit" id="total_scope_3_emission_intensity_unit" value="{{ isset($response['total_scope_3_emission_intensity_unit']) ? $response['total_scope_3_emission_intensity_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['total_scope_3_emission_intensity']) ? json_decode($response['total_scope_3_emission_intensity'], true) : [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_scope_3_emission_intensity[<?php echo $count; ?>][year]" placeholder="Year" id="total_scope_3_emission_intensity_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="total_scope_3_emission_intensity[<?php echo $count; ?>][value]" placeholder="Value" id="total_scope_3_emission_intensity_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>"; ?>
                        <button type="button" class="btn add-row-btn" data-field="total_scope_3_emission_intensity">+</button>
                     </div>
                  </li>
               </ol>
               <h6>Air pollutants</h6>
               <ol>
                  <li>
                     <div class="incrementable-section" data-field="no_x">
                        <label for="usr">NOx</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="no_x_unit" placeholder="Unit" id="no_x_unit" value="{{ isset($response['no_x_unit']) ? $response['no_x_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['no_x']) ? json_decode($response['no_x'], true) : [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="no_x[<?php echo $count; ?>][year]" placeholder="Year" id="no_x_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="no_x[<?php echo $count; ?>][value]" placeholder="Value" id="no_x_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>"; ?>
                        <button type="button" class="btn add-row-btn" data-field="no_x">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="so_x">
                        <label for="usr">SOx</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="so_x_unit" placeholder="Unit" id="so_x_unit" value="{{ isset($response['so_x_unit']) ? $response['so_x_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['so_x']) ? json_decode($response['so_x'], true) : [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="so_x[<?php echo $count; ?>][year]" placeholder="Year" id="so_x_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="so_x[<?php echo $count; ?>][value]" placeholder="Value" id="so_x_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>"; ?>
                        <button type="button" class="btn add-row-btn" data-field="so_x">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="particulate_matter">
                        <label for="usr">Particulate Matter</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="particulate_matter_unit" placeholder="Unit" id="particulate_matter_unit" value="{{ isset($response['particulate_matter_unit']) ? $response['particulate_matter_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['particulate_matter']) ? json_decode($response['particulate_matter'], true) : [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="particulate_matter[<?php echo $count; ?>][year]" placeholder="Year" id="particulate_matter_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="particulate_matter[<?php echo $count; ?>][value]" placeholder="Value" id="particulate_matter_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>"; ?>
                        <button type="button" class="btn add-row-btn" data-field="particulate_matter">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="pop">
                        <label for="usr">Persistent Organic Pollutants (POP)</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="pop_unit" placeholder="Unit" id="pop_unit" value="{{ isset($response['pop_unit']) ? $response['pop_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['pop']) ? json_decode($response['pop'], true) : [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="pop[<?php echo $count; ?>][year]" placeholder="Year" id="pop_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="pop[<?php echo $count; ?>][value]" placeholder="Value" id="pop_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>"; ?>
                        <button type="button" class="btn add-row-btn" data-field="pop">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="voc">
                        <label for="usr">Volatile Organic Compounds (VOC)</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="voc_unit" placeholder="Unit" id="voc_unit" value="{{ isset($response['voc_unit']) ? $response['voc_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['voc']) ? json_decode($response['voc'], true) : [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="voc[<?php echo $count; ?>][year]" placeholder="Year" id="voc_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="voc[<?php echo $count; ?>][value]" placeholder="Value" id="voc_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>"; ?>
                        <button type="button" class="btn add-row-btn" data-field="voc">+</button>
                     </div>
                  </li>
                  <li>
                     <div class="incrementable-section" data-field="hazardous_air_pollutants">
                        <label for="usr">Hazardous Air Pollutants</label>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="hazardous_air_pollutants_unit" placeholder="Unit" id="hazardous_air_pollutants_unit" value="{{ isset($response['hazardous_air_pollutants_unit']) ? $response['hazardous_air_pollutants_unit'] : "" }}">
                        </div>
                        <?php 
                        $count = 0;
                        $energyDetail = isset($response['hazardous_air_pollutants']) ? json_decode($response['hazardous_air_pollutants'], true): [];
                        echo "<ul>";
                        foreach ($energyDetail as $year => $value) { ?>
                           <li class="d-flex gap-2 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="hazardous_air_pollutants[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_air_pollutants_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                              </div>
                              <div class="form-group w-fit">
                                 <input   type="text" class="form-control" name="hazardous_air_pollutants[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_air_pollutants_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                        <?php 
                           $count++; 
                        } 
                        echo "</ul>";?>
                        <button type="button" class="btn add-row-btn" data-field="hazardous_air_pollutants">+</button>
                     </div>
                  </li>
               </ol>
            </div>

            <!-- Natural Capital Tab -->
            <div class="tab-pane fade" id="natural-capital" role="tabpanel" aria-labelledby="natural-capital-tab">
               <div class="form-group mt-3">
                  <label for="usr">Natural Capital</label>
                  <textarea name="natural_capital" id="natural_capital" rows="5" class="form-control" placeholder="Natural Capital">{{ isset($response['natural_capital']) ? $response['natural_capital'] : "" }}</textarea>
                  @if($errors->has('natural_capital'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('natural_capital') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>
            </div>

            <!-- CSR for Climate Change Tab -->
            <div class="tab-pane fade" id="csr" role="tabpanel" aria-labelledby="csr-tab">
               <div class="form-group mt-3">
                  <label for="usr">CSR For Climate Action</label>
                  <textarea name="csr_for_climate_action" id="csr_for_climate_action" rows="5" class="form-control" placeholder="CSR For Climate Action">{{ isset($response['csr_for_climate_action']) ? $response['csr_for_climate_action'] : "" }}</textarea>
                  @if($errors->has('csr_for_climate_action'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('csr_for_climate_action') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="incrementable-section mt-3" data-field="csr_initiative_detail">
                  <h6>Initiatives Undertaken for CSR</h6>
                  <ul>
                     <?php
                     $count = 0;
                     $initiativeDetails = isset($response['csr_initiative_detail']) ? json_decode($response['csr_initiative_detail'], true) : [];
                     foreach ($initiativeDetails as $item) { ?>
                           <li class="d-flex" style="gap:10px;">
                              <div class="form-group" style="flex:1">
                                 <label>Initiative Undertaken</label>
                                 <textarea class="form-control no-editor" name="csr_initiative_detail[<?php echo $count; ?>][undertaken]" rows="3" placeholder="Initiative Undertaken" id="csr_initiative_detail_<?php echo $count; ?>_undertaken"><?php echo htmlspecialchars($item['undertaken'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:1">
                                 <label>Details of the Initiative</label>
                                 <textarea class="form-control no-editor" name="csr_initiative_detail[<?php echo $count; ?>][details]" rows="3" placeholder="Details of the Initiative" id="csr_initiative_detail_<?php echo $count; ?>_details"><?php echo htmlspecialchars($item['details'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:1">
                                 <label>Outcome of the Initiative</label>
                                 <textarea class="form-control no-editor" name="csr_initiative_detail[<?php echo $count; ?>][outcome]" rows="3" placeholder="Outcome of the Initiative" id="csr_initiative_detail_<?php echo $count; ?>_outcome"><?php echo htmlspecialchars($item['outcome'] ?? ''); ?></textarea>
                              </div>
                              <div class="form-group" style="flex:0 0 fit-content">
                                 <button type="button" class="btn remove-row-btn mt-4" data-index="<?php echo $count; ?>">-</button>
                              </div>
                           </li>
                     <?php 
                           $count++; 
                     } 
                     ?>
                  </ul>
                  <button type="button" class="btn add-row-btn" data-field="csr_initiative_detail">+ Add Initiative</button>
                  @if($errors->has('csr_initiative_detail'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('csr_initiative_detail') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>

               <div class="incrementable-section" data-field="csr_budget">
                  <h6>CSR Budget</h6>
                  <div class="form-group w-fit">
                     <input type="text" class="form-control" name="csr_budget_unit" placeholder="Unit" id="csr_budget_unit" value="{{ isset($response['csr_budget_unit']) ? $response['csr_budget_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['csr_budget']) ? json_decode($response['csr_budget'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2 w-100">
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="csr_budget[<?php echo $count; ?>][year]" placeholder="Year" id="csr_budget_<?php echo $count; ?>_year" value="<?php echo $value['year']; ?>">
                        </div>
                        <div class="form-group w-fit">
                           <input type="text" class="form-control" name="csr_budget[<?php echo $count; ?>][value]" placeholder="Value" id="csr_budget_<?php echo $count; ?>_value" value="<?php echo $value['value']; ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>"; ?>
                  <button type="button" class="btn add-row-btn" data-field="csr_budget">+</button>
               </div>

            </div>

            <!-- Product Stewardship Tab -->
            <div class="tab-pane fade" id="product-stewardship" role="tabpanel" aria-labelledby="product-stewardship-tab">
               <div class="form-group mt-3">
                  <label for="usr">Product Stewardship</label>
                  <textarea name="product_stewardship" id="product_stewardship" rows="5" class="form-control" placeholder="Product Stewardship">{{ isset($response['product_stewardship_field']) ? $response['product_stewardship_field'] : "" }}</textarea>
                  @if($errors->has('product_stewardship'))
                  <ul class="parsley-errors-list filled">
                     @foreach($errors->get('product_stewardship') as $error)
                     <li class="parsley-required">{{ $error }}</li>
                     @endforeach
                  </ul>
                  @endif
               </div>
            </div>
         </div>

         <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary Theme-Btn" id="save-from"><?php echo (isset($response)) ? "Update" : "Submit" ?></button>
         </div>
         </form>
      </div>
   </div>
</div>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/assets/js')}}/editor.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="{{url('/assets/css')}}/editor.css" type="text/css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>

<script>
   const editorSetting = {
      "strikeout": false,
      "ol": false,
      "ul": true,
      "undo": true,
      "redo": true,
      "l_align": false,
      "r_align": false,
      "c_align": false,
      "justify": false,
      "unlink": false,
      "insert_link": false,
      "insert_img": false,
      "insert_table": false,
      "hr_line": false,
      'block_quote': false,
      'source': false,
      'indent': false,
      'outdent': false,
      'fonts': false,
      'styles': false,
      'print': false,
      'rm_format': false,
      'status_bar': false,
      'font_size': false,
      'color': false,
      'splchars': false,
      'select_all': false,
      'togglescreen': false,
      "superscript": true,
      "subscript": true,
      'forcePasteAsPlainText': true
   };

   $('textarea').each(function (i, v) {
      if ($(this).hasClass('no-editor')) return;

      $(this).attr('id', 'txtEditor' + i);
      var editorid = $(this).attr('id');

      $("#" + editorid).Editor(editorSetting);
      $('#' + editorid).parent().find(".Editor-editor").html($("#" + editorid).val());
   });
</script>
<script>
   var exist_name = <?php echo json_encode($corporates_exist_names); ?>;
   var exist_short_name = <?php echo json_encode($corporates_exist_shortnames); ?>;
   var full_names_exist = (exist_name || []).map(name => name.toLowerCase());
   var short_names_exist = (exist_short_name || []).map(name => name.toLowerCase());
   console.log("Exist Name:", exist_name); // Debug
   console.log("Exist Short Name:", exist_short_name);
   function fileValidation(id){
      var fileInput = document.getElementById(id);
      var filePath = fileInput.value;
      var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
      if(!allowedExtensions.exec(filePath)){
         alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
         fileInput.value = '';
         return false;
      }
   }

   function removeimage(element,elementname){
      $(element).parent().hide();
      $('input[name='+elementname+']').val(' ')
   }

   function fileValidImage(element){
      var fileInput = element;
      var filePath = fileInput.value;
      var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
      if(!allowedExtensions.exec(filePath)){
         alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
         fileInput.value = '';
         return false;
      }
   }

   $(document).ready(function() {   
      $("#image").change(function(){
         var fileInput = document.getElementById('image');
         var filePath = fileInput.value;
         var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
         if(!allowedExtensions.exec(filePath)){
            alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
            fileInput.value = '';
            return false;
         }else{
            $("#header-image-pre").hide();
            var input=this;
            bool1=true;
            if (input.files && input.files[0]) {
               var reader = new FileReader();
               reader.readAsDataURL(input.files[0]);
               reader.onload = function (e) {
                  var image = new Image();
                  image.src=e.target.result;
                  image.onload = function () {
                     var height = this.height;
                     var width = this.width;
                     if (height < 350 || width < 1000) {
                        alert('Please upload file size must be greater than 1000 X 350');
                        fileInput.value = '';
                     }else{
                        $('#header-image-pre').attr('src',e.target.result).show();
                     }
                  };
               };
            }
         } 
      });

      // Add row functionality
      $(document).ready(function() {

      $('.incrementable-section').each(function() {
        var $section = $(this);
        var fieldName = $section.data('field');
        
        // Skip non-year/value sections (factory_locations, initiative details)
        if (fieldName === 'factory_locations') {
            return;
        }
        if(fieldName.includes('initiative_detail')) {
            var $ul = $section.find('ul');
            // Check if the <ul> is empty
            if ($ul.children('li').length === 0) {
               var newIndex = 0;
               var newRow = `
                     <li class="d-flex" style="gap:10px">
                           <div class="form-group" style="flex:1">
                              <label>Initiative Undertaken</label>
                              <textarea class="form-control no-editor" name="${fieldName}[${newIndex}][undertaken]" rows="3" placeholder="Initiative Undertaken" id="${fieldName}_${newIndex}_undertaken"></textarea>
                           </div>
                           <div class="form-group" style="flex:1">
                              <label>Details of the Initiative</label>
                              <textarea class="form-control no-editor" name="${fieldName}[${newIndex}][details]" rows="3" placeholder="Details of the Initiative" id="${fieldName}_${newIndex}_details"></textarea>
                           </div>
                           <div class="form-group" style="flex:1">
                              <label>Outcome of the Initiative</label>
                              <textarea class="form-control no-editor" name="${fieldName}[${newIndex}][outcome]" rows="3" placeholder="Outcome of the Initiative" id="${fieldName}_${newIndex}_outcome"></textarea>
                           </div>
                           <div class="form-group" style="flex:0 0 fit-content">
                              <button type="button" class="mt-4 btn remove-row-btn" data-index="${newIndex}">-</button>
                           </div>
                     </li>
                  `;
                  $ul.append(newRow);
            }
        } else {
         var $ul = $section.find('ul');
         // Check if the <ul> is empty
         if ($ul.children('li').length === 0) {
               // Add one empty year/value row
               var newIndex = 0;
               var newRow = `
                  <li class="d-flex gap-2 w-100 w-100">
                           <div class="form-group w-fit">
                              <input type="text" class="form-control" name="${fieldName}[${newIndex}][year]" placeholder="Year" id="${fieldName}_${newIndex}_year" value="">
                           </div>
                           <div class="form-group w-fit">
                              <input type="text" class="form-control" name="${fieldName}[${newIndex}][value]" placeholder="Value" id="${fieldName}_${newIndex}_value" value="">
                           </div>
                           <div class="form-group col-md-2">
                              <button type="button" class="btn remove-row-btn" data-index="${newIndex}">-</button>
                           </div>
                  </li>
               `;
               $ul.append(newRow);
         }
        }
        
    });
         // Add row functionality
         var initiativeFields = ['waste_initiative_detail','csr_initiative_detail', 'energy_initiative_detail', 'emission_initiative_detail', 'water_initiative_detail'];
         

         $('.add-row-btn').on('click', function() {
            var field = $(this).data('field');
            var container = $(this).prev('ul');
            var lastIndex = container.find('li').length > 0 ? parseInt(container.find('li:last .remove-row-btn').data('index')) : -1;
            var newIndex = lastIndex + 1;
            var newRow;

            if (initiativeFields.includes(field)) {
                newRow = `
                    <li class="d-flex" style="gap:10px">
                           <div class="form-group" style="flex:1">
                              <label>Initiative Undertaken</label>
                              <textarea class="form-control no-editor" name="${field}[${newIndex}][undertaken]" rows="3" placeholder="Initiative Undertaken" id="${field}_${newIndex}_undertaken"></textarea>
                           </div>
                           <div class="form-group" style="flex:1">
                              <label>Details of the Initiative</label>
                              <textarea class="form-control no-editor" name="${field}[${newIndex}][details]" rows="3" placeholder="Details of the Initiative" id="${field}_${newIndex}_details"></textarea>
                           </div>
                           <div class="form-group" style="flex:1">
                              <label>Outcome of the Initiative</label>
                              <textarea class="form-control no-editor" name="${field}[${newIndex}][outcome]" rows="3" placeholder="Outcome of the Initiative" id="${field}_${newIndex}_outcome"></textarea>
                           </div>
                           <div class="form-group" style="flex:0 0 fit-content">
                              <button type="button" class="mt-4 btn remove-row-btn" data-index="${newIndex}">-</button>
                           </div>
                     </li>
                `;
                container.append(newRow);
                var detailsId = field + '_' + newIndex + '_details';
                  var outcomeId = field + '_' + newIndex + '_outcome';
                  var undertakenId = field + '_' + newIndex + '_undertaken';

                  $('#' + detailsId).Editor(editorSetting);
                  $('#' + detailsId).parent().find('.Editor-editor').html('');

                  $('#' + outcomeId).Editor(editorSetting);
                  $('#' + outcomeId).parent().find('.Editor-editor').html('');

                  $('#' + undertakenId).Editor(editorSetting);
                  $('#' + undertakenId).parent().find('.Editor-editor').html('');
            } else if (field === 'factory_locations') {
                // Single input for factory_locations
                newRow = `
                    <li class="d-flex gap-2 w-100">
                        <div class="form-group col-md-10">
                            <input type="text" class="form-control" name="${field}[${newIndex}]" placeholder="Location" id="${field}_${newIndex}">
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" class="btn remove-row-btn" data-index="${newIndex}">-</button>
                        </div>
                    </li>
                `;
                container.append(newRow);
            } else {
                // Default year/value pair for other fields
                newRow = `
                    <li class="d-flex gap-2 w-100 w-100">
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="${field}[${newIndex}][year]" placeholder="Year" id="${field}_${newIndex}_year" value="">
                              </div>
                              <div class="form-group w-fit">
                                 <input type="text" class="form-control" name="${field}[${newIndex}][value]" placeholder="Value" id="${field}_${newIndex}_value" value="">
                              </div>
                              <div class="form-group col-md-2">
                                 <button type="button" class="btn remove-row-btn " data-index="${newIndex}">-</button>
                              </div>
                     </li>
                `;
                container.append(newRow);
            }
            
        });

         // Remove row functionality
         $(document).on('click', '.remove-row-btn', function() {
            var index = $(this).data('index');
            var field = $(this).closest('.incrementable-section').data('field');
            var container = $(this).closest('ul');
            $(this).closest('li').remove();

            // Reindex the remaining rows generically (handles any subfields)
            container.find('li').each(function(i) {
                $(this).find('input, textarea').each(function() {
                    var oldName = $(this).attr('name');
                    if (oldName) {
                        var newName = oldName.replace(/\[\d+\]/, '[' + i + ']');
                        $(this).attr('name', newName);
                    }
                    var oldId = $(this).attr('id');
                    if (oldId) {
                        var newId = oldId.replace(/_\d+_/, '_' + i + '_');
                        $(this).attr('id', newId);
                    }
                });
                $(this).find('.remove-row-btn').data('index', i).attr('data-index', i);
            });
        });
      });

      // Remove row functionality
      $(document).on('click', '.remove-row-btn', function() {
         var index = $(this).data('index');
         var field = $(this).closest('.incrementable-section').data('field');
         $(this).closest('li').remove();

         // Reindex the remaining rows
         var container = $(this).closest('ul');
         container.find('li').each(function(i) {
            $(this).find('input[name="' + field + '[' + index + '][year]"]').attr({
               name: field + '[' + i + '][year]',
               id: field + '_' + i + '_year'
            });
            $(this).find('input[name="' + field + '[' + index + '][value]"]').attr({
               name: field + '[' + i + '][value]',
               id: field + '_' + i + '_value'
            });
            $(this).find('.remove-row-btn').data('index', i).attr('data-index', i);
         });
      });
   });

   $(document).ready(function() {
      // Decode the JSON string to an array of strings
      var industry_val = <?php echo isset($response['industry']) ? $response['industry'] : '[]'; ?>;
      console.log("Industry Values:", industry_val); // Debug: Log the raw industry values

      // Ensure industry_val is an array
      if (typeof industry_val === 'string') {
         industry_val = JSON.parse(industry_val);
      }
      console.log("Parsed Industry Values:", industry_val); // Debug: Log the parsed values

      // Initialize Chosen for dropdowns with multiple option
      $("#ind_cls").chosen({
         width: "100%",
         max_selected_options: 5 // Optional: Limit the number of selections
      });

      // Fetch industry and segment data
      $.ajax({
         type: 'GET',
         url: "https://uat.envesya.com/api/get_industry_segment",
         success: function(response) {
               var industrySegmentData = JSON.parse(response);
               console.log("Industry Data:", industrySegmentData); // Debug: Log the fetched data

               // Populate industry dropdown
               var industryOptions = '<option value="">Select</option>';
               $.each(industrySegmentData.industry, function(index, item) {
                  industryOptions += '<option value="' + item.id + '">' + item.name + '</option>';
               });
               $("#ind_cls").html(industryOptions);
               console.log("Options Populated:", $("#ind_cls").html()); // Debug: Log the populated options

               // Set selected industries for edit mode
               if (industry_val.length > 0 && industry_val[0] !== '') {
                  $("#ind_cls").val(industry_val).trigger("chosen:updated");
                  console.log("Selected Values Set:", $("#ind_cls").val()); // Debug: Log the selected values
               } else {
                  $("#ind_cls").trigger("chosen:updated");
               }

               // var full_names = industrySegmentData.full_names || [];
               // var short_names = industrySegmentData.short_names || [];
               var full_names = (industrySegmentData.full_names || []).map(name => name.toLowerCase());
               // console.log(full_names);
               var short_names = (industrySegmentData.short_names || []).map(name => name.toLowerCase());

               

               // Determine if it's edit mode
               var isEdit = <?php echo isset($response) ? 'true' : 'false'; ?>;
               var currentName = $('#name').val().trim().toLowerCase();
               var currentShortName = $('#short_name').val().trim().toLowerCase();

               // Keyup validation for Legal Name
               $(document).on('keyup','#name', function() {
                  var value = $(this).val().trim();
                  var normalizedValue = normalizeName(value);
                  console.log("Input:", value, "Normalized:", normalizedValue);

                  var errorSpan = $('#listing_name_error');
                  errorSpan.text('').removeClass('error'); 

                  let normalizedFullNames = full_names.map(normalizeName);
                  let normalizedFullNamesExist = full_names_exist.map(normalizeName);

                  if (normalizedValue && 
                     (normalizedFullNames.includes(normalizedValue) || normalizedFullNamesExist.includes(normalizedValue)) && 
                     (!isEdit || normalizedValue !== normalizeName(currentName))) {
                     
                     errorSpan.text('Legal Name already exists').addClass('error');
                  }
               });

               // Short Name validation
               $(document).on('keyup','#short_name', function() {
                  var value = $(this).val().trim();
                  var normalizedValue = normalizeName(value);

                  var errorSpan = $('#listing_short_name_error');
                  errorSpan.text('').removeClass('error'); 

                  let normalizedShortNames = short_names.map(normalizeName);
                  let normalizedShortNamesExist = short_names_exist.map(normalizeName);

                  if (normalizedValue && 
                     (normalizedShortNames.includes(normalizedValue) || normalizedShortNamesExist.includes(normalizedValue)) && 
                     (!isEdit || normalizedValue !== normalizeName(currentShortName))) {
                     
                     errorSpan.text('Short Name already exists').addClass('error');
                  }
               });
         },
         error: function(e) {
               console.error("AJAX Error:", e); // Debug: Log any AJAX errors
               alert("Error fetching industry and segment data");
         }
      });

      function normalizeName(name) {
         return name
            .toLowerCase()
            .replace(/\bpvt\b/g, 'private')
            .replace(/\bprivate\b/g, 'private')
            .replace(/\bltd\b/g, 'limited')
            .replace(/\blimited\b/g, 'limited')
            .replace(/\s+/g, ' ') // collapse multiple spaces
            .trim();
      }

      function debounce(func, wait) {
         let timeout;
         return function executedFunction(...args) {
            const later = () => {
               clearTimeout(timeout);
               func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
         };
      }

      const form = document.querySelector('form');
      form.addEventListener('submit', debounce(function (event) {
         alert();
      event.preventDefault();
      // Your form submission logic here
      console.log('Form submitted');
      }, 1000)); // 1-second delay

      $('form').on('submit', function(e) {
         var nameError = $('#listing_name_error').text();
         var shortNameError = $('#listing_short_name_error').text();

         if (nameError || shortNameError) {
            alert('Name or shortname already exist.');
            e.preventDefault();
            return false;
         }
      });

      // On industry change, handle segment population if needed
      $("#ind_cls").on("change", function() {
         var industry_ids = $(this).val() || [];
         console.log("Selected Industries:", industry_ids); // Debug: Log the selected industries
      });
   });
</script>

@endsection
@section('scripts')
@parent
@endsection
@section('styles')
@parent
@endsection