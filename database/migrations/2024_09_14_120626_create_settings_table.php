<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('facebook_link');
			$table->string('whatsapp');
			$table->string('instagram_link');
			$table->string('email');
			$table->string('twitter_link');
			$table->string('youtube_link');
			$table->string('commission_details');
			$table->string('banks');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}