<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Endpoints</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 2rem; }
        h1 { color: #333; }
        table { border-collapse: collapse; width: 100%; background: #fff; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #007bff; color: #fff; }
        tr:nth-child(even) { background: #f2f2f2; }
        a { color: #007bff; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Available API Endpoints</h1>
    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th>URL</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($apiRoutes as $route)
                <tr>
                    <td>{{ $route['method'] }}</td>
                    <td><a href="{{ $route['url'] }}" target="_blank">{{ $route['url'] }}</a></td>
                    <td>{{ $route['desc'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top:2rem;color:#888;">Tip: Use a tool like Postman for POST/PUT/DELETE requests.</p>
</body>
</html>
