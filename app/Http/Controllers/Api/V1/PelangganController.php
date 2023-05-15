<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PelangganRequest;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $result = Pelanggan::all();
            
            return response()->json([
                'success'   => true,
                'result'    => $result,
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'success'    => false,
                'message'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PelangganRequest $request)
    {
        try{
            $pelanggan = Pelanggan::create([
                'id_pelanggan'  => $request->id_pelanggan,
                'nama'          => $request->nama,
                'domisili'      => $request->domisili,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);

            if(!$pelanggan->id){
                throw new \Exception("Error creating pelanggan");
            }

            return response()->json([
                'success'   => true,
                'result'    => $pelanggan,
            ], 201);
        }
        catch(\Exception $e){
            return response()->json([
                'success'    => false,
                'message'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pelanggan)
    {
        try{
            $pelanggan = Pelanggan::where('id_pelanggan', strtoupper($id_pelanggan))->first(); 
            
            if(!$pelanggan){
                return response()->json([
                    'success'   => false,
                    'result'    => 'not found',
                ], 200);
            }

            return response()->json([
                'success'   => true,
                'result'    => $pelanggan,
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'success'    => false,
                'message'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PelangganRequest $request, string $id_pelanggan)
    {
        try{
            $pelanggan = Pelanggan::where('id_pelanggan', strtoupper($id_pelanggan))->first(); 
            
            if(!$pelanggan){
                return response()->json([
                    'success'   => false,
                    'result'    => 'not found',
                ], 200);
            }

            $pelanggan->nama            = $request->nama;
            $pelanggan->domisili        = $request->domisili;
            $pelanggan->jenis_kelamin   = $request->jenis_kelamin;
            $pelanggan->save();

            return response()->json([
                'success'   => true,
                'result'    => $pelanggan,
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'success'    => false,
                'message'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_pelanggan)
    {
        try{
            $pelanggan = Pelanggan::where('id_pelanggan', strtoupper($id_pelanggan))->first(); 
            
            if(!$pelanggan){
                return response()->json([
                    'success'   => false,
                    'result'    => 'not found',
                ], 200);
            }

            $pelanggan->delete();

            return response()->json([
                'success'   => true,
                'result'    => 'deleted pelanggan '.$id_pelanggan,
            ], 200);
        }
        catch(\Exception $e){
            return response()->json([
                'success'    => false,
                'message'   => $e->getMessage(),
            ], 500);
        }
    }
}
