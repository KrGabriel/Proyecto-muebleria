<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .totales {
            margin-top: 20px;
        }

        .totales h3 {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h2>
        Proyecciones
        @if (isset($bancoNombre))
            - {{ ucfirst($bancoNombre) }}
        @endif
    </h2>


    @php
        $p_debitos = 0;
        $p_haberes = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th>¿Entro?</th>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Débito</th>
                <th>Haber</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proyecciones as $p)
                @php
                    $p_debitos += $p->debe ?? 0;
                    $p_haberes += $p->haber ?? 0;
                @endphp
                <tr>
                    <td>{{ $p->entro ? "Sí" : "NO" }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $p->concepto ?? ('Cheque N° ' . $p->numero_cheque) }}</td>
                    <td>${{ number_format($p->debe ?? 0, 2) }}</td>
                    <td>${{ number_format($p->haber ?? 0, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totales">
        <h3>Total débitos: ${{ number_format($p_debitos, 2) }}</h3>
        <h3>Total haberes: ${{ number_format($p_haberes, 2) }}</h3>
    </div>
</body>
</html>
