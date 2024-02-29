<?php

use App\Models\Cart;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Trong Laravel, hasColumn() là một phương thức được sử dụng để kiểm tra xem một bảng trong cơ sở dữ liệu có chứa một cột nhất định hay không.


       if (!Schema::hasColumn('cart_products','cart_id')) {
        # code...
        Schema::table('cart_products', function (Blueprint $table) {
            //
            $table->foreignIdFor(Cart::class,'cart_id')->constrained()->onDelete('cascade');
        });
       }
       if (!Schema::hasColumn('cart_products','user_id')) {
        # code...
        Schema::table('cart_products', function (Blueprint $table) {
            //
            $table->dropColumn('user_id');
        });
       }
    //    if (!Schema::hasColumn('cart_products','product_color')) {
    //     # code...
    //     Schema::table('cart_products', function (Blueprint $table) {
    //         //
    //         $table->dropColumn('product_color');
    //     });
    //    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('cart_products','cart_id')) {
            # code...
            Schema::table('cart_products', function (Blueprint $table) {
                //
                $table->dropColumn('cart_id');
            });
           }
           if (!Schema::hasColumn('cart_products','user_id')) {
            # code...
            Schema::table('cart_products', function (Blueprint $table) {
                //
                $table->foreignIdFor(Cart::class);
            });
           }
        //    if (!Schema::hasColumn('cart_products','product_color')) {
        //     # code...
        //     Schema::table('cart_products', function (Blueprint $table) {
        //         //
        //         $table->string('product_color');
        //     });
        //    }
    }
};
