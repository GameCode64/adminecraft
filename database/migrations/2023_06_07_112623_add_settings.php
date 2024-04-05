<?php

use App\Models\Settings;
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
        Settings::upsert(
            [
                [
                    "Key"=>"ServerTitle",
                    "Value"=>"Minecraft"
                ],
                [
                    "Key"=>"AllowResetPassword",
                    "Value"=>"false"
                ],
                [
                    "Key"=>"AllowRegister",
                    "Value"=>"false"
                ],
            ],
            ["id"]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
