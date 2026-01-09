@extends('layouts.app')
@section('content')
<!-- page content -->
<!-- top tiles -->
<div class="container">
   <div class="card mt-4">
      <div class="card-header">All Responsible Corporates</div>
      <div class="card-body">
         <div class="row clear">
            <div class="col-lg-12">
               <div class="d-flex justify-content-end mb-2">
                  <a href="{{ route('responsible-corp-add') }}" class='btn btn-primary action-btn'>Add</a>
               </div>
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
                        @if ($corporates->count() == 0)
                           <tr>
                              <td colspan="8">No records to display.</td>
                           </tr>
                        @endif
                        @if(isset($corporates))
                           @foreach($corporates as $key => $corporate)
                              <tr>
                                 <td>{{ $key + 1 }}</td>
                                 <td>{{ $corporate->name ?? '' }}</td>
                                 <td>{{ $corporate->short_name ?? '' }}</td>
                                 <td>{{ $corporate->enteredBy ? $corporate->enteredBy->name : 'N/A' }}</td>
                                 <td>
                                    @if($corporate->approval == 0)
                                       <span>Pending</span>
                                    @elseif($corporate->approval == 1)
                                       Approved
                                    @elseif($corporate->approval == 2)
                                       <span>Rejected</span>
                                    @elseif($corporate->approval == 3)
                                       Reviewed
                                    @endif
                                 </td>
                                 <td>{{ $corporate->created_at ? date('d M Y', strtotime($corporate->created_at)) : '' }}</td>
                                 <td>{{ $corporate->updated_at ? date('d M Y', strtotime($corporate->updated_at)) : '' }}</td>
                                 <td>
                                    <a href="{{ route('responsible-corp-update', [$corporate->id, 'page' => request()->query('page', '')]) }}" class='btn btn-success action-btn'>Edit</a>
                                    @if(auth()->user()->is_admin == 1)
                                    
                                    <a href="{{ route('responsible-corp-delete',$corporate->id) }}" class='btn btn-danger'>Delete</a>
                                    @endif
                                    @if(auth()->user()->is_admin == 1)
                                       @if($corporate->approval == 2)
                                          <a href="{{ route('listing_statusupdateres', [$corporate->id, 1, 'page' => request()->query('page', '')]) }}" class='btn btn-success'>Approve</a>
                                       @elseif($corporate->approval == 3)
                                          <a href="{{ route('listing_statusupdateres', [$corporate->id, 1, 'page' => request()->query('page', '')]) }}" class='btn btn-success'>Approve</a>
                                          <a href="{{ route('listing_statusupdateres', [$corporate->id, 2, 'page' => request()->query('page', '')]) }}" class='btn btn-danger'>Reject</a>
                                       @elseif($corporate->approval == 0)
                                          <a href="{{ route('listing_statusupdateres', [$corporate->id, 3, 'page' => request()->query('page', '')]) }}" class='btn btn-success'>Review</a>
                                       @elseif($corporate->approval == 1)
                                          {{-- <a href="{{ route('listing_statusupdateres', [$corporate->id, 2, 'page' => request()->query('page', '')]) }}" class='btn btn-danger'>Reject</a> --}}
                                       @endif
                                    @endif
                                 </td>
                              </tr>
                           @endforeach
                        @endif
                     </tbody>
                  </table>
                  {{-- {!! $corporates->appends(request()->except('page'))->links() !!} --}}
                  {{-- <p>
                     Displaying {{ $corporates->count() }} of {{ $corporates->total() }} listing(s).
                  </p> --}}
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