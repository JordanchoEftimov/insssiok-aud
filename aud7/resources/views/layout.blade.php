<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Layout</title>
</head>
<body>
<header>
    <h1>Welcome to the Admin Dashboard</h1>
    <nav>
        <ul>
            <li><a href="{{ route('clients.index') }}">Clients</a></li>
            <li><a href="{{ route('invoices.index') }}">Invoices</a></li>
        </ul>
    </nav>
</header>

<main>
    @yield('content')
</main>
</body>
</html>
