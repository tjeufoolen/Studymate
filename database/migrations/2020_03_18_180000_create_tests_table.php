<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('test_type_id');
            $table->unsignedBigInteger('module_id');
            $table->timestamp('deadline_at')->nullable();
            $table->timestamps();

            $table->foreign('test_type_id')
                ->references('id')
                ->on('test_types');

            $table->foreign('module_id')
                ->references('id')
                ->on('modules')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tests', function(Blueprint $table) {
            $table->dropForeign('test_type_id');
        });
        Schema::dropIfExists('tests');
    }
}
