<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserWebHookResource;
use App\Mail\Welcome;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Spatie\WebhookServer\WebhookCall;

class UserController extends Controller
{
    public function test(){
        //$role = Role::create(['name' => 'partner']);
        //return Carbon::now()->toDateTimeString();
        return  User::whereDate('created_at',Carbon::now()->subDays(2)->format('Y-m-d'))->get();
        //return Carbon::now()->subDays(2)->format('Y-m-d');
    }

    public function login(Request $request){
        $creds = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $creds['email'])->first();

        // Check password
        if(!$user || !Hash::check($creds['password'], $user->password)) {
            return response([
                'message' => 'wrong email or password'
            ], 401);
        }
        $token = $user->createToken($user->email)->plainTextToken;




        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        //$request->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function store(StoreRequest $request){

        $user = User::create($request->except(['roles',]));
        $user->assignRole(explode(",",$request->input('roles')));
        //Mail::to($user)->send(new welcome($user));
        WebhookCall::create()
            ->url('http://blog-site.test/webhook-receiving-url')
            ->payload(['user' => new UserWebHookResource($user)])
            ->useSecret('mysecret')
            ->dispatch();
        return new UserResource($user);

        /*$token = $user->createToken($user->email)->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];*/

        //Mail::to($user)->send(new welcome($user));
        /*return[
            'user' => $user
        ];*/
    }

    public function update(UpdateRequest $request,User $user){

        $user->update($request->except(['roles']));
        $user->syncRoles(explode(",",$request->input('roles')));
        return new UserResource($user);
    }

    public function list(){
        //return new UserCollection(User::all());
        return new  UserCollection(Cache::remember('users',60*60,function (){
            return User::all();
        }));
    }
    public function show(User $user){
        return new UserResource($user);
    }

    public function delete(User $user){
        $user->roles()->detach();
        $user->delete();
        return [
            'message' => 'User deleted'
        ];
    }
}
