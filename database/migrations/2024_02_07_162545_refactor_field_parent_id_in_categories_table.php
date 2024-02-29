<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        //Trong Laravel, hasColumn() là một phương thức được sử dụng để kiểm tra xem một bảng trong cơ sở dữ liệu có chứa một cột nhất định hay không.
        if (Schema::hasColumn('categories','parent_id')) {
            # code...
            Schema::table('categories', function (Blueprint $table) {
                //
                $table->unsignedBigInteger('parent_id')->nullable()->change();
            });
        }
    
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('categories','parent_id')) {
            # code...
            Schema::table('categories', function (Blueprint $table) {
                //
                $table->unsignedBigInteger('parent_id')->nullable()->change();
            });
        }
    }
};
