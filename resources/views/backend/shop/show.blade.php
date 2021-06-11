@extends('backend.layouts.app')

@section('title')
Shop Details
@endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.store.index")}}' icon='fa fa-home'>
        Shop
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">Shop Details</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class=""></i> Shop <small class="text-muted">Details</small>
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
                <div class="table-responsive">
                    <table class="table table-responsive-sm table-hover table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <strong>
                                        Name
                                    </strong>
                                </th>
                                <th scope="col">
                                    <strong>
                                        Value
                                    </strong>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shop->getAttributes() as $key => $value)
                            <tr>
                                <td>
                                    <strong>
                                        {{ label_case($key) }}
                                    </strong>
                                </td>
                                <td>
                                    {!! $value !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection