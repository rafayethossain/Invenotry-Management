<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->bigInteger('order_id');
            $table->integer('customer_id');
            $table->date('sale_date');
            $table->float('trade_price');
            $table->float('tp_amount')->default(0);
            $table->float('total')->default(0);
            $table->string('invoice_no')->nullable();
            $table->text('store_id')->nullable();
            $table->text('quantity')->nullable();
            $table->integer('seller_id')->nullable();
            $table->boolean('superAdmin_approval')->default(0);
            $table->integer('added_by')->nullable();
            $table->integer('edited_by')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
