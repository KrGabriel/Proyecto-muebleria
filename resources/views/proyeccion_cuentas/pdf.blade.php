<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style='text-align:center'>Proyecciones</h2>

    @php
        $p_debitos = 0;
        $p_haberes = 0;

        // Sumar todos los débitos y haberes
        foreach ($proyecciones as $p) {
            // Para sumar numéricos, parseamos quitando el signo $ y convirtiendo a float/int
            $debito_num = floatval(str_replace(['$', ','], '', $p->debito));
            $haber_num = floatval(str_replace(['$', ','], '', $p->haber));

            $p_debitos += $debito_num;
            $p_haberes += $haber_num;
        }
    @endphp

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Concepto</th>
                <th>Débito</th>
                <th>Haber</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proyecciones as $p)
                <tr>
                    <td>{{ $p->fecha }}</td>
                    <td>{{ $p->concepto }}</td>
                    <td>{{ $p->debito }}</td>
                    <td>{{ $p->haber }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total débitos: ${{ number_format($p_debitos, 2) }}</h3>
    <h3>Total haberes: ${{ number_format($p_haberes, 2) }}</h3>
</body>
</html>
