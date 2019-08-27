<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });

Auth::routes();

//login check
Route::get('/', 'HomeController@checklogin');

//dashboard route
Route::get('/home', 'HomeController@index')->name('home');

//all user expense 
Route::get('user/payment-report', 'UserController@paymentreport');

//print payment
Route::get('printpaymentreport', 'UserController@printpaymentreport');

//date to date seller report
Route::get('user/date-to-date-seller-report', 'UserController@datetodatesellerreport');

//all customers transaction report
Route::get('customer/all-customer-report', 'CustomerController@allcustomerreport');

//print all customers transaction report
Route::get('printallcustomerreport', 'CustomerController@printallcustomerreport');

//pdf of all customers transaction report
Route::get('pdf-allcustomer-report', 'CustomerController@exportPDFallcustomerreport');

//excel of all customers transaction report
Route::get('excel-allcustomer-report', 'CustomerController@exportExcelallcustomerreport');

//individual customer report
Route::get('customer/report/{id}', 'CustomerController@report');

//print individual customer report
Route::get('individual-customer-report/{id}', 'CustomerController@printindividualreport');

//pdf individual customer report
Route::get('individual-customer-report-pdf/{id}', 'CustomerController@pdfIndividualReport');

//excel individual customer report
Route::get('individual-customer-report-excel/{id}', 'CustomerController@excelIndividualReport');

//date to date area report
Route::get('area/report', 'AreaController@datetodateareareport');

//date to date income report
Route::get('income/report', 'IncomeController@datetodateincome');

//print date to date income report
Route::get('print-income-report', 'IncomeController@printincomereport');

//pdf date to date income report
Route::get('pdf-income-report', 'IncomeController@exportPDF');

//excel date to date income report
Route::get('excel-income-report', 'IncomeController@exportExcel');

//expense report
Route::get('expense/report', 'ExpenseController@datetodateexpense');

//print date to date expense report
Route::get('print-expense-report', 'ExpenseController@printexpensereport');

//particular expense report
Route::get('expense/particular-expense', 'ExpenseController@particularexpense');

//print particular expense report
Route::get('print-particular-expense-report', 'ExpenseController@printparticularexpensereport');

//add purchase via barcode
Route::get('purchase/add-via-barcode', 'PurchaseController@addviabarcode');
Route::post('purchase/via-barcode', 'PurchaseController@purchaseviabarcode');

//date to date purchase report
Route::get('purchase/report', 'PurchaseController@purchasereport');

//date to date sales report
Route::get('sale/report', 'SaleController@datetodatesale');

//print particular sale report
Route::get('print-sale-report', 'SaleController@printsalereport');

//quotation create page
Route::get('quotation', 'HomeController@quotation');

//price quotation
Route::get('quotation/pricelist', 'HomeController@pricelist');

//print price quotation
Route::get('printquotation/{id}', 'HomeController@printquotation');

//pdf price quotation
Route::get('pdfquotation/{id}', 'HomeController@pdfquotation');

//excel price quotation
Route::get('excelquotation/{id}', 'HomeController@excelquotation');

//print product sample expense
Route::get('print-expense/{id}', 'ExpenseController@printproductexpense');

//return loan
Route::get('loan/return', 'LoanController@loanreturn');

//confirm before saving
Route::post('loan/confirm-loan-payment', 'LoanController@confirmloanpayment');
Route::post('/loanpayment', 'LoanController@loanpayment');

//change password
Route::get('/changePassword','HomeController@showChangePasswordForm');
Route::post('/changePassword','HomeController@changePassword')->name('changePassword');

//get subcategory list when adding product using ajax
Route::get('/getsubcategory/{id}', 'ProductController@getSubCategory');

//get subarea list when adding user using ajax
Route::get('/getsubarea/{id}', 'SubAreaController@getSubArea');

//print a particular sale
Route::get('/printsale/{id}', 'SaleController@print');

//pdf of a particular sale
Route::get('/salepdf/{id}', 'SaleController@exportPDF');

//excel of a particular sale
Route::get('/saleexcel/{id}', 'SaleController@exportExcel');

//convert an order to sale
Route::get('/ordertosale/{id}', 'SaleController@OrderToSale');

//approve a sale (by super admin)
Route::post('/saleapproval/{id}', 'SaleController@update');

//approve an expense (by super admin)
Route::post('/expenseapproval/{id}', 'ExpenseController@approval');

//all report from a date to another
Route::get('allreport', 'HomeController@allreport');

//area manager-> report of particular seller
Route::get('sellerreport', 'AreaController@sellerreport');

//print product stock
Route::get('print-product', 'ProductController@print');

//pdf of product stock
Route::get('product-pdf', 'ProductController@exportPDF');

//pdf of product stock
Route::get('product-excel', 'ProductController@exportExcel');

// Route::get('dailyreport', 'ExpenseController@dailyreport');
// Route::get('weeklyreport', 'ExpenseController@weeklyreport');
// Route::get('monthlyreport', 'ExpenseController@monthlyreport');
// Route::get('yearlyreport', 'ExpenseController@yearlyreport');

//particular area report
// Route::get('/areareport/{id}', 'AreaController@report');

// Route::get('dailysales', 'SaleController@dailysales');
// Route::get('weeklysales', 'SaleController@weeklysales');
// Route::get('monthlysales', 'SaleController@monthlysales');

//resource routes
Route::resource('product', 'ProductController');
Route::resource('customer', 'CustomerController');
Route::resource('income', 'IncomeController');
Route::resource('expense', 'ExpenseController');
Route::resource('purchase', 'PurchaseController');
Route::resource('sale', 'SaleController');
Route::resource('order', 'OrderController');
Route::resource('category', 'CategoryController');
Route::resource('subcategory', 'SubCategoryController');
Route::resource('area', 'AreaController');
Route::resource('subarea', 'SubAreaController');
Route::resource('expenseitem', 'ExpenseItemController');
Route::resource('returnedproduct', 'ReturnedProductController');
Route::resource('damagedproduct', 'DamagedProductController');

Route::middleware(['role:super_admin'])->group(function() {
    Route::resource('loan', 'LoanController');
    Route::resource('user', 'UserController');
});

//product search for select2
Route::get('productautocompletesearch','ProductController@autocompletesearch')->name('productautocompletesearch');

////customer search for select2
Route::get('customerautocompletesearch','CustomerController@autocompletesearch')->name('customerautocompletesearch');

//check for pending sales, expense, purchase
Route::get('/checkforpending', 'HomeController@checkforpending');






