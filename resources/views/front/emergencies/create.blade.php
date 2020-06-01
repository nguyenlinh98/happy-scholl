@extends('front.layouts.urgent-contact')
@section('content')
    <form class="survey" action="{{ route('emergency.review') }}" method="POST">
        @csrf
        @include('front.emergencies.views.urgent-contact-subject')
        @include('front.emergencies.views.yes_no-question')
        @include('front.emergencies.views.input-question')
        @include('front.emergencies.views.class-list')
        @include('front.emergencies.views.urgent-contact-sender')

        <a href="#" class="btn-in" onclick="$(this).closest('form').submit();return false">{{ translate('確認') }}</a>
        <a href="{{ route('emergency.top') }}" class="btn-out">{{ translate('戻る') }}</a>
    </form>
@endsection
@push('script')
    <script>
        $('document').ready(function () {
            if ($('.school_class').length == $('.school_class:checked').length) {
                $('#send_all').prop('checked', true);
            } else {
                $('#send_all').prop('checked', false);
            }
            $('.school_class').on('change', function () {
                if ($('.school_class').length == $('.school_class:checked').length) {
                    $('#send_all').prop('checked', true);
                } else {
                    $('#send_all').prop('checked', false);
                }
            });

        });

        function selectAll(target) {
            if (true === $(target).prop('checked')) {
                $('.school_class').prop('checked', true);
            } else {
                $('.school_class').prop('checked', false);
            }
        }

        function autoCheckbox(target) {
            if(0 === $(target).val().length) {
                var checkbokId = '#' + $(target).attr('id').split('_')[0];
                $(checkbokId).prop('checked', false);
            } else {
                var checkbokId = '#' + $(target).attr('id').split('_')[0];
                $(checkbokId).prop('checked', true);
            }
        }
    </script>
@endpush
