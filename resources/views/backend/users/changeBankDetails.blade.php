@extends ('backend.layouts.app')

<?php
$module_name_singular = Str::singular($module_name);
?>

@section('title') {{ __($module_action) }} {{ $module_title }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}' >
        {{ $module_title }}
    </x-backend-breadcrumb-item>

    <x-backend-breadcrumb-item type="active">{{__('Change Password')}}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{$module_icon}}"></i> Profile
                    <small class="text-muted">@lang('Change Bank Details') </small>
                </h4>
                <div class="small text-muted">
                    {{ __('labels.backend.users.edit.sub-title') }}
                </div>
            </div>
            <!--/.col-->
            <div class="col-4">
                <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                    <x-buttons.return-back />
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
        <hr>
        <div class="row mt-4 mb-4">
            <div class="col-6">
                {{ html()->form('PATCH', route('backend.users.changeBankDetailsUpdate', $user_profile->user_id))->class('form-horizontal')->open() }}

                <div class="form-group row">
                    {{ html()->label(__('labels.backend.users.fields.bank_name'))->class('col-md-6 form-control-label')->for('bank_name') }}

                    <div class="col-md-6">
                        {{ html()->select('bank_name', [
                            'Al-Rajhi Islamic Bank' => 'Al-Rajhi Islamic Bank',
                            'Affin Bank' => 'Affin Bank',
                            'Affin Islamic' => 'Affin Islamic',
                            'Alliance Bank' => 'Alliance Bank',
                            'AmBank' => 'AmBank',
                            'Bank Islam' => 'Bank Islam',
                            'Bank Muamalat Malaysia Bhd' => 'Bank Muamalat Malaysia Bhd',
                            'Bank Rakyat' => 'Bank Rakyat',
                            'Bank Simpanan Nasional' => 'Bank Simpanan Nasional',
                            'CIMB Bank' => 'CIMB Bank',
                            'Citibank' => 'Citibank',
                            'Hong Leong Bank' => 'Hong Leong Bank',
                            'HSBC Bank' => 'HSBC Bank',
                            'Kuwait Finance House' => 'Kuwait Finance House',
                            'Maybank' => 'Maybank',
                            'MBSB Bank' => 'MBSB Bank',
                            'OCBC Bank' => 'OCBC Bank',
                            'Public Bank' => 'Public Bank',
                            'RHB Bank' => 'RHB Bank',
                            'Standard Chartered Bank' => 'Standard Chartered Bank',
                            'United Overseas Bank' => 'United Overseas Bank'
                            ])
                            ->class('form-control')
                            ->value($user_profile->bank_name)
                            ->required() }}
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    {{ html()->label(__('labels.backend.users.fields.bank_account_name'))->class('col-md-6 form-control-label')->for('bank_account_name') }}

                    <div class="col-md-6">
                        {{ html()->text('bank_account_name')
                            ->class('form-control')
                            ->value($user_profile->bank_account_name)
                            ->required() }}
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    {{ html()->label(__('labels.backend.users.fields.bank_account_number'))->class('col-md-6 form-control-label')->for('bank_account_number') }}

                    <div class="col-md-6">
                        {{ html()->text('bank_account_number')
                            ->class('form-control')
                            ->value($user_profile->bank_account_number)
                            ->required() }}
                    </div>
                </div><!--form-group-->

                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    {{ html()->button($text = "<i class='fas fa-save'></i> Save", $type = 'submit')->class('btn btn-success') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{ html()->closeModelForm() }}
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    @lang('Updated'): {{$user_profile->updated_at->diffForHumans()}}
                </small>
            </div>
        </div>
    </div>
</div>

@endsection
