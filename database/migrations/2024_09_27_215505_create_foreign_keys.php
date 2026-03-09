<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration
{
	public function up()
	{
		if (Schema::hasTable('clients')) {
			Schema::table('clients', function (Blueprint $table) {
				$table
					->foreign('region_id')
					->references('id')
					->on('regions')
					->onDelete('no action')
					->onUpdate('no action');
			});
		}
		Schema::table('regions', function (Blueprint $table) {
			$table
				->foreign('city_id')
				->references('id')
				->on('cities')
				->onDelete('no action')
				->onUpdate('no action');
		});

		if (Schema::hasTable('clients') && Schema::hasTable('orders')) {
			Schema::table('orders', function (Blueprint $table) {
				$table
					->foreign('client_id')
					->references('id')
					->on('clients')
					->onDelete('no action')
					->onUpdate('no action');
			});
		}

		if (Schema::hasTable('restaurants') && Schema::hasTable('orders')) {
			Schema::table('orders', function (Blueprint $table) {
				$table
					->foreign('restaurant_id')
					->references('id')
					->on('restaurants')
					->onDelete('cascade')
					->onUpdate('cascade');
			});
		}

		if (Schema::hasTable('restaurants')) {
			Schema::table('restaurants', function (Blueprint $table) {
				$table
					->foreign('region_id')
					->references('id')
					->on('regions')
					->onDelete('restrict')
					->onUpdate('restrict');
			});
		}

		if (Schema::hasTable('restaurants') && Schema::hasTable('products')) {
			Schema::table('products', function (Blueprint $table) {
				$table
					->foreign('restaurant_id')
					->references('id')
					->on('restaurants')
					->onDelete('cascade')
					->onUpdate('cascade');
			});
		}

		if (Schema::hasTable('restaurants') && Schema::hasTable('offers')) {
			Schema::table('offers', function (Blueprint $table) {
				$table
					->foreign('restaurant_id')
					->references('id')
					->on('restaurants')
					->onDelete('no action')
					->onUpdate('no action');
			});
		}

		if (Schema::hasTable('clients') && Schema::hasTable('comments')) {
			Schema::table('comments', function (Blueprint $table) {
				$table
					->foreign('client_id')
					->references('id')
					->on('clients')
					->onDelete('no action')
					->onUpdate('no action');
			});
		}

		if (Schema::hasTable('restaurants') && Schema::hasTable('comments')) {
			Schema::table('comments', function (Blueprint $table) {
				$table
					->foreign('restaurant_id')
					->references('id')
					->on('restaurants')
					->onDelete('no action')
					->onUpdate('no action');
			});
		}

		if (Schema::hasTable('clients') && Schema::hasTable('tokens')) {
			Schema::table('tokens', function (Blueprint $table) {
				$table
					->foreign('client_id')
					->references('id')
					->on('clients')
					->onDelete('no action')
					->onUpdate('no action');
			});
		}

		if (Schema::hasTable('clients') && Schema::hasTable('tokens')) {
			Schema::table('tokens', function (Blueprint $table) {
				$table
					->foreign('restaurant_id')
					->references('id')
					->on('clients')
					->onDelete('no action')
					->onUpdate('no action');
			});
		}

		if (Schema::hasTable('restaurants') && Schema::hasTable('payments')) {
			Schema::table('payments', function (Blueprint $table) {
				$table
					->foreign('restaurant_id')
					->references('id')
					->on('restaurants')
					->onDelete('no action')
					->onUpdate('no action');
			});
		}

		Schema::table('order_product', function (Blueprint $table) {
			$table
				->foreign('order_id')
				->references('id')
				->on('orders')
				->onDelete('cascade')
				->onUpdate('cascade');
		});

		Schema::table('order_product', function (Blueprint $table) {
			$table
				->foreign('product_id')
				->references('id')
				->on('products')
				->onDelete('cascade')
				->onUpdate('cascade');
		});

		if (Schema::hasTable('restaurants') && Schema::hasTable('category_restaurant')) {
			Schema::table('category_restaurant', function (Blueprint $table) {
				$table
					->foreign('restaurant_id')
					->references('id')
					->on('restaurants')
					->onDelete('no action')
					->onUpdate('no action');
			});
		}

		Schema::table('category_restaurant', function (Blueprint $table) {
			$table
				->foreign('category_id')
				->references('id')
				->on('categories')
				->onDelete('no action')
				->onUpdate('no action');
		});
	}

	public function down()
	{
		Schema::table('clients', function (Blueprint $table) {
			$table->dropForeign('clients_region_id_foreign');
		});
		Schema::table('regions', function (Blueprint $table) {
			$table->dropForeign('regions_city_id_foreign');
		});
		Schema::table('orders', function (Blueprint $table) {
			$table->dropForeign('orders_client_id_foreign');
		});
		Schema::table('orders', function (Blueprint $table) {
			$table->dropForeign('orders_restaurant_id_foreign');
		});
		Schema::table('restaurants', function (Blueprint $table) {
			$table->dropForeign('restaurants_region_id_foreign');
		});
		Schema::table('products', function (Blueprint $table) {
			$table->dropForeign('products_restaurant_id_foreign');
		});
		Schema::table('offers', function (Blueprint $table) {
			$table->dropForeign('offers_restaurant_id_foreign');
		});
		Schema::table('comments', function (Blueprint $table) {
			$table->dropForeign('comments_client_id_foreign');
		});
		Schema::table('comments', function (Blueprint $table) {
			$table->dropForeign('comments_restaurant_id_foreign');
		});
		Schema::table('tokens', function (Blueprint $table) {
			$table->dropForeign('tokens_client_id_foreign');
		});
		Schema::table('tokens', function (Blueprint $table) {
			$table->dropForeign('tokens_restaurant_id_foreign');
		});
		Schema::table('payments', function (Blueprint $table) {
			$table->dropForeign('payments_restaurant_id_foreign');
		});
		Schema::table('order_product', function (Blueprint $table) {
			$table->dropForeign('order_product_order_id_foreign');
		});
		Schema::table('order_product', function (Blueprint $table) {
			$table->dropForeign('order_product_product_id_foreign');
		});
		Schema::table('category_restaurant', function (Blueprint $table) {
			$table->dropForeign('category_restaurant_restaurant_id_foreign');
		});
		Schema::table('category_restaurant', function (Blueprint $table) {
			$table->dropForeign('category_restaurant_category_id_foreign');
		});
	}
}
