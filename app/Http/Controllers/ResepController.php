<?php

namespace App\Http\Controllers;
use App\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;


class ResepController extends Controller
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

    public function show(Request $request)
    {
        $respon = DB::table('resep')
                      ->join('category','resep.category_id','=','category.id')
                      ->join('users','resep.author_id','=','users.id')
                      ->select('resep.*','nama_category','name')
                      ->get();
        if($respon){
            return response()->json([
                'status' => true,
                'message' => 'Success Read Data',
                'data' => $respon
            ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Bad request',
                    'data' => ''
                ],500);
        }               
    }

    public function save(Request $request)
    {
        $response = null;
        $user = (object) ['gambar' => ''];

        if($request->hasFile('gambar')){
            // ambil nama asli file
            $original_filename = $request->file('gambar')->getClientOriginalName();
            // regex .extensifile
            $original_file_arr = explode('.',$original_filename);
            // ambil extensi file dan taro dibagian akhir
            $file_ext = end($original_file_arr);
            // path folder image yang akan di upload
            $destination_path = './upload/user/';
            // ganti nama file menjadi
            $image = 'U-'.time().'.'.$file_ext;

            if($request->file('gambar')->move($destination_path,$image)){
                $user->image = './upload/user/'.$image;
                $data = [
                    'nama_resep' => $request->input('nama_resep'),
                    'gambar' => 'http://example.com/public/upload/user/'.$image,
                    'category_id' => $request->input('category_id'),
                    'deskripsi' => $request->input('deskripsi'),
                    'author_id' => $request->input('author_id')
                ];
                $respon = Resep::create($data);
                if($respon){
                    return $this->responseRequestSuccess($data);
                }else{
                    return $this->responseRequestError('Cannot upload file');
                }
            }else{
                return $this->responseRequestError('Cannot upload file');
            }
        }else{
            return $this->responseRequestError('File not found');
        }
    }

    protected function responseRequestSuccess($data)
    {
        return response()->json([
            'status' => true,
            'message' => 'resep success created!',
            'data' => $data
        ], 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    protected function responseRequestError($message = 'Bad request', $statusCode = 200)
    {
        return response()->json([
            'status' => false,
            'message' => 'resep error created!',
            'data' => ''
        ], $statusCode)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }

    
}
