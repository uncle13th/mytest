<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->default(0)->comment('父级ID');
            $table->string('name')->comment('菜单名称');
            $table->string('icon')->nullable()->comment('图标');
            $table->string('url')->nullable()->comment('链接');
            $table->integer('sort')->default(0)->comment('排序');
            $table->boolean('is_show')->default(true)->comment('是否显示');
            $table->enum('type', ['menu', 'folder'])->default('menu')->comment('菜单类型');
            $table->timestamps();
        });

        // 创建角色-菜单关联表
        Schema::create('role_menu', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('menu_id');
            $table->primary(['role_id', 'menu_id']);
            
            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('cascade');
                  
            $table->foreign('menu_id')
                  ->references('id')
                  ->on('menus')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_menu');
        Schema::dropIfExists('menus');
    }
}
