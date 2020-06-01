<div class="alert alert-{{session()->has('type') ? session('type') : 'success'}} alert-dismissible fade show" role="alert">
    @if(session()->has('title'))<h4 class="alert-heading"{{session('title')}}</h4>@endif
    <span>{{session('message')}}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
