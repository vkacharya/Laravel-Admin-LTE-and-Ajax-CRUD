@foreach ($stream as $row)
    <tr>
        <td>{{ $row->id }}</td>
        <td>{{ $row->student_id }}</td>
        <td>{{ $row->stream_type }}</td>
        <td>{{ $row->is_active }}</td>


        <td><button value="{{ $row->id }}" data-bs-target="#sreamModal" class="btn btn-primary edit-btn"
                data-bs-toggle="modal">Edit</button>
        </td>
        <td>

            <button type="submit" value="{{ $row->id }}" class="btn btn-danger delete-btn ">
                Delete </button>


        </td>

    </tr>
@endforeach
