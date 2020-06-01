<?php
$sidebar_menus = hsp_getConfig('topadmin_sidebar_menus');
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
                <li class="pb-2">
                    <a class="nav-link nav-link-btn pt-1" href="{{route($menu['route'])}}">
                        <div class="row m-0">
                            {{-- <div class="logo-menu p-0 float-left"><img class="" src="{{url('/css/asset/'.$menu['image'])}}" alt=""></div> --}}
                            <div class="col-10 menu-text p-0 pt-1 text-center" style="font-size:13px!important; margin: 0 auto">{{$menu['text']}}</div>
                        </div>
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            @endif
        @endforeach


        </ul>
    </div>
</nav>

<script>
    $(function(){
        var current = location.pathname;
        $('#nav li a').each(function(){
            var $this = $(this);
            // if the current path is like this link, make it active

            if($this.attr('href').indexOf(current) !== -1){
                $this.addClass('active');
            }
        })
    })
</script>
