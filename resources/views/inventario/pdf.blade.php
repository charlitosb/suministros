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
            border-left: 4px solid #3498db;
        }

        .filter-info h4 {
            font-size: 10px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .filter-info p {
            font-size: 9px;
            color: #666;
            margin: 2px 0;
        }

        .filter-info span {
            font-weight: bold;
            color: #333;
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

        .stock-ok { color: #27ae60; font-weight: bold; }
        .stock-low { color: #f39c12; font-weight: bold; }
        .stock-out { color: #e74c3c; font-weight: bold; }

        .totals {
            margin-top: 20px;
            border-top: 2px solid #2c3e50;
            padding-top: 15px;
        }

        .totals-grid {
            display: table;
            width: 100%;
        }

        .totals-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }

        .totals-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
        }

        .totals table {
            width: 100%;
            margin: 0;
        }

        .totals th {
            background-color: #34495e;
            text-align: left;
            padding: 6px 10px;
        }

        .totals td {
            text-align: right;
            padding: 6px 10px;
            font-weight: bold;
        }

        .summary-box {
            background-color: #ecf0f1;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .summary-box h4 {
            font-size: 10px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .summary-box .big-number {
            font-size: 16px;
            font-weight: bold;
            color: #27ae60;
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

        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema de Suministros</h1>
        <p>Reporte de Inventario - Generado el {{ date('d/m/Y H:i') }}</p>
    </div>

    @if(count($filtrosAplicados) > 0)
    <div class="filter-info">
        <h4>Filtros Aplicados:</h4>
        @foreach($filtrosAplicados as $nombre => $valor)
            <p>{{ $nombre }}: <span>{{ $valor }}</span></p>
        @endforeach
    </div>
    @endif

    @if($suministros->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">ID</th>
                <th style="width: 28%;">Descripción</th>
                <th style="width: 12%;">Marca</th>
                <th style="width: 13%;">Categoría</th>
                <th style="width: 12%;">Tipo Equipo</th>
                <th style="width: 10%;" class="text-right">Precio</th>
                <th style="width: 8%;" class="text-center">Stock</th>
                <th style="width: 12%;" class="text-right">Valor Total</th>
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
        <div class="totals-grid">
            <div class="totals-left">
                <p style="font-size: 9px; color: #666;">
                    Este reporte incluye {{ $suministros->count() }} producto(s) según los filtros aplicados.
                </p>
            </div>
            <div class="totals-right">
                <table>
                    <tr>
                        <th>Total de Productos:</th>
                        <td>{{ $suministros->count() }}</td>
                    </tr>
                    <tr>
                        <th>Total de Unidades:</th>
                        <td>{{ number_format($totalStock) }}</td>
                    </tr>
                    <tr>
                        <th>Valor del Inventario:</th>
                        <td style="font-size: 11px; color: #27ae60;">Q {{ number_format($valorTotal, 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @else
    <div class="no-data">
        <p>No se encontraron suministros con los filtros seleccionados.</p>
    </div>
    @endif

    <div class="footer">
        <p>Programación WEB</p>
        <p>Carlos Barrios 202408075</p>
    </div>
</body>
</html>
