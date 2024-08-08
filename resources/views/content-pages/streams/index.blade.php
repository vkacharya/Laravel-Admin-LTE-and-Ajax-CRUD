@extends('dashboard')
@section('content')

    <div class="container py-5 h-100">
        <div class="">
            <div class="">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">

                        <h1 class="mb-4 pb-2 pb-md-0 mb-md-5">Streams Data</h1>
                        <button type="button" class="btn btn-primary mb-3" data-bs-target="#streamModal"
                            data-bs-toggle="modal" id="addStreamBtn">
                            Add Stream
                        </button>

                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>Stream Type</th>
                                        <th>Is Active</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="stream_data">

                                </tbody>
                            </table>
                        </div>

                        <!-- Stream Modal -->
                        <div class="modal fade" id="streamModal" tabindex="-1" aria-labelledby="streamModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="StreamModalLabel">Add/Edit Stream</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="streamForm">
                                            @csrf
                                            <input type="hidden" id="stream" name="id" class="id-class"
                                                value="">
                                            <div class="row">
                                                <div class="col student-div">
                                                    <label class="col-form-label">Student ID</label>
                                                    <input class="form-control rounded student_id error error-student_id"
                                                        type="text" name="student_id" id="student_id" value="">
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-12 stream-div">
                                                    <select name="stream_type" class="select form-control-lg stream_type">
                                                        <option value="" selected disabled>Select Stream</option>
                                                        <option value="IT">IT</option>
                                                        <option value="DOCTOR">DOCTOR</option>
                                                        <option value="ENGINEER">ENGINEER</option>
                                                    </select>
                                                    <label class="form-label select-label">Stream</label>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-12 is_active-div">
                                                    <select name="is_active" class="is_active select form-control-lg">
                                                        <option value="" selected disabled>Select Student Status
                                                        </option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                    <label class="form-label select-label">Student Active Status</label>
                                                </div>
                                            </div>

                                            <div class="mt-4 pt-2">
                                                <button type="submit" class="btn btn-primary mt-3">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('custom-scripts')
    <script>
        $(document).ready(function() {

            fetchStreams();

            function fetchStreams() {
                $.ajax({
                    type: "GET",
                    url: '{{ route('stream.show') }}',
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('#stream_data').html(response.html);
                        }
                    },
                    error: function(xhr, status, error) {

                    }
                    // error: function(res) {
                    // res.jsonerrors.errors
                    // key val
                    // key => student_id
                    // val => "student id is required"

                    // $(`.error_${key}`).html(value);


                });
            }

            // Add modal open
            $('#addStreamBtn').on('click', function() {
                $('.error').html('');
                $('#streamForm').trigger('reset');
                $('#stream').val('');
                clearValidationErrors();
                $('#StreamModalLabel').text('Add Stream');
            });

            //  add/update stream
            $('#streamForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let id = $('#stream').val();
                let url = id ? '/streams/' + id : '{{ route('streams.store') }}';
                let method = id ? 'POST' : 'POST';

                if (id) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.status == 400) {
                            clearValidationErrors();
                            showValidationErrors(data);
                            console.log(data.errors);
                        } else {
                            $('#streamModal').modal('hide');
                            fetchStreams();
                        }
                    },
                    error: function(xhr, status, errors) {
                        clearValidationErrors();
                        showValidationErrors(xhr);
                        // console.log(xhr.responseJSON.errors);

                    }
                });
            });

            function clearValidationErrors() {
                $('span,br').remove();
            }

            function showValidationErrors(xhr) {
                if (xhr.responseJSON.errors.student_id) {
                    $('.student-div').append('<span class="text-danger">' + xhr.responseJSON.errors.student_id +
                        '</span><br>');
                }
                if (xhr.responseJSON.errors.stream_type) {
                    $('.stream-div').append('<br><span class="text-danger">' + xhr.responseJSON.errors.stream_type +
                        '</span><br>');
                }
                if (xhr.responseJSON.errors.is_active) {
                    $('.is_active-div').append('<br><span class="text-danger">' + xhr.responseJSON.errors
                        .is_active +
                        '</span><br>');
                }
            }

            // Edit Stream
            $(document).on('click', '.edit-btn', function() {
                var id = $(this).val();
                $('#streamModal').modal('show');
                $('#StreamModalLabel').text('Edit Stream');

                $.ajax({
                    type: "GET",
                    url: "/streams/" + id + "/edit",
                    success: function(response) {
                        if (response.status == 404) {
                            console.log(response.message);
                        } else if (response.status == 200 && response.stream) {
                            $('.student_id').val(response.stream.student_id);
                            $('.stream_type').val(response.stream.stream_type);
                            $('.is_active').val(response.stream.is_active);
                            $('#stream').val(response.stream.id);
                        }
                    },
                    error: function(error) {


                    }
                });
            });


            $(document).on('click', '.close', function() {
                $('#streamForm').trigger("reset");
                $('#stream').val('');
                clearValidationErrors();
            });

            $('#streamModal').on('hidden.bs.modal', function(e) {
                $('#streamForm').trigger("reset");
                $('#stream').val('');
                clearValidationErrors();
            })


            $(document).on('click', '.delete-btn', function() {
                var id = $(this).val();
                if (confirm('Are you sure you want to delete this stream?')) {
                    $.ajax({
                        type: 'POST',
                        url: '/streams/' + id,
                        data: {
                            "id": id,
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            fetchStreams();
                        }
                    });
                }
            });
        });
    </script>
@endpush
