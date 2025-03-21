<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $commande->id }}</title>
</head>
<body>
<h1>Facture pour la commande #{{ $commande->id }}</h1>
<p>Client : {{ $commande->user->name }}</p>
<p>Date de commande : {{ $commande->created_at->format('d/m/Y') }}</p>
<p>Statut : {{ ucfirst($commande->statut) }}</p>

<h3>Détails des burgers :</h3>
<ul>
    @foreach($commande->burgers as $burger)
        <li>{{ $burger->name }} - {{ $burger->price }}€</li>
    @endforeach
</ul>

<h3>Total : {{ $commande->total }}€</h3>
</body>
</html>
