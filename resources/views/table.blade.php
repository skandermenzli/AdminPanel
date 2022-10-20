
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
                <td> {{$user->status}} </td>
                <td>{{$user->function}}</td>
                <td>
                    @foreach($user->getRoleNames() as $role)
                                    {{$role}}
                        @if(!$loop->last),@endif
                    @endforeach
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
