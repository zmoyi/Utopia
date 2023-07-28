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
        Schema::create('card_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->comment('所属用户ID，可为空');
            $table->unsignedBigInteger('category_id')->nullable()->comment('所属分类ID，可为空');
            $table->unsignedBigInteger('app_id')->nullable()->comment('所属AppID，可为空');
            $table->string('code')->unique()->comment('卡密，唯一索引');
            $table->string('secret_key')->comment('卡密对应的密钥');
            $table->dateTime('expiration_date')->nullable()->comment('过期时间，可为空');
            $table->boolean('is_used')->default(false)->comment('是否已使用，默认为未使用');
            $table->unsignedInteger('usage_limit')->nullable()->comment('使用次数限制，可为空');
            $table->timestamp('activated_at')->nullable()->comment('激活时间，可为空');
            $table->text('note')->nullable()->comment('备注，可为空');
            $table->boolean('active')->default(false)->comment('卡密状态，默认为未激活');
            $table->string('expiration_action')->default('disable')->comment('过期后的操作，默认为停用');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_codes');
    }
};
