<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('burgers', function (Blueprint $table) {
            $table->boolean('archive')->default(false); // Archive un burger
        });
    }

    public function down()
    {
        Schema::table('burgers', function (Blueprint $table) {
            $table->dropColumn(['archive']);
        });
    }

};
