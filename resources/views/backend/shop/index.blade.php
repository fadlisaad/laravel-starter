@extends('backend.layouts.app')

@section('title')
Pending Approval Shop Listing
@endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon=''>Pending Approval Shop Listing</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class=""></i> Pending Approval Shop <small class="text-muted">List</small>
                </h4>
                <div class="small text-muted">
                    @lang(":module_name Management Dashboard", ['module_name'=>Str::title('Shop')])
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="float-right">
                    <div class="btn-group" role="group" aria-label="Toolbar button groups">
                        <a class="btn btn-sm btn-primary mt-1" href="{{ route("backend.store.pending") }}" data-toggle="tooltip" title="Fetch latest data"><i class="fas fa-wrench"></i> Refresh
                        </a>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">
                <table id="datatable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Shop Name</th>
                            <th>Person in charge</th>
                            <th>Email</th>
                            <th>Phone No.</th>
                            <th>Status</th>
                            <th class="text-right">{{ __('labels.backend.action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push ('after-styles')
<!-- DataTables Core and Extensions -->
<link rel="stylesheet" href="{{ asset('vendor/datatable/datatables.min.css') }}">

@endpush

@push ('after-scripts')
<!-- DataTables Core and Extensions -->
<script type="text/javascript" src="{{ asset('vendor/datatable/datatables.min.js') }}"></script>

<script type="text/javascript">

    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: true,
        responsive: true,
        ajax: '{{ route("backend.store.index_data") }}',
        columns: [
            {data: 'store_name', name: 'store_name'},
            {data: 'person_in_charge', name: 'person_in_charge'},
            {data: 'email', name: 'email'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

</script>
@endpush
