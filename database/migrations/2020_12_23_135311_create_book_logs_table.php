<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bookId')->index();
            $table->integer('userId')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('fine',10,2);
            $table->decimal('paid',10,2);
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
        Schema::dropIfExists('book_logs');
    }
}
