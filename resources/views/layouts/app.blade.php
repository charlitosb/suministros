<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Suministros')</title>
    <style>
        /* ============================================
           SISTEMA DE SUMINISTROS - Estilos Minimalistas
           Autor: Carlos Barrios 202408075
           ============================================ */
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 2rem;
            text-align: center;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        /* Navbar */
        .navbar {
            background-color: #34495e;
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 0;
        }

        .navbar-menu li {
            position: relative;
        }

        .navbar-menu a {
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            padding: 1rem 1.2rem;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .navbar-menu a:hover,
        .navbar-menu a.active {
            background-color: #2c3e50;
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #ecf0f1;
            font-size: 0.9rem;
        }

        .navbar-user span {
            opacity: 0.8;
        }

        .btn-logout {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #c0392b;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        /* Page Title */
        .page-title {
            font-size: 1.5rem;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #3498db;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #eee;
        }

        /* Tables */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-success {
            background-color: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background-color: #219a52;
        }

        .btn-warning {
            background-color: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d68910;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        .btn-sm {
            padding: 0.3rem 0.6rem;
            font-size: 0.8rem;
        }

        .btn-group {
            display: flex;
            gap: 0.5rem;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-control {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.95rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        select.form-control {
            cursor: pointer;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger, .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background-color: #27ae60;
            color: white;
        }

        .badge-danger {
            background-color: #e74c3c;
            color: white;
        }

        .badge-warning {
            background-color: #f39c12;
            color: white;
        }

        .badge-info {
            background-color: #3498db;
            color: white;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.25rem;
            margin-top: 1.5rem;
        }

        .pagination a, .pagination span {
            padding: 0.5rem 0.75rem;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            font-size: 0.85rem;
        }

        .pagination a:hover {
            background-color: #3498db;
            color: white;
            border-color: #3498db;
        }

        .pagination .active span {
            background-color: #3498db;
            color: white;
            border-color: #3498db;
        }

        .pagination .disabled span {
            color: #aaa;
            cursor: not-allowed;
        }

        /* Footer */
        .footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            padding: 1rem;
            margin-top: auto;
        }

        .footer p {
            margin: 0.25rem 0;
            font-size: 0.85rem;
        }

        .footer .author {
            opacity: 0.8;
        }

        /* Utilities */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-success { color: #27ae60; }
        .text-danger { color: #e74c3c; }
        .text-warning { color: #f39c12; }
        .text-muted { color: #7f8c8d; }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }

        /* Filters */
        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .filters .form-group {
            margin-bottom: 0;
            min-width: 150px;
        }

        .filters label {
            font-size: 0.8rem;
            margin-bottom: 0.3rem;
        }

        .filters .form-control {
            padding: 0.5rem;
            font-size: 0.85rem;
        }

        /* Stock Indicators */
        .stock-ok { color: #27ae60; font-weight: 600; }
        .stock-low { color: #f39c12; font-weight: 600; }
        .stock-out { color: #e74c3c; font-weight: 600; }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .stat-card .stat-label {
            font-size: 0.85rem;
            color: #7f8c8d;
            margin-top: 0.25rem;
        }

        .stat-card.success .stat-value { color: #27ae60; }
        .stat-card.warning .stat-value { color: #f39c12; }
        .stat-card.danger .stat-value { color: #e74c3c; }
        .stat-card.info .stat-value { color: #3498db; }

        /* Detail View */
        .detail-row {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #7f8c8d;
            width: 200px;
            flex-shrink: 0;
        }

        .detail-value {
            color: #2c3e50;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-container {
                flex-direction: column;
                padding: 0.5rem;
            }

            .navbar-menu {
                flex-wrap: wrap;
                justify-content: center;
            }

            .navbar-menu a {
                padding: 0.75rem 1rem;
                font-size: 0.8rem;
            }

            .navbar-user {
                padding: 0.5rem;
            }

            .main-content {
                padding: 1rem;
            }

            .filters {
                flex-direction: column;
            }

            .filters .form-group {
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="header">
        <h1>Sistema de Suministros</h1>
    </header>

    <!-- Navbar -->
    @auth
    <nav class="navbar">
        <div class="navbar-container">
            <ul class="navbar-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Inicio
                    </a>
                </li>
                <li>
                    <a href="{{ route('marcas.index') }}" class="{{ request()->routeIs('marcas.*') ? 'active' : '' }}">
                        Marcas
                    </a>
                </li>
                <li>
                    <a href="{{ route('categorias.index') }}" class="{{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                        Categorías
                    </a>
                </li>
                <li>
                    <a href="{{ route('tipos-equipo.index') }}" class="{{ request()->routeIs('tipos-equipo.*') ? 'active' : '' }}">
                        Tipos Equipo
                    </a>
                </li>
                <li>
                    <a href="{{ route('equipos.index') }}" class="{{ request()->routeIs('equipos.*') ? 'active' : '' }}">
                        Equipos
                    </a>
                </li>
                <li>
                    <a href="{{ route('suministros.index') }}" class="{{ request()->routeIs('suministros.*') ? 'active' : '' }}">
                        Suministros
                    </a>
                </li>
                <li>
                    <a href="{{ route('ingresos.index') }}" class="{{ request()->routeIs('ingresos.*') ? 'active' : '' }}">
                        Ingresos
                    </a>
                </li>
                <li>
                    <a href="{{ route('instalaciones.index') }}" class="{{ request()->routeIs('instalaciones.*') ? 'active' : '' }}">
                        Instalaciones
                    </a>
                </li>
                <li>
                    <a href="{{ route('inventario.index') }}" class="{{ request()->routeIs('inventario.*') ? 'active' : '' }}">
                        Inventario
                    </a>
                </li>
            </ul>
            <div class="navbar-user">
                <span>{{ Auth::user()->nombre }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Salir</button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Main Content -->
    <main class="main-content">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>Programación WEB</p>
        <p class="author">Carlos Barrios 202408075</p>
    </footer>

    @stack('scripts')
</body>
</html>
