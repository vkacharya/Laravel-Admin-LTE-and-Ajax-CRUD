<?php

namespace App\Http\Controllers;

use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

use function PHPUnit\Framework\fileExists;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $student = student::paginate(5);

        $students = student::all();
        // $html = View::make('content-pages.students.index', compact('students'))->render();

        // return response()->json(['success' => true, 'html' => $html]);
        return view('content-pages.students.index', compact('students'));

    }

    public function test()
    {
        $students = student::all();
        $html = View::make('profile.partials._table', compact('students'))->render();
        return response()->json(['success' => true, 'html' => $html]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content-pages.students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd("called");
        // $validated = StudentStoreRequest::validated();

        // if ($request->has('image')) {
        //     $validated = $request->file('image')->store('students/images', ['disk' => 'public']);
        // }
        // if ($request->has('documents')) {
        //     foreach($request->has('documents'))
        //     $validated['image_name'] = $request->file('image_name')->store('students/images', ['disk' => 'public']);
        // }





        $validator = Validator::make(
            $request->all(),
            [
                "name" => 'required',
                "image" => 'required|image|mimes:png,jpg,jpeg',
                "address" => 'required',
                "contact" => 'required',
                "documents" => 'required',
                "documents.*" => 'mimes:pdf',
            ],
            $messages = [
                "documents.required" => "You must upload at least one file",
            ]
        );
        // dd(Validator::make($request->all(), ["documents.*" => 'required|mimes:pdf'])->validate());


        if ($validator->fails()) {
            // dd($validator->errors()->all());
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);

        } else {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('images', $imageName, ['disk' => 'public']);

            $documentNames = [];
            foreach ($request->file('documents') as $document) {
                $documentName = time() . '_' . $document->getClientOriginalName();
                $document->storeAs('documents', $documentName, ['disk' => 'public']);
                $documentNames[] = $documentName;
            }

            Student::create([
                "name" => $request->name,
                "image" => $imageName,
                "address" => $request->address,
                "contact" => $request->contact,
                "documents" => json_encode($documentNames),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Student created successfully',
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                'status' => 200,
                'student' => $student,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Student Found.'
            ]);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd("11");

        $validator = Validator::make($request->all(), [
            "name" => 'required',
            "image" => 'image|mimes:png,jpg,jpeg',
            "address" => 'required',
            "contact" => 'required',
            "documents.*" => 'mimes:pdf'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $student = Student::find($id);

            if (!$student) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No Student Found.'
                ]);
            }

            $imageName = $student->image;
            if ($request->hasFile('image')) {
                if (Storage::exists('public/images/' . $imageName)) {
                    Storage::delete('public/images/' . $imageName);
                }
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('images', $imageName, ['disk' => 'public']);
            }

            $documentNames = json_decode($student->documents, true);
            if ($request->hasFile('documents')) {
                foreach ($documentNames as $documentName) {
                    if (Storage::exists('public/documents/' . $documentName)) {
                        Storage::delete('public/documents/' . $documentName);
                    }
                }
                $documentNames = [];
                foreach ($request->file('documents') as $document) {
                    $documentName = time() . '_' . $document->getClientOriginalName();
                    $document->storeAs('documents', $documentName, ['disk' => 'public']);
                    $documentNames[] = $documentName;
                }
            }

            $student->update([
                "name" => $request->name,
                "image" => $imageName,
                "address" => $request->address,
                "contact" => $request->contact,
                "documents" => json_encode($documentNames),
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Student updated successfully from update',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        Storage::delete('public' . '/' . $student->image);
        if (Storage::exists('public/documents/' . $student->documents))
            foreach (json_decode($student->documents, true) as $documentName) {
                Storage::delete('public' . '/' . $documentName);
            }

        if ($student) {
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Student Deleted Successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Student Found.'
            ]);
        }
    }
}



