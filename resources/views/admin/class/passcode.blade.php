<div>
    <div class="div" style="background-color:#f5f8fa;">
        <h3>{{ hsp_school()->name }} </h3>
        <div>
        @if(strpos(url('/'), 'hsp.stg.newit-dev-local.com') !== false)
            <img src="{{ url('/css/asset/qr/local_qr_code.png') }}" alt="http://hsp.stg.newit-dev-local.com/front/register">
        @elseif (strpos(url('/'), 'stg.hapisuku.com') !== false)
            <img src="{{ url('/css/asset/qr/stg_qr_code.png') }}" alt="https://stg.hapisuku.com/front/register">
        @else
            <img src="{{ url('/css/asset/qr/qr_code.png') }}" alt="https://hapisuku.com/front/register">
        @endif
        </div>
        <p>名前： {{ $student->name }}</p>
        <p>認証コード：{{ hsp_school()->schoolPasscode->passcode }}</p>
        <p>お子様コード：{{ $passcode }}</p>
        <img src="{{ asset('images/register_manual.PNG') }}" style="width:100%;hight:auto">
    </div>
</div>
