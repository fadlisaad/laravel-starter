@extends('backend.layouts.app')

@section('title')
Product Details
@endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.store.index")}}'>
        Shop
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">Product Details</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class=""></i> Product <small class="text-muted">Details</small>
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
                        {{ $product['title'] }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                @foreach($product['detail_list'] as $detail)
                                    @if($detail['key'] == 'main_pic')
                                    @php $image = $detail['value'] @endphp
                                    @endif
                                @endforeach
                                <img src="http://culick.com/fm/download?user_name={{ env('API_USERNAME_2') }}&token={{ env('API_PASSWORD') }}&uuid={{ $image }}" class="img-fluid img-thumbnail">
                            </div>
                            <div class="col-3">
                                <dl>
                                    <dt>Price (RM)</dt>
                                    <dd>{!! $product['price'] !!}</dd>
                                    <dt>Sale Price (RM)</dt>
                                    <dd>{!! $product['sale_price'] !!}</dd>
                                    <dt>Status</dt>
                                    <dd>{!! status_label($product['enabled']) !!}</dd>
                                    <dt>Wish List</dt>
                                    <dd>{!! $product['wish_count'] !!}</dd>
                                    <dt>Hashtag</dt>
                                    <dd>
                                        @php
                                            $tag1 = explode(' ',$product['upward_hashtag']);
                                        @endphp
                                        @foreach($tag1 as $tag)
                                            <span class="badge badge-secondary">#{{ $tag }}</span>
                                        @endforeach
                                    </dd>
                                    <dt>Relation Hashtag</dt>
                                    <dd>
                                        @php
                                            $tag2 = explode(' ',$product['downward_hashtag']);
                                        @endphp
                                        @foreach($tag2 as $tag)
                                            <span class="badge badge-primary">#{{ $tag }}</span>
                                        @endforeach
                                    </dd>
                                    <dt>Rating</dt>
                                    <dd>
                                        @php $rating = $product['rate']; @endphp  
                                        <div class="placeholder" style="color: lightgray;">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <span>({{ $rating }})</span>
                                        </div>

                                        <div class="text-warning" style="position: relative;top: -22px;">
                                            
                                            @while($rating>0)
                                                @if($rating >0.5)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="fas fa-star-half"></i>
                                                @endif
                                                @php $rating--; @endphp
                                            @endwhile

                                        </div>
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-6">
                                <h5>Details</h5>
                                <table class="table">
                                    <thead>
                                        <th>Name</th>
                                        <th>Value</th>
                                    </thead>
                                    <tbody>
                                        @foreach($product['detail_list'] as $detail)
                                        <tr>
                                            <td>{!! label_case($detail['key']) !!}</td>
                                            <td>{!! $detail['value'] !!}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" onclick="window.history.back()" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Rating
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if($review)
                                @php
                                    $max_rating = 0;
                                    $n = count($review);
                                @endphp
                                @foreach($review as $rate => $count)
                                    @php
                                    $max_rating = $max_rating + $count['rate'];
                                    @endphp
                                @endforeach
                                <?php $rate = $max_rating/$n; ?>
                                @else
                                <?php $rate = 0; ?>
                                @endif
                                <button class="rating_circle">{{ $rate }}</button>
                            </div>
                            <div class="col-md-7">
                                <div class="progress mt-3" style="height:10px">
                                   <div class="progress-bar bg-gradient-success" style="width:70%;height:10px"></div>
                                </div>
                                <div class="progress mt-3" style="height:10px">
                                    <div class="progress-bar bg-gradient-success" style="width:10%;height:10px"></div>
                                </div>
                                <div class="progress mt-3" style="height:10px">
                                    <div class="progress-bar bg-gradient-success" style="width:10%;height:10px"></div>
                                </div>
                                <div class="progress mt-3" style="height:10px">
                                    <div class="progress-bar bg-gradient-success" style="width:5%;height:10px"></div>
                                </div>
                                <div class="progress mt-3" style="height:10px">
                                    <div class="progress-bar bg-gradient-success" style="width:5%;height:10px"></div>
                                </div>                
                            </div>
                            <div class="col-md-1">
                                <div class="row">
                                    <h6 class="rating_text">5</h6>
                                </div>
                                <div class="row">
                                    <h6 class="">4</h6>
                                </div>
                                <div class="row">
                                    <h6 class="">3</h6>
                                </div>
                                <div class="row">
                                    <h6 class="">2</h6>
                                </div>
                                <div class="row">
                                    <h6 class="">1</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        Review
                    </div>
                    <div class="card-body">
                        @if($review)
                        <div class="card p-3 mb-2">
                            @foreach($review as $data)
                            @php
                                $user_data = [
                                    "user_name" => env('API_USERNAME_2'),
                                    "token" => env('API_PASSWORD'),
                                    "user_uuid" => $data['user_uuid']
                                ];

                                $response_user = Illuminate\Support\Facades\Http::get(env('API_URL').'user/get_public_info', [
                                    'data' => json_encode($user_data)
                                ]);
                            @endphp
                            <div class="d-flex flex-row"> <img src="http://culick.com/fm/download?user_name={{ env('API_USERNAME_2') }}&token={{ env('API_PASSWORD') }}&uuid={{ $response_user['image_uuid'] }}" width="60px" height="60px" class="rounded-circle img-thumbnail">
                                <div class="d-flex flex-column ms-2">
                                    <h6 class="mb-1 text-primary">{{ $response_user['name'] }}</h6>
                                    <p class="comment-text">{{ $data['comment'] }}</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="d-flex flex-row gap-3 align-items-center">
                                    <div class="d-flex align-items-center"> <i class="fas fas-heart-o"></i> <span class="ms-1 fs-10">Rating {{ $data['rate'] }}</span> </div>
                                </div>
                                <div class="d-flex flex-row"> <span class="text-muted fw-normal fs-10">{{ Carbon\Carbon::parse($data['date_time'])->diffForHumans() }}</span> </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        No review yet
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-styles')
<style type="text/css">
    .rating_circle{
    width: 100px;
    height: 100px;
    border-radius: 70px;
    border: 1px none;
    font-size: 35px;
  }
  .rating_text{
      margin-top: 38px;
  }
  .stars-outer {
  display: inline-block;
  position: relative;
  font-family: FontAwesome;
  font-size: 20px;
  letter-spacing: 5px;
}
</style>
@endpush