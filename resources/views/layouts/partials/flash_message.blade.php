@if (Session::has('message'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert {{ Session::get('flash_type', 'alert-info') }} alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                @if (is_array(Session::get('message')))
                    @foreach (Session::get('message') as $message)
                        <strong>{{$message}}</strong><br/>
                    @endforeach
                @else
                    <strong>{{Session::get('message')}}</strong>
                @endif
            </div>
        </div>
    </div>
@endif
