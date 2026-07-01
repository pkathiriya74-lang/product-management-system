@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-5">


            <div class="card shadow">
                <div class="card-header text-center">
                    <h3>Login</h3>
                </div>

                <div class="card-body">
    

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/login" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Login
                        </button>
                        <p class="text-center mt-3">
                            Don't have an account?
                            <a href="/register">Register here</a>
                        </p>

                    </form>

                </div>
            </div>

        </div>


    </div>

@endsection