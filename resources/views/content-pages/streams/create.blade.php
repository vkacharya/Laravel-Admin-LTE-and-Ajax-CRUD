@extends('dashboard')
@section('content')

    <div class="container py-5 h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5"> @php echo isset($stream->id) ? 'Update Stream' : 'Add New Stream'; @endphp</h3>
                        <form id="streamForm">
                            <div class="row">
                                <div class="col"><label class="col-form-label">Student ID</label>
                                    <input class="form-control rounded" class="rounded" type="text" name="student_id"
                                        id="student_id"
                                        value="{{ old('student_id', isset($stream->student_id) ? $stream->student_id : '') }}">
                                </div>

                            </div>

                            <div class="row" style="margin-top:20px">
                                <div class="col-12">

                                    <select name="stream_type" class="select form-control-lg">
                                        <option value="1" selected disabled>Select Stream </option>
                                        <option value="IT"
                                            {{ old('stream_type', isset($stream->stream_type) ? 'selected' : '') }}>
                                            IT</option>
                                        <option value=""
                                            {{ old('stream_type', isset($stream->stream_type) ? 'selected' : '') }}>
                                            DOCTOR</option>
                                        <option
                                            value="ENGINEER"{{ old('stream_type', isset($stream->stream_type) ? 'selected' : '') }}>
                                            ENGINEER</option>
                                    </select>
                                    <label class="form-label select-label">Stream</label>

                                </div>
                            </div>


                            <div class="row" style="margin-top:20px">
                                <div class="col-12">

                                    <select name="is_active" class="select form-control-lg">
                                        <option value="null" selected disabled>Select Student Status</option>
                                        <option value="1"
                                            {{ old('is_active', isset($stream->is_active) == 1 ? 'selected' : '') }}>Active
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', isset($stream->is_active) == 0 ? 'selected' : '') }}>
                                            Inactive
                                        </option>
                                    </select>
                                    <label class="form-label select-label">Student Active Status</label>

                                </div>
                            </div>




                            <div class="mt-4 pt-2">
                                <input data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit" name="submit"
                                    value="{{ isset($stream->id) ? 'Update' : 'Add' }}" />
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')

    $(document).ready(function() {
    $('#streamForm').submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $.ajax({
    type: 'POST',
    url: '{{ route('streams.store') }}',
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
    window.location.href = "{{ route('streams.index') }}"

    console.log(response);
    },
    error: function(response) {
    console.log(response);

    }
    });
    });
    });

@stop
