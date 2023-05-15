<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Pelanggan;
use App\Models\Barang;
use App\Models\Penjualan;

use App\Models\LogActivity;
use App\Http\Requests\PenjualanRequest;

class PenjualanController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualans = Penjualan::all();
        return view('penjualan.index', compact('penjualans'));
    }

    public function tableIndex()
    {
        try{
            $penjualans   = Penjualan::all();
            $final  =   [];

            foreach($penjualans as $penjualan){

                $content = [
                    'id'                => $penjualan->id_nota,
                    'id_nota'           => $penjualan->id_nota,
                    'tanggal_transaksi' => $penjualan->tanggal_transaksi,
                    'kode_pelanggan'    => "({$penjualan->kode_pelanggan}) {$penjualan->pelanggan->nama}",
                    'subtotal'          => $penjualan->subtotal,
                    'created_at'        => $penjualan->created_at,
                    'last_updated'      => $penjualan->last_updated,
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
                "controller"    => "PenjualanController",
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
    public function store(penjualanRequest $request)
    {
        try{
            // dd($request);
            $pelanggan = Pelanggan::where('id_pelanggan', strtoupper($request->kode_pelanggan))->first(); 

            // Validasi pelanggan
            if(!$pelanggan){
                return response()->json([
                    'success'   => false,
                    'result'    => 'Invalid pelanggan or pelanggan not found: '.$request->kode_pelanggan,
                ], 200);
            }

            $subtotal   = 0.00;
            $pivot      = [];

            // Validasi barang
            foreach($request->barang as $requestBarang){
                $requestBarang = (object) $requestBarang;
                $barang = Barang::where('kode', strtoupper($requestBarang->kode_barang))->first(); 
            
                if(!$barang){
                    return response()->json([
                        'success'   => false,
                        'result'    => 'Barang not found: '.$requestBarang->kode_barang,
                    ], 200);
                }

                $subtotal += ($barang->harga * $requestBarang->quantity);

                $pivot[$barang->kode] = [
                    'quantity' => $requestBarang->quantity
                ];
            }

            $penjualan = Penjualan::create([
                'id_nota'           => $request->id_nota,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'kode_pelanggan'    => $request->kode_pelanggan,
                'subtotal'          => $subtotal,
            ]);

            if(!$penjualan->id){
                throw new \Exception("Error creating penjualan");
            }

            $penjualan->barang()->sync($pivot);


            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Created penjualan ID {$penjualan->id}",
                "type"          => "Web",
                "controller"    => "PenjualanController",
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
                "controller"    => "PenjualanController",
                "function"      => "Store",
                "user_id"     =>  Auth::user()->id,
            ]);

            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $barangs    = Barang::all();
        return view('penjualan.create', compact('pelanggans','barangs'));
    }

    public function edit($id)
    {
        $penjualan  = penjualan::where('id_nota', strtoupper($id))->first();
        $pelanggans = Pelanggan::all();
        $barangs    = Barang::all();

        return view('penjualan.edit', compact('penjualan','pelanggans','barangs'));
    }

    public function update(penjualanRequest $request, $id)
    {
        try{
            $penjualan = Penjualan::where('id_nota', strtoupper($id))->first(); 
            
            if(!$penjualan){
                return response()->json([
                    'success'   => false,
                    'result'    => 'not found',
                ], 200);
            }

            $pelanggan = Pelanggan::where('id_pelanggan', strtoupper($request->kode_pelanggan))->first(); 

            // Validasi pelanggan
            if(!$pelanggan){
                return response()->json([
                    'success'   => false,
                    'result'    => 'Invalid pelanggan or pelanggan not found: '.$request->kode_pelanggan,
                ], 200);
            }

            $subtotal   = 0.00;
            $pivot      = [];

            // Validasi barang & hitung subtotal
            foreach($request->barang as $requestBarang){
                $requestBarang = (object) $requestBarang;
                $barang = Barang::where('kode', strtoupper($requestBarang->kode_barang))->first(); 
            
                if(!$barang){
                    return response()->json([
                        'success'   => false,
                        'result'    => 'Barang not found: '.$requestBarang->kode_barang,
                    ], 200);
                }

                $subtotal += ($barang->harga * $requestBarang->quantity);

                $pivot[$barang->kode] = [
                    'quantity' => $requestBarang->quantity
                ];
            }

            $penjualan->tanggal_transaksi = $request->tanggal_transaksi;
            $penjualan->kode_pelanggan    = $request->kode_pelanggan;
            $penjualan->subtotal          = $subtotal;
            $penjualan->save();

            if(!$penjualan->id){
                throw new \Exception("Error updating penjualan");
            }

            $penjualan->barang()->sync($pivot);

            return Response::json([
                'success' => true
            ], 200);
        }
        catch(\Exception $e){
            $LogActivityProcess = LogActivity::create([
                "result"        => false,
                "message"       => "Error: {$e->getMessage()}",
                "type"          => "Web",
                "controller"    => "PenjualanController",
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
            $penjualan = penjualan::where('id_nota', strtoupper($id))->first();            
            $penjualan->delete();

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Deleted penjualan ID {$penjualan->id}",
                "type"          => "Web",
                "controller"    => "PenjualanController",
                "function"      => "Destroy",
                "user_id"       => Auth::user()->id,
            ]);

            Alert::success('Nota penjualan berhasil dihapus!');
            return redirect()->route('penjualan.index');

        }
        catch(\Exception $e){
            $LogActivityProcess = LogActivity::create([
                "result"        => false,
                "message"       => "Error: {$e->getMessage()}",
                "type"          => "Web",
                "controller"    => "PenjualanController",
                "function"      => "Destroy",
                "user_id"     =>  Auth::user()->id,
            ]);

            Alert::error('Gagal menghapus nota', $e->getMessage());
            return redirect()->route('penjualan.index');
        }
    }
}

