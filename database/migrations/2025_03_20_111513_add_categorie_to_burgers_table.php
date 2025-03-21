<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddCategorieToBurgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('burgers', function (Blueprint $table) {
            $table->string('categorie')->default('Autre')->after('description');
        });

        // Optionally, update existing records to have a default value
        DB::table('burgers')->update(['categorie' => 'Autre']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('burgers', function (Blueprint $table) {
            $table->dropColumn('categorie');
        });
    }
}
