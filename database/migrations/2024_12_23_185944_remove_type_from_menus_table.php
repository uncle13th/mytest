<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTypeFromMenusTable extends Migration
{
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }

    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->enum('type', ['menu', 'folder'])->default('menu')->comment('菜单类型');
        });
    }
}
