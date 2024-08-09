<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use Exception;
use App\Models\student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\JsonResponse;

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
    public function store(StudentStoreRequest $request)
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


        try {
            $validator = $request->validated();
            //dump()
            // $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            // $validator['image'] = $imageName;
            // dd($validator)
            // $documentNames = [];
            $validator['image'] = $validator['image']->store('images', ['disk' => 'public']);
            $documentNames = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $documentNames[] = $document->store('documents', ['disk' => 'public']);
                }
                $validator['documents'] = serialize($documentNames);
            }

            // dd($validator);

            Student::create($validator);

            return response()->json(['status' => 200, 'message' => 'Stream created successfully']);
        } catch (Exception $e) {

            return response()->json([

                'status' => 400,
                'message' => 'Validation Error',
                'errors' => $e->getMessage()
            ]);
        }



        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         "name" => 'required',
        //         "image" => 'required|image|mimes:png,jpg,jpeg',
        //         "address" => 'required',
        //         "contact" => 'required',
        //         "documents" => 'required',
        //         "documents.*" => 'mimes:pdf',
        //     ],
        //     $messages = [
        //         "documents.required" => "You must upload at least one file",
        //     ]
        // );
        // // dd(Validator::make($request->all(), ["documents.*" => 'required|mimes:pdf'])->validate());


        // if ($validator->fails()) {
        //     // dd($validator->errors()->all());
        //     return response()->json([
        //         'status' => 400,
        //         'errors' => $validator->messages()
        //     ]);

        // } else {
        //     $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        //     $request->file('image')->storeAs('images', $imageName, ['disk' => 'public']);

        //     $documentNames = [];
        //     foreach ($request->file('documents') as $document) {
        //         $documentName = time() . '_' . $document->getClientOriginalName();
        //         $document->storeAs('documents', $documentName, ['disk' => 'public']);
        //         $documentNames[] = $documentName;
        //     }

        //     Student::create([
        //         "name" => $request->name,
        //         "image" => $imageName,
        //         "address" => $request->address,
        //         "contact" => $request->contact,
        //         "documents" => json_encode($documentNames),
        //     ]);

        //     return response()->json([
        //         'status' => 200,
        //         'message' => 'Student created successfully',
        //     ]);
        // }
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
                'docs' => unserialize($student->documents)
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
    public function update(StudentUpdateRequest $request, $id)
    {
        // dd("11", $request->id);

        try {
            $student = Student::find($id);
            $validator = $request->validated();
            // dump($student);
            $imageName = $student->image;
            if ($request->hasFile('image')) {
                if (Storage::exists('public' . '/' . $imageName)) {
                    Storage::delete('public' . '/' . $imageName);
                }
                $validator['image'] = $validator['image']->store('images', ['disk' => 'public']);
            }
            // dd($validator);

            $documentNames = [];
            // dd($request->hasFile('documents'));

            // dd($documentNames = unserialize($student->documents));
            if ($request->hasFile('documents')) {
                foreach (unserialize($student->documents) as $documentName) {
                    if (Storage::exists('public' . '/' . $documentName)) {
                        Storage::delete('public' . '/' . $documentName);
                    }
                }

                foreach ($request->file('documents') as $document) {
                    $documentNames[] = $document->store('documents', ['disk' => 'public']);
                }
                $validator['documents'] = serialize($documentNames);

            }


            // dd($validator);
            $validator = Student::find($id)->update($validator);
        } catch (Exception $e) {

            return response()->json([

                'status' => 400,
                'message' => 'Validation Error',
                'errors' => $e->getMessage()
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $request, $id)
    {
        $student = Student::find($id);
        // dd($student['documents']);
        Storage::delete('public' . '/' . $student->image);
        if (fileExists($student->documents)) {
            foreach (unserialize($student->documents) as $documentName) {

                Storage::delete('public' . '/' . $documentName);

            }
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




