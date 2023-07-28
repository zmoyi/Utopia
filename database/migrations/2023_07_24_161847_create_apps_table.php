<?php

use App\Services\AppService;
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
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->comment('所属用户ID，可为空');
            $table->string('name')->comment('App名称');
            $table->enum('type', [AppService::SINGLE_CODE, AppService::MEMBER_VERIFY])->default(AppService::SINGLE_CODE)->comment('App类型：web、mobile、desktop');
            $table->text('public_key')->comment('公钥');
            $table->text('private_key')->comment('私钥');
            $table->json('custom_fields')->nullable()->comment('可自定义字段，使用JSON格式存储');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps');
    }
};
