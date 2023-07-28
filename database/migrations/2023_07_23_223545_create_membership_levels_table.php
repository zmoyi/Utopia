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
        Schema::create('membership_levels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('会员级别的名称');
            $table->string('slug')->unique()->comment('会员级别的别名');
            $table->unsignedInteger('card_codes_quota')->default(0)->comment('该级别会员可生成的卡密数量限额');
            $table->integer('validity_period')->default(0)->comment('会员级别的有效期，以天为单位');
            $table->decimal('price', 10, 2)->default(0)->comment('会员级别的价格');
            $table->decimal('discount', 5, 2)->default(0)->comment('会员级别的折扣比例，范围在 0-1 之间');
            $table->text('description')->nullable()->comment('会员级别的描述，用于介绍该会员级别的特点和权益');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_levels');
    }
};
