<?php
// app/Models/CommandeBurger.php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CommandeBurger extends Pivot
{
    protected $table = 'commande_burger';

    /**
     * Les attributs qui sont attribuables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'commande_id',
        'burger_id',
        'quantite',
    ];
}

