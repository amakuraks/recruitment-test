<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PenjualanRequest;
use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\Barang;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $result = Penjualan::all();

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
    public function store(PenjualanRequest $request)
    {
        try{
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

            return response()->json([
                'success'   => true,
                'result'    => $penjualan,
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
    public function show(string $id_nota)
    {
        try{
            $penjualan = Penjualan::where('id_nota', strtoupper($id_nota))->first(); 
            
            if(!$penjualan){
                return response()->json([
                    'success'   => false,
                    'result'    => 'not found',
                ], 200);
            }

            return response()->json([
                'success'   => true,
                'result'    => $penjualan,
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
    public function update(PenjualanRequest $request, string $id_nota)
    {
        try{
            $penjualan = Penjualan::where('id_nota', strtoupper($id_nota))->first(); 
            
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
                throw new \Exception("Error creating penjualan");
            }

            $penjualan->barang()->sync($pivot);

            return response()->json([
                'success'   => true,
                'result'    => $penjualan,
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
    public function destroy(string $id_nota)
    {
        try{
            $penjualan = Penjualan::where('id_nota', strtoupper($id_nota))->first(); 
            
            if(!$penjualan){
                return response()->json([
                    'success'   => false,
                    'result'    => 'not found',
                ], 200);
            }

            $penjualan->delete();

            return response()->json([
                'success'   => true,
                'result'    => 'deleted penjualan '.$id_nota,
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
