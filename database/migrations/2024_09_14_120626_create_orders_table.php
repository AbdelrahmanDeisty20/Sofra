<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->enum('state', array('pending', 'accepted', 'rejected', 'delivered', 'declined'));
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->decimal('delivery_charge');
			$table->decimal('commission');
			$table->string('address');
			$table->enum('payment_method', array('cash', 'visa'));
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}