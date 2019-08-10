<?php

namespace App\Http\Controllers;

use App\Myfiles;
use Illuminate\Http\Request;

class fileController extends Controller
{
    public function index(){
        return view('files');
    }
    public function upload(Request $request){

        $file = $request->file;
        $size = $request->file('file')->getSize();

        $filename = $file->getClientOriginalName();

        $fileModel = new Myfiles;
        $fileModel->file_name = $filename;
        $fileModel->file_path = $file->store('public/my_files');
        $fileModel->file_size = $size;
        $fileModel->save();


        return response()->json(['success'=>'Upload successful']);
    }
}
