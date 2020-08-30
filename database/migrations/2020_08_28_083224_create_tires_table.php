<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tires', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name',256);
            $table->mediumInteger('width');
            $table->mediumInteger('profile')->nullable();
            $table->string('diameter',50);
            $table->mediumInteger('load_index');
            $table->string('speed_index',3);
            $table->foreignId('vendor_id')->nullable()->constrained('vendor');
            $table->foreignId('model_id')->nullable()->constrained('model');
            $table->string('quantity','10');
            $table->float('price');
            $table->json('missing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tires');
    }
}
