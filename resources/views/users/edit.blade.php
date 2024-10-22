@extends('layouts.admin')
@section('h1')
    Roles
@endsection
@section('')
@endsection
@section('content')
    <a href="/admin/users" class="btn btn-success">ortga</a>
    <div>
        <form role="form" action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Ism</label>
                <input class="form-control" name="name" type="text" value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" type="email" value="{{ $user->email }}">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="form-control" name="password" type="password">
                <small style="color: #00CA79">Agar parolni yangilamoqchi bo'lmasangiz bo'sh qoldiring</small>
            </div>
            <div class="form-group">
                <label>Roles</label>
                <select name="role" class="form-control">
                    <option>--Tanlash--</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->roles->first()->name == $role->name ? 'selected' : ' '}}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-info">Save</button>
        </form>
    </div>
@endsection
