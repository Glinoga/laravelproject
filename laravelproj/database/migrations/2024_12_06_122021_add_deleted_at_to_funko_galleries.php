<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_add_deleted_at_to_funko_galleries.php

public function up()
{
    Schema::table('funko_galleries', function (Blueprint $table) {
        $table->softDeletes(); // This adds the 'deleted_at' column
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('funko_galleries', function (Blueprint $table) {
            //
        });
    }
};
