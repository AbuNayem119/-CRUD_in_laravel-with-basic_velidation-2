<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StudentController extends Controller
{
    /**
     * All Students.....
     */
    public function index()
    {
        $all_data = Student::all();
        return view('frontend.index',[
            'all_data'  => $all_data,
        ]);
    }


    /**
     * All Students.....
     */
    public function create()
    {
        return view('frontend.create');
    }


    /**
     * All Students.....
     */
    public function store( Request $request )
    {

        $this -> validate($request, [
            'name'      => 'required',
            'email'     => ['required','email','unique:students'],
            'cell'      => ['required','unique:students'],
            'address'   => 'required',
            'image'     => 'required',
        ]);


        if ($request -> hasFile('image')) {
            $img = $request -> file('image');
            $unique_img_name = md5(time().rand()).".". $img -> getClientOriginalExtension();
            $img -> move( public_path('media/student/') , $unique_img_name);
        }

        Student::create([
            'name' => $request -> name,
            'email' => $request -> email,
            'cell' => $request -> cell,
            'address' => $request -> address,
            'image' => $unique_img_name,
        ]);
        return back()->with('message','Data Sent Successfully !');
    }


    /**
     * All Students.....
     */
    public function edit($id)
    {
        $data = Student::find($id);
        return view('frontend.edit', [
            'all_data' => $data,
        ]);
    }


    /**
     * All Students.....
     */
    public function update(Request $request ,$id)
    {

        $this -> validate($request, [
            'name'  => ['required'],
            'email'  => ['required'],
            'cell'  => ['required'],
            'address'  => ['required'],
            'image'  => ['required'],
        ]);
        
        $data = Student::find($id);
        $unique_img_name ='';
        if ($request -> hasFile('image')) {

            $old_img = 'media/student/'. $data->image;
            if (File::exists($old_img)) {
                File::delete($old_img);
            }

            $img = $request -> file('image');
            $unique_img_name = md5(time().rand()).".". $img -> getClientOriginalExtension();
            $img -> move( public_path('media/student/') , $unique_img_name);

            
            
        }

        $data-> name = $request->name;
        $data-> email = $request->email;
        $data-> cell = $request->cell;
        $data-> address = $request->address;
        $data-> image = $unique_img_name;
        $data -> update();

        return back()->with('message','Data Update Successfully !');

    }


    /**
     * All Students.....
     */
    public function show($id)
    {
        $data = Student::find($id);
        return view('frontend.show', [
            'all_data'  => $data,
        ]);
    }


    /**
     * All Students.....
     */
    public function destroy($id)
    {
        $data = Student::find($id);
        $data -> delete();
        $old_img = 'media/student/'. $data->image;
        if (File::exists($old_img)) {
            File::delete($old_img);
        }
        return back();
    }


































}
