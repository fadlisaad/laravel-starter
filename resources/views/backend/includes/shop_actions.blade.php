<div class="text-right">
    <a href="{{route('backend.store.show', $data)}}" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip" title="{{__('labels.backend.show')}}"><i class="fas fa-desktop"></i></a>

    @if ($data->status != 1)
    <a href="{{route('backend.store.approve', $data)}}" class="btn btn-info btn-sm mt-1" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="Approve" data-confirm="@lang('Are you sure?')"><i class="fas fa-check"></i></a>

    <a href="{{route('backend.store.reject', $data)}}" class="btn btn-danger btn-sm mt-1" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="Reject" data-confirm="@lang('Are you sure?')"><i class="fas fa-ban"></i></a>
    @endif

</div>
