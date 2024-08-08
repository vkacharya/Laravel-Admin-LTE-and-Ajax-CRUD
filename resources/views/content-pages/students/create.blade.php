    {{-- @extends('dashboard')
    @section('content')

        <div class="container py-5 h-100">
            <div class="">
                <div class="">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h1 class="mb-4 pb-2 pb-md-0 mb-md-5">
                                @php echo isset($student->id) ? 'Update Student' : 'Add Student'; @endphp
                            </h1>
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
                            {{-- <form id="studentForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <input type="text" id="name" name="name"
                                                class="form-control form-control-lg rounded"
                                                value="{{ old('name', isset($student->name) ? $student->name : '') }}" />
                                            <label class="form-label" for="name">Name</label>
                                            <small class="text-danger">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </small>
                                        </div>
                                        <div class="mb-3" style="margin-top:10px">
                                            <input
                                                class="form-control"value="{{ old('image', isset($student->image) ? $student->image : '') }}"
                                                type="file" id="image" name="image">
                                            <img class="rounded mx-auto d-block"
                                                src="{{ old('image', isset($student->image) ? url(Storage::url($student->image)) : '') }}">
                                            <label for="image" class="form-label rounded">Image</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 d-flex align-items-center">
                                    <div class="form-outline w-100">
                                        <input type="text"
                                            value="{{ old('address', isset($student->address) ? $student->address : '') }}"
                                            name="address" id="address" class="form-control form-control-lg rounded">
                                        <label for="address" class="form-label">Address</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 pb-2">
                                    <div class="form-outline">
                                        <input type="tel" id="contact"
                                            value="{{ old('contact', isset($student->contact) ? $student->contact : '') }}"
                                            name="contact" class="form-control form-control-lg rounded" />
                                        <label class="form-label" for="contact">Phone Number</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 pb-2">
                                    <label for="documents" class="form-label">Documents</label>
                                    <input class="form-control rounded"
                                        value="{{ old('documents', isset($student->documents) ? $student->documents : '') }}"
                                        name="documents[]" type="file" id="documents" multiple>
                                    <a class="rounded mx-auto d-block"
                                        src="{{ old('documents', isset($student->documents) ? url(Storage::url($student->documents)) : '') }}">
                                        {{ isset($student->documents) ? url(Storage::url($student->documents)) : '' }}</a>
                                </div>
                                <div class="mt-4 pt-2">
                                    <input class="btn btn-primary btn-lg" id="{{ isset($student->id) ? 'Update' : 'Add' }}"
                                        type="submit" value="{{ isset($student->id) ? 'Update' : 'Add' }}" />
                                </div>
                            </form> --}}
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
                console.log("11 called!");

                $.ajax({
                    type: "GET",
                    url: '{{ route('student.test') }}',
                    dataType: "json",
                    success: function(response) {
                        console.log(response.success, ' ---> log success');
                        console.log(response.html, ' --> html esp ');
                        if (response.success) {
                            $('#student_data').html(response.html)
                        }


                    }
                });
            }

        });

        $(document).ready(function() {
            $('#studentForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('students.store') }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        window.location.href = "{{ route('students.index') }}"


                    },
                    error: function(response) {
                        console.log(response);

                    }
                });
            });
        });
    </script>
@endpush --}}
