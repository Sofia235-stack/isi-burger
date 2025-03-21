<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture - Commande #{{ $commande->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>Facture - Commande #{{ $commande->id }}</h1>
<p><strong>Client :</strong> {{ $commande->user->name }}</p>
<p><strong>Date de commande :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>

<table>
    <thead>
    <tr>
        <th>Burger</th>
        <th>Prix (CFA)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($commande->burgers as $burger)
        <tr>
            <td>{{ $burger->nom }}</td>
            <td>{{ $burger->prix }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<h3>Total payé : {{ $commande->total }} CFA</h3>
</body>
</html>
