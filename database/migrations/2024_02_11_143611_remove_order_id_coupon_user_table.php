<?php

use App\Models\Oder;
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
        //check xem nếu nó tồn tại order id  thì sẽ xóa khóa ngoại và xóa cột nó đi và ngược lại và khi reload lại và tạo ngược lại
        if (Schema::hasColumn('coupon_user','oder_id')) {
            # code...
            Schema::table('coupon_user',function(Blueprint $table){
                $table->dropForeignIdFor(Oder::class);
                $table->dropColumn('oder_id');
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        if (!Schema::hasColumn('coupon_user','oder_id')) {
            # code...
            Schema::table('coupon_user',function(Blueprint $table){
                $table->dropForeignIdFor(Oder::class);
              
            });
        }
    }
};
