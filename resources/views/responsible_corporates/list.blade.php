@extends('layouts.app')
@section('content')
<!-- page content -->
<!-- top tiles -->
<?php //echo "<pre>"; print_r($category);die; ?>
<!-- category form section -->

<div class="container">
   <div class="card mt-4">
      <div class="card-header">All Responsible Corporates</div>
      <div class="card-body">
         <div class="row clear">
            <div class="col-lg-12">
               <div class="table-responsive">
                  <table id="" class="table table-striped table-bordered category-tbl freelist_tbl">
                     <thead>
                        <tr>
                           <th>S.No</th>
                           <th>Legal Name</th>
                           <th>Short Name</th>
                           <th>Entered By</th>
                           <th>Status</th>
                           <th>Created at</th>
                           <th>Updated at</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if ($response->count() == 0)
                           <tr>
                              <td colspan="8">No records to display.</td>
                           </tr>
                        @endif
                        @if(isset($response))
                           @foreach($response as $key=>$value)
                              @php
                                 $value_showcase = json_decode($value->showcase,true);
                              @endphp
                              <tr>
                                 <td>{{ $key+1 }}</td>
                                 <td>{{ isset($value->name) ? $value->name : '' }}</td>
                                 <td>{{ isset($value->short_name) ? $value->short_name : '' }}</td>
                                 <td>{{ $value->enteredByUser ? $value->enteredByUser->name : 'N/A' }}</td>
                                 <td>
                                    @if($value->approval==0)
                                    <span>Pending</span>
                                    @elseif($value->approval==1)
                                       Approved
                                    @elseif($value->approval==2)
                                       <span>Rejected</span>
                                    @elseif($value->approval==3)
                                       Reviewed
                                    @endif
                                 </td>
                                 <td>{{isset($value->created_at) ? date('d M Y', strtotime($value->created_at)): '' }}</td>
                                 <td>{{isset($value->updated_at) ? date('d M Y', strtotime($value->updated_at)): '' }}</td>
                                 <td>
                                    <a href="{{ route('responsible-corp-update',[$value->id,'page='.(isset($_GET['page']) && $_GET['page']!='' ? $_GET['page'] :'')]) }}" class='btn btn-success action-btn'>Edit</a>
                                    <a href="{{ route('responsible-corp-delete',[$value->id,'page='.(isset($_GET['page']) && $_GET['page']!='' ? $_GET['page'] :'')]) }}" class='btn btn-danger'>delete</a>
                                    @if(auth()->user()->is_admin == 1)
                                       @if($value->approval==2 )
                                       <a href="{{ route('listing_statusupdateres',[$value->id,1,'page='.(isset($_GET['page']) && $_GET['page']!='' ? $_GET['page'] :'')]) }}" class='btn btn-success'>Approve</a>
                                       @elseif($value->approval==3)
                                       <a href="{{ route('listing_statusupdateres',[$value->id,1,'page='.(isset($_GET['page']) && $_GET['page']!='' ? $_GET['page'] :'')]) }}" class='btn btn-success'>Approve</a>
                                       <a href="{{ route('listing_statusupdateres',[$value->id,2,'page='.(isset($_GET['page']) && $_GET['page']!='' ? $_GET['page'] :'')]) }}" class='btn btn-danger'>Reject</a>
                                       @elseif($value->approval==0)
                                       <a href="{{ route('listing_statusupdateres',[$value->id,3,'page='.(isset($_GET['page']) && $_GET['page']!='' ? $_GET['page'] :'')]) }}" class='btn btn-success'>Review</a>
                                       @elseif($value->approval==1)
                                       <a href="{{ route('listing_statusupdateres',[$value->id,2,'page='.(isset($_GET['page']) && $_GET['page']!='' ? $_GET['page'] :'')]) }}" class='btn btn-danger'>Reject</a>
                                       @endif
                                    @endif
                                 </td>
                              </tr>
                           @endforeach
                        @endif
                     </tbody>
                  </table>
                  {!! $response->appends(Request::except('page'))->render() !!}

                  <p>
                     Displaying {{$response->count()}} of {{ $response->total() }} listing(s).
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /top tiles -->
<script type="text/javascript">
   var urlParams = new URLSearchParams(window.location.search);
   var param_x = urlParams.get('page');
   if(param_x){
      $('html,body').animate({
         scrollTop: $(document).height()
      });
   }
</script>
<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
<script type="text/javascript">
   CKEDITOR.replace('category_description', {
       skin: 'moono',
       enterMode: CKEDITOR.ENTER_BR,
       shiftEnterMode: CKEDITOR.ENTER_P,
       toolbar: [
           { name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
           { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
           { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
           { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
           { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
           { name: 'links', items: [ 'Link', 'Unlink' ] },
           { name: 'insert', items: [ 'Image'] },
           { name: 'spell', items: [ 'jQuerySpellChecker' ] },
           { name: 'table', items: [ 'Table' ] }
       ],
   });
</script>
@endsection
@section('scripts')
@parent
{{-- {{ Html::script(mix('assets/admin/js/dashboard.js')) }} --}}
@endsection
@section('styles')
@parent
{{-- {{ Html::style(mix('assets/admin/css/dashboard.css')) }} --}}
@endsection