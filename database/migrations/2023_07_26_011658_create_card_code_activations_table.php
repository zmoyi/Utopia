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
        Schema::create('card_code_activations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('card_code_id')->index();
            $table->unsignedBigInteger('user_id');
            $table->timestamp('activated_at')->nullable();
            $table->string('activation_ip')->nullable()->comment('激活IP地址');
            $table->string('activation_device')->nullable()->comment('激活设备信息');
            $table->text('activation_app_signature')->nullable()->comment('激活App签名');
            $table->unsignedBigInteger('app_id')->nullable()->comment('关联的App ID');
            $table->unsignedTinyInteger('activation_count')->default(0)->comment('激活次数');
            $table->boolean('is_single_use')->default(true)->comment('是否为一次性卡密，为true表示只能激活一次，为false表示可多次激活');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_code_activations');
    }
};
