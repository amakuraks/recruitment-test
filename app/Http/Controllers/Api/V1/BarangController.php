<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BarangRequest;
use App\Models\Barang;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $result = Barang::all();

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
    public function store(BarangRequest $request)
    {
        try{
            $barang = Barang::create([
                'nama'      => $request->nama,
                'kode'      => $request->kode,
                'kategori'  => $request->kategori,
                'harga'     => $request->harga,
            ]);

            if(!$barang->id){
                throw new \Exception("Error creating barang");
            }

            return response()->json([
                'success'   => true,
                'result'    => $barang,
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
    public function show(string $kode)
    {
        try{
            $barang = Barang::where('kode', strtoupper($kode))->first(); 
            
            if(!$barang){
                return response()->json([
                    'success'   => false,
                    'result'    => 'not found',
                ], 200);
            }

            return response()->json([
                'success'   => true,
                'result'    => $barang,
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
    public function update(BarangRequest $request, string $kode)
    {
        try{
            $barang = Barang::where('kode', strtoupper($kode))->first(); 
            
            if(!$barang){
                return response()->json([
                    'success'   => false,
                    'result'    => 'not found',
                ], 200);
            }

            $barang->nama       = $request->nama;
            $barang->kategori   = $request->kategori;
            $barang->harga   = $request->harga;
            $barang->save();

            return response()->json([
                'success'   => true,
                'result'    => $barang,
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
    public function destroy(string $kode)
    {
        try{
            $barang = Barang::where('kode', strtoupper($kode))->first(); 
            
            if(!$barang){
                return response()->json([
                    'success'   => false,
                    'result'    => 'not found',
                ], 200);
            }

            $barang->delete();

            return response()->json([
                'success'   => true,
                'result'    => 'deleted barang '.$kode,
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
