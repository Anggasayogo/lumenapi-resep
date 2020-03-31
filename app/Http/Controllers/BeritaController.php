<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Berita;

class BeritaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request)
    {
        $response = null;
        $user = (object) ['gambar' => ""];

        if ($request->hasFile('gambar')) {
            $original_filename = $request->file('gambar')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/user/';
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file('gambar')->move($destination_path, $image)) {
                $user->image = '/upload/user/' . $image;
                $data = [
                    'judul' => $request->input('judul'),
                    'kontent_berita' => $request->input('kontent_berita'),
                    'gambar' => 'http://example.com/public/upload/user/'.$image
                ];
                $beritacreated = Berita::create($data);

                if($beritacreated){
                    return $this->responseRequestSuccess($data);
                }else{
                    return $this->responseRequestError('Cannot upload file');
                }
            } else {
                return $this->responseRequestError('Cannot upload file');
            }
        } else {
            return $this->responseRequestError('File not found');
        }
    }

    protected function responseRequestSuccess($data)
    {
        return response()->json(['status' => true,
                                 'message' => 'success created berita',
                                  'data' => $data
                                ], 200)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 500)
    {
        return response()->json(['status' => false,
                                 'error' => $message
                                ], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
    

    public function show(Request $request)
    {
        $data = Berita::get();
        if($data){
            return response()->json([
                'status' => true,
                'message' => 'Data all berita',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data Not be Found!',
                'data' => '',
            ],404);
        }
    }

    public function detail($id)
    {
        $data = Berita::find($id);
        if($data){
            return response()->json([
                'status' => true,
                'message' => 'Detail berita!',
                'data' => $data
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data Not be Found!',
                'data' => '',
            ],404);
        } 
    }

    public function destroyed($id)
    {
        $delete = Berita::destroy($id);
        if($delete){
            return response()->json([
                'status' => true,
                'message' => 'Deleted berita! id '.$id
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Id Not be Found!',
            ],404);
        } 
    }

    public function updated(Request $request)
    {
        $response = null;
        $user = (object) ['gambar' => ""];

        if ($request->hasFile('gambar')) {
            $original_filename = $request->file('gambar')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/user/';
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file('gambar')->move($destination_path, $image)) {
                $user->image = '/upload/user/' . $image;
                $data = [
                    'judul' => $request->input('judul'),
                    'kontent_berita' => $request->input('kontent_berita'),
                    'gambar' => 'http://example.com/public/upload/user/'.$image
                ];
                $beritacreated = Berita::where('id',$request->id)->update($data);

                if($beritacreated){
                    return $this->responseRequestSuccess($data);
                }else{
                    return $this->responseRequestError('Cannot upload file');
                }
            } else {
                return $this->responseRequestError('Cannot upload file');
            }
        } else {
            return $this->responseRequestError('File not found');
        }


    }

}
