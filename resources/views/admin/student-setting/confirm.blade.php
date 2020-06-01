@extends('layouts.app')
@section('content')
@component('components.form-confirm')
    @slot('title')
        {{ hsp_title() }}
    @endslot

    @slot('action')
        {{ route('admin.student_setting.import', $schoolClass) }}
    @endslot
    @slot('header')

    @endslot
    <div class="p-4">
        <input type="hidden" name="school_class_id" value="{{ old('school_class_id') }}">
        <h2 class="text-muted mb-2">確認</h2>
        <div class=" mb-4">
            <div class="bg-white py-2 px-3">
                <table class="table datatable" id="students_verify_table">
                    <thead>
                        <tr class="datatable--header--row">
                            <th scope="col" class="datatable--header--cell">お子様</th>
                            <th scope="col" class="datatable--header--cell">セイ</th>
                            <th scope="col" class="datatable--header--cell">メイ</th>
                            <th scope="col" class="datatable--header--cell">性別</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(old('students', []) as $index => $student )
                            <tr @if($student['is_invalid']) class="bg-danger" @endif>
                                <td>
                                    {{ $student['name'] }}
                                    <input type="hidden" name="students[{{ $index }}][name]" value="{{ $student['name'] }}">
                                    <input type="hidden" name="students[{{ $index }}][is_invalid]" value="{{ $student['is_invalid'] ? 'true' : 'false' }}">
                                </td>
                                <td>
                                    {{ $student['first_name'] }}
                                    <input type="hidden" name="students[{{ $index }}][first_name]" value="{{ $student['first_name'] }}">
                                </td>
                                <td>
                                    {{ $student['last_name'] }}
                                    <input type="hidden" name="students[{{ $index }}][last_name]" value="{{ $student['last_name'] }}">
                                </td>
                                <td>
                                    @if($student['gender'] === 1)
                                        男性
                                    @else
                                        女性
                                    @endif
                                    <input type="hidden" name="students[{{ $index }}][gender]" value="{{ $student['gender'] }}">
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mx-auto w-50 mt-4 p-4">
            <button class="btn btn-block btn-primary py-3 {{ $errors->has('csv_file') ? 'is-invalid' : '' }}" tabindex="0" type="button" data-target="#uploadFormModal" data-toggle="modal">
                <span class="h3"> 再{{ hsp_action('import') }}</span>
            </button>
            @includeWhen($errors->has('csv_file'), 'components.form-error', ["name" => 'csv_file'])
        </div>
    </div>
@endcomponent
@include("admin.student-setting.modal.import-modal")
@endsection
