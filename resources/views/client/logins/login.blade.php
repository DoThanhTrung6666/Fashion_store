@extends('layout.client')
@section('content')
<div class="container w-50">
    <h1>Login</h1>
    
    @if (session('errorLogin'))
    <div class="alert alert-danger">
        {{session('errorLogin')}}
    </div>
        
    @endif
    <form action="{{ route('userLogin') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="" class="form-label">Username</label>
            <input type="name" name="username" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
        <div class="mb-3">
            <a href="{{ route('userRegister') }}">Register</a>
        </div>
    </form>
</div>
@endsection
