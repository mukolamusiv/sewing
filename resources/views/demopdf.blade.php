<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Звіт</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Звіт по замовленням</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Замовник</th>
                <th>Статус</th>
                <th>Вартість</th>
                <th>Продукт</th>
                <th>Дата створення</th>
                <th>Дата оновлення</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($orders as $order) --}}
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->company->name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->total_cost }}</td>
                    {{-- <td>{{ $order->template->name }}</td> --}}
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->updated_at }}</td>
                </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>
</body>
</html>
