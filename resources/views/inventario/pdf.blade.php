<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            color: #666;
        }

        .filter-info {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .filter-info p {
            font-size: 9px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #2c3e50;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            text-transform: uppercase;
        }

        td {
            padding: 6px 5px;
            border-bottom: 1px solid #ddd;
            font-size: 9px;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .stock-ok {
            color: #27ae60;
            font-weight: bold;
        }

        .stock-low {
            color: #f39c12;
            font-weight: bold;
        }

        .stock-out {
            color: #e74c3c;
            font-weight: bold;
        }

        .totals {
            margin-top: 20px;
            border-top: 2px solid #2c3e50;
            padding-top: 10px;
        }

        .totals table {
            width: 300px;
            margin-left: auto;
        }

        .totals th {
            background-color: #34495e;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .footer p {
            margin: 2px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema de Suministros</h1>
        <p>Reporte de Inventario - {{ date('d/m/Y H:i') }}</p>
    </div>

    @if($categoriaFiltro)
    <div class="filter-info">
        <p><strong>Filtro aplicado:</strong> Categoría: {{ $categoriaFiltro->nombre_categoria }}</p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 30%;">Descripción</th>
                <th style="width: 12%;">Marca</th>
                <th style="width: 13%;">Categoría</th>
                <th style="width: 12%;">Tipo Equipo</th>
                <th style="width: 10%;" class="text-right">Precio</th>
                <th style="width: 8%;" class="text-center">Stock</th>
                <th style="width: 10%;" class="text-right">Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suministros as $suministro)
            <tr>
                <td>{{ $suministro->id }}</td>
                <td>{{ $suministro->descripcion }}</td>
                <td>{{ $suministro->marca->descripcion }}</td>
                <td>{{ $suministro->categoria->nombre_categoria }}</td>
                <td>{{ $suministro->tipoEquipo->descripcion }}</td>
                <td class="text-right">Q {{ number_format($suministro->precio, 2) }}</td>
                <td class="text-center 
                    @if($suministro->stock == 0) stock-out 
                    @elseif($suministro->stock <= 5) stock-low 
                    @else stock-ok 
                    @endif">
                    {{ $suministro->stock }}
                </td>
                <td class="text-right">Q {{ number_format($suministro->precio * $suministro->stock, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <th>Total de Productos:</th>
                <td class="text-right">{{ $suministros->count() }}</td>
            </tr>
            <tr>
                <th>Total de Unidades:</th>
                <td class="text-right">{{ $totalStock }}</td>
            </tr>
            <tr>
                <th>Valor Total del Inventario:</th>
                <td class="text-right"><strong>Q {{ number_format($valorTotal, 2) }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Programación WEB</p>
        <p>Carlos Barrios 202408075</p>
    </div>
</body>
</html>
