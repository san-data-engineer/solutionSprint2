<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExampleEntityTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('example_entity', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->timestamp('created_at')->useCurrent()->index();
      $table->timestamp('updated_at')->useCurrent()->index();
      $table->boolean('active')->index();
      $table->uuid('app_id')->index();

    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('example_entity');
  }
}
