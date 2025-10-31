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
        if (! Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('customer_name');
                $table->string('customer_email');
                $table->string('customer_phone', 20);
                $table->string('album_id', 36)->nullable();
                $table->foreign('album_id')->references('id')->on('albums')->nullOnDelete();
                $table->decimal('total_price', 10, 2);
                $table->timestamps();
            });
        } else {
            Schema::table('orders', function (Blueprint $table) {
                if (! Schema::hasColumn('orders', 'album_id')) {
                    $table->string('album_id', 36)->nullable()->after('customer_phone');
                    $table->foreign('album_id')->references('id')->on('albums')->nullOnDelete();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
