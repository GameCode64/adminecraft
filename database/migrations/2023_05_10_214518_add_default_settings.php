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
                    "Key"=>"RconServer",
                    "Value"=>"127.0.0.1"
                ],
                [
                    "Key"=>"RconPort",
                    "Value"=>"25575"
                ],
                [
                    "Key"=>"RconPass",
                    "Value"=>""
                ],
                [
                    "Key"=>"MCServer",
                    "Value"=>"127.0.0.1"
                ],
                [
                    "Key"=>"MCPort",
                    "Value"=>"25565"
                ],
                [
                    "Key"=>"MCLocation",
                    "Value"=>"~/minecraft"
                ],
                [
                    "Key"=>"SFTP",
                    "Value"=>"false"
                ],
                [
                    "Key"=>"SFTPServer",
                    "Value"=>"127.0.0.1"
                ],
                [
                    "Key"=>"SFTPPort",
                    "Value"=>"22"
                ],
                [
                    "Key"=>"SFTPUser",
                    "Value"=>"minecraftuser"
                ],
                [
                    "Key"=>"SFTPPass",
                    "Value"=>"minecraftpass"
                ],
                [
                    "Key"=>"SFTPPublicKey",
                    "Value"=>"~/ssh.pub"
                ]
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
