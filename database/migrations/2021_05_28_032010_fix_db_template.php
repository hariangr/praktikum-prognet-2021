<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Databasenya banyak yg error
// Terpaksa fix sendiri
class FixDbTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_category_details', function (Blueprint $table) {
            $table->dropColumn('updated_at');
        });
        Schema::table('product_category_details', function (Blueprint $table) {
            $table->timestamp("updated_at")->nullable();
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('profile_image');
            $table->dropColumn('phone');
        });
        Schema::table('admins', function (Blueprint $table) {
            $table->string("profile_image")->nullable();
            $table->string("phone")->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_image');
            $table->dropColumn('status');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string("profile_image")->nullable();
            $table->string("status")->nullable();
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('username');
        });
        Schema::table('admins', function (Blueprint $table) {
            $table->string("email");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
