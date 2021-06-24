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

        <div class="row mt-2">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-cube"></i>
                        Sales Details for {{ $shop->store_name }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-sm table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <strong>
                                                Date
                                            </strong>
                                        </th>
                                        <th scope="col">
                                            <strong>
                                                Amount (RM)
                                            </strong>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($sales)
                                    @foreach ($sales['res_list'] as $value)
                                    <tr>
                                        <td>
                                            {{ $value['date'] }}
                                        </td>
                                        <td>
                                            {{ $value['daily_sells'] }}
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <strong>Total</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $sales['total_sells'] }}</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    @else
                                    <tr>
                                        <td colspan="2">
                                            <strong>No sales data available</strong>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="alert alert-info">Note: Data is correct as of today</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-cube"></i>
                        Shop Details
                    </div>
                    <div class="card-body">
                        <dl>
                        @foreach ($shop->getAttributes() as $key => $value)
                            <dt>{{ label_case($key) }}</dt>
                            <dd>{!! $value !!}</dd>
                        @endforeach
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-cube"></i>
                        Product List
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive-sm table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <strong>
                                                #
                                            </strong>
                                        </th>
                                        <th scope="col">
                                            <strong>
                                                Name
                                            </strong>
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($products)
                                @php $i=1; @endphp
                                @foreach ($products['res_list'] as $product)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{!! $product['title'] !!}</td>
                                    <td>
                                        <a href="{{ route('backend.product.show',$product['uuid']) }}" class="btn btn-primary btn-sm">View</a></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3">No product list</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection