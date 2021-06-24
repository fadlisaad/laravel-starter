<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Shop;
use App\Models\Sale;
use Log;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function index()
    {
        return view("backend.shop.index");
    }

    public function index_data()
    {
        $shop = Shop::orderBy('id', 'desc')->get();
        return Datatables::of($shop)
            ->addColumn('action', function ($data) {
                return view('backend.includes.shop_actions', compact('data'));
            })
            ->editColumn('status', function ($data) {
                $return_data = status_label($data->status);
                return $return_data;
            })
            ->escapeColumns('status')
            ->editColumn('request_time', function ($data) {
                $return_data = $data->request_time->diffForHumans();
                return $return_data;
            })
            ->make(true);
    }

    public function index_sales()
    {
        return view("backend.shop.index-sales");
    }

    public function index_sales_data()
    {
        $sales = Sale::all();
  
        return Datatables::of($sales)
            ->editColumn('shop_name', function ($data) {
                return $data->shop->store_name;
            })
            ->editColumn('daily_sales', function ($data) {
                return number_format($data->sales_amount,2);
            })
            ->editColumn('total_sales', function ($data) {
                return number_format($data->sales_amount,2);
            })
            ->editColumn('date', function ($data) {
                return $data->sales_date;
            })
            ->addColumn('action', function ($data) {
                return view('backend.includes.shop_sales_actions', compact('data'));
            })
            ->make(true);
    }

    public function show($id)
    {
        $shop = Shop::find($id);
        $sales = $this->sales($id);
        $products = $this->product_list($id);
        return view("backend.shop.show", compact('shop', 'sales', 'products'));
    }

    public function enabled()
    {
        $data = [
            "user_name" => env('API_USERNAME'),
            "token" => env('API_PASSWORD'),
            "offset" => 0,
            "page_size" => 30,
            "requested_field" => "*",
            "filter" => [
                "status" => "1"
            ]
        ];

        $response = Http::get(env('API_URL').'store_reg/get_queue_list', [
            'data' => json_encode($data)
        ]);

        if($response['result'] == 'ok')
        {

            foreach ($response['res_list'] as $value) {

                Shop::firstOrCreate([
                    "store_name" => $value['store_name'],
                    "lng" => $value['lng'],
                    "lat" => $value['lat'],
                    "address" => $value['address'],
                    "phone_number" => $value['phone_number'],
                    "email" => $value['email'],
                    "description" => $value['description'],
                    "person_in_charge" => $value['person_in_charge'],
                    "status" => $value['status'],
                    "request_time" => $value['request_time'],
                    "response_time" => $value['response_time'],
                    "category_uuid" => $value['category_uuid'],
                    "creator_user_uuid" => $value['creator_user_uuid'],
                    "store_uuid" => $value['store_uuid']
                ]);

                Log::info('Shop'. $value['store_name'].' stored in database.');
            };

            flash('<i class="fas fa-check"></i> Latest enabled shop has been retrieved')->success();
        } else {
            flash('<i class="fas fa-ban"></i> Failed to retrieve enabled shop data')->error();
        }
        return redirect()->back();
    }

    public function pending()
    {
        $data = [
            "user_name" => env('API_USERNAME'),
            "token" => env('API_PASSWORD'),
            "offset" => 0,
            "page_size" => 30,
            "requested_field" => "*",
            "filter" => [
                "status" => "0"
            ]
        ];

        $response = Http::get(env('API_URL').'store_reg/get_queue_list', [
            'data' => json_encode($data)
        ]);

        if($response['result'] == 'ok')
        {

            foreach ($response['res_list'] as $value) {

                Shop::firstOrCreate([
                    "store_name" => $value['store_name'],
                    "lng" => $value['lng'],
                    "lat" => $value['lat'],
                    "address" => $value['address'],
                    "phone_number" => $value['phone_number'],
                    "email" => $value['email'],
                    "description" => $value['description'],
                    "person_in_charge" => $value['person_in_charge'],
                    "status" => $value['status'],
                    "request_time" => $value['request_time'],
                    "response_time" => $value['response_time'],
                    "category_uuid" => $value['category_uuid'],
                    "creator_user_uuid" => $value['creator_user_uuid'],
                    "store_uuid" => $value['store_uuid']
                ]);

                Log::info('Shop'. $value['store_name'].' stored in database.');
            };

            flash('<i class="fas fa-check"></i> Latest pending shop has been retrieved')->success();
        } else {
            flash('<i class="fas fa-ban"></i> Failed to retrieve latest pending shop data. API error response: '.$response['error_desc'])->error();
        }
        return redirect()->back();
    }

    public function approve($id)
    {
        $shop = Shop::find($id);

        $data = [
            "user_name" => env('API_USERNAME'),
            "token" => env('API_PASSWORD'),
            "creator_user_uuid" => $shop->creator_user_uuid,
            "currency" => 'MYR',
            "requested_field" => "*",
            "detail" => [
                [
                    "key" => "address",
                    "order" => 1,
                    "value" => $shop->address
                ],
                [
                    "key" => "phone_number",
                    "order" => 2,
                    "value" => $shop->phone_number
                ],
                [
                    "key" => "email",
                    "order" => 3,
                    "value" => $shop->email
                ],
                [
                    "key" => "description",
                    "order" => 4,
                    "value" => $shop->description
                ],
                [
                    "key" => "person_in_charge",
                    "order" => 5,
                    "value" => $shop->person_in_charge
                ],
            ]
        ];

        $response = Http::get(env('API_URL').'store_reg/accept_last_request', [
            'data' => json_encode($data)
        ]);
        
        $shop->status = 1;
        $shop->update();

        Log::info('Shop '. $shop->store_name.' approved.');

        if($response['result'] == 'ok')
        {
            $flash = 'Shop '. $shop->store_name.' has been approved.';

        } else {
            $flash = $response['error_desc'];
        }

        flash('<i class="fas fa-check"></i> '.$flash)->success();
        return redirect()->back();
    }

    public function reject($id)
    {
        $shop = Shop::find($id);

        $data = [
            "user_name" => env('API_USERNAME'),
            "token" => env('API_PASSWORD'),
            "creator_user_uuid" => $shop->creator_user_uuid
        ];

        $response = Http::get(env('API_URL').'store_reg/reject_last_request', [
            'data' => json_encode($data)
        ]);
        
        $shop->status = 2;
        $shop->update();

        Log::info('Shop '. $shop->store_name.' rejected.');

        if($response['result'] == 'ok')
        {
            $flash = 'Shop '. $shop->store_name.' has been rejected.';

        } else {
            $flash = $response['error_desc'];
        }

        flash('<i class="fas fa-check"></i> '.$flash)->success();
        return redirect()->back();
    }

    public function sales($id)
    {
        $shop = Shop::find($id);

        $data = [
            "user_name" => env('API_USERNAME'),
            "token" => env('API_PASSWORD'),
            "store_uuid" => $shop->store_uuid,
            "order_status_array" => [
                "closed",
                "arrival_confirmed",
                "shipped_out",
                "shipment_submitted",
                "seller_paid",
                "arrival_claimed"
            ],
            "start_date" => "2021-01-01",
            "end_date" => Carbon::now()->format('Y-m-d')
        ];

        $response = Http::get(env('API_URL').'purchase/get_store_sales_info', [
            'data' => json_encode($data)
        ]);

        if($response['result'] == 'ok')
        {
            foreach($response['res_list'] as $data)
            {
                Sale::firstOrCreate([
                    'shop_id' => $id,
                    'sales_date' => $data['date'],
                    'sales_amount' => $data['daily_sells']
                ]);
            }

            return $response;
        }
        else
        {
            return false;
        }
    }

    public function product_list($id)
    {
        $shop = Shop::find($id);

        $data = [
            "user_name" => env('API_USERNAME'),
            "token" => env('API_PASSWORD'),
            "store_uuid" => $shop->store_uuid
        ];

        $response = Http::get(env('API_URL').'store/get_product_list', [
            'data' => json_encode($data)
        ]);

        if($response['result'] == 'ok')
        {
            return $response;
        }
        else
        {
            return false;
        }
    }

    public function product_details($product_uuid)
    {
        $data = [
            "user_name" => env('API_USERNAME'),
            "token" => env('API_PASSWORD'),
            "product_uuid" => $product_uuid
        ];

        $response = Http::get(env('API_URL').'store/get_product', [
            'data' => json_encode($data)
        ]);

        if($response['result'] == 'ok')
        {
            $product = $response;
            $review = $this->product_review($product_uuid);
            return view("backend.shop.product", compact('product','review'));
        }
        else
        {
            return back()->withError('Cannot retrive product details');
        }
    }

    public function product_review($product_uuid)
    {
        $data = [
            "user_name" => env('API_USERNAME'),
            "token" => env('API_PASSWORD'),
            "product_uuid" => $product_uuid
        ];

        $response = Http::get(env('API_URL').'product_review/get_list', [
            'data' => json_encode($data)
        ]);

        if($response['result'] == 'ok')
        {
            return $response['res_list'];
        }
        else
        {
            return false;
        }
    }

    public function add_manager(Request $request)
    {
        $shop_id = $request->get('shop_id');
        $shop = Shop::find($shop_id);

        $data = [
            "user_name" => env('API_USERNAME'),
            "token" => env('API_PASSWORD'),
            "shop_uuid" => $shop->shop_uuid,
            "user_uuid" => $shop->creator_user_uuid,
            "access" => 2
        ];

        $response = Http::post(env('API_URL').'add_store_manager', [
            'data' => json_encode($data)
        ]);
        
        $shop->update();

        Log::info('Shop '. $shop->store_name.' manager has been updated.');

        if($response['result'] == 'ok')
        {
            $flash = 'Shop '. $shop->store_name.' manager cannot be updated.';

        } else {
            $flash = $response['error_desc'];
        }

        flash('<i class="fas fa-check"></i> '.$flash)->success();
        return redirect()->back();
    }
}
