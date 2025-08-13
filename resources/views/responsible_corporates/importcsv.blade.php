@extends('admin.layouts.admin')
@section('content')
<!-- page content -->
<!-- top tiles -->
<?php //echo "<pre>"; print_r($event);die; ?>
<!-- event form section -->
<!-- $showcase_arr=["Materials","Producers","Services","Financiers","Innovator","Organization","Resources","Epr","Projects"]; -->
 @php
      $showcase_arr=["Producers","Services","Financiers","Innovators","Epr","Projects"];
      if(isset($response)){
      $show_json_arr =  json_decode($response['showcase'],true);
      }
  @endphp
<div class="main-content">
   <div class="row">
      <div class="col-lg-12">
         <div class="PageTitle"><h2>Import Responsible Corporates</h2></div>
      </div>
   </div>

  <div class="row clear">
     <div class="col-lg-12">
         <div class="Inner-container">
            
            {{ Form::open(['route'=>['admin.save-responsible-corp-import'],'method' => 'post','class'=>'form-horizontal form-label-left','files'=>true]) }}
                <div class="form-group">
                    <label for="image">Import CSV</label>
                    <input type="file" class="form-control" name="importcsv" placeholder="" > 
                </div>
                <div class="form-group ">
                    <button type="submit" class="btn Theme-Btn" id="save-from">Submit</button>
                </div>
            {{ Form::close() }}
        </div>
     </div>
  </div>
</div>
<!-- /top tiles -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" /> -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->


<script src="{{url('/assets/admin/js')}}/editor.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<link href="{{url('/assets/admin/css')}}/editor.css" type="text/css" rel="stylesheet"/>
@endsection
@section('scripts')
@parent
{{ Html::script(mix('assets/admin/js/dashboard.js')) }}
@endsection
@section('styles')
@parent
{{ Html::style(mix('assets/admin/css/dashboard.css')) }}
@endsection