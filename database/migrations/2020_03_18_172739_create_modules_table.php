<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->integer('credits');
            $table->unsignedBigInteger('coordinator_id');
            $table->unsignedBigInteger('term_id');
            $table->timestamps();

            $table->foreign('coordinator_id')
                ->references('id')
                ->on('teachers')
                ->onDelete('cascade');

            $table->foreign('term_id')
                ->references('id')
                ->on('terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function(Blueprint $table) {
            $table->dropForeign('test_id');
            $table->dropForeign('coordinator_id');
            $table->dropForeign('term_id');
        });
        Schema::dropIfExists('modules');
    }
}
