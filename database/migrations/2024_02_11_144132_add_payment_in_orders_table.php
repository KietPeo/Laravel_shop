<?php

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
        // hasColumn() là một phương thức được sử dụng để kiểm tra xem một bảng trong cơ sở dữ liệu có chứa một cột nhất định hay không.

        // if (!Schema::hasColumn('oders','payment')) {
        //     # code...
        //     //Trong đoạn mã của bạn, điều kiện if (!Schema::hasColumn('oders','payment')) 
        //     // đang kiểm tra xem bảng orders có cột payment hay không. Nếu cột này không tồn tại, đoạn mã trong khối if sẽ được thực thi.
        //     // Trong trường hợp cột payment không tồn tại trong bảng orders, đoạn mã trong khối if sẽ sử dụng Schema::table() 
        //     // để thêm cột payment vào bảng orders. Cột này sẽ có kiểu dữ liệu là string và cho phép giá trị null thông qua phương thức nullable(). 
        //     // Điều này có nghĩa là cột payment có thể chứa giá trị null, tức là có thể không có giá trị được chỉ định cho cột này.
        //     Schema::table('orders', function (Blueprint $table) {
        //         //
        //         $table->string('payment')->nullable();
        //     });
        // }

        if (!Schema::hasColumn('oders','payment')) {
            Schema::table('oders', function (Blueprint $table) {
                $table->string('payment')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('oders','payment')) {
            Schema::table('oders', function (Blueprint $table) {
                $table->dropColumn('payment');
            });
        }
       
    }
};
