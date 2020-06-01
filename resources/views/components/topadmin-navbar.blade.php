<nav id="main-navigation" class="navbar navbar-expand-sm navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
{{--    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{config('app.url')}}">{{ config('app.name') }}</a>--}}
   <div class="col-lg-3">
       <a class="navbar-brand mr-0" href="{{url('/admin/home')}}" style="margin-left: 5%;">
           <div class="logo" style="width: 100%;height: auto; margin: 0 auto; display: flex">
               <img style="height:35px; margin-top:10px;" src="{{url('/css/asset/logo.png')}}" alt="">
               <p style="margin-left:20px; margin-top: 10px; color: white!important;" class="text-center">HSP管理画面</p>
           </div>
       </a>
   </div>
    <div class="col-lg-6"></div>
    <div class="col-lg-3">
    <ul class="navbar-nav float-right px-3 navbar-nav-color">
        {{-- <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12" y2="17"></line></svg>
            </a>
        </li> --}}
            {{-- <li class="nav-item text-nowrap">
            <a class="nav-link" href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                ユーザー設定        </a>
        </li> --}}
            {{-- <li class="text-nowrap">
                <a class="nav-link" href="#">
                    <img src="{{url('/css/asset/announce.png')}}" alt="">
                </a>
            </li>
            <li class=" text-nowrap">
                <a class="nav-link" href="#">
                    <input type="image" src="{{url('/css/asset/refresh.png')}}" onClick="window.location.reload();" style="border: none">
                </a>
            </li> --}}
            <li class=" text-nowrap" style="padding-top: 5px;">
                <a class="nav-link" href="{{route('top_admin.logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">ログアウト</a>
                <form id="logout-form" action="{{route('top_admin.logout')}}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>
