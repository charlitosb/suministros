<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Suministros</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #2c3e50;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #1a252f;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .login-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-card {
            background: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }

        .login-card h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #2980b9;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .footer {
            background-color: #1a252f;
            color: #ecf0f1;
            text-align: center;
            padding: 1rem;
        }

        .footer p {
            margin: 0.25rem 0;
            font-size: 0.85rem;
        }

        .footer .author {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <header class="header">
        <h1>Sistema de Suministros</h1>
    </header>

    <div class="login-container">
        <div class="login-card">
            <h2>Iniciar Sesión</h2>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" 
                           id="usuario" 
                           name="usuario" 
                           class="form-control" 
                           value="{{ old('usuario') }}"
                           placeholder="Ingrese su usuario"
                           required 
                           autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control" 
                           placeholder="Ingrese su contraseña"
                           required>
                </div>

                <button type="submit" class="btn-login">Ingresar</button>
            </form>
        </div>
    </div>

    <footer class="footer">
        <p>Programación WEB</p>
        <p class="author">Carlos Barrios 202408075</p>
    </footer>
</body>
</html>
