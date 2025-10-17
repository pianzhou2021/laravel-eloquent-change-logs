<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Pianzhou\EloquentChangeLog\Config;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        collect(Config::migration())->each(function ($columns, $tableName) {
            Schema::create($tableName, function (Blueprint $table) use ($columns) {
                $table->id();
                collect($columns)->each(function ($value, $name) use ($table) {
                    $type = $value[0];
                    $parameters = $value[1] ?? [];
                    $table->addColumn($type, $name, $parameters);
                });
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        collect(Config::migration())->each(function ($columns, $tableName) {
            Schema::dropIfExists($tableName);
        });
    }
};
