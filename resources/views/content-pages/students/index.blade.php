@extends('dashboard')
@section('content')

    <div class="container py-5 h-100">
        <div class="">
            <div class="">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">

                        <h1 class="mb-4 pb-2 pb-md-0 mb-md-5">Students Data</h1>
                        <button type="button" class="btn btn-primary mb-3" data-bs-target="#studentModal"
                            data-bs-toggle="modal" id="addStudentBtn">
                            Add Student
                        </button>

                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>image</th>
                                        <th>name</th>
                                        <th>address</th>
                                        <th>contact</th>
                                        <th>documents</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="student_data">

                                </tbody>
                            </table>
                        </div>

                        <!-- Student Modal -->
                        <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="studentModalLabel">Add/Edit Student</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="studentForm" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" id="studentId" value="" class="id-class"
                                                name="id">
                                            <input type="hidden" name="_method" value="POST" class="_method">

                                            <div class="form-group name">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name">
                                            </div>
                                            <div class="form-group imagedata">
                                                <label for="image">Image</label>
                                                <input type="file" class="form-control-file" id="image"
                                                    name="image">
                                                <img id="currentImage" src="" alt="Current Image"
                                                    style="max-width: 100px;">
                                            </div>
                                            <div class="form-group address">
                                                <label for="address">Address</label>
                                                <input type="text" class="form-control" id="address" name="address">
                                            </div>
                                            <div class="form-group contact">
                                                <label for="contact">Contact</label>
                                                <input type="text" class="form-control" id="contact" name="contact">
                                            </div>
                                            <div class="form-group documents">
                                                <label for="documents">Documents</label>
                                                <input type="file" class="form-control-file" id="documents"
                                                    name="documents[]" accept="application/pdf" multiple>
                                                <div id="currentDocuments">
                                                    <a href="{{ asset('storage/documents/') }}" target="_blank"
                                                        class="btn btn-info btn-sm">View</a>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3">Save</button>
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

            fetchstudent();

            function fetchstudent() {
                $.ajax({
                    type: "GET",
                    url: '{{ route('student.test') }}',
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            $('#student_data').html(response.html)
                        }
                    }
                });
            }

            // Add/Edit student
            $('#studentForm').submit(function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                let formData = new FormData(this);
                let id = $('.id-class').val();
                let url = '{{ route('students.store') }}';
                let method = 'POST';

                if (id !== "") {
                    url = '/students/' + id;
                    method = 'POST';
                    formData.append('_method', 'PATCH');
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.status == 400) {
                            console.log(data.errors.documents);

                            clearValidationErrors();
                            validation(xhr);
                        } else {
                            $('#studentModal').modal('hide');
                            fetchstudent();
                        }
                    },
                    error: function(xhr, status, errors) {
                        clearValidationErrors();
                        validation(xhr);
                        console.log(xhr.responseJSON.errors.documents);

                    }
                });
            });

            function clearValidationErrors() {
                $('span,br').remove();
            }

            function validation(xhr) {
                clearValidationErrors();

                if (xhr.responseJSON.errors.name) {
                    $('.name').append('<span class="text-danger">' + xhr.responseJSON.errors.name + '</span><br>');
                }
                if (xhr.responseJSON.errors.image) {
                    $('.imagedata').append('<span class="text-danger">' + xhr.responseJSON.errors.image +
                        '</span><br>');
                }
                if (xhr.responseJSON.errors.address) {
                    $('.address').append('<span class="text-danger">' + xhr.responseJSON.errors.address +
                        '</span><br>');
                }
                if (xhr.responseJSON.errors.contact) {
                    $('.contact').append('<span class="text-danger">' + xhr.responseJSON.errors.contact +
                        '</span><br>');
                }
                if (xhr.responseJSON.errors.documents) {
                    $('.documents').append('<span class="text-danger">' + xhr.responseJSON.errors.documents +
                        '</span><br>');
                }
            }

            // Edit student form open
            $(document).on('click', '.edit-btn', function(e) {
                e.preventDefault();
                var stud_id = $(this).val();
                $('#studentModal').modal('show');
                $('#currentImage').show();
                $('._method').val('PATCH');

                $.ajax({
                    type: "GET",
                    url: "/students/" + stud_id + "/edit",
                    success: function(response) {
                        if (response.status == 404) {
                            console.log(response.message);
                        } else {
                            $('#name').val(response.student.name);
                            var img = response.student.image;
                            $('#currentImage').attr("src",
                                `{{ asset('storage/images/${img}') }}`);
                            $('#address').val(response.student.address);
                            $('#contact').val(response.student.contact);
                            $('#currentDocuments').prepend(response.student.documents);
                            $('.id-class').val(response.student.id);
                            var doc = response.student.documents;
                            doc = doc.replace(/"|'/g, '', /[]/g);
                            doc = doc.replace(/^\[(.+)\]$/, '$1');
                            $('#currentDocuments a').attr('href',
                                `{{ asset('storage/documents/${doc}') }}`);
                        }
                    }
                });
            });

            $(document).on('click', '.close', function(e) {
                $('#studentForm')[0].reset();
                $('.id-class').val('');
                $('._method').val('POST');
                $('#currentImage').hide();
                clearValidationErrors();
            });

            $(document).on('click', '#addStudentBtn', function(e) {
                $('#currentImage').hide();
                $('#currentDocuments').hide();
                $('.id-class').val('');
                $('._method').val('POST');
                $('#studentForm')[0].reset();
                clearValidationErrors();

            });

            // Student delete
            $(document).on('click', '.delete-btn', function() {
                var student_id = $(this).val();
                if (confirm('Are you sure you want to delete this student?')) {
                    $.ajax({
                        type: 'POST',
                        url: '/students/' + student_id,
                        data: {
                            "id": student_id,
                            _method: 'delete',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            fetchstudent();
                        }
                    });
                }
            });
        });
    </script>
@endpush
