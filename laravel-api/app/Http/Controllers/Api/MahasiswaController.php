<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index(){
        $mahasiswa  = Mahasiswa::all();

        return new MahasiswaResource(true, 'List Data Mahasiswa', $mahasiswa);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'namamahasiswa' => 'required|string|max:255',
            'nim'           => 'required|string|max:11|unique:mahasiswas',
            'alamat'        => 'required|string|max:255',
            'gender'        => 'required|string|max:255',
            'agama'         => 'required|string|max:50',
            'usia'          => 'required|string|max:3', 
            // 'image'         => 'required|image|mimes:jpeg,png,jpg,zip,svg,webp|max:2048', 
        ],

        [
        'namamahasiswa.required' => "Nama Harus Di Isi",
        'nim.required'           => "Nim Harus Diisi",
        'nim.unique'             => "Nim Tidak Boleh Sama",
        'nim.max'                => "Nim Tidak Boleh Lebih Dari 11 Digit",
        'alamat.required'        => "Alamat Harus Di Isi",
        'gender.required'        => "Gender Harus Di Isi",
        'agama.required'         => "Agama Harus Di Isi",
        'usia.required'          => "Usia Harus Diisi",
        // 'image.required'         => "Image Harus Diisi",
        'usia.max'               => "Usia Tidak Boleh Lebih Dari 3 Digit",
        
        ]);

        //upload image
        // $image =$request->file('image');
        // $image->storeAs('public/mahasiswa', $image->hashName());

        if ($validator->fails()){
            $response["eror"] = TRUE;
            $response["success"] = 0;
            $response["message"] = $validator->errors()->first();
        }else{
            $mahasiswa  = new Mahasiswa;
            $mahasiswa->namamahasiswa = $request->namamahasiswa ;
            $mahasiswa->nim = $request->nim ;
            $mahasiswa->alamat = $request->alamat ;
            $mahasiswa->gender = $request->gender ;
            $mahasiswa->agama = $request->agama ;
            $mahasiswa->usia = $request->usia ;
            // $mahasiswa->image = $image->hashName() ;
            $data  = $mahasiswa->save();
        }

        if ($data !== false ){

            $response["eror"] = FALSE;
            $response["success"] = 1;
            $response["massage"] = "Data Berhasil Di Simpan";

        }else {

            $response["eror"] = TRUE;
            $response["success"] = 0;
            $response["massage"] = "Data Gagal Di Simpan";

        }

        echo json_encode($response);
    }
    public function cari(Request $request){
        $mahasiswa = Mahasiswa::where('namamahasiswa','like','%'.$request->cari.'%')->get();
        
        return new MahasiswaResource(true, 'List Data Mahasiswa', $mahasiswa);
    }
}
