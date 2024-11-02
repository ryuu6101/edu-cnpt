@extends('login.layouts.master')

@section('title', 'Đăng nhập')

@section('contents')

<!-- Login form -->
<form class="login-form" action="{{ route('login.auth') }}" method="POST">
    @method('post')
    @csrf
    <div class="card mb-0">
        <div class="card-body">
            <div class="text-center mb-3">
                <i class="icon-reading icon-2x text-secondary border-secondary border-3 rounded-pill p-3 mb-3 mt-1"></i>
                <h5 class="mb-0">Đăng nhập</h5>
                <span class="d-block text-muted">Vui lòng nhập thông tin</span>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="text" class="form-control" placeholder="Tên tài khoản" name="username" value="{{ old('username') }}">
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
                @error('username')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left">
                <input type="password" class="form-control" placeholder="Mật khẩu" name="password">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
                @error('password')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
            </div>

            <div class="text-center">
                {{-- <a href="login_password_recover.html">Forgot password?</a> --}}
            </div>
        </div>
    </div>
</form>
<!-- /login form -->

@endsection