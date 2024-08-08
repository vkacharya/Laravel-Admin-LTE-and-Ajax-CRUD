@foreach ($students as $row)
    <tr>
        <td>{{ $row->id }}</td>

        <td><img src="{{ asset('storage/images/' . $row->image) }}" width="100px"></td>
        </td>
        <td>{{ $row->name }}</td>
        <td>{{ $row->address }}</td>
        <td>{{ $row->contact }}</td>
        <td> {{ $row->documents }}</td>
        <td>
            @foreach ((array) $row->documents as $document)
                <a href="{{ asset('storage/documents/' . $document) }}" target="_blank"
                    class="btn btn-info btn-sm">View</a>
            @endforeach
        </td>

        <td><button value="{{ $row->id }}" data-bs-target="#studentModal" class="btn btn-primary edit-btn"
                data-bs-toggle="modal">Edit</button>
        </td>
        <td>

            <button type="submit" value="{{ $row->id }}" class="btn btn-danger delete-btn ">
                Delete </button>


        </td>

    </tr>
@endforeach
