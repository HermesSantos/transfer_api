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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->integer('manager_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('balance')->default(0);
            $table->timestamps();

            /**
             * Added the foreign keys
             */
            $table->foreign('user_id')
                ->references('id')
                ->on('common_users');

            $table->foreign('manager_id')
                ->references('id')
                ->on('managers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
