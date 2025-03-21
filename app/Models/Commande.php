<?php
// app/Models/Commande.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont attribuables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'statut',
        'total',
        'date_commande',
    ];

    protected $casts = [
        'date_commande' => 'datetime',
    ];

    /**
     * Une relation "appartient à" avec l'utilisateur (client).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Une relation "plusieurs à plusieurs" avec les burgers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function burgers()
    {
        return $this->belongsToMany(Burger::class, 'commande_burger')
            ->withPivot('quantite');
    }

    /**
     * Une relation "un à un" avec le paiement.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function paiement()
    {
        return $this->hasOne(Paiement::class);
    }
}

