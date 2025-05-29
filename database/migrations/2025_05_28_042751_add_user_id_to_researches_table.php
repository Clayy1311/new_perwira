<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToResearchesTable extends Migration
{
    public function up()
    {
        Schema::table('researches', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // nullable dulu
        });
    }

    public function down()
    {
        Schema::table('researches', function (Blueprint $table) {
            // Hilangkan dropForeign karena foreign key tidak pernah ada
            if (Schema::hasColumn('researches', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
}
