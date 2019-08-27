<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpenseItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expense_items')->insert([
            'name' => 'Customer Felicitation',
        	'details' => 'Expense for Customer Felicitation',
            'added_by' => 1,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('expense_items')->insert([
            'name' => 'Product Sample',
            'details' => 'Expense for Giving Product Sample to the Customer',
            'added_by' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('expense_items')->insert([
            'name' => 'Travelling Allowance',
            'details' => 'Expense for Travelling Allowance',
            'added_by' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('expense_items')->insert([
            'name' => 'Salary',
            'details' => 'Expense for Employees Salary',
            'added_by' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
