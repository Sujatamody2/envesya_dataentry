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
         <form action="<?php echo route('responsible-corp-updating', $response['id']); ?>" page="<?php echo (isset($response)) ? 'edit' : 'add'; ?>" method="post" class="form-horizontal">
            <input type="hidden" name="listing_id" value="<?php echo (isset($response['id']) && $response['id']) ? $response['id'] : ''; ?>">
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
                  <select name="industry[]" class="chzn-select form-control" data-placeholder="Choose Industries..." id="ind_cls">
                     <option>1</option>
                     <option>2</option>
                     <option>3</option>
                     <option>4</option>
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

               <div class="form-group">
                  <label for="usr">Factory Locations</label>
                  <input type="text" class="form-control" name="factory_locations" value="{{(isset($response['factory_locations']) && $response['factory_locations'] != '') ? $response['factory_locations'] : ''}}" placeholder="Location" id="factory_locations">
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

               <div class="incrementable-section" data-field="total_non_renewable_energy_consumption">
                  <label for="usr">Total Non Renewable Energy Consumption</label>
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

               <div class="incrementable-section" data-field="specific_energy_consumption">
                  <label for="usr">Specific Energy Consumption</label>
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

               <div class="incrementable-section" data-field="water_replenishment_percentage">
                  <label for="usr">Water Replenishment % of Consumption</label>
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

               <div class="incrementable-section" data-field="total_water_discharged">
                  <label for="usr">Total Water Discharged</label>
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

               <div class="incrementable-section" data-field="specific_water_consumption">
                  <label for="usr">Specific Water Consumption</label>
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

               <div class="incrementable-section" data-field="hazardous_waste">
                  <label for="usr">Hazardous Waste</label>
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

               <div class="incrementable-section" data-field="scope_3_emissions">
                  <label for="usr">Scope 3 Emissions</label>
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
      $('.add-row-btn').on('click', function() {
         var field = $(this).data('field');
         var container = $(this).prev('ul');
         var lastIndex = container.find('li').length > 0 ? parseInt(container.find('li:last .remove-row-btn').data('index')) : -1;
         var newIndex = lastIndex + 1;

         var newRow = `
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
</script>

@endsection
@section('scripts')
@parent
@endsection
@section('styles')
@parent
@endsection