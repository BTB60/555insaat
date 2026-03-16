@extends('layouts.guest')

@section('title', 'Giriş')

@section('content')
<div class="login-page">
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <i class="bi bi-building"></i>
                <h1>555 İnşaat</h1>
                <p>İşçi İdarəetmə Sistemi</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf
                <div class="form-group">
                    <label>İstifadəçi adı və ya Email</label>
                    <div class="input-group">
                        <i class="bi bi-person"></i>
                        <input type="text" name="email" class="form-control" placeholder="Email" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label>Şifrə</label>
                    <div class="input-group">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" class="form-control" placeholder="Şifrə" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Daxil ol
                </button>
            </form>

            <div class="demo-accounts">
                <h3><i class="bi bi-info-circle"></i> Demo Hesablar</h3>
                <div class="demo-grid">
                    <div class="demo-card admin">
                        <span class="role-badge">Admin</span>
                        <p><strong>İstifadəçi:</strong> admin</p>
                        <p><strong>Şifrə:</strong> admin123</p>
                    </div>
                    <div class="demo-card employee">
                        <span class="role-badge">İşçi</span>
                        <p><strong>İstifadəçi:</strong> murad</p>
                        <p><strong>Şifrə:</strong> 123456</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.querySelector('input[name="password"]');
    const icon = document.querySelector('.toggle-password i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
@endsection
