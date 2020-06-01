<?php
$sidebar_menus = hsp_getConfig('sidebar_menus');
$schoolSetting = \App\Models\SchoolSetting::where('school_id', auth()->user()->school_id)->first();
$slugs  = [];
$routes = Route::getRoutes();

foreach ($routes as $route)
{
    $slugs[] = $route->uri();
}?>
<nav class="text-center" style="">
    <div class="sidebar-sticky" id="top">
        <ul class="art-hmenu pl-0" id="nav">
        @foreach($sidebar_menus as $menu)
            {{-- {{dd($sidebar_menus)}} --}}
            @if($menu['changable'] == false)
                <li class="mb-2">
                    <a class="nav-link nav-link-btn pt-0 pb-0" href="{{route($menu['route'])}}">
                        <div class="row m-0" style="height: 100%">
                            <div class="logo-menu logo-menu-fix p-0 float-left align-middle">
                                <img class="check-menu-click-symbol" src="{{url('/css/asset/'.$menu['image'])}}" alt="">
                                <img class="check-menu-click" src="{{$menu['image-hover'] !==null ? url('/css/asset/hover/'.$menu['image-hover']) : ''}}" alt="">
                            </div>
                            <div class="col-10 menu-text p-0 logo-menu-fix" {{!empty($menu['text']) && $menu['text'] == '生徒登録設定（転入・転校）'? 'style=font-size:17px!important;margin-left:10px'  :''}}><span>{{$menu['text']}}</span></div>
                        </div>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            @else
                @php $setting_column = $menu['column']; @endphp
                @if($schoolSetting->$setting_column == 1)
                    @php $show = true; @endphp
                @else
                    @php $show = false; @endphp
                @endif

                @if($show == true)
                    <li class="mb-2">
                        <a class="nav-link nav-link-btn pt-0 pb-0" href="{{route($menu['route'])}}">
                            <div class="row m-0" style="height: 100%">
                                <div class="logo-menu logo-menu-fix p-0 float-left">
                                    <img class="check-menu-click-symbol align-middle" src="{{url('/css/asset/'.$menu['image'])}}" alt="">
                                    <img class="check-menu-click" src="{{$menu['image-hover']!== null ? url('/css/asset/hover/'.$menu['image-hover']) : ''}}" alt="">
                                </div>
                                <div class="col-10 menu-text p-0 logo-menu-fix"><span>{{$menu['text']}}</span></div>
                            </div>
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                @endif
            @endif
            @endforeach


        </ul>
    </div>
</nav>

<script>
    jQuery(function($) {
        var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $('#nav li a').each(function() {
            if (path.includes(this.href) == true) {
                $(this).addClass('active');
            }
        });
    });
</script>
