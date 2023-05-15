<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use App\Models\LogActivity;
use App\Http\Requests\TokenRequest;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('token.index');
    }

    public function tableIndex()
    {
        try{
            $user   = Auth::user();
            $tokens = $user->tokens;
            $final  =   [];

            foreach($tokens as $token){

                $content = [
                    'id'            => $token->id,
                    'label'         => $token->name,
                    'created_at'    => $token->created_at,
                    'last_used'     => $token->last_used_at,
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
                "controller"    => "TokenController",
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TokenRequest $request)
    {
        try{
            $user   = Auth::user();
            $token  = $user->createToken($request->label);

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Created token {$request->label}",
                "type"          => "Web",
                "controller"    => "TokenController",
                "function"      => "Store",
                "user_id"       => Auth::user()->id,
            ]);

            return Response::json([
                'success'   => true,
                'token'     => $token->plainTextToken,
            ], 201);
        }
        catch(\Exception $e){
            $LogActivityProcess = LogActivity::create([
                "result"        => false,
                "message"       => "Error: {$e->getMessage()}",
                "type"          => "Web",
                "controller"    => "TokenController",
                "function"      => "Store",
                "user_id"       =>  Auth::user()->id,
            ]);

            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $user   = Auth::user();
            $result = $user->tokens()->where('id', $id)->delete();

            if(!$result){
                throw new \Exception("Failed deleting token");
            }

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Deleted token ID {$id}",
                "type"          => "Web",
                "controller"    => "TokenController",
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
                "controller"    => "TokenController",
                "function"      => "Destroy",
                "user_id"       =>  Auth::user()->id,
            ]);

            return Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
