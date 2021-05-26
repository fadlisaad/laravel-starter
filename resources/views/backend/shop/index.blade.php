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

                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4">
            <div class="col">
                <table class="table table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>Shop Name</th>
                            <th>Owner</th>
                            <th>E-mail</th>
                            <th>Phone No.</th>
                            <th>Status</th>
                            <th class="text-right">{{ __('labels.backend.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shop as $data)
                        <tr>
                            <td>{{ $data['store_name'] }}</td>
                            <td>{{ $data['person_in_charge'] }}</td>
                            <td>{{ $data['email'] }}</td>
                            <td>{{ $data['phone_number'] }}</td>
                            <td>{!! status_label($data['status']) !!}</td>
                            <td>View</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">

        </div>
    </div>
</div>
@endsection
