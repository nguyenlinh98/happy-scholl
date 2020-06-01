@extends('front.layouts.front')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="select-school">
            <!-- NAVBAR -->
            <div class="nav-top">
                <a href="{{route('front.calendar.index')}}" class="back-top"><img src="{{asset('images/front/arr-left.png')}}">{{translate('戻る')}}</a>
                <h3>{{translate('カレンダー')}}</h3>
            </div>
            <form action="{{route('front.calendar.updatetheme')}}" method = "POST" enctype="multipart/form-data">
                                    @method('PATCH')
                                    @csrf
            <div class="calendar">
                <div class="title">{{translate(getSchoolName())}}</div>
                <div class="head">
                    {{translate('カレンダー背景選択')}}
                </div>
                @include('layouts.partials.flash_message')
                <div class="list-calendar">
                @foreach($themes as $key => $theme)
                    <div class="item-calendar">
                        <figure>
                        @if($theme->type == \App\Models\CalendarTheme::TYPE_ORIGINAL)
                            <a href="{{route('front.calendar.uploadimage',[$theme->id])}}">
                            @if(file_exists(public_path() . $theme->background_image))
                              <img id="{{$theme->id}}" class="calendar_theme" src="{{asset($theme->background_image)}}" alt="{{translate($theme->type)}}" title="{{translate($theme->type)}}">
                            @else
                              <img id="{{$theme->id}}" class="calendar_theme" src="{{asset('images/front/thumb-calendar.png')}}" alt="{{translate($theme->type)}}" title="{{translate($theme->type)}}">
                            @endif
                            </a>
                        @else
                        <a href="#">
                            @if(file_exists(public_path() . $theme->background_image))
                              <img id="{{$theme->id}}" class="calendar_theme" src="{{asset($theme->background_image)}}" alt="{{translate($theme->type)}}" title="{{translate($theme->type)}}">
                            @else
                              <img id="{{$theme->id}}" class="calendar_theme" src="{{asset('images/front/thumb-calendar.png')}}" alt="{{translate($theme->type)}}" title="{{translate($theme->type)}}">
                            @endif
                        </a>
                        @endif
                        </figure>
                        <h5>{{translate($theme->name)}}</h5>
                    </div>
                @endforeach
                </div>
            </div>
            <input type="hidden" id="calendar_theme_id" value="" name="calendar_theme_id">
            <button class="btn-login margin-top-30" type="submit">{{translate('送信')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
        var arr = []; // all ID of themes
        $(".calendar_theme").each(function() {
             var id = $(this).attr('id');
             arr.push(id);
        });

        $('.calendar_theme').click(function() {
            var removeItem = $(this).attr('id');

            // b is array of theme ID not click
            var b = $.grep(arr, function(value) {
              return value != removeItem;
            });
             var div_click = "#" + removeItem;
             $(div_click).css('border','3px solid #E4007F');

             b.forEach(function(item) {
                  var div_not_click = "#" + item;
                  $(div_not_click).css('border','none');
             });
             // add ID to theme and submit
             $('#calendar_theme_id').val(removeItem);
        });
</script>
@endpush
