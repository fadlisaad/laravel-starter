<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Shop;
use Log;
use Yajra\DataTables\DataTables;

class ShopController extends Controller
{
    public function index()
    {
        return view("backend.shop.index");
    }

    public function index_data()
    {
        $shop = Shop::all();
        return Datatables::of($shop)
            ->addColumn('action', function ($data) {
                return view('backend.includes.shop_actions', compact('data'));
            })
            ->editColumn('status', function ($data) {
                $return_data = $data->status;
                return $return_data;
            })
            ->make(true);
    }

    public function show($id)
    {
        $shop = Shop::find($id);
        return view("backend.shop.show", compact('shop'));
    }

    public function pending()
    {
        $data = [
            "user_name" => "b4f9b332-3738-11eb-b138-efd51cb920f0",
            "token" => "77104283",
            "offset" => 0,
            "page_size" => 30,
            "requested_field" => "*",
            "filter" => [
                "status" => "0"
            ]
        ];

        $response = Http::get('https://culick.com/store_reg/get_queue_list', [
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
            flash('<i class="fas fa-ban"></i> Failed to retrieve lastest pending shop data')->error();
        }
        return redirect()->back();
    }

    public function approve($id)
    {
        $shop = Shop::find($id);

        $data = [
            "user_name" => "b4f9b332-3738-11eb-b138-efd51cb920f0",
            "token" => "77104283",
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

        $response = Http::get('https://culick.com/store_reg/accept_last_request', [
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
            "user_name" => "b4f9b332-3738-11eb-b138-efd51cb920f0",
            "token" => "77104283",
            "creator_user_uuid" => $shop->creator_user_uuid
        ];

        $response = Http::get('https://culick.com/store_reg/reject_last_request', [
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
}
