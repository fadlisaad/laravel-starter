@extends('backend.layouts.app')

@section('title')
Shop Sales
@endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon=''>Shop Sales</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class=""></i> Shop <small class="text-muted">Sales</small>
                </h4>
                <div class="small text-muted">
                    @lang(":module_name Management Dashboard", ['module_name'=>Str::title('Shop')])
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="float-right">
                    <div class="btn-group" role="group" aria-label="Toolbar button groups">
                        <a class="btn btn-sm btn-primary mt-1" href="#" data-toggle="tooltip" title="Fetch latest data"><i class="fas fa-wrench"></i> Refresh
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
                            <th>ID</th>
                            <th>Shop Name</th>
                            <th>Date</th>
                            <th>Daily Sales (RM)</th>
                            <th>Total Sales (RM)</th>
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
        ajax: '{{ route("backend.store.index_sales_data") }}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'shop_name', name: 'shop_name'},
            {data: 'date', name: 'date'},
            {data: 'daily_sales', name: 'daily_sales'},
            {data: 'total_sales', name: 'total_sales'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order: [[ 0, "desc" ]]
    });

</script>
@endpush
