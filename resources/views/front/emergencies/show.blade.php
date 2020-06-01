@extends('front.layouts.urgent-contact')
@section('content')
<div class="head">{{ translate('クラスを選んでください') }}</div>
<div class="list-u">
    <div class="item-u"><a href="{{ route('emergency.class.show', ['emergencyId' => $emergencyId, 'classId' => 0]) }}">{{ translate('全　体') }}</a></div>
</div>
@for ($i = 0; $i < count($schoolClasses); $i = $i + 8)
        <div class="list-u">
    @for ($j = $i ; $j < min($i + 8, count($schoolClasses)); $j = $j + 4)
            <div class="colw-1">
        @for ($k = $j; $k < min($j + 4, count($schoolClasses)); ++$k)
                <div class="item-u">
                    <a href="{{ route('emergency.class.show', ['emergency_id' => $emergencyId, 'class_id'=> $schoolClasses[$k]->id]) }}">{{ $schoolClasses[$k]->name  }}</a>
                </div>
        @endfor
            </div>
    @endfor
        </div>
@endfor
<a href="{{ route('emergency.index') }}" class="btn-ene">{{ translate('戻る') }}</a>
@endsection
