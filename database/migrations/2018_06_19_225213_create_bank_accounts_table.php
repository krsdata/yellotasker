<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->nullable();
			$table->string('molplayProfile_id', 100)->nullable();
			$table->string('bank_name')->nullable();
			$table->string('account_name')->nullable();
			$table->string('account_number')->nullable();
			$table->string('ifsc_code')->nullable();
			$table->text('bank_branch', 65535)->nullable();
			$table->text('bankdetails', 65535)->nullable();
			$table->boolean('status')->default(0);
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
		Schema::drop('bank_accounts');
	}

}
