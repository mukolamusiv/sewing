<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Звіт про виробництво - Замовлення #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .container { width: 100%; padding: 20px; }
        .header { text-align: center; font-size: 22px; font-weight: bold; margin-bottom: 20px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        .summary { font-size: 16px; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Звіт про виробництво - Замовлення #{{ $order->id }}</div>


        <!-- Інформація -->
        <div class="section">
            <h3>Про замовлення</h3>
            <p class="summary">Замовник: {{ $order->company->name }}</p>
            <p class="summary">Виріб: {{ $order->material->name }}</p>
            <p class="summary">Вартість: {{ $order->final_price - $order->cost_price }} грн</p>
            <p class="summary">Статус: {{ $order->status }}</p>
        </div>


        <!-- Етапи виробництва -->
        <div class="section">
            <h3>Етапи виробництва</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Назва етапу</th>
                        <th>Тривалість (год)</th>
                        <th>Виконавець</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->process as $stage)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $stage->step }}</td>
                            <td>{{ $stage->end_time-$stage->start_time }}</td>
                            <td>{{ $stage->user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Використані матеріали -->
        <div class="section">
            <h3>Використані матеріали</h3>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Матеріал</th>
                        <th>Кількість</th>
                        <th>Вартість (грн)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->materials as $material)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $material->material->name }}</td>
                            <td>{{ $material->quantity }}</td>
                            <td>{{ $material->material->unit_cost }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Загальна вартість -->
        <div class="section">
            <h3>Фінансовий звіт</h3>
            <p class="summary">Собівартість: {{ $order->cost_price }} грн</p>
            <p class="summary">Кінцева вартість: {{ $order->final_price }} грн</p>
            <p class="summary">Чистий прибуток: {{ $order->final_price - $order->cost_price }} грн</p>
        </div>
    </div>
</body>
</html>
