<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\LogActivity;
use App\Http\Requests\UserDataRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index');
    }

    public function tableIndex()
    {
        try{
            $users   = User::all();
            $final  =   [];

            foreach($users as $user){

                $content = [
                    'id'            => $user->id,
                    'name'          => $user->name,
                    'email'         => $user->email,
                    'created_at'    => $user->created_at,
                    'last_updated'  => $user->last_updated,
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
                "controller"    => "UserController",
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
    public function store(UserDataRequest $request)
    {
        try{
            $user = new User;
            $user->id           = $request->id;
            $user->name         = $request->name;
            $user->email        = $request->email;
            $user->password     = Hash::make($request->password);
            $user->is_active    = true; 
            $user->save();

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Created user ID {$user->id}",
                "type"          => "Web",
                "controller"    => "UserController",
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
                "controller"    => "UserController",
                "function"      => "Store",
                "user_id"       =>  Auth::user()->id,
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
            $user = User::find($id);
            return Response::json([
                'success'   => true,
                'data'      => [
                    'id'            => $user->id,
                    'name'          => $user->name,
                    'email'         => $user->email,
                    'created_at'    => $user->created_at,
                    'last_updated'  => $user->last_updated,
                ]
            ], 200);
        }
        catch(\Exception $e){
            $LogActivityProcess = LogActivity::create([
                "result"        => false,
                "message"       => "Error: {$e->getMessage()}",
                "type"          => "Web",
                "controller"    => "UserController",
                "function"      => "Edit",
                "user_id"       =>  Auth::user()->id,
            ]);

            return Response::json([
                'success'   => false,
                'message'   => 'Error or not found'
            ], 404);
        }
    }

    public function update(UserDataRequest $request, $id)
    {
        try{
            $user = User::find($id);
            $user->name         = $request->name;
            // $user->email        = $request->email;
            // $user->password     = Hash::make($request->password);
            // $user->is_active    = $request->is_active; 
            $user->save();

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Updated user ID {$user->id}",
                "type"          => "Web",
                "controller"    => "UserController",
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
                "controller"    => "UserController",
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
            $user = User::find($id);
            $user->delete();

            $LogActivityProcess = LogActivity::create([
                "result"        => true,
                "message"       => "Deleted user ID {$id}",
                "type"          => "Web",
                "controller"    => "UserController",
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
                "controller"    => "UserController",
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
