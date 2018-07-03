@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(session()->has($msg))
        <div class="flash-message">
            <p class="alert alert-{{ $msg }} alert-dismissible" role="alert"><i class="icon_error"></i>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span class="error_msg">{{ session()->get($msg) }}</span>
            </p>
        </div>
    @endif
@endforeach