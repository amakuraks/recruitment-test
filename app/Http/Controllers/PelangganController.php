<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use App\Models\Pelanggan;
use App\Models\LogActivity;
use App\Http\Requests\PelangganRequest;

class PelangganController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pelanggan.index');
    }

    public function tableIndex()
    {
        try{
            $pelanggans   = Pelanggan::all();
            $final  =   [];

            foreach($pelanggans as $pelanggan){

                $content = [
                    'id'            => $pelanggan->id_pelanggan,
                    'id_pelanggan'  => $pelanggan->id_pelanggan,
                    'nama'          => $pelanggan->nama,
                    'domisili'      => $pelanggan->domisili,
                    'jenis_kelamin' => $pelanggan->jenis_kelamin,
                    'created_at'    => $pelanggan->created_at,
                    'last_updated'  => $pelanggan->last_updated,
                ];

                array_push($final, $content);
            }

            return Response::json([
                'success'   => true,
                'data'      => $final,
            ], 200);
        }
        catch(\Exception $e){
            $LogActivityProcess = LogActivity::create([
                "result"        => false,
                "message"       => "Error: {$e->getMessage()}",
                "type"          => "Web",
                "controller"    => "PelangganController",
                "function"      => "tableIndex",
                "user_id"       =>  Auth::user()->id,
            ]);

            return Response::json([
                'success'   => false,
                'message'   => "Error: {$e->getMessage()}"
            ], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PelangganRequest $request)
    {
        try{
            $pelanggan = new pelanggan;
            $pelanggan->id_pelanggan    = $request->id_pelanggan;
            $pelanggan->nama            = $request->nama;
            $pelanggan->domisili        = $request->domisili;
            $pelanggan->jenis_kelamin   = $request->jenis_kelamin;
            $pelanggan->save();

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Created pelanggan ID {$pelanggan->id}",
                "type"          => "Web",
                "controller"    => "PelangganController",
                "function"      => "Store",
                "user_id"       => Auth::user()->id,
            ]);

            return Response::json([
                'success' => true
            ], 201);
        }
        catch(\Exception $e){
            $LogActivityProcess = LogActivity::create([
                "result"        => false,
                "message"       => "Error: {$e->getMessage()}",
                "type"          => "Web",
                "controller"    => "PelangganController",
                "function"      => "Store",
                "user_id"     =>  Auth::user()->id,
            ]);

            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        try{
            $pelanggan = Pelanggan::where('id_pelanggan', strtoupper($id))->first();

            return Response::json([
                'success'   => true,
                'data'      => [
                    'id'            => $pelanggan->id_pelanggan,
                    'id_pelanggan'  => $pelanggan->id_pelanggan,
                    'nama'          => $pelanggan->nama,
                    'domisili'      => $pelanggan->domisili,
                    'jenis_kelamin' => $pelanggan->jenis_kelamin,
                    'created_at'    => $pelanggan->created_at,
                    'last_updated'  => $pelanggan->last_updated,
                ]
            ], 200);
        }
        catch(\Exception $e){
            $LogActivityProcess = LogActivity::create([
                "result"        => false,
                "message"       => "Error: {$e->getMessage()}",
                "type"          => "Web",
                "controller"    => "PelangganController",
                "function"      => "Edit",
                "user_id"       =>  Auth::user()->id,
            ]);

            return Response::json([
                'success'   => false,
                'message'   => 'Error or not found'
            ], 404);
        }
    }

    public function update(PelangganRequest $request, $id)
    {
        try{
            $pelanggan = Pelanggan::where('id_pelanggan', strtoupper($id))->first();
            $pelanggan->nama            = $request->nama;
            $pelanggan->domisili        = $request->domisili;
            $pelanggan->jenis_kelamin   = $request->jenis_kelamin;
            $pelanggan->save();

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Updated pelanggan ID {$pelanggan->id}",
                "type"          => "Web",
                "controller"    => "PelangganController",
                "function"      => "Update",
                "user_id"       => Auth::user()->id,
            ]);

            return Response::json([
                'success' => true
            ], 200);
        }
        catch(\Exception $e){
            $LogActivityProcess = LogActivity::create([
                "result"        => false,
                "message"       => "Error: {$e->getMessage()}",
                "type"          => "Web",
                "controller"    => "PelangganController",
                "function"      => "Update",
                "user_id"       =>  Auth::user()->id,
            ]);

            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $pelanggan = Pelanggan::where('id_pelanggan', strtoupper($id))->first();
            $pelanggan->delete();

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Deleted pelanggan ID {$pelanggan->id}",
                "type"          => "Web",
                "controller"    => "PelangganController",
                "function"      => "Destroy",
                "user_id"       => Auth::user()->id,
            ]);

            return Response::json([
                'success' => true
            ], 200);

        }
        catch(\Exception $e){
            $LogActivityProcess = LogActivity::create([
                "result"        => false,
                "message"       => "Error: {$e->getMessage()}",
                "type"          => "Web",
                "controller"    => "PelangganController",
                "function"      => "Destroy",
                "user_id"     =>  Auth::user()->id,
            ]);

            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

