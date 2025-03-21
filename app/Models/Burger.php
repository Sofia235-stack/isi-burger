<?php
// app/Models/Burger.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont attribuables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prix',
        'image',
        'description',
        'stock',
        'archive',
        'categorie',
    ];

    /**
     * Une relation "plusieurs à plusieurs" avec les commandes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_burger')
            ->withPivot('quantite');
    }
}

