<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gamer_details', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer("UserID");
            $table->integer("DeathCount")->default(0);
            $table->boolean("Whitelisted")->default(false);
            $table->boolean("Banned")->default(false);
            $table->boolean("OPed")->default(false);
            $table->text("Skin")->nullable(true);
            $table->float("LocX")->default(0);
            $table->float("LocY")->default(0);
            $table->float("LocZ")->default(0);
            


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gamer_details');
    }
};
