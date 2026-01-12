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
                           <th>Push Status</th>
                           <th>Created at</th>
                           <th>Updated at</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if ($corporates->count() == 0)
                           <tr>
                              <td colspan="9">No records to display.</td>
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
                                       <span class="badge bg-warning">Pending</span>
                                    @elseif($corporate->approval == 1)
                                       <span class="badge bg-success">Approved</span>
                                    @elseif($corporate->approval == 2)
                                       <span class="badge bg-danger">Rejected</span>
                                    @elseif($corporate->approval == 3)
                                       <span class="badge bg-info">Reviewed</span>
                                    @endif
                                 </td>
                                 <td>
                                    <div style="min-width: 150px;">
                                       @if($corporate->pushed_to_uat)
                                          <div class="mb-1">
                                             <span class="badge bg-success">✓ UAT</span>
                                             <small class="d-block text-muted" style="font-size: 0.7rem;">
                                                {{ $corporate->uat_push_date ??  '' }}
                                             </small>
                                          </div>
                                       @endif
                                       @if($corporate->pushed_to_production)
                                          <div>
                                             <span class="badge bg-success">✓ Production</span>
                                             <small class="d-block text-muted" style="font-size: 0.7rem;">
                                                {{ $corporate->production_push_date ?? '' }}
                                             </small>
                                          </div>
                                       @endif
                                       @if(!$corporate->pushed_to_uat && !$corporate->pushed_to_production)
                                          <span class="badge bg-secondary">Not Pushed</span>
                                       @endif
                                    </div>
                                 </td>
                                 <td>{{ $corporate->created_at ? date('d M Y', strtotime($corporate->created_at)) : '' }}</td>
                                 <td>{{ $corporate->updated_at ? date('d M Y', strtotime($corporate->updated_at)) : '' }}</td>
                                 <td>
                                    <div class="d-flex flex-wrap gap-1">
                                       <a href="{{ route('responsible-corp-update', [$corporate->id, 'page' => request()->query('page', '')]) }}" 
                                          class='btn btn-sm btn-success'>Edit</a>
                                       
                                       @if(auth()->user()->is_admin == 1)
                                          <a href="{{ route('responsible-corp-delete', $corporate->id) }}"
                                             class="btn btn-sm btn-danger"
                                             onclick="return confirm('Are you sure you want to delete this record?')">
                                             Delete
                                          </a>
                                       @endif

                                       @if(auth()->user()->is_admin == 1)
                                          @if($corporate->approval == 2)
                                             <button type="button" class="btn btn-sm btn-success" 
                                                onclick="showApprovalModal({{ $corporate->id }}, 1, '{{ request()->query('page', '') }}')">
                                                Approve
                                             </button>
                                          @elseif($corporate->approval == 3)
                                             <button type="button" class="btn btn-sm btn-success" 
                                                onclick="showApprovalModal({{ $corporate->id }}, 1, '{{ request()->query('page', '') }}')">
                                                Approve
                                             </button>
                                             <a href="{{ route('listing_statusupdateres', [$corporate->id, 2, 'page' => request()->query('page', '')]) }}" 
                                                class='btn btn-sm btn-danger'>Reject</a>
                                          @elseif($corporate->approval == 0)
                                             <a href="{{ route('listing_statusupdateres', [$corporate->id, 3, 'page' => request()->query('page', '')]) }}" 
                                                class='btn btn-sm btn-info'>Review</a>
                                          @elseif($corporate->approval == 1)
                                             <!-- Already approved - show push options -->
                                             <button type="button" class="btn btn-sm btn-primary" 
                                                onclick="showPushModal({{ $corporate->id }}, '{{ request()->query('page', '') }}')">
                                                Push to API
                                             </button>
                                          @endif
                                       @endif
                                    </div>
                                 </td>
                              </tr>
                           @endforeach
                        @endif
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="approvalModalLabel">Approve and Push Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form id="approvalForm" method="GET">
            <div class="modal-body">
               <p>Select the site where you want to push this data:</p>
               <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="api_push_site" id="pushToUat" value="uat" checked>
                  <label class="form-check-label" for="pushToUat">
                     UAT (uat.envesya.com)
                  </label>
               </div>
               <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="api_push_site" id="pushToProduction" value="production">
                  <label class="form-check-label" for="pushToProduction">
                     Production (envesya.com)
                  </label>
               </div>
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="api_push_site" id="noPush" value="">
                  <label class="form-check-label" for="noPush">
                     Don't push to any site (only approve)
                  </label>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-success">Approve</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Push Modal (for already approved records) -->
<div class="modal fade" id="pushModal" tabindex="-1" aria-labelledby="pushModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="pushModalLabel">Push Data to API</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form id="pushForm" method="GET">
            <div class="modal-body">
               <p>Select the site where you want to push this data:</p>
               <div class="form-check mb-2">
                  <input class="form-check-input" type="radio" name="api_push_site" id="pushToUat2" value="uat" checked>
                  <label class="form-check-label" for="pushToUat2">
                     UAT (uat.envesya.com)
                  </label>
               </div>
               <div class="form-check">
                  <input class="form-check-input" type="radio" name="api_push_site" id="pushToProduction2" value="production">
                  <label class="form-check-label" for="pushToProduction2">
                     Production (envesya.com)
                  </label>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-primary">Push Data</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script type="text/javascript">
   var urlParams = new URLSearchParams(window.location.search);
   var param_x = urlParams.get('page');
   if(param_x){
      $('html,body').animate({
         scrollTop: $(document).height()
      });
   }

   function showApprovalModal(corporateId, status, page) {
      var form = document.getElementById('approvalForm');
      form.action = "{{ url('responsible-corp/listing_statusupdateres') }}/" + corporateId + "/" + status + "?page=" + page;
      
      var modal = new bootstrap.Modal(document.getElementById('approvalModal'));
      modal.show();
   }

   function showPushModal(corporateId, page) {
      var form = document.getElementById('pushForm');
      form.action = "{{ url('responsible-corp/manual-push') }}/" + corporateId + "?page=" + page;
      
      var modal = new bootstrap.Modal(document.getElementById('pushModal'));
      modal.show();
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
@endsection
@section('styles')
@parent
<style>
   .gap-1 {
      gap: 0.25rem;
   }
</style>
@endsection