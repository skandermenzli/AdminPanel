<?php

namespace App\Services;

use App\Events\UserCreated;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{

    public function store(StoreRequest $request){
        $user = User::create($request->except(['roles']));
        $user->assignRole($request->input('roles'));
        // Mail::to($user)->send(new welcome($user));
        UserCreated::dispatch($user);
    }

    public function update(UpdateRequest $request,User $user){
        $user->update($request->except(['roles']));
        $user->roles()->detach();
        $user->assignRole($request->input('roles'));
    }

    public function usersByStatus(){
        return DB::table('users')
            ->select(DB::raw('count(*) as count,status'))
            ->groupBy('status')
            ->get();
    }
    public function usersBySite(){
        return DB::table('users')
            ->join('sites','site_id','sites.id')
            ->select(DB::raw('count(*) as count,sites.name as name'))
            ->groupBy('sites.name')
            ->get();
    }

}
