@extends('layouts.app')
@section('content')
@component('components.form')
    @slot('title')
        {{ __('meeting.title.index') }}
    @endslot

    @slot('action')
        {{ route('admin.meeting.confirm') }}
    @endslot
    @slot('header')

        <div class="container-fluid p-0">
            <div class="p-0 mb-2">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                    @if( request()->get('type') === 'individual' )
                        <h2 class="text-muted">個別のお手紙</h2>
                    @else
                        <h2 class="text-muted">お手紙</h2>
                    @endif
                </div>
            </div>
        </div>

    @endslot
    <div class="d-flex row-search pt-4 px-4">
        <div class="p-0 row-search-btn">
            @if( request()->get('type') === 'individual' )
                <a href="{{ route('admin.meeting.create') }}?type=collection">
                    <div class="text-center mr-3 btn-content btn-content-letter mb-0">
                        <p class="mb-0">お手紙の作成</p>
                    </div>
                </a>
            @else
                <div class="text-center mr-3 btn-content-deactive btn-content-letter-action mb-0">
                    <p class="mb-0">お手紙の作成</p>
                </div>
            @endif
        </div>
        @if(hsp_setting('letter_individual_active'))
            <div class="p-0 row-search-btn">
                @if( request()->get('type') === 'individual' )
                    <div class="text-center mr-3 btn-content-deactive btn-content-letter mb-0 float-right">
                        <p class="mb-0">個別お手紙の作成</p>
                    </div>
                @else
                    <a href="{{ route('admin.meeting.create') }}?type=individual">
                        <div class="text-center mr-3 btn-content btn-content-letter mb-0 float-right">
                            <p class="mb-0">個別お手紙の作成</p>
                        </div>
                    </a>
                @endif
            </div>
        @endif
    </div>
    @include("admin.meeting.form")
@endcomponent
@endsection
