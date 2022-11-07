<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable()->default(null);
            $table->string('original_name', 255)->nullable()->default(null);
            $table->unsignedBigInteger('size');
            $table->string('mime',30);
            $table->string('path', 255);
            $table->string('disk', 100);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('fileable_id')->nullable()->default(null);
            $table->string('fileable_type')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
