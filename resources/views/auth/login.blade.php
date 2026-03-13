<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giriş - 555 İnşaat</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e3a5f 0%, #264653 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
            color: #fff;
        }
        
        .login-logo h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .login-logo p {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        .login-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            padding: 40px;
        }
        
        .login-card h2 {
            color: #1e3a5f;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .form-floating {
            margin-bottom: 20px;
        }
        
        .form-floating .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            height: 60px;
        }
        
        .form-floating .form-control:focus {
            border-color: #1e3a5f;
            box-shadow: 0 0 0 0.2rem rgba(30, 58, 95, 0.25);
        }
        
        .form-floating label {
            padding-left: 15px;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #1e3a5f 0%, #264653 100%);
            border: none;
            border-radius: 10px;
            padding: 15px;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            color: #fff;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(30, 58, 95, 0.4);
        }
        
        .input-group-text {
            background: transparent;
            border: 2px solid #e9ecef;
            border-left: none;
            cursor: pointer;
        }
        
        .form-floating .form-control:not(:placeholder-shown) + label,
        .form-floating .form-control:focus + label {
            color: #1e3a5f;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .footer-text {
            text-align: center;
            color: rgba(255,255,255,0.7);
            margin-top: 30px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <h1>555 İnşaat</h1>
            <p>İşçi İdarəetmə Sistemi</p>
        </div>
        
        <div class="login-card">
            <h2><i class="bi bi-shield-lock me-2"></i>Sistemə Giriş</h2>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-floating">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" placeholder="name@example.com" 
                           value="{{ old('email') }}" required autofocus>
                    <label for="email"><i class="bi bi-envelope me-2"></i>Email ünvanı</label>
                </div>
                
                <div class="form-floating">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" placeholder="Şifrə" required>
                    <label for="password"><i class="bi bi-lock me-2"></i>Şifrə</label>
                </div>
                
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                        Məni yadda saxla
                    </label>
                </div>
                
                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Daxil ol
                </button>
            </form>
            
            <div class="text-center mt-4">
                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #1e3a5f;">
                    <i class="bi bi-key me-1"></i>Şifrəni unutmusunuz?
                </a>
            </div>
        </div>
        
        <p class="footer-text">
            &copy; {{ date('Y') }} 555 İnşaat. Bütün hüquqlar qorunur.
        </p>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
