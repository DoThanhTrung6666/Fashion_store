@extends('layout.client')
@section('content')
<div class="container w-50">
    <h1>register</h1>
    @if (session('message'))
    <div class="alert alert-success">
        {{session('message')}}
    </div>
        
    @endif
    <form action="{{ route('userRegister') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="" class="form-label">name</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Username</label>
            <input type="text" name="username" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
        <div class="mb-3">
            <a href="{{ route('userLogin') }}">Login</a>
        </div>
    </form>
</div>
@endsection
