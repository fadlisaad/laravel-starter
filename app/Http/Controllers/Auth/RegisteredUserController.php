<?php

namespace App\Http\Controllers\Auth;

use App\Events\Frontend\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shop;
use App\Models\ShopUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        if($request->get('email')){
            $email = $request->get('email');
        } else {
            $email = NULL;
        }
        return view('auth.register')->with('email', $email);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $shop = Shop::where('email', $request->email)->first();

        if($shop)
        {
            if($request->email == $shop->email)
            {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'name' => $request->first_name . " " . $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                // username
                $username = config('app.initial_username')+$user->id;
                $user->username = $username;
                $user->save();

                $user->syncRoles(['merchant']);

                //Auth::login($user);

                event(new UserRegistered($user));

                // add user as shop owner
                ShopUser::create([
                    'shop_id' => $shop->id,
                    'user_id' => $user->id
                ]);

                Log::info('Merchant Onboarding | Shop:'.$shop->store_name.', User:'.$request->first_name. " " .$request->last_name);

                flash("Your account has been registered! Please check your e-mail for confirmation.")->success()->important();
                return redirect(route('login'));
                //return redirect(RouteServiceProvider::HOME);

            } else {
                flash('Your e-mail is not registered in the Merchant site yet.')->error();
            }
        } else {
            flash('Your e-mail is not applicable for this registration. You must use the same e-mail address registered into Cartsitu app.')->error();
        }

        return redirect()->back();
    }
}
