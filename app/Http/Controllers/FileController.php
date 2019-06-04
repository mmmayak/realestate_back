<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
   
    public function index()
    {
        return response()->json(\App\File::select('id','path','name','description','created_at')->get());
    }
        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFile(\App\File $file){

        $contentType =  mime_content_type( storage_path('app/' . $file->path) );
        
        $headers = array(
            'Content-Type: ' . $contentType ,
        );
        
        //return Storage::download($file->path,$file->name,$headers);
        return response()->download(storage_path('app/'.$file->path),$file->name,$headers);

    }
    public function store(Request $request)
    {
        //
        //'file' => 'required|max:10000|mimes:doc,docx'
        $validator = Validator::make($request->all(), [
            'file' => 'file|required|max:10000|mimes:pdf',
            'name' => 'required|max:256|min:3',
            'description' => 'required|max:256|min:3',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages(), 'status' => 400],400);
        }
        

        $file = $request->file('file');
        $path = $this->uploadFile($file);
        $createdFile = \App\File::create(['path'=>$path,'name'=>$request->input('name')/*$file->getClientOriginalName()*/,'description'=>$request->input('description')]);
           
        return response()->json( $createdFile , 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\App\File $file)
    {
        // delete local file
        Storage::delete($file->path);
        // delete row from DB
        $file->delete();
          // return response
          return response()->json([
             'message' => 'File : '.$file->id.' deleted '
         ],200);
    }

    private function uploadFile($file)
    {
        $file_name = rand() . '.' . $file->getClientOriginalExtension();
        $path = ('/files/private/');
        Storage::putFileAs($path, $file, $file_name);
        return $path.$file_name;
        
    }
}
