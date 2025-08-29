@extends('layouts.app')

@section('content')
<style>
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
         <input type="hidden" name="listing_id" value="{{(isset($response['id']) && $response['id'] != '') ? $response['id'] : ''}}">
         <input type="hidden" name="org_id" value="{{(isset($response['org_id']) && $response['org_id'] != '') ? $response['org_id'] : ''}}">

         <!-- Bootstrap Tabs -->
         <ul class="nav nav-tabs" id="corporateTabs" role="tablist">
            <li class="nav-item">
               <a class="nav-link active" id="company-tab" data-toggle="tab" href="#company" role="tab" aria-controls="company" aria-selected="true">Company Detail</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="energy-tab" data-toggle="tab" href="#energy" role="tab" aria-controls="energy" aria-selected="false">Energy</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="water-tab" data-toggle="tab" href="#water" role="tab" aria-controls="water" aria-selected="false">Water</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" id="waste-tab" data-toggle="tab" href="#waste" role="tab" aria-controls="waste" aria-selected="false">Waste</a>
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
                        <input type="text" class="form-control" name="name" placeholder="Legal Name" value="{{(isset($response['name']) && $response['name'] != '') ? $response['name'] : ''}}" id="name" required>
                        <span id="listing_name_error"></span>
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
                        <input type="text" class="form-control" name="short_name" placeholder="Short Name" value="{{(isset($response['short_name']) && $response['short_name'] != '') ? $response['short_name'] : ''}}" id="short_name" required oninput="this.value=this.value.replace(/[/?@,]/g,'');">
                        <span id="listing_short_name_error"></span>
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
                           <li class="d-flex gap-2">
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

               <div class="incrementable-section" data-field="total_energy_consumption">
                  <label for="usr">Total Energy Consumption</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_energy_consumption_unit" placeholder="Unit" id="total_energy_consumption_unit" value="{{ isset($response['total_energy_consumption_unit']) ? $response['total_energy_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_energy_consumption']) ? json_decode($response['total_energy_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_energy_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_energy_consumption_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_energy_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_energy_consumption_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="total_renewable_energy_consumption">
                  <label for="usr">Total Renewable Energy Consumption</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_renewable_energy_consumption_unit" placeholder="Unit" id="total_renewable_energy_consumption_unit" value="{{ isset($response['total_renewable_energy_consumption_unit']) ? $response['total_renewable_energy_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_renewable_energy_consumption']) ? json_decode($response['total_renewable_energy_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_renewable_energy_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_renewable_energy_consumption_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_renewable_energy_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_renewable_energy_consumption_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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


               <div class="incrementable-section" data-field="total_non_renewable_electricity_consumption">
                  <label for="usr">Total electricity consumption (Non Renewable)</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_non_renewable_electricity_consumption_unit" placeholder="Unit" id="total_non_renewable_electricity_consumption_unit" value="{{ isset($response['total_non_renewable_electricity_consumption_unit']) ? $response['total_non_renewable_electricity_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_non_renewable_electricity_consumption']) ? json_decode($response['total_non_renewable_electricity_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_non_renewable_electricity_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_non_renewable_electricity_consumption_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_non_renewable_electricity_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_non_renewable_electricity_consumption_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="total_non_renewable_fuel_consumption">
                  <label for="usr">Total fuel consumption (Non Renewable)</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_non_renewable_fuel_consumption_unit" placeholder="Unit" id="total_non_renewable_fuel_consumption_unit" value="{{ isset($response['total_non_renewable_fuel_consumption_unit']) ? $response['total_non_renewable_fuel_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_non_renewable_fuel_consumption']) ? json_decode($response['total_non_renewable_fuel_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_non_renewable_fuel_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_non_renewable_fuel_consumption_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_non_renewable_fuel_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_non_renewable_fuel_consumption_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="non_renewable_energy_cosuption_through_source">
                  <label for="usr">Energy consumption through other sources (Non Renewable)</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="non_renewable_energy_cosuption_through_source_unit" placeholder="Unit" id="non_renewable_energy_cosuption_through_source_unit" value="{{ isset($response['non_renewable_energy_cosuption_through_source_unit']) ? $response['non_renewable_energy_cosuption_through_source_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['non_renewable_energy_cosuption_through_source']) ? json_decode($response['non_renewable_energy_cosuption_through_source'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="non_renewable_energy_cosuption_through_source[<?php echo $count; ?>][year]" placeholder="Year" id="non_renewable_energy_cosuption_through_source_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="non_renewable_energy_cosuption_through_source[<?php echo $count; ?>][value]" placeholder="Value" id="non_renewable_energy_cosuption_through_source_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="non_renewable_energy_cosuption_through_source">+</button>
               </div>

               <div class="incrementable-section" data-field="total_non_renewable_energy_consumption">
                  <label for="usr">Total Non Renewable Energy Consumption</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_non_renewable_energy_consumption_unit" placeholder="Unit" id="total_non_renewable_energy_consumption_unit" value="{{ isset($response['total_non_renewable_energy_consumption_unit']) ? $response['total_non_renewable_energy_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_non_renewable_energy_consumption']) ? json_decode($response['total_non_renewable_energy_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_non_renewable_energy_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_non_renewable_energy_consumption_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_non_renewable_energy_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_non_renewable_energy_consumption_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="renewable_power_percentage">
                  <label for="usr">Renewable Power % of Total</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="renewable_power_percentage_unit" placeholder="Unit" id="renewable_power_percentage_unit" value="{{ isset($response['renewable_power_percentage_unit']) ? $response['renewable_power_percentage_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['renewable_power_percentage']) ? json_decode($response['renewable_power_percentage'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="renewable_power_percentage[<?php echo $count; ?>][year]" placeholder="Year" id="renewable_power_percentage_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="renewable_power_percentage[<?php echo $count; ?>][value]" placeholder="Value" id="renewable_power_percentage_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="total_electricity_consumption">
                  <label for="usr">Total Electricity Consumption</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_electricity_consumption_unit" placeholder="Unit" id="total_electricity_consumption_unit" value="{{ isset($response['total_electricity_consumption_unit']) ? $response['total_electricity_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_electricity_consumption']) ? json_decode($response['total_electricity_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_electricity_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_electricity_consumption_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_electricity_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_electricity_consumption_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="total_electricity_consumption">+</button>
               </div>

               <div class="incrementable-section" data-field="total_fuel_consumption">
                  <label for="usr">Total Fuel Consumption</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_fuel_consumption_unit" placeholder="Unit" id="total_fuel_consumption_unit" value="{{ isset($response['total_fuel_consumption_unit']) ? $response['total_fuel_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_fuel_consumption']) ? json_decode($response['total_fuel_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_fuel_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_fuel_consumption_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_fuel_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_fuel_consumption_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="energy_cosuption_through_source">
                  <label for="usr">Energy consumption through other sources</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="energy_cosuption_through_source_unit" placeholder="Unit" id="energy_cosuption_through_source_unit" value="{{ isset($response['energy_cosuption_through_source_unit']) ? $response['energy_cosuption_through_source_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['energy_cosuption_through_source']) ? json_decode($response['energy_cosuption_through_source'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="energy_cosuption_through_source[<?php echo $count; ?>][year]" placeholder="Year" id="energy_cosuption_through_source_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="energy_cosuption_through_source[<?php echo $count; ?>][value]" placeholder="Value" id="energy_cosuption_through_source_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="energy_cosuption_through_source">+</button>
               </div>

               <div class="incrementable-section" data-field="specific_energy_consumption">
                  <label for="usr">Specific Energy Consumption</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="specific_energy_consumption_unit" placeholder="Unit" id="specific_energy_consumption_unit" value="{{ isset($response['specific_energy_consumption_unit']) ? $response['specific_energy_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['specific_energy_consumption']) ? json_decode($response['specific_energy_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_energy_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="specific_energy_consumption_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_energy_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="specific_energy_consumption_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="specific_energy_consumption">+</button>
               </div>

               <div class="incrementable-section" data-field="energy_intensity_per_rupee_turnover">
                  <label for="usr">Energy Intensity per Rupee of Turnover</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="energy_intensity_per_rupee_turnover_unit" placeholder="Unit" id="energy_intensity_per_rupee_turnover_unit" value="{{ isset($response['energy_intensity_per_rupee_turnover_unit']) ? $response['energy_intensity_per_rupee_turnover_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['energy_intensity_per_rupee_turnover']) ? json_decode($response['energy_intensity_per_rupee_turnover'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="energy_intensity_per_rupee_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="energy_intensity_per_rupee_turnover_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="energy_intensity_per_rupee_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="energy_intensity_per_rupee_turnover_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="energy_intensity_per_rupee_turnover_ppp">
                  <label for="usr">Energy intensity per rupee of turnover (PPP adjusted)</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="energy_intensity_per_rupee_turnover_ppp_unit" placeholder="Unit" id="energy_intensity_per_rupee_turnover_ppp_unit" value="{{ isset($response['energy_intensity_per_rupee_turnover_ppp_unit']) ? $response['energy_intensity_per_rupee_turnover_ppp_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['energy_intensity_per_rupee_turnover_ppp']) ? json_decode($response['energy_intensity_per_rupee_turnover_ppp'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="energy_intensity_per_rupee_turnover_ppp[<?php echo $count; ?>][year]" placeholder="Year" id="energy_intensity_per_rupee_turnover_ppp_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="energy_intensity_per_rupee_turnover_ppp[<?php echo $count; ?>][value]" placeholder="Value" id="energy_intensity_per_rupee_turnover_ppp_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="energy_intensity_per_rupee_turnover_ppp">+</button>
               </div>

               <div class="incrementable-section" data-field="energy_intensity_physical_output">
                  <label for="usr">Energy intensity in terms of physical output</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="energy_intensity_physical_output_unit" placeholder="Unit" id="energy_intensity_physical_output_unit" value="{{ isset($response['energy_intensity_physical_output_unit']) ? $response['energy_intensity_physical_output_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['energy_intensity_physical_output']) ? json_decode($response['energy_intensity_physical_output'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="energy_intensity_physical_output[<?php echo $count; ?>][year]" placeholder="Year" id="energy_intensity_physical_output_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="energy_intensity_physical_output[<?php echo $count; ?>][value]" placeholder="Value" id="energy_intensity_physical_output_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="energy_intensity">
                  <label for="usr">Energy intensity</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="energy_intensity_unit" placeholder="Unit" id="energy_intensity_unit" value="{{ isset($response['energy_intensity_unit']) ? $response['energy_intensity_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['energy_intensity']) ? json_decode($response['energy_intensity'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="energy_intensity[<?php echo $count; ?>][year]" placeholder="Year" id="energy_intensity_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="energy_intensity[<?php echo $count; ?>][value]" placeholder="Value" id="energy_intensity_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="energy_intensity">+</button>
               </div>
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
               <div class="incrementable-section" data-field="water_withdrawal_source_surface">
                  <label for="usr">Water Withdrawal Source - Surface</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_withdrawal_source_surface_unit" placeholder="Unit" id="water_withdrawal_source_surface_unit" value="{{ isset($response['water_withdrawal_source_surface_unit']) ? $response['water_withdrawal_source_surface_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_withdrawal_source_surface']) ? json_decode($response['water_withdrawal_source_surface'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_withdrawal_source_surface[<?php echo $count; ?>][year]" placeholder="Year" id="water_withdrawal_source_surface_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_withdrawal_source_surface[<?php echo $count; ?>][value]" placeholder="Value" id="water_withdrawal_source_surface_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_withdrawal_source_ground">
                  <label for="usr">Water Withdrawal Source - Ground</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_withdrawal_source_ground_unit" placeholder="Unit" id="water_withdrawal_source_ground_unit" value="{{ isset($response['water_withdrawal_source_ground_unit']) ? $response['water_withdrawal_source_ground_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_withdrawal_source_ground']) ? json_decode($response['water_withdrawal_source_ground'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_withdrawal_source_ground[<?php echo $count; ?>][year]" placeholder="Year" id="water_withdrawal_source_ground_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_withdrawal_source_ground[<?php echo $count; ?>][value]" placeholder="Value" id="water_withdrawal_source_ground_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_withdrawal_source_thirdparty">
                  <label for="usr">Water Withdrawal Source - Third Party</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_withdrawal_source_thirdparty_unit" placeholder="Unit" id="water_withdrawal_source_thirdparty_unit" value="{{ isset($response['water_withdrawal_source_thirdparty_unit']) ? $response['water_withdrawal_source_thirdparty_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_withdrawal_source_thirdparty']) ? json_decode($response['water_withdrawal_source_thirdparty'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_withdrawal_source_thirdparty[<?php echo $count; ?>][year]" placeholder="Year" id="water_withdrawal_source_thirdparty_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_withdrawal_source_thirdparty[<?php echo $count; ?>][value]" placeholder="Value" id="water_withdrawal_source_thirdparty_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_withdrawal_source_sea">
                  <label for="usr">Water Withdrawal Source - Sea</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_withdrawal_source_sea_unit" placeholder="Unit" id="water_withdrawal_source_sea_unit" value="{{ isset($response['water_withdrawal_source_sea_unit']) ? $response['water_withdrawal_source_sea_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_withdrawal_source_sea']) ? json_decode($response['water_withdrawal_source_sea'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_withdrawal_source_sea[<?php echo $count; ?>][year]" placeholder="Year" id="water_withdrawal_source_sea_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_withdrawal_source_sea[<?php echo $count; ?>][value]" placeholder="Value" id="water_withdrawal_source_sea_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_withdrawal_source_other">
                  <label for="usr">Water Withdrawal Source - Other</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_withdrawal_source_other_unit" placeholder="Unit" id="water_withdrawal_source_other_unit" value="{{ isset($response['water_withdrawal_source_other_unit']) ? $response['water_withdrawal_source_other_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_withdrawal_source_other']) ? json_decode($response['water_withdrawal_source_other'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_withdrawal_source_other[<?php echo $count; ?>][year]" placeholder="Year" id="water_withdrawal_source_other_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_withdrawal_source_other[<?php echo $count; ?>][value]" placeholder="Value" id="water_withdrawal_source_other_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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


               <div class="incrementable-section" data-field="water_replenishment_percentage">
                  <label for="usr">Water Replenishment % of Consumption</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_replenishment_percentage_unit" placeholder="Unit" id="water_replenishment_percentage_unit" value="{{ isset($response['water_replenishment_percentage_unit']) ? $response['water_replenishment_percentage_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['water_replenishment_percentage']) ? json_decode($response['water_replenishment_percentage'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="water_replenishment_percentage[<?php echo $count; ?>][year]" placeholder="Year" id="water_replenishment_percentage_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="water_replenishment_percentage[<?php echo $count; ?>][value]" placeholder="Value" id="water_replenishment_percentage_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="total_water_withdrawal">
                  <label for="usr">Total Water Withdrawal</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_water_withdrawal_unit" placeholder="Unit" id="total_water_withdrawal_unit" value="{{ isset($response['total_water_withdrawal_unit']) ? $response['total_water_withdrawal_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_water_withdrawal']) ? json_decode($response['total_water_withdrawal'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_water_withdrawal[<?php echo $count; ?>][year]" placeholder="Year" id="total_water_withdrawal_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_water_withdrawal[<?php echo $count; ?>][value]" placeholder="Value" id="total_water_withdrawal_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="total_water_withdrawal_by_source">
                  <label for="usr">Total Water Withdrawal by Source</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_water_withdrawal_by_source_unit" placeholder="Unit" id="total_water_withdrawal_by_source_unit" value="{{ isset($response['total_water_withdrawal_by_source_unit']) ? $response['total_water_withdrawal_by_source_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_water_withdrawal_by_source']) ? json_decode($response['total_water_withdrawal_by_source'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_water_withdrawal_by_source[<?php echo $count; ?>][year]" placeholder="Year" id="total_water_withdrawal_by_source_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_water_withdrawal_by_source[<?php echo $count; ?>][value]" placeholder="Value" id="total_water_withdrawal_by_source_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="total_water_withdrawal_by_source">+</button>
               </div>

               <div class="incrementable-section" data-field="total_water_consumption">
                  <label for="usr">Total Water Consumption</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_water_consumption_unit" placeholder="Unit" id="total_water_consumption_unit" value="{{ isset($response['total_water_consumption_unit']) ? $response['total_water_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_water_consumption']) ? json_decode($response['total_water_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_water_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="total_water_consumption_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_water_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="total_water_consumption_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_discharge_to_surface_water_no_treatment">
                  <label for="usr">Water Discharge to Surface Water - No Treatment</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_discharge_to_surface_water_no_treatment_unit" placeholder="Unit" id="water_discharge_to_surface_water_no_treatment_unit" value="{{ isset($response['water_discharge_to_surface_water_no_treatment_unit']) ? $response['water_discharge_to_surface_water_no_treatment_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_discharge_to_surface_water_no_treatment']) ? json_decode($response['water_discharge_to_surface_water_no_treatment'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_surface_water_no_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_surface_water_no_treatment_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_surface_water_no_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_surface_water_no_treatment_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_discharge_to_surface_water_with_treatment">
                  <label for="usr">Water Discharge to Surface Water - With Treatment</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_discharge_to_surface_water_with_treatment_unit" placeholder="Unit" id="water_discharge_to_surface_water_with_treatment_unit" value="{{ isset($response['water_discharge_to_surface_water_with_treatment_unit']) ? $response['water_discharge_to_surface_water_with_treatment_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_discharge_to_surface_water_with_treatment']) ? json_decode($response['water_discharge_to_surface_water_with_treatment'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_surface_water_with_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_surface_water_with_treatment_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_surface_water_with_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_surface_water_with_treatment_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_discharge_to_ground_water_no_treatment">
                  <label for="usr">Water Discharge to Ground Water - No Treatment</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_discharge_to_ground_water_no_treatment_unit" placeholder="Unit" id="water_discharge_to_ground_water_no_treatment_unit" value="{{ isset($response['water_discharge_to_ground_water_no_treatment_unit']) ? $response['water_discharge_to_ground_water_no_treatment_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_discharge_to_ground_water_no_treatment']) ? json_decode($response['water_discharge_to_ground_water_no_treatment'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_ground_water_no_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_ground_water_no_treatment_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_ground_water_no_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_ground_water_no_treatment_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_discharge_to_ground_water_with_treatment">
                  <label for="usr">Water Discharge to Ground Water - With Treatment</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_discharge_to_ground_water_with_treatment_unit" placeholder="Unit" id="water_discharge_to_ground_water_with_treatment_unit" value="{{ isset($response['water_discharge_to_ground_water_with_treatment_unit']) ? $response['water_discharge_to_ground_water_with_treatment_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_discharge_to_ground_water_with_treatment']) ? json_decode($response['water_discharge_to_ground_water_with_treatment'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_ground_water_with_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_ground_water_with_treatment_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_ground_water_with_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_ground_water_with_treatment_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_discharge_to_sea_water_no_treatment">
                  <label for="usr">Water Discharge to Sea Water - No Treatment</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_discharge_to_sea_water_no_treatment_unit" placeholder="Unit" id="water_discharge_to_sea_water_no_treatment_unit" value="{{ isset($response['water_discharge_to_sea_water_no_treatment_unit']) ? $response['water_discharge_to_sea_water_no_treatment_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_discharge_to_sea_water_no_treatment']) ? json_decode($response['water_discharge_to_sea_water_no_treatment'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_sea_water_no_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_sea_water_no_treatment_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_sea_water_no_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_sea_water_no_treatment_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_discharge_to_sea_water_with_treatment">
                  <label for="usr">Water Discharge to Sea Water - With Treatment</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_discharge_to_sea_water_with_treatment_unit" placeholder="Unit" id="water_discharge_to_sea_water_with_treatment_unit" value="{{ isset($response['water_discharge_to_sea_water_with_treatment_unit']) ? $response['water_discharge_to_sea_water_with_treatment_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_discharge_to_sea_water_with_treatment']) ? json_decode($response['water_discharge_to_sea_water_with_treatment'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_sea_water_with_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_sea_water_with_treatment_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_sea_water_with_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_sea_water_with_treatment_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_discharge_to_thirdparty_water_no_treatment">
                  <label for="usr">Water Discharge to Third Party Water - No Treatment</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_no_treatment_unit" placeholder="Unit" id="water_discharge_to_thirdparty_water_no_treatment_unit" value="{{ isset($response['water_discharge_to_thirdparty_water_no_treatment_unit']) ? $response['water_discharge_to_thirdparty_water_no_treatment_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_discharge_to_thirdparty_water_no_treatment']) ? json_decode($response['water_discharge_to_thirdparty_water_no_treatment'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_no_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_thirdparty_water_no_treatment_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_no_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_thirdparty_water_no_treatment_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_discharge_to_thirdparty_water_with_treatment">
                  <label for="usr">Water Discharge to Third Party Water - With Treatment</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_with_treatment_unit" placeholder="Unit" id="water_discharge_to_thirdparty_water_with_treatment_unit" value="{{ isset($response['water_discharge_to_thirdparty_water_with_treatment_unit']) ? $response['water_discharge_to_thirdparty_water_with_treatment_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_discharge_to_thirdparty_water_with_treatment']) ? json_decode($response['water_discharge_to_thirdparty_water_with_treatment'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_with_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_thirdparty_water_with_treatment_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_thirdparty_water_with_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_thirdparty_water_with_treatment_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_discharge_to_other_water_no_treatment">
                  <label for="usr">Water Discharge to Other Water - No Treatment</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_discharge_to_other_water_no_treatment_unit" placeholder="Unit" id="water_discharge_to_other_water_no_treatment_unit" value="{{ isset($response['water_discharge_to_other_water_no_treatment_unit']) ? $response['water_discharge_to_other_water_no_treatment_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_discharge_to_other_water_no_treatment']) ? json_decode($response['water_discharge_to_other_water_no_treatment'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_other_water_no_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_other_water_no_treatment_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_other_water_no_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_other_water_no_treatment_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_discharge_to_other_water_with_treatment">
                  <label for="usr">Water Discharge to Other Water - With Treatment</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_discharge_to_other_water_with_treatment_unit" placeholder="Unit" id="water_discharge_to_other_water_with_treatment_unit" value="{{ isset($response['water_discharge_to_other_water_with_treatment_unit']) ? $response['water_discharge_to_other_water_with_treatment_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_discharge_to_other_water_with_treatment']) ? json_decode($response['water_discharge_to_other_water_with_treatment'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_other_water_with_treatment[<?php echo $count; ?>][year]" placeholder="Year" id="water_discharge_to_other_water_with_treatment_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_discharge_to_other_water_with_treatment[<?php echo $count; ?>][value]" placeholder="Value" id="water_discharge_to_other_water_with_treatment_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="total_water_discharged">
                  <label for="usr">Total Water Discharged</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_water_discharged_unit" placeholder="Unit" id="total_water_discharged_unit" value="{{ isset($response['total_water_discharged_unit']) ? $response['total_water_discharged_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_water_discharged']) ? json_decode($response['total_water_discharged'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_water_discharged[<?php echo $count; ?>][year]" placeholder="Year" id="total_water_discharged_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_water_discharged[<?php echo $count; ?>][value]" placeholder="Value" id="total_water_discharged_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_intensity_per_rupee_turnover">
                  <label for="usr">Water Intensity per Rupee of Turnover</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_intensity_per_rupee_turnover_unit" placeholder="Unit" id="water_intensity_per_rupee_turnover_unit" value="{{ isset($response['water_intensity_per_rupee_turnover_unit']) ? $response['water_intensity_per_rupee_turnover_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['water_intensity_per_rupee_turnover']) ? json_decode($response['water_intensity_per_rupee_turnover'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="water_intensity_per_rupee_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="water_intensity_per_rupee_turnover_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="water_intensity_per_rupee_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="water_intensity_per_rupee_turnover_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_intensity_per_rupee_ppp_turnover">
                  <label for="usr">Water Intensity per Rupee of Turnover (PPP Adjusted)</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_intensity_per_rupee_ppp_turnover_unit" placeholder="Unit" id="water_intensity_per_rupee_ppp_turnover_unit" value="{{ isset($response['water_intensity_per_rupee_ppp_turnover_unit']) ? $response['water_intensity_per_rupee_ppp_turnover_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_intensity_per_rupee_ppp_turnover']) ? json_decode($response['water_intensity_per_rupee_ppp_turnover'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_intensity_per_rupee_ppp_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="water_intensity_per_rupee_ppp_turnover_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_intensity_per_rupee_ppp_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="water_intensity_per_rupee_ppp_turnover_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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
                  <button type="button" class="btn add-row-btn" data-field="water_intensity_per_rupee_ppp_turnover">+</button>
               </div>

               <div class="incrementable-section" data-field="water_intensity_physical_output">
                  <label for="usr">Water Intensity in Terms of Physical Output</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_intensity_physical_output_unit" placeholder="Unit" id="water_intensity_physical_output_unit" value="{{ isset($response['water_intensity_physical_output_unit']) ? $response['water_intensity_physical_output_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_intensity_physical_output']) ? json_decode($response['water_intensity_physical_output'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_intensity_physical_output[<?php echo $count; ?>][year]" placeholder="Year" id="water_intensity_physical_output_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_intensity_physical_output[<?php echo $count; ?>][value]" placeholder="Value" id="water_intensity_physical_output_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="water_intensity">
                  <label for="usr">Water Intensity</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="water_intensity_unit" placeholder="Unit" id="water_intensity_unit" value="{{ isset($response['water_intensity_unit']) ? $response['water_intensity_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $waterDetail = isset($response['water_intensity']) ? json_decode($response['water_intensity'], true) : [];
                  echo "<ul>";
                  foreach ($waterDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_intensity[<?php echo $count; ?>][year]" placeholder="Year" id="water_intensity_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="water_intensity[<?php echo $count; ?>][value]" placeholder="Value" id="water_intensity_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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
                  <button type="button" class="btn add-row-btn" data-field="water_intensity">+</button>
               </div>

               <div class="incrementable-section" data-field="specific_water_consumption">
                  <label for="usr">Specific Water Consumption</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="specific_water_consumption_unit" placeholder="Unit" id="specific_water_consumption_unit" value="{{ isset($response['specific_water_consumption_unit']) ? $response['specific_water_consumption_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['specific_water_consumption']) ? json_decode($response['specific_water_consumption'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_water_consumption[<?php echo $count; ?>][year]" placeholder="Year" id="specific_water_consumption_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_water_consumption[<?php echo $count; ?>][value]" placeholder="Value" id="specific_water_consumption_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="specific_water_consumption">+</button>
               </div>
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

               <div class="incrementable-section" data-field="plastic_waste">
                  <label for="usr">Plastic Waste</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="plastic_waste_unit" placeholder="Unit" id="plastic_waste_unit" value="{{ isset($response['plastic_waste_unit']) ? $response['plastic_waste_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['plastic_waste']) ? json_decode($response['plastic_waste'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="plastic_waste[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="plastic_waste[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="e_waste">
                  <label for="usr">E-Waste</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="e_waste_unit" placeholder="Unit" id="e_waste_unit" value="{{ isset($response['e_waste_unit']) ? $response['e_waste_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['e_waste']) ? json_decode($response['e_waste'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="e_waste[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="e_waste[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="biological_waste">
                  <label for="usr">Biological Waste</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="biological_waste_unit" placeholder="Unit" id="biological_waste_unit" value="{{ isset($response['biological_waste_unit']) ? $response['biological_waste_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['biological_waste']) ? json_decode($response['biological_waste'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="biological_waste[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="biological_waste[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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
                  <button type="button" class="btn add-row-btn" data-field="biological_waste">+</button>
               </div>

               <div class="incrementable-section" data-field="construction_waste">
                  <label for="usr">Construction Waste</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="construction_waste_unit" placeholder="Unit" id="construction_waste_unit" value="{{ isset($response['construction_waste_unit']) ? $response['construction_waste_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['construction_waste']) ? json_decode($response['construction_waste'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="construction_waste[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="construction_waste[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="battery_waste">
                  <label for="usr">Battery Waste</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="battery_waste_unit" placeholder="Unit" id="battery_waste_unit" value="{{ isset($response['battery_waste_unit']) ? $response['battery_waste_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['battery_waste']) ? json_decode($response['battery_waste'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="battery_waste[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="battery_waste[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="radioactive_waste">
                  <label for="usr">Radioactive Waste</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="radioactive_waste_unit" placeholder="Unit" id="radioactive_waste_unit" value="{{ isset($response['radioactive_waste_unit']) ? $response['radioactive_waste_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['radioactive_waste']) ? json_decode($response['radioactive_waste'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="radioactive_waste[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="radioactive_waste[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="waste_intensity_ppp">
                  <label for="usr">Waste Intensity (PPP Adjusted)</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="waste_intensity_ppp_unit" placeholder="Unit" id="waste_intensity_ppp_unit" value="{{ isset($response['waste_intensity_ppp_unit']) ? $response['waste_intensity_ppp_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['waste_intensity_ppp']) ? json_decode($response['waste_intensity_ppp'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="waste_intensity_ppp[<?php echo $count; ?>][year]" placeholder="Year" id="waste_intensity_ppp_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="waste_intensity_ppp[<?php echo $count; ?>][value]" placeholder="Value" id="waste_intensity_ppp_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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
                  <button type="button" class="btn add-row-btn" data-field="waste_intensity_ppp">+</button>
               </div>

               <div class="incrementable-section" data-field="waste_intensity">
                  <label for="usr">Waste Intensity</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="waste_intensity_unit" placeholder="Unit" id="waste_intensity_unit" value="{{ isset($response['waste_intensity_unit']) ? $response['waste_intensity_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['waste_intensity']) ? json_decode($response['waste_intensity'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="waste_intensity[<?php echo $count; ?>][year]" placeholder="Year" id="waste_intensity_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="waste_intensity[<?php echo $count; ?>][value]" placeholder="Value" id="waste_intensity_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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
                  <button type="button" class="btn add-row-btn" data-field="waste_intensity">+</button>
               </div>

               <div class="incrementable-section" data-field="plastic_waste_recycled">
                  <label for="usr">Plastic Waste Recycled</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="plastic_waste_recycled_unit" placeholder="Unit" id="plastic_waste_recycled_unit" value="{{ isset($response['plastic_waste_recycled_unit']) ? $response['plastic_waste_recycled_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['plastic_waste_recycled']) ? json_decode($response['plastic_waste_recycled'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="plastic_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_recycled_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="plastic_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_recycled_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="plastic_waste_reused">
                  <label for="usr">Plastic Waste Reused</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="plastic_waste_reused_unit" placeholder="Unit" id="plastic_waste_reused_unit" value="{{ isset($response['plastic_waste_reused_unit']) ? $response['plastic_waste_reused_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['plastic_waste_reused']) ? json_decode($response['plastic_waste_reused'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="plastic_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_reused_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="plastic_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_reused_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="plastic_waste_other_recovery">
                  <label for="usr">Plastic Waste Other Recovery</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="plastic_waste_other_recovery_unit" placeholder="Unit" id="plastic_waste_other_recovery_unit" value="{{ isset($response['plastic_waste_other_recovery_unit']) ? $response['plastic_waste_other_recovery_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['plastic_waste_other_recovery']) ? json_decode($response['plastic_waste_other_recovery'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="plastic_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="plastic_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="e_waste_recycled">
                  <label for="usr">E-Waste Recycled</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="e_waste_recycled_unit" placeholder="Unit" id="e_waste_recycled_unit" value="{{ isset($response['e_waste_recycled_unit']) ? $response['e_waste_recycled_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['e_waste_recycled']) ? json_decode($response['e_waste_recycled'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="e_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_recycled_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="e_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_recycled_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="e_waste_reused">
                  <label for="usr">E-Waste Reused</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="e_waste_reused_unit" placeholder="Unit" id="e_waste_reused_unit" value="{{ isset($response['e_waste_reused_unit']) ? $response['e_waste_reused_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['e_waste_reused']) ? json_decode($response['e_waste_reused'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="e_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_reused_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="e_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_reused_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="e_waste_other_recovery">
                  <label for="usr">E-Waste Other Recovery</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="e_waste_other_recovery_unit" placeholder="Unit" id="e_waste_other_recovery_unit" value="{{ isset($response['e_waste_other_recovery_unit']) ? $response['e_waste_other_recovery_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['e_waste_other_recovery']) ? json_decode($response['e_waste_other_recovery'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="e_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="e_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="biological_waste_recycled">
                  <label for="usr">Biological Waste Recycled</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="biological_waste_recycled_unit" placeholder="Unit" id="biological_waste_recycled_unit" value="{{ isset($response['biological_waste_recycled_unit']) ? $response['biological_waste_recycled_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['biological_waste_recycled']) ? json_decode($response['biological_waste_recycled'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="biological_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_recycled_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="biological_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_recycled_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="biological_waste_reused">
                  <label for="usr">Biological Waste Reused</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="biological_waste_reused_unit" placeholder="Unit" id="biological_waste_reused_unit" value="{{ isset($response['biological_waste_reused_unit']) ? $response['biological_waste_reused_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['biological_waste_reused']) ? json_decode($response['biological_waste_reused'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="biological_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_reused_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="biological_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_reused_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="biological_waste_other_recovery">
                  <label for="usr">Biological Waste Other Recovery</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="biological_waste_other_recovery_unit" placeholder="Unit" id="biological_waste_other_recovery_unit" value="{{ isset($response['biological_waste_other_recovery_unit']) ? $response['biological_waste_other_recovery_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['biological_waste_other_recovery']) ? json_decode($response['biological_waste_other_recovery'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="biological_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="biological_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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
               <div class="incrementable-section" data-field="construction_waste_recycled">
                  <label for="usr">Construction Waste Recycled</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="construction_waste_recycled_unit" placeholder="Unit" id="construction_waste_recycled_unit" value="{{ isset($response['construction_waste_recycled_unit']) ? $response['construction_waste_recycled_unit'] : '' }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['construction_waste_recycled']) ? json_decode($response['construction_waste_recycled'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="construction_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_recycled_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="construction_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_recycled_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="construction_waste_reused">
                  <label for="usr">Construction Waste Reused</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="construction_waste_reused_unit" placeholder="Unit" id="construction_waste_reused_unit" value="{{ isset($response['construction_waste_reused_unit']) ? $response['construction_waste_reused_unit'] : '' }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['construction_waste_reused']) ? json_decode($response['construction_waste_reused'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="construction_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_reused_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="construction_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_reused_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="construction_waste_other_recovery">
                  <label for="usr">Construction Waste Other Recovery</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="construction_waste_other_recovery_unit" placeholder="Unit" id="construction_waste_other_recovery_unit" value="{{ isset($response['construction_waste_other_recovery_unit']) ? $response['construction_waste_other_recovery_unit'] : '' }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['construction_waste_other_recovery']) ? json_decode($response['construction_waste_other_recovery'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="construction_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="construction_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="battery_waste_recycled">
                  <label for="usr">Battery Waste Recycled</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="battery_waste_recycled_unit" placeholder="Unit" id="battery_waste_recycled_unit" value="{{ isset($response['battery_waste_recycled_unit']) ? $response['battery_waste_recycled_unit'] : '' }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['battery_waste_recycled']) ? json_decode($response['battery_waste_recycled'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="battery_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_recycled_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="battery_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_recycled_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="battery_waste_reused">
                  <label for="usr">Battery Waste Reused</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="battery_waste_reused_unit" placeholder="Unit" id="battery_waste_reused_unit" value="{{ isset($response['battery_waste_reused_unit']) ? $response['battery_waste_reused_unit'] : '' }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['battery_waste_reused']) ? json_decode($response['battery_waste_reused'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="battery_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_reused_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="battery_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_reused_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="battery_waste_other_recovery">
                  <label for="usr">Battery Waste Other Recovery</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="battery_waste_other_recovery_unit" placeholder="Unit" id="battery_waste_other_recovery_unit" value="{{ isset($response['battery_waste_other_recovery_unit']) ? $response['battery_waste_other_recovery_unit'] : '' }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['battery_waste_other_recovery']) ? json_decode($response['battery_waste_other_recovery'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="battery_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="battery_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="radioactive_waste_recycled">
                  <label for="usr">Radioactive Waste Recycled</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="radioactive_waste_recycled_unit" placeholder="Unit" id="radioactive_waste_recycled_unit" value="{{ isset($response['radioactive_waste_recycled_unit']) ? $response['radioactive_waste_recycled_unit'] : '' }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['radioactive_waste_recycled']) ? json_decode($response['radioactive_waste_recycled'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="radioactive_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_recycled_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="radioactive_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_recycled_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="radioactive_waste_reused">
                  <label for="usr">Radioactive Waste Reused</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="radioactive_waste_reused_unit" placeholder="Unit" id="radioactive_waste_reused_unit" value="{{ isset($response['radioactive_waste_reused_unit']) ? $response['radioactive_waste_reused_unit'] : '' }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['radioactive_waste_reused']) ? json_decode($response['radioactive_waste_reused'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="radioactive_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_reused_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="radioactive_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_reused_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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
               <div class="incrementable-section" data-field="radioactive_waste_other_recovery">
                  <label for="usr">Radioactive Waste Other Recovery</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="radioactive_waste_other_recovery_unit" placeholder="Unit" id="radioactive_waste_other_recovery_unit" value="{{ isset($response['radioactive_waste_other_recovery_unit']) ? $response['radioactive_waste_other_recovery_unit'] : '' }}">
                  </div>
                  <?php 
                  $count = 0;
                  $wasteDetail = isset($response['radioactive_waste_other_recovery']) ? json_decode($response['radioactive_waste_other_recovery'], true) : [];
                  echo "<ul>";
                  foreach ($wasteDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="radioactive_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                           </div>
                           <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="radioactive_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="hazardous_waste_recycled">
                  <label for="usr">Hazardous Waste Recycled</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="hazardous_waste_recycled_unit" placeholder="Unit" id="hazardous_waste_recycled_unit" value="{{ isset($response['hazardous_waste_recycled_unit']) ? $response['hazardous_waste_recycled_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['hazardous_waste_recycled']) ? json_decode($response['hazardous_waste_recycled'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_recycled_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_recycled_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="hazardous_waste_reused">
                  <label for="usr">Hazardous Waste Reused</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="hazardous_waste_reused_unit" placeholder="Unit" id="hazardous_waste_reused_unit" value="{{ isset($response['hazardous_waste_reused_unit']) ? $response['hazardous_waste_reused_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['hazardous_waste_reused']) ? json_decode($response['hazardous_waste_reused'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_reused_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_reused_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="hazardous_waste_other_recovery">
                  <label for="usr">Hazardous Waste Other Recovery</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="hazardous_waste_other_recovery_unit" placeholder="Unit" id="hazardous_waste_other_recovery_unit" value="{{ isset($response['hazardous_waste_other_recovery_unit']) ? $response['hazardous_waste_other_recovery_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['hazardous_waste_other_recovery']) ? json_decode($response['hazardous_waste_other_recovery'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="non_hazardous_waste_recycled">
                  <label for="usr">Non-Hazardous Waste Recycled</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="non_hazardous_waste_recycled_unit" placeholder="Unit" id="non_hazardous_waste_recycled_unit" value="{{ isset($response['non_hazardous_waste_recycled_unit']) ? $response['non_hazardous_waste_recycled_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['non_hazardous_waste_recycled']) ? json_decode($response['non_hazardous_waste_recycled'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_recycled[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_recycled_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_recycled[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_recycled_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="non_hazardous_waste_reused">
                  <label for="usr">Non-Hazardous Waste Reused</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="non_hazardous_waste_reused_unit" placeholder="Unit" id="non_hazardous_waste_reused_unit" value="{{ isset($response['non_hazardous_waste_reused_unit']) ? $response['non_hazardous_waste_reused_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['non_hazardous_waste_reused']) ? json_decode($response['non_hazardous_waste_reused'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_reused[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_reused_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_reused[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_reused_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="non_hazardous_waste_other_recovery">
                  <label for="usr">Non-Hazardous Waste Other Recovery</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="non_hazardous_waste_other_recovery_unit" placeholder="Unit" id="non_hazardous_waste_other_recovery_unit" value="{{ isset($response['non_hazardous_waste_other_recovery_unit']) ? $response['non_hazardous_waste_other_recovery_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['non_hazardous_waste_other_recovery']) ? json_decode($response['non_hazardous_waste_other_recovery'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_other_recovery[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_other_recovery_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_other_recovery[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_other_recovery_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="plastic_waste_incineration">
                  <label for="usr">Plastic Waste Incineration</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="plastic_waste_incineration_unit" placeholder="Unit" id="plastic_waste_incineration_unit" value="{{ isset($response['plastic_waste_incineration_unit']) ? $response['plastic_waste_incineration_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['plastic_waste_incineration']) ? json_decode($response['plastic_waste_incineration'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="plastic_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_incineration_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="plastic_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_incineration_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="plastic_waste_landfilling">
                  <label for="usr">Plastic Waste Landfilling</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="plastic_waste_landfilling_unit" placeholder="Unit" id="plastic_waste_landfilling_unit" value="{{ isset($response['plastic_waste_landfilling_unit']) ? $response['plastic_waste_landfilling_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['plastic_waste_landfilling']) ? json_decode($response['plastic_waste_landfilling'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="plastic_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="plastic_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="plastic_waste_other_disposal">
                  <label for="usr">Plastic Waste Other Disposal</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="plastic_waste_other_disposal_unit" placeholder="Unit" id="plastic_waste_other_disposal_unit" value="{{ isset($response['plastic_waste_other_disposal_unit']) ? $response['plastic_waste_other_disposal_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['plastic_waste_other_disposal']) ? json_decode($response['plastic_waste_other_disposal'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="plastic_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="plastic_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="plastic_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="plastic_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="e_waste_incineration">
                  <label for="usr">E-Waste Incineration</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="e_waste_incineration_unit" placeholder="Unit" id="e_waste_incineration_unit" value="{{ isset($response['e_waste_incineration_unit']) ? $response['e_waste_incineration_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['e_waste_incineration']) ? json_decode($response['e_waste_incineration'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="e_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_incineration_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="e_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_incineration_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="e_waste_landfilling">
                  <label for="usr">E-Waste Landfilling</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="e_waste_landfilling_unit" placeholder="Unit" id="e_waste_landfilling_unit" value="{{ isset($response['e_waste_landfilling_unit']) ? $response['e_waste_landfilling_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['e_waste_landfilling']) ? json_decode($response['e_waste_landfilling'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="e_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="e_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="e_waste_other_disposal">
                  <label for="usr">E-Waste Other Disposal</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="e_waste_other_disposal_unit" placeholder="Unit" id="e_waste_other_disposal_unit" value="{{ isset($response['e_waste_other_disposal_unit']) ? $response['e_waste_other_disposal_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['e_waste_other_disposal']) ? json_decode($response['e_waste_other_disposal'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="e_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="e_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="e_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="e_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="biological_waste_incineration">
                  <label for="usr">Biological Waste Incineration</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="biological_waste_incineration_unit" placeholder="Unit" id="biological_waste_incineration_unit" value="{{ isset($response['biological_waste_incineration_unit']) ? $response['biological_waste_incineration_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['biological_waste_incineration']) ? json_decode($response['biological_waste_incineration'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="biological_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_incineration_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="biological_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_incineration_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="biological_waste_landfilling">
                  <label for="usr">Biological Waste Landfilling</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="biological_waste_landfilling_unit" placeholder="Unit" id="biological_waste_landfilling_unit" value="{{ isset($response['biological_waste_landfilling_unit']) ? $response['biological_waste_landfilling_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['biological_waste_landfilling']) ? json_decode($response['biological_waste_landfilling'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="biological_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="biological_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="biological_waste_other_disposal">
                  <label for="usr">Biological Waste Other Disposal</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="biological_waste_other_disposal_unit" placeholder="Unit" id="biological_waste_other_disposal_unit" value="{{ isset($response['biological_waste_other_disposal_unit']) ? $response['biological_waste_other_disposal_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['biological_waste_other_disposal']) ? json_decode($response['biological_waste_other_disposal'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="biological_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="biological_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="biological_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="biological_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="construction_waste_incineration">
                  <label for="usr">Construction Waste Incineration</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="construction_waste_incineration_unit" placeholder="Unit" id="construction_waste_incineration_unit" value="{{ isset($response['construction_waste_incineration_unit']) ? $response['construction_waste_incineration_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['construction_waste_incineration']) ? json_decode($response['construction_waste_incineration'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="construction_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_incineration_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="construction_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_incineration_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="construction_waste_landfilling">
                  <label for="usr">Construction Waste Landfilling</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="construction_waste_landfilling_unit" placeholder="Unit" id="construction_waste_landfilling_unit" value="{{ isset($response['construction_waste_landfilling_unit']) ? $response['construction_waste_landfilling_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['construction_waste_landfilling']) ? json_decode($response['construction_waste_landfilling'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="construction_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="construction_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="construction_waste_other_disposal">
                  <label for="usr">Construction Waste Other Disposal</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="construction_waste_other_disposal_unit" placeholder="Unit" id="construction_waste_other_disposal_unit" value="{{ isset($response['construction_waste_other_disposal_unit']) ? $response['construction_waste_other_disposal_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['construction_waste_other_disposal']) ? json_decode($response['construction_waste_other_disposal'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="construction_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="construction_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="construction_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="construction_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="battery_waste_incineration">
                  <label for="usr">Battery Waste Incineration</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="battery_waste_incineration_unit" placeholder="Unit" id="battery_waste_incineration_unit" value="{{ isset($response['battery_waste_incineration_unit']) ? $response['battery_waste_incineration_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['battery_waste_incineration']) ? json_decode($response['battery_waste_incineration'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="battery_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_incineration_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="battery_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_incineration_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="battery_waste_landfilling">
                  <label for="usr">Battery Waste Landfilling</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="battery_waste_landfilling_unit" placeholder="Unit" id="battery_waste_landfilling_unit" value="{{ isset($response['battery_waste_landfilling_unit']) ? $response['battery_waste_landfilling_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['battery_waste_landfilling']) ? json_decode($response['battery_waste_landfilling'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="battery_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="battery_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="battery_waste_other_disposal">
                  <label for="usr">Battery Waste Other Disposal</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="battery_waste_other_disposal_unit" placeholder="Unit" id="battery_waste_other_disposal_unit" value="{{ isset($response['battery_waste_other_disposal_unit']) ? $response['battery_waste_other_disposal_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['battery_waste_other_disposal']) ? json_decode($response['battery_waste_other_disposal'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="battery_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="battery_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="battery_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="battery_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="radioactive_waste_incineration">
                  <label for="usr">Radioactive Waste Incineration</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="radioactive_waste_incineration_unit" placeholder="Unit" id="radioactive_waste_incineration_unit" value="{{ isset($response['radioactive_waste_incineration_unit']) ? $response['radioactive_waste_incineration_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['radioactive_waste_incineration']) ? json_decode($response['radioactive_waste_incineration'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="radioactive_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_incineration_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="radioactive_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_incineration_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="radioactive_waste_landfilling">
                  <label for="usr">Radioactive Waste Landfilling</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="radioactive_waste_landfilling_unit" placeholder="Unit" id="radioactive_waste_landfilling_unit" value="{{ isset($response['radioactive_waste_landfilling_unit']) ? $response['radioactive_waste_landfilling_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['radioactive_waste_landfilling']) ? json_decode($response['radioactive_waste_landfilling'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="radioactive_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="radioactive_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="radioactive_waste_other_disposal">
                  <label for="usr">Radioactive Waste Other Disposal</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="radioactive_waste_other_disposal_unit" placeholder="Unit" id="radioactive_waste_other_disposal_unit" value="{{ isset($response['radioactive_waste_other_disposal_unit']) ? $response['radioactive_waste_other_disposal_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['radioactive_waste_other_disposal']) ? json_decode($response['radioactive_waste_other_disposal'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="radioactive_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="radioactive_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="radioactive_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="radioactive_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="hazardous_waste_incineration">
                  <label for="usr">Hazardous Waste Incineration</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="hazardous_waste_incineration_unit" placeholder="Unit" id="hazardous_waste_incineration_unit" value="{{ isset($response['hazardous_waste_incineration_unit']) ? $response['hazardous_waste_incineration_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['hazardous_waste_incineration']) ? json_decode($response['hazardous_waste_incineration'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_incineration_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_incineration_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="hazardous_waste_landfilling">
                  <label for="usr">Hazardous Waste Landfilling</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="hazardous_waste_landfilling_unit" placeholder="Unit" id="hazardous_waste_landfilling_unit" value="{{ isset($response['hazardous_waste_landfilling_unit']) ? $response['hazardous_waste_landfilling_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['hazardous_waste_landfilling']) ? json_decode($response['hazardous_waste_landfilling'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="hazardous_waste_other_disposal">
                  <label for="usr">Hazardous Waste Other Disposal</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="hazardous_waste_other_disposal_unit" placeholder="Unit" id="hazardous_waste_other_disposal_unit" value="{{ isset($response['hazardous_waste_other_disposal_unit']) ? $response['hazardous_waste_other_disposal_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['hazardous_waste_other_disposal']) ? json_decode($response['hazardous_waste_other_disposal'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="hazardous_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="non_hazardous_waste_incineration">
                  <label for="usr">Non-Hazardous Waste Incineration</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="non_hazardous_waste_incineration_unit" placeholder="Unit" id="non_hazardous_waste_incineration_unit" value="{{ isset($response['non_hazardous_waste_incineration_unit']) ? $response['non_hazardous_waste_incineration_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['non_hazardous_waste_incineration']) ? json_decode($response['non_hazardous_waste_incineration'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_incineration[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_incineration_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_incineration[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_incineration_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="non_hazardous_waste_landfilling">
                  <label for="usr">Non-Hazardous Waste Landfilling</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="non_hazardous_waste_landfilling_unit" placeholder="Unit" id="non_hazardous_waste_landfilling_unit" value="{{ isset($response['non_hazardous_waste_landfilling_unit']) ? $response['non_hazardous_waste_landfilling_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['non_hazardous_waste_landfilling']) ? json_decode($response['non_hazardous_waste_landfilling'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_landfilling[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_landfilling_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_landfilling[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_landfilling_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="non_hazardous_waste_other_disposal">
                  <label for="usr">Non-Hazardous Waste Other Disposal</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="non_hazardous_waste_other_disposal_unit" placeholder="Unit" id="non_hazardous_waste_other_disposal_unit" value="{{ isset($response['non_hazardous_waste_other_disposal_unit']) ? $response['non_hazardous_waste_other_disposal_unit'] : '' }}">
                  </div>
                  <ul>
                     <?php 
                     $count = 0;
                     $wasteDetail = isset($response['non_hazardous_waste_other_disposal']) ? json_decode($response['non_hazardous_waste_other_disposal'], true) : [];
                     foreach ($wasteDetail as $year => $value) { ?>
                           <li class="d-flex gap-2">
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_other_disposal[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_other_disposal_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                              </div>
                              <div class="form-group col-md-5">
                                 <input type="text" class="form-control" name="non_hazardous_waste_other_disposal[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_other_disposal_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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




               <div class="incrementable-section" data-field="hazardous_waste">
                  <label for="usr">Hazardous Waste</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="hazardous_waste_unit" placeholder="Unit" id="hazardous_waste_unit" value="{{ isset($response['hazardous_waste_unit']) ? $response['hazardous_waste_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['hazardous_waste']) ? json_decode($response['hazardous_waste'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="hazardous_waste[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_waste_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="hazardous_waste[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_waste_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="non_hazardous_waste">
                  <label for="usr">Non-Hazardous Waste</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="non_hazardous_waste_unit" placeholder="Unit" id="non_hazardous_waste_unit" value="{{ isset($response['non_hazardous_waste_unit']) ? $response['non_hazardous_waste_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['non_hazardous_waste']) ? json_decode($response['non_hazardous_waste'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="non_hazardous_waste[<?php echo $count; ?>][year]" placeholder="Year" id="non_hazardous_waste_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="non_hazardous_waste[<?php echo $count; ?>][value]" placeholder="Value" id="non_hazardous_waste_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="waste_by_type">
                  <label for="usr">Waste by Type</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="waste_by_type_unit" placeholder="Unit" id="waste_by_type_unit" value="{{ isset($response['waste_by_type_unit']) ? $response['waste_by_type_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['waste_by_type']) ? json_decode($response['waste_by_type'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="waste_by_type[<?php echo $count; ?>][year]" placeholder="Year" id="waste_by_type_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="waste_by_type[<?php echo $count; ?>][value]" placeholder="Value" id="waste_by_type_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="waste_by_type">+</button>
               </div>

               <div class="incrementable-section" data-field="waste_by_disposal_method">
                  <label for="usr">Waste by Disposal Method</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="waste_by_disposal_method_unit" placeholder="Unit" id="waste_by_disposal_method_unit" value="{{ isset($response['waste_by_disposal_method_unit']) ? $response['waste_by_disposal_method_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['waste_by_disposal_method']) ? json_decode($response['waste_by_disposal_method'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="waste_by_disposal_method[<?php echo $count; ?>][year]" placeholder="Year" id="waste_by_disposal_method_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="waste_by_disposal_method[<?php echo $count; ?>][value]" placeholder="Value" id="waste_by_disposal_method_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="waste_by_disposal_method">+</button>
               </div>

               <div class="incrementable-section" data-field="waste_intensity_per_rupee_turnover">
                  <label for="usr">Waste Intensity per Rupee of Turnover</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="waste_intensity_per_rupee_turnover_unit" placeholder="Unit" id="waste_intensity_per_rupee_turnover_unit" value="{{ isset($response['waste_intensity_per_rupee_turnover_unit']) ? $response['waste_intensity_per_rupee_turnover_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['waste_intensity_per_rupee_turnover']) ? json_decode($response['waste_intensity_per_rupee_turnover'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="waste_intensity_per_rupee_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="waste_intensity_per_rupee_turnover_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="waste_intensity_per_rupee_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="waste_intensity_per_rupee_turnover_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="waste_intensity_physical_output">
                  <label for="usr">Waste Intensity in Terms of Physical Output</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="waste_intensity_physical_output_unit" placeholder="Unit" id="waste_intensity_physical_output_unit" value="{{ isset($response['waste_intensity_physical_output_unit']) ? $response['waste_intensity_physical_output_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['waste_intensity_physical_output']) ? json_decode($response['waste_intensity_physical_output'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="waste_intensity_physical_output[<?php echo $count; ?>][year]" placeholder="Year" id="waste_intensity_physical_output_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="waste_intensity_physical_output[<?php echo $count; ?>][value]" placeholder="Value" id="waste_intensity_physical_output_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="scope_1_emissions">
                  <label for="usr">Scope 1 Emissions</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="scope_1_emissions_unit" placeholder="Unit" id="scope_1_emissions_unit" value="{{ isset($response['scope_1_emissions_unit']) ? $response['scope_1_emissions_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['scope_1_emissions']) ? json_decode($response['scope_1_emissions'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="scope_1_emissions[<?php echo $count; ?>][year]" placeholder="Year" id="scope_1_emissions_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="scope_1_emissions[<?php echo $count; ?>][value]" placeholder="Value" id="scope_1_emissions_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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
                  <label for="usr">Scope 2 Emissions</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="scope_2_emissions_unit" placeholder="Unit" id="scope_2_emissions_unit" value="{{ isset($response['scope_2_emissions_unit']) ? $response['scope_2_emissions_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['scope_2_emissions']) ? json_decode($response['scope_2_emissions'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="scope_2_emissions[<?php echo $count; ?>][year]" placeholder="Year" id="scope_2_emissions_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="scope_2_emissions[<?php echo $count; ?>][value]" placeholder="Value" id="scope_2_emissions_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="specific_emissions_scope_1_2_intensity_ppp">
                  <label for="usr">Specific Emissions-Scope 1 and 2 Intensity PPP</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="specific_emissions_scope_1_2_intensity_ppp_unit" placeholder="Unit" id="specific_emissions_scope_1_2_intensity_ppp_unit" value="{{ isset($response['specific_emissions_scope_1_2_intensity_ppp_unit']) ? $response['specific_emissions_scope_1_2_intensity_ppp_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['specific_emissions_scope_1_2_intensity_ppp']) ? json_decode($response['specific_emissions_scope_1_2_intensity_ppp'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_emissions_scope_1_2_intensity_ppp[<?php echo $count; ?>][year]" placeholder="Year" id="specific_emissions_scope_1_2_intensity_ppp_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_emissions_scope_1_2_intensity_ppp[<?php echo $count; ?>][value]" placeholder="Value" id="specific_emissions_scope_1_2_intensity_ppp_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>"; ?>
                  <button type="button" class="btn add-row-btn" data-field="specific_emissions_scope_1_2_intensity_ppp">+</button>
               </div>

               <!-- Specific Emissions Scope 1 and 2 Intensity Physical Output -->
               <div class="incrementable-section" data-field="specific_emissions_scope_1_2_intensity_physical_output">
                  <label for="usr">Specific Emissions-Scope 1 and 2 Intensity Physical Output</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="specific_emissions_scope_1_2_intensity_physical_output_unit" placeholder="Unit" id="specific_emissions_scope_1_2_intensity_physical_output_unit" value="{{ isset($response['specific_emissions_scope_1_2_intensity_physical_output_unit']) ? $response['specific_emissions_scope_1_2_intensity_physical_output_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['specific_emissions_scope_1_2_intensity_physical_output']) ? json_decode($response['specific_emissions_scope_1_2_intensity_physical_output'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_emissions_scope_1_2_intensity_physical_output[<?php echo $count; ?>][year]" placeholder="Year" id="specific_emissions_scope_1_2_intensity_physical_output_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_emissions_scope_1_2_intensity_physical_output[<?php echo $count; ?>][value]" placeholder="Value" id="specific_emissions_scope_1_2_intensity_physical_output_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <!-- Specific Emissions Scope 3 per Rupee Turnover -->
               <div class="incrementable-section" data-field="specific_emissions_scope_3_per_rupee_turnover">
                  <label for="usr">Specific Emissions-Scope 3 per Rs Turnover</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="specific_emissions_scope_3_per_rupee_turnover_unit" placeholder="Unit" id="specific_emissions_scope_3_per_rupee_turnover_unit" value="{{ isset($response['specific_emissions_scope_3_per_rupee_turnover_unit']) ? $response['specific_emissions_scope_3_per_rupee_turnover_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['specific_emissions_scope_3_per_rupee_turnover']) ? json_decode($response['specific_emissions_scope_3_per_rupee_turnover'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_emissions_scope_3_per_rupee_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="specific_emissions_scope_3_per_rupee_turnover_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_emissions_scope_3_per_rupee_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="specific_emissions_scope_3_per_rupee_turnover_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <!-- Total Scope 3 Emission Intensity -->
               <div class="incrementable-section" data-field="total_scope_3_emission_intensity">
                  <label for="usr">Total Scope 3 Emission Intensity</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_scope_3_emission_intensity_unit" placeholder="Unit" id="total_scope_3_emission_intensity_unit" value="{{ isset($response['total_scope_3_emission_intensity_unit']) ? $response['total_scope_3_emission_intensity_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_scope_3_emission_intensity']) ? json_decode($response['total_scope_3_emission_intensity'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_scope_3_emission_intensity[<?php echo $count; ?>][year]" placeholder="Year" id="total_scope_3_emission_intensity_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_scope_3_emission_intensity[<?php echo $count; ?>][value]" placeholder="Value" id="total_scope_3_emission_intensity_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <!-- NOx Emissions -->
               <div class="incrementable-section" data-field="no_x">
                  <label for="usr">NOx Emissions</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="no_x_unit" placeholder="Unit" id="no_x_unit" value="{{ isset($response['no_x_unit']) ? $response['no_x_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['no_x']) ? json_decode($response['no_x'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="no_x[<?php echo $count; ?>][year]" placeholder="Year" id="no_x_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="no_x[<?php echo $count; ?>][value]" placeholder="Value" id="no_x_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <!-- SOx Emissions -->
               <div class="incrementable-section" data-field="so_x">
                  <label for="usr">SOx Emissions</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="so_x_unit" placeholder="Unit" id="so_x_unit" value="{{ isset($response['so_x_unit']) ? $response['so_x_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['so_x']) ? json_decode($response['so_x'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="so_x[<?php echo $count; ?>][year]" placeholder="Year" id="so_x_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="so_x[<?php echo $count; ?>][value]" placeholder="Value" id="so_x_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <!-- Particulate Matter -->
               <div class="incrementable-section" data-field="particular_matter">
                  <label for="usr">Particulate Matter</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="particular_matter_unit" placeholder="Unit" id="particular_matter_unit" value="{{ isset($response['particular_matter_unit']) ? $response['particular_matter_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['particular_matter']) ? json_decode($response['particular_matter'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="particular_matter[<?php echo $count; ?>][year]" placeholder="Year" id="particular_matter_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="particular_matter[<?php echo $count; ?>][value]" placeholder="Value" id="particular_matter_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>"; ?>
                  <button type="button" class="btn add-row-btn" data-field="particular_matter">+</button>
               </div>

               <!-- POP (Persistent Organic Pollutants) -->
               <div class="incrementable-section" data-field="pop">
                  <label for="usr">Persistent Organic Pollutants (POP)</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="pop_unit" placeholder="Unit" id="pop_unit" value="{{ isset($response['pop_unit']) ? $response['pop_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['pop']) ? json_decode($response['pop'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="pop[<?php echo $count; ?>][year]" placeholder="Year" id="pop_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="pop[<?php echo $count; ?>][value]" placeholder="Value" id="pop_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <!-- VOC (Volatile Organic Compounds) -->
               <div class="incrementable-section" data-field="voc">
                  <label for="usr">Volatile Organic Compounds (VOC)</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="voc_unit" placeholder="Unit" id="voc_unit" value="{{ isset($response['voc_unit']) ? $response['voc_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['voc']) ? json_decode($response['voc'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="voc[<?php echo $count; ?>][year]" placeholder="Year" id="voc_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="voc[<?php echo $count; ?>][value]" placeholder="Value" id="voc_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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


               <div class="incrementable-section" data-field="scope_3_emissions">
                  <label for="usr">Scope 3 Emissions</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="scope_3_emissions_unit" placeholder="Unit" id="scope_3_emissions_unit" value="{{ isset($response['scope_3_emissions_unit']) ? $response['scope_3_emissions_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['scope_3_emissions']) ? json_decode($response['scope_3_emissions'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="scope_3_emissions[<?php echo $count; ?>][year]" placeholder="Year" id="scope_3_emissions_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="scope_3_emissions[<?php echo $count; ?>][value]" placeholder="Value" id="scope_3_emissions_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="total_scope_1_2_emission_intensity">
                  <label for="usr">Total Scope 1 and Scope 2 Emission Intensity</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="total_scope_1_2_emission_intensity_unit" placeholder="Unit" id="total_scope_1_2_emission_intensity_unit" value="{{ isset($response['total_scope_1_2_emission_intensity_unit']) ? $response['total_scope_1_2_emission_intensity_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['total_scope_1_2_emission_intensity']) ? json_decode($response['total_scope_1_2_emission_intensity'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_scope_1_2_emission_intensity[<?php echo $count; ?>][year]" placeholder="Year" id="total_scope_1_2_emission_intensity_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="total_scope_1_2_emission_intensity[<?php echo $count; ?>][value]" placeholder="Value" id="total_scope_1_2_emission_intensity_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="total_scope_1_2_emission_intensity">+</button>
               </div>

               <div class="incrementable-section" data-field="specific_emissions_scope_1_2_per_rupee_turnover">
                  <label for="usr">Specific Emissions-Scope 1 and Scope 2 per Rs Turnover</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="specific_emissions_scope_1_2_per_rupee_turnover_unit" placeholder="Unit" id="specific_emissions_scope_1_2_per_rupee_turnover_unit" value="{{ isset($response['specific_emissions_scope_1_2_per_rupee_turnover_unit']) ? $response['specific_emissions_scope_1_2_per_rupee_turnover_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['specific_emissions_scope_1_2_per_rupee_turnover']) ? json_decode($response['specific_emissions_scope_1_2_per_rupee_turnover'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_emissions_scope_1_2_per_rupee_turnover[<?php echo $count; ?>][year]" placeholder="Year" id="specific_emissions_scope_1_2_per_rupee_turnover_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="specific_emissions_scope_1_2_per_rupee_turnover[<?php echo $count; ?>][value]" placeholder="Value" id="specific_emissions_scope_1_2_per_rupee_turnover_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="air_pollutants">
                  <label for="usr">Air Pollutants</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="air_pollutants_unit" placeholder="Unit" id="air_pollutants_unit" value="{{ isset($response['air_pollutants_unit']) ? $response['air_pollutants_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['air_pollutants']) ? json_decode($response['air_pollutants'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="air_pollutants[<?php echo $count; ?>][year]" placeholder="Year" id="air_pollutants_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="air_pollutants[<?php echo $count; ?>][value]" placeholder="Value" id="air_pollutants_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
                        </div>
                        <div class="form-group col-md-2">
                           <button type="button" class="btn remove-row-btn" data-index="<?php echo $count; ?>">-</button>
                        </div>
                     </li>
                  <?php 
                     $count++; 
                  } 
                  echo "</ul>";?>
                  <button type="button" class="btn add-row-btn" data-field="air_pollutants">+</button>
               </div>

               <div class="incrementable-section" data-field="hazardous_air_pollutants">
                  <label for="usr">Hazardous Air Pollutants</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="hazardous_air_pollutants_unit" placeholder="Unit" id="hazardous_air_pollutants_unit" value="{{ isset($response['hazardous_air_pollutants_unit']) ? $response['hazardous_air_pollutants_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['hazardous_air_pollutants']) ? json_decode($response['hazardous_air_pollutants'], true): [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="hazardous_air_pollutants[<?php echo $count; ?>][year]" placeholder="Year" id="hazardous_air_pollutants_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="hazardous_air_pollutants[<?php echo $count; ?>][value]" placeholder="Value" id="hazardous_air_pollutants_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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

               <div class="incrementable-section" data-field="csr_budget">
                  <label for="usr">CSR Budget</label>
                  <div class="form-group col-md-5">
                     <input type="text" class="form-control" name="csr_budget_unit" placeholder="Unit" id="csr_budget_unit" value="{{ isset($response['csr_budget_unit']) ? $response['csr_budget_unit'] : "" }}">
                  </div>
                  <?php 
                  $count = 0;
                  $energyDetail = isset($response['csr_budget']) ? json_decode($response['csr_budget'], true) : [];
                  echo "<ul>";
                  foreach ($energyDetail as $year => $value) { ?>
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="csr_budget[<?php echo $count; ?>][year]" placeholder="Year" id="csr_budget_<?php echo $count; ?>_year" value="<?php echo htmlspecialchars(trim($year, '[]')); ?>">
                        </div>
                        <div class="form-group col-md-5">
                           <input type="text" class="form-control" name="csr_budget[<?php echo $count; ?>][value]" placeholder="Value" id="csr_budget_<?php echo $count; ?>_value" value="<?php echo htmlspecialchars($value); ?>">
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
                  <textarea name="product_stewardship" id="product_stewardship" rows="5" class="form-control" placeholder="Product Stewardship">{{ isset($response['product_stewardship']) ? $response['product_stewardship'] : "" }}</textarea>
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
         // Add row functionality
         $('.add-row-btn').on('click', function() {
            var field = $(this).data('field');
            var container = $(this).prev('ul');
            var lastIndex = container.find('li').length > 0 ? parseInt(container.find('li:last .remove-row-btn').data('index')) : -1;
            var newIndex = lastIndex + 1;

            var newRow;
            if (field === 'factory_locations') {
                  // Single input for factory_locations
                  newRow = `
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-10">
                              <input type="text" class="form-control" name="${field}[${newIndex}]" placeholder="Location" id="${field}_${newIndex}">
                        </div>
                        <div class="form-group col-md-2">
                              <button type="button" class="btn remove-row-btn" data-index="${newIndex}">-</button>
                        </div>
                     </li>
                  `;
            } else {
                  // Existing year/value pair logic for other fields
                  newRow = `
                     <li class="d-flex gap-2">
                        <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="${field}[${newIndex}][year]" placeholder="Year" id="${field}_${newIndex}_year">
                        </div>
                        <div class="form-group col-md-5">
                              <input type="text" class="form-control" name="${field}[${newIndex}][value]" placeholder="Value" id="${field}_${newIndex}_value">
                        </div>
                        <div class="form-group col-md-2">
                              <button type="button" class="btn remove-row-btn" data-index="${newIndex}">-</button>
                        </div>
                     </li>
                  `;
            }
            container.append(newRow);
         });

         // Remove row functionality
         $(document).on('click', '.remove-row-btn', function() {
            var index = $(this).data('index');
            var field = $(this).closest('.incrementable-section').data('field');
            $(this).closest('li').remove();

            // Reindex the remaining rows
            var container = $(this).closest('ul');
            container.find('li').each(function(i) {
                  if (field === 'factory_locations') {
                     // Reindex for single input
                     $(this).find('input[name="' + field + '[' + index + ']"]').attr({
                        name: field + '[' + i + ']',
                        id: field + '_' + i
                     });
                  } else {
                     // Reindex for year/value pairs
                     $(this).find('input[name="' + field + '[' + index + '][year]"]').attr({
                        name: field + '[' + i + '][year]',
                        id: field + '_' + i + '_year'
                     });
                     $(this).find('input[name="' + field + '[' + index + '][value]"]').attr({
                        name: field + '[' + i + '][value]',
                        id: field + '_' + i + '_value'
                     });
                  }
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
         },
         error: function(e) {
               console.error("AJAX Error:", e); // Debug: Log any AJAX errors
               alert("Error fetching industry and segment data");
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