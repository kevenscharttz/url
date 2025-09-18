<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dashboards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('platform', ['powerbi','metabase']);
            $table->text('url');
            $table->enum('visibility', ['public','private'])->default('private');
            $table->enum('scope', ['organization','profile','user']);
            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('dashboards');
        Schema::enableForeignKeyConstraints();
    }
};