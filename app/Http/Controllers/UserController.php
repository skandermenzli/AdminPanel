<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Exports\UsersExport;
use App\Exports\UsersExportView;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Imports\UsersImport;
use App\Jobs\SendEmail;
use App\Mail\Welcome;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(UserService $service){
        $users = User::filterByRole()->filterBySite()->get();
        $users_status = $service->usersByStatus();
        $users_site = $service->usersBySite();




       // $users =DB::table('users')
                   // ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                   // ->join('roles', 'roles.id', '=', 'model_has_roles.role_id') select='roles.name as role'
                   // ->where('model_has_roles.role_id','=',request('role'))
                    //->select('users.*')
                    //->get();

       //$users2 = User::all($users);
       //dd($users2);

        return view('home')->with(compact('users','users_site','users_status'));

    }
    public function create(){
        return view('users.create');
    }

    public function store(StoreRequest $request,UserService $service){

        $service->store($request);
       /* $user = User::create($request->except(['roles']));
        $user->assignRole($request->input('roles'));
       // Mail::to($user)->send(new welcome($user));
        UserCreated::dispatch($user);
       ###########

        /*
        $status = Password::sendResetLink(
            $request->only('email')
        );
        Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
        */
        return redirect('home');

    }


    public function edit(User $user){
        //dd($user->getRoleNames());
        return view('users.edit')->with(compact('user'));
    }


    public function update(UpdateRequest $request,User $user,UserService $service){
        $service->update( $request,$user);
        /*$user->update($request->except(['roles']));
        $user->roles()->detach();
        $user->assignRole($request->input('roles'));*/
        return redirect('home');

    }

    public function export()
    {
        return Excel::download(new UsersExportView, 'users.xlsx');
    }

    public function import(Request $request)
    {
        //dd($request);
        $import = new UsersImport();
        Excel::import($import, $request->file->path());

        foreach ($import->users as $user){
            $this->dispatch(new SendEmail($user));
        }

        return redirect('home')->with('success', 'All good!');
    }



    public function stats(){
        $users_status = DB::table('users')
                             ->select(DB::raw('count(*) as count,status'))
                             ->groupBy('status')
                             ->get();

        $users_sites = DB::table('users')
            ->join('sites','site_id','sites.id')
            ->select(DB::raw('count(*) as count,sites.name'))
            ->groupBy('sites.name')
            ->get();
        $users_status1 = User::select("status", DB::raw("count(*) as user_count"))
            ->groupBy('status')
            ->get();

        dd($users_status);
    }

    public function collection(){
        $collection = collect([1, 2, 3, 4, 5]);
       $test = $collection->contains(function ($value, $key) {
            return $value > 4;
        });
       Log::channel("custom")->critical("log test");

        dd($collection->sum());

    }

}
