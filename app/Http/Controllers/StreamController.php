<?php

namespace App\Http\Controllers;

use App\Http\Requests\StreamRequest;
use App\Models\stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class StreamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $stream = Stream::paginate(5);
        return view('content-pages.streams.index', compact('stream'));
    }

    public function showData()
    {

        $stream = Stream::all();
        $html = View::make('profile.partials._table2', compact('stream'))->render();
        return response()->json(['success' => true, 'html' => $html]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content-pages.streams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "student_id" => 'required',
            "stream_type" => 'required',
            "is_active" => 'required',
        ]);

        // $id = $request->id;
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->messages()]);
        } else {
            Stream::create($request->all());
            return response()->json(['status' => 200, 'message' => 'Stream created successfully']);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(stream $stream)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $stream = Stream::find($id);
        if ($stream) {
            return response()->json([
                'status' => 200,
                'stream' => $stream,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Stream Data Found.'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stream $stream)
    {
        // dd("check request");

        $validator = Validator::make($request->all(), [
            "student_id" => 'required',
            "stream_type" => 'required',
            "is_active" => 'required',
        ]);
        $id = $request->id;
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->messages()]);
        } else if ($id) {

            $stream->update($request->all());
            return response()->json([
                'status' => 200,
                'message' => 'Stream updated successfully',
            ]);
        }


    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(stream $stream)
    {
        $stream->delete();
        return redirect()->route('streams.index')
            ->with('status', 'Stream deleted successfully');
    }
}
