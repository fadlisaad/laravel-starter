@extends ('backend.layouts.app')

@section('title') {{ $module_action }} {{ $module_title }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}' >
        {{ $module_title }}
    </x-backend-breadcrumb-item>

    <x-backend-breadcrumb-item type="active">Profile</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{$module_icon}}"></i> Profile
                    <small class="text-muted">{{ __('labels.backend.users.show.action') }} </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.index.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="float-right">
                    <a href="{{ route("backend.users.profileEdit", $user->id) }}" class="btn btn-primary mt-1 btn-sm" data-toggle="tooltip" title="Edit {{ Str::singular($module_name) }} Profile"><i class="fas fa-wrench"></i> Edit</a>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->

        <div class="row mt-4 mb-4">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user"></i>
                        Personal Information
                    </div>
                    <div class="card-body">
                        <img src="{{asset($user->avatar)}}" class="user-profile-image img-fluid img-thumbnail" style="max-height:200px; max-width:200px;" />
                        <dl>
                            <?php $fields_array = [
                                [ 'name' => 'name' ],
                                [ 'name' => 'email' ],
                                [ 'name' => 'mobile' ],
                                [ 'name' => 'gender' ],
                                [ 'name' => 'date_of_birth', 'type' => 'date'],
                                [ 'name' => 'profile_privecy' ],
                                [ 'name' => 'address' ],
                                [ 'name' => 'bio' ],
                                [ 'name' => 'login_count' ],
                                [ 'name' => 'last_login', 'type' => 'datetime' ],
                                [ 'name' => 'last_ip' ],
                            ]; ?>
                            @foreach ($fields_array as $field)
                                @php
                                $field_name = $field['name'];
                                $field_type = isset($field['type'])? $field['type'] : '';
                                @endphp

                                <dt>{{ __("labels.backend.users.fields.".$field_name) }}</dt>

                                @if ($field_name == 'date_of_birth' && $userprofile->$field_name != '')
                                <dd>
                                    @if(auth()->user()->id == $userprofile->user_id)
                                    {{ $userprofile->$field_name->isoFormat('LL') }}
                                    @else
                                    {{ $userprofile->$field_name->format('jS \\of F') }}
                                    @endif
                                </dd>
                                @elseif ($field_type == 'date' && $userprofile->$field_name != '')
                                <dd>
                                    {{ $userprofile->$field_name->isoFormat('LL') }}
                                </dd>
                                @elseif ($field_type == 'datetime' && $userprofile->$field_name != '')
                                <dd>
                                    {{ $userprofile->$field_name->isoFormat('llll') }}
                                </dd>
                                @else
                                <dd>{{ $userprofile->$field_name }}</dd>
                                @endif
                            @endforeach

                            <dt>{{ __('labels.backend.users.fields.password') }}</dt>
                            <dd>
                                <a href="{{ route('backend.users.changeProfilePassword', $user->id) }}" class="btn btn-outline-primary btn-sm">Change password</a>
                            </dd>

                            <dt>{{ __('labels.backend.users.fields.social') }}</dt>
                            <dd>
                                <ul class="list-unstyled">
                                    @foreach ($user->providers as $provider)
                                    <li>
                                        <i class="fab fa-{{ $provider->provider }}"></i> {{ label_case($provider->provider) }}
                                    </li>
                                    @endforeach
                                </ul>
                            </dd>

                            <dt>{{ __('labels.backend.users.fields.status') }}</dt>
                            <dd>{!! $user->status_label !!}</dd>

                            <dt>{{ __('labels.backend.users.fields.confirmed') }}</dt>
                            <dd>{!! $user->confirmed_label !!}</dd>

                            <dt>{{ __('labels.backend.users.fields.roles') }}</dt>
                            <dd>
                                @if($user->roles()->count() > 0)
                                    <ul>
                                        @foreach ($user->roles() as $role)
                                        <li>{{ ucwords($role) }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                </dd>

                            <dt>{{ __('labels.backend.users.fields.permissions') }}</dt>
                            <dd>
                                @if($user->permissions()->count() > 0)
                                    <ul>
                                        @foreach ($user->permissions() as $permission)
                                        <li>{{ $permission['name'] }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                </dd>

                            <dt>{{ __('labels.backend.users.fields.created_at') }}</dt>
                            <dd>{{ $user->created_at->isoFormat('llll') }}<br><small>({{ $user->created_at->diffForHumans() }})</small></dd>

                            <dt>{{ __('labels.backend.users.fields.updated_at') }}</dt>
                            <dd>{{ $user->updated_at->isoFormat('llll') }}<br/><small>({{ $user->updated_at->diffForHumans() }})</small></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-dollar-sign"></i>
                        Bank Account Details
                    </div>
                    <div class="card-body">
                        <?php $bank_array = [
                            [ 'name' => 'bank_name' ],
                            [ 'name' => 'bank_account_name' ],
                            [ 'name' => 'bank_account_number' ]
                        ]; ?>
                        <dl>
                        @foreach ($bank_array as $field)
                            @php
                            $field_name = $field['name'];
                            $field_type = isset($field['type'])? $field['type'] : '';
                            @endphp

                            <dt>{{ __("labels.backend.users.fields.".$field_name) }}</dt>
                            <dd>{{ $userprofile->$field_name ?? 'N/A' }}</dd>
                        @endforeach
                        </dl>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('backend.users.changeBankDetails', $user->id) }}" class="btn btn-primary btn-sm">Update Bank Details</a>
                    </div>
                </div>
            </div>
            <!--/.col-->
            @hasrole('merchant')
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-cube"></i>
                        Shop Information
                    </div>
                    <div class="card-body">
                        <dl>
                            <dt>Store Name</dt>
                            <dd>{{ $shop[0]['store_name'] }}</dd>
                            <dt>Store Address</dt>
                            <dd>{{ $shop[0]['address'] }}</dd>
                            <dt>Store Description</dt>
                            <dd>{{ $shop[0]['description'] }}</dd>
                            <?php $shop_array = [
                                [ 'name' => 'url_website', 'type' => 'url' ],
                                [ 'name' => 'url_facebook', 'type' => 'url' ],
                                [ 'name' => 'url_twitter', 'type' => 'url' ],
                                [ 'name' => 'url_linkedin', 'type' => 'url' ]
                            ]; ?>
                            @foreach ($shop_array as $field)
                                @php
                                $field_name = $field['name'];
                                $field_type = isset($field['type'])? $field['type'] : '';
                                @endphp

                                <dt>{{ __("labels.backend.users.fields.".$field_name) }}</dt>
                                <dd>
                                    <a href="{{ $userprofile->$field_name }}" target="_blank">{{ $userprofile->$field_name }}</a>
                                </dd>
                            @endforeach
                        </dl>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('backend.store.show', $shop[0]['id']) }}" class="btn btn-primary btn-sm">View Shop Details</a>
                    </div>
                </div>
            </div>
            @endhasrole
            <!--/.col-->
        </div>
        <!--/.row-->
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    Updated: {{$user->updated_at->diffForHumans()}},
                    Created at: {{$user->created_at->isoFormat('LLLL')}}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
