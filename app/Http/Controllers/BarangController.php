<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use App\Models\Barang;
use App\Models\LogActivity;
use App\Http\Requests\BarangRequest;

class BarangController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('barang.index');
    }

    public function tableIndex()
    {
        try{
            $barangs   = Barang::all();
            $final  =   [];

            foreach($barangs as $barang){

                $content = [
                    'id'            => $barang->kode,
                    'kode'          => $barang->kode,
                    'nama'          => $barang->nama,
                    'kategori'      => $barang->kategori,
                    'harga'         => $barang->harga,
                    'created_at'    => $barang->created_at,
                    'last_updated'  => $barang->last_updated,
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
                "controller"    => "BarangController",
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
    public function store(BarangRequest $request)
    {
        try{
            $barang = new Barang;
            $barang->kode       = $request->kode;
            $barang->nama       = $request->nama;
            $barang->kategori   = $request->kategori;
            $barang->harga      = $request->harga;
            $barang->save();

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Created barang ID {$barang->id}",
                "type"          => "Web",
                "controller"    => "BarangController",
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
                "controller"    => "BarangController",
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
            $barang = Barang::where('kode', strtoupper($id))->first();

            return Response::json([
                'success'   => true,
                'data'      => [
                    'id'            => $barang->kode,
                    'kode'          => $barang->kode,
                    'nama'          => $barang->nama,
                    'kategori'      => $barang->kategori,
                    'harga'         => $barang->harga,
                    'created_at'    => $barang->created_at,
                    'last_updated'  => $barang->last_updated,
                ]
            ], 200);
        }
        catch(\Exception $e){
            $LogActivityProcess = LogActivity::create([
                "result"        => false,
                "message"       => "Error: {$e->getMessage()}",
                "type"          => "Web",
                "controller"    => "BarangController",
                "function"      => "Edit",
                "user_id"       =>  Auth::user()->id,
            ]);

            return Response::json([
                'success'   => false,
                'message'   => 'Error or not found'
            ], 404);
        }
    }

    public function update(BarangRequest $request, $id)
    {
        try{
            $barang = Barang::where('kode', strtoupper($id))->first();
            $barang->nama       = $request->nama;
            $barang->kategori   = $request->kategori;
            $barang->harga      = $request->harga;
            $barang->save();

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Updated barang ID {$barang->id}",
                "type"          => "Web",
                "controller"    => "BarangController",
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
                "controller"    => "BarangController",
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
            $barang = Barang::where('kode', strtoupper($id))->first();
            $barang->delete();

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Deleted barang ID {$barang->id}",
                "type"          => "Web",
                "controller"    => "BarangController",
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
                "controller"    => "BarangController",
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

