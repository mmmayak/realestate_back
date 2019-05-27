<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
   
    public function index()
    {
        return response()->json(\App\File::select('id','name','description','created_at')->get());
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
        $files = $request->files->all();
        
        $response = array();
        
        foreach ($files as $file) {

            $path = $this->uploadFile($file);
            $createdFile = \App\File::create(['path'=>$path,'name'=>$file->getClientOriginalName()]);
           
            array_push($response, ['id'=> $createdFile->id , 'path' => $createdFile->path ]);
        }
        return response()->json( $response , 201);
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
        Storage::put($path.$file_name,$file);
        return $path.$file_name;
        //File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        //$file->move($path, $file_name);
        //$filePath = '/files/' . $file_name;
        //return $filePath;
    }
}
