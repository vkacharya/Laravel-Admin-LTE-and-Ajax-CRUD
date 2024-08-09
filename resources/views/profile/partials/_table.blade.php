@foreach ($students as $row)
    <tr>
        <td>{{ $row->id }}</td>
        <td><img src="{{ url(Storage::url($row->image)) }}" width="100px"></td>
        <td>{{ $row->name }}</td>
        <td>{{ $row->address }}</td>
        <td>{{ $row->contact }}</td>
        <td>
            @foreach (unserialize($row->documents) as $documents)
                {{ $documents }} <a href="{{ url(Storage::url($documents)) }}" target="_blank"
                    class="btn btn-info btn-sm">View</a><br>
            @endforeach
        </td>
        <td>
            <button value="{{ $row->id }}" data-bs-target="#studentModal" class="btn btn-primary edit-btn"
                data-bs-toggle="modal">Edit</button>
        </td>
        <td>
            <button type="submit" value="{{ $row->id }}" class="btn btn-danger delete-btn">
                Delete
            </button>
        </td>
    </tr>
@endforeach
