@extends('layouts.app')

@section('content')
<div class="container">

        <h1 class="text-center m-2 p-2">Users table</h1>
    <div class="btn-group m-2" role="group" aria-label="Basic mixed styles example">
        <h4 class="m-2">filter by role: </h4>
        <a href="/user?role={{'2'}}" class="btn btn-outline-secondary" >director</a>
        <a href="/user?role={{'3'}}" class="btn btn-outline-secondary">partner</a>
        <a href="/user?role={{'4'}}" class="btn btn-outline-secondary">user</a>
    </div>
    <div class="row">

        <div class="col-2">
            @foreach($users_status as $user_status)
                <h5> <span class="badge {{$user_status->status==0?'bg-secondary':'bg-success'}} ">number of {{$user_status->status==0?'inactive':'active'}} users:</span> <b>{{$user_status->count}}</b></h5>
            @endforeach
        </div>
        <div class="col">
            @foreach($users_site as $user_site)
                <h6>number of users in {{$user_site->name}}: <span class="badge bg-primary rounded-pill">{{$user_site->count}}</span></h6>
            @endforeach
        </div>
    </div>

    <div class=" row">
        <div class="col-2 mb-1">
            <a href="/user/export" class="btn btn-success">Export table</a>
        </div>
        <div class="col-5 mb-1">
            <form action="/user/import" method="post" enctype="multipart/form-data">
                @csrf
            <div class="input-group">

                <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="file">
                <button class="btn btn-success" type="submit" id="inputGroupFileAddon04">Import users</button>

            </div>
            </form>

        </div>
        <div class="">
            <form action="/user">
                <div class="input-group mb-3">
                    <input type="text" name="site" class="form-control" placeholder="search by site" aria-label="search" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2">Search</button>
                </div>
            </form>
        </div>

    </div>
        @if(count($users)>0)
            <div class="row">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First_Name</th>
                        <th scope="col">Last_Name</th>
                        <th scope="col">Mail</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Status</th>
                        <th scope="col">Function</th>
                        <th scope="col">Roles</th>
                        <th scope="col">Site</th>
                        @role('super_admin')
                        <th scope="col">edit</th>
                        @endrole

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                        <th scope="row">{{$user->id}}</th>
                        <td>{{$user->name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td><span class="badge {{$user->status==0?'bg-secondary':'bg-success'}} ">
                                {{$user->status==0?'inactive':'active'}}
                            </span>
                        </td>
                        <td>{{$user->function}}</td>
                        <td>
                        @foreach($user->getRoleNames() as $role)
                                <span class="badge {{$role=='user'?'bg-info':($role=='partner'?'bg-warning':($role=='director'?'bg-danger':'bg-primary'))}} ">
                                    {{$role}}
                                </span>
                            @if(!$loop->last),@endif
                        @endforeach
                        </td>
                        <td>{{$user->site->name}}</td>
                        @role('super_admin')
                        <td><a href="/user/{{$user->id}}/edit" class="btn btn-primary ">edit</a></td>
                        @endrole

                    </tr>
                    @endforeach
                    </tbody>
                </table>


            </div>

        @else
            <h1>there are no users available</h1>
        @endif


</div>
@endsection


