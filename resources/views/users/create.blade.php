@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="text-center m-2">Create a user</h1>
            <div class="col-md-8">
                <form action="/user" method="post" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label for="first name" class="form-label">First name</label>
                        <input type="text" name="name" class="form-control" id="first name" value="{{old('name')}}">
                        @error('name')
                        <p class="text-danger m-1">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="last name" class="form-label">last name</label>
                        <input type="text"  class="form-control" id="last name" name="last_name" value="{{old('last_name')}}">
                        @error('last_name')
                        <p class="text-danger m-1">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="inputPassword4">
                        @error('password')
                        <p class="text-danger m-1">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">phone</label>
                        <input type="number" name="phone" class="form-control" id="phone" value="{{old('phone')}}">
                        @error('phone')
                        <p class="text-danger m-1">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="inputEmail" class="form-label">Mail</label>
                        <input type="email" class="form-control" id="inputEmail" placeholder="name@mail.com" name="email" value="{{old('email')}}">
                        @error('email')
                        <p class="text-danger m-1">{{$message}}</p>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="inputFunction" class="form-label">Function</label>
                        <input type="text" class="form-control" id="inputFunction" name="function" value="{{old('function')}}">
                        @error('function')
                        <p class="text-danger m-1">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="inputStatus" class="form-label">Status</label>
                        <select id="inputStatus" class="form-select" name="status">
                            <option value="0">inactive</option>
                            <option value="1">active</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>roles :</strong></label><br>
                        <label><input type="checkbox" name="roles[]" value="user" {{ (is_array(old('roles')) and in_array("user", old('roles'))) ? ' checked' : '' }}> user</label>
                        <label><input type="checkbox" name="roles[]" value="partner" {{ (is_array(old('roles')) and in_array("partner", old('roles'))) ? ' checked' : '' }}> partner</label>
                        <label><input type="checkbox" name="roles[]" value="director" {{ (is_array(old('roles')) and in_array("director", old('roles'))) ? ' checked' : '' }}> director</label>
                    </div>


                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
        </div>
    </div>
@endsection
