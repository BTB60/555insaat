<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Giriş') - 555 İnşaat</title>
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
        }
        
        .login-box {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .login-header i {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 16px;
        }
        
        .login-header h1 {
            font-size: 28px;
            color: #1a1a2e;
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: #666;
        }
        
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-danger {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-group i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.2s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #667eea;
            cursor: pointer;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }
        
        .demo-accounts {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #e0e0e0;
        }
        
        .demo-accounts h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 16px;
            text-align: center;
        }
        
        .demo-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        
        .demo-card {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
        }
        
        .demo-card.admin {
            border-left: 3px solid #667eea;
        }
        
        .demo-card.employee {
            border-left: 3px solid #28a745;
        }
        
        .role-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .demo-card.admin .role-badge {
            background: #e8eaff;
            color: #667eea;
        }
        
        .demo-card.employee .role-badge {
            background: #e8f5e9;
            color: #28a745;
        }
        
        .demo-card p {
            font-size: 13px;
            color: #555;
            margin: 4px 0;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @yield('content')
    
    @stack('scripts')
</body>
</html>