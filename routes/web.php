<?php

use App\Http\Controllers\RankingLakuPandaiController;
use App\Http\Controllers\SmsController;

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

Route::get('/', function () {
    return view('sessions.signIn');
});

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@doLogin');
Route::get('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {

    // Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');
    // Route::get('/dashboard/ppob', 'DashboardController@detailDashboardPpob')->name('detail_dashboard_ppob');
    // Route::get('/dashboard/lakupandai', 'DashboardController@detailDashboardLakupandai')->name('detail_dashboard_lakupandai');
    // Route::get('/dashboard/all', 'DashboardController@detailDashboardAll')->name('detail_dashboard_all');
    // Route::get('/dashboard/reward', 'DashboardController@agentReward')->name('agent_reward');
    // Route::get('/dashboard/activeAgent', 'DashboardController@agentActive')->name('agent_active');
    // Route::get('/dashboard/resignAgent', 'DashboardController@agentResign')->name('agent_resign');
    // Route::get('/dashboard/allAgent', 'DashboardController@agentAll')->name('agent_all');
    Route::get('/dashboard/rank', 'TransactionsController@rankTransactions')->name('transaction_rank');
    Route::get('/dashboard', 'DashboardBaruController@index')->name('dashboard');
    Route::get('/landing', function () {
        return view('apps.landing');
    })->name('landing');

    // Route::get('/dashboard', function () {
    //     return view('apps.landing');
    // })->name('landing');

    Route::get('/agen', 'MerchantsController@menu')->name('agen');
    Route::get('/agen/list', 'MerchantsController@index')->name('agen_list');
    Route::get('/agen/create', 'MerchantsController@create')->name('agen_create');
    Route::post('/agen/store', 'MerchantsController@store')->name('agen_store');
    Route::get('/agen/{id}/edit', 'MerchantsController@edit')->name('agen_edit');
    Route::post('/agen/{id}/update', 'MerchantsController@update')->name('agen_update');
    Route::get('/agen/create/inquiry', 'MerchantsController@inquiry_nik')->name('agen_inquiry_nik');
    Route::post('/agen/store/inquiry', 'MerchantsController@store_inquiry_nik')->name('agen_store_inquiry_nik');
    Route::get('/agen/create/inquiry/rek', 'MerchantsController@inquiry_rek')->name('agen_inquiry_rek');
    Route::post('/agen/store/inquiry/rek', 'MerchantsController@store_inquiry_rek')->name('agen_store_inquiry_rek');
    Route::get('/agen/create/cif', 'MerchantsController@create_cif')->name('agen_create_cif');
    Route::post('/agen/store/cif', 'MerchantsController@store_cif')->name('agen_store_cif');
    Route::get('/agen/create/rekening', 'MerchantsController@create_rekening')->name('agen_create_rekening');
    Route::post('/agen/store/rekening', 'MerchantsController@store_rekening')->name('agen_store_rekening');
    Route::post('/agen/{id}/activate', 'MerchantsController@activateMerchant')->name('agen_activate');
    Route::post('/agen/{id}/deactivate', 'MerchantsController@deactivateMerchant')->name('agen_deactivate');
    Route::get('/agen/request', 'MerchantsController@request_list')->name('agen_request');
    Route::get('/agen/request/{id}', 'MerchantsController@detail_request')->name('agen_request_detail');
    Route::post('/agen/{id}/reject', 'MerchantsController@rejectAgent')->name('agen_reject');

    Route::get('/merchants.pdf', 'MerchantsController@exportPDF')->name('merchants.pdf');
    Route::get('/merchants.csv', 'MerchantsController@exportCSV')->name('merchants.csv');
    Route::get('/merchants.excel', 'MerchantsController@exportExcel')->name('merchants.excel');
    Route::get('/merchants.txt', 'MerchantsController@exportTxt')->name('merchants.txt');
    
    Route::get('/message', 'MessageLogController@index')->name('message_log');

    Route::get('/transaction', 'TransactionsController@index')->name('transaction');
    Route::get('/transaction/updateStatus/{code}', 'TransactionsController@updateStatus')->name('transaction_updateStatus');
    Route::get('/transaction/{id}/edit', 'TransactionsController@edit')->name('transaction_edit');
    Route::post('/transaction/{id}/update', 'TransactionsController@update')->name('transaction_update');
    Route::get('/transaction/export', 'TransactionsController@export');
    Route::get('/transaction.pdf', 'TransactionsController@exportPDF')->name('transactions.pdf');
    Route::get('/transactions.csv', 'TransactionsController@exportCSV')->name('transactions.csv');
    Route::get('/transaction/saleExport', 'TransactionsController@exportCSVPaymentOnly')->name('transactions.csvPaymentOnly');
    Route::get('/transaction/feeExport', 'TransactionsController@exportCSVFeeOnly')->name('transactions.csvFeeOnly');
    Route::get('/transaction/reversal', 'TransactionsController@reversal');
    Route::get('/transaction/reversal/{additional_data}', 'TransactionsController@postReversal')->name('transaction_postReversal');
    Route::get('/transaction/fee', 'TransactionsController@reportFee')->name('transaction_fee');


    Route::get('/transactionSaleBJB', 'TransactionSaleBJBController@indexSale')->name('transactionSaleBJB');
    // Route::post('/transactionSaleBJB/{id}/updatebjb', 'TransactionSaleBJBController@updatebjb')->name('transaction_updatebjb');

    Route::get('/transaction_log', 'TransactionLogController@index')->name('transaction_log');
    Route::get('/transaction_log/create', 'TransactionLogController@create')->name('transactionlog_create');
    Route::get('/transaction_log/edit/{stan}', 'TransactionLogController@edit')->name('transactionlog_edit');
    Route::put('/transaction_log/update/{additional_data}', 'TransactionLogController@update')->name('transactionlog_update');
    Route::get('/transaction_log/show/{additional_data}', 'TransactionLogController@show')->name('transactionlog_show');
    Route::post('/transaction_log/destroy/{additional_data}', 'TransactionLogController@destroy')->name('transactionlog_destroy');
    Route::post('/transaction_log/store', 'TransactionLogController@store')->name('transactionlog_store');
    Route::post('/transaction_log/updatestatus/{additional_data}', 'TransactionsController@updateStatus')->name('transactionlog_updatestatus');

    // Route::post('/transactionBJB/{id}/updatebjb', 'TransactionBJBsController@updatebjb')->name('transaction_updatebjb');
    // Route::post('/transactionBJB/{id}/update', 'TransactionBJBsController@update')->name('transactionBJB_update');
    // Route::get('/transactionBJB/{id}/edit', 'TransactionBJBsController@edit')->name('transactionBJB_edit');
    // Route::get('/transactionBJB', 'TransactionBJBsController@index')->name('transactionBJB');
    // Route::get('/transactionBJB/export', 'TransactionBJBsController@export');
    // Route::get('/transactionBJB/exportPDF', 'TransactionBJBsController@exportPDF');
    // Route::get('/transactionBJB/exportCSV', 'TransactionBJBsController@exportCSV');
    // Route::get('/transactionBJB/feeExport', 'TransactionBJBsController@feeExport');
    // Route::get('/transactionBJB/edit/{id}', 'TransactionBJBsController@edit');

    Route::get('/transactionBJB', 'TransactionBJBsController@index')->name('transactionBJB');
    Route::get('/transactionBJB/updateStatus/{code}', 'TransactionBJBsController@updateStatus')->name('transactionBJB_updateStatus');
    Route::get('/transactionBJB/{id}/edit', 'TransactionBJBsController@edit')->name('transactionBJB_edit');
    Route::post('/transactionBJB/{id}/update', 'TransactionBJBsController@update')->name('transactionBJB_update');
    Route::get('/transactionBJB/export', 'TransactionBJBsController@export');
    Route::get('/transactionBJB/exportPDF', 'TransactionBJBsController@exportPDF');
    Route::get('/transactionBJB/exportCSV', 'TransactionBJBsController@exportCSV');
    Route::get('/transactionBJB/saleExport', 'TransactionBJBsController@saleExport');
    Route::get('/transactionBJB/feeExport', 'TransactionBJBsController@feeExport');
    Route::get('/transactionBJB/reversal', 'TransactionBJBsController@reversal');
    Route::get('/transactionBJB/reversal/{additional_data}', 'TransactionBJBsController@postReversal')->name('transactionBJB_postReversal');

    Route::get('/biller', 'BillersController@index')->name('biller');

    Route::get('/terminal', 'TerminalsController@index')->name('terminal');
    Route::get('/terminal/create', 'TerminalsController@create')->name('terminal_create');
    Route::post('/terminal/store', 'TerminalsController@store')->name('terminal_store');
    Route::get('/terminal/{id}/edit', 'TerminalsController@edit')->name('terminal_edit');
    Route::post('/terminal/{id}/update', 'TerminalsController@update')->name('terminal_update');
    Route::post('/terminal/{id}/destroy', 'TerminalsController@destroy')->name('terminal_destroy');
    Route::post('/terminal/{id}/{merchant_id}/delete', 'TerminalsController@deleteMerchantData')->name('terminal_delete');
    Route::get('/terminal/{id}/activateBilliton', 'TerminalsController@activateBilliton')->name('terminal_activate_billiton');
    Route::get('/terminal/{id}/updateBilliton', 'TerminalsController@updateBilliton')->name('terminal_update_billiton');

    // Routes for Master Data
    Route::get('/hak-akses', 'HakAksesController@index')->name('hakakses');
    Route::get('/hak-akses/create', 'HakAksesController@create')->name('hakakses_create');
    Route::post('/hak-akses/store', 'HakAksesController@store')->name('hakakses_store');
    Route::get('/hak-akses/{id}/edit', 'HakAksesController@edit')->name('hakakses_edit');
    Route::post('/hak-akses/{id}/update', 'HakAksesController@update')->name('hakakses_update');
    Route::post('/hak-akses/{id}/destroy', 'HakAksesController@destroy')->name('hakakses_destroy');
    Route::get('/hak-akses/chart', 'HakAksesController@showChart')->name('hakakses_chart');

    // Routes for ServiceMeta
    Route::get('/servicemeta', 'ServiceMetaController@index')->name('servicemeta');
    Route::get('/servicemeta/create', 'ServiceMetaController@create')->name('servicemeta_create');
    Route::post('/servicemeta/store', 'ServiceMetaController@store')->name('servicemeta_store');
    Route::get('/servicemeta/{id}/edit', 'ServiceMetaController@edit')->name('servicemeta_edit');
    Route::post('/servicemeta/{id}/update', 'ServiceMetaController@update')->name('servicemeta_update');
    Route::post('/servicemeta/{id}/destroy', 'ServiceMetaController@destroy')->name('servicemeta_destroy');

    Route::get('/screen', 'ScreenController@index')->name('screen');
    Route::get('/screen/create', 'ScreenController@create')->name('screen_create');
    Route::post('/screen/store', 'ScreenController@store')->name('screen_store');
    Route::get('/screen/{id}/edit', 'ScreenController@edit')->name('screen_edit');
    Route::post('/screen/{id}/update', 'ScreenController@update')->name('screen_update');
    Route::post('/screen/{id}/destroy', 'ScreenController@destroy')->name('screen_destroy');

    Route::get('/component', 'ComponentController@index')->name('component');
    Route::get('/component/create', 'ComponentController@create')->name('component_create');
    Route::post('/component/store', 'ComponentController@store')->name('component_store');
    Route::get('/component/{id}/edit', 'ComponentController@edit')->name('component_edit');
    Route::post('/component/{id}/update', 'ComponentController@update')->name('component_update');
    Route::post('/component/{id}/destroy', 'ComponentController@destroy')->name('component_destroy');

    Route::get('/service', 'ServiceController@index')->name('service');
    Route::get('/service/create', 'ServiceController@create')->name('service_create');
    Route::post('/service/store', 'ServiceController@store')->name('service_store');
    Route::get('/service/{id}/edit', 'ServiceController@edit')->name('service_edit');
    Route::post('/service/{id}/update', 'ServiceController@update')->name('service_update');
    Route::post('/service/{id}/destroy', 'ServiceController@destroy')->name('service_destroy');

    Route::get('/screen-component', 'ScreenComponentController@index')->name('screen_component');
    Route::get('/screen-component/create', 'ScreenComponentController@create')->name('screen_component_create');
    Route::post('/screen-component/store', 'ScreenComponentController@store')->name('screen_component_store');
    Route::get('/screen-component/{screen_id}/edit', 'ScreenComponentController@edit')->name('screen_component_edit');
    Route::post('/screen-component/{screen_id}/update', 'ScreenComponentController@update')->name('screen_component_update');
    Route::post('/screen-component/{screen_id}/destroy', 'ScreenComponentController@destroy')->name('screen_component_destroy');

    Route::get('/billers', 'BillersController@index')->name('billers');
    Route::get('/billers/create', 'BillersController@create')->name('billers_create');
    Route::post('/billers/store', 'BillersController@store')->name('billers_store');
    Route::get('/billers/{id}/edit', 'BillersController@edit')->name('billers_edit');
    Route::post('/billers/{id}/update', 'BillersController@update')->name('billers_update');
    Route::post('/billers/{id}/destroy', 'BillersController@destroy')->name('billers_destroy');

    Route::get('/new_features', 'NewFeaturesController@index')->name('new_features');

    Route::get('/masterdata', 'MasterDataController@index')->name('masterdata');

    Route::get('/fee', 'FeeController@index')->name('fee');
    Route::get('/fee/create', 'FeeController@create')->name('fee_create');
    Route::post('/fee/store', 'FeeController@store')->name('fee_store');
    Route::get('/edit/{meta_id}/{service_id}/{seq}', 'FeeController@edit')->name('fee_edit');
    Route::post('/fee/update/{meta_id}/{service_id}/{seq}', 'FeeController@update')->name('fee_update');
    Route::post('fee/destroy/{meta_id}/{service_id}/{seq}', 'FeeController@edit')->name('fee_destroy');

    Route::get('/persen_fee', 'PersenFeeController@index')->name('persen_fee');
    Route::get('/persen_fee/create', 'PersenFeeController@create')->name('persen_fee_create');
    Route::post('/persen_fee/store', 'PersenFeeController@store')->name('persen_fee_store');
    Route::post('persen_fee/destroy/{id}', 'PersenFeeController@destroy')->name('persen_fee_destroy');
    Route::get('/persen_fee/edit/{id}', 'PersenFeeController@edit')->name('persen_fee_edit');
    Route::post('/persen_fee/update/{id}', 'PersenFeeController@update')->name('persen_fee_update');
    //Route::post('/persen_fee/destroy/{meta_id}/{service_id}/{seq}', 'PersenFeeController@edit')->name('persen_fee_destroy');

    Route::get('/nasabah', 'DataCalonNasabahController@index')->name('nasabah');
    Route::get('/nasabah/list', 'DataCalonNasabahController@list')->name('nasabah_list');
    Route::get('/nasabah/request', 'DataCalonNasabahController@list_request')->name('nasabah_request');
    Route::post('/nasabah/cif/{id}', 'DataCalonNasabahController@store_cif')->name('nasabah_cif');
    Route::post('/nasabah/reject/{id}', 'DataCalonNasabahController@rejectNasabah')->name('nasabah_reject');
    Route::post('/nasabah/approve/{id}', 'DataCalonNasabahController@approveNasabah')->name('nasabah_approve');
    Route::get('/nasabah/detail/{id}', 'DataCalonNasabahController@detailRequest')->name('nasabah_detail');
    Route::post('/end-sms/{id}', 'SmsTwilioController@sendSms')->name('send_sms');

    Route::post('/end-sms/{id}', 'SmsTwilioController@sendSms')->name('send_sms');

    Route::get('/nasabah/approve', 'DataCalonNasabahController@list_approve')->name('list_approve');
    Route::post('/nasabah/accept/{id}', 'DataCalonNasabahController@acceptNasabah')->name('nasabah_accept');
    Route::get('/nasabah/{id}/detail', 'DataCalonNasabahController@detailApprove')->name('nasabah_detail_approve');

    Route::get('/persen_fee', 'PersenFeeController@index')->name('persen_fee');
    Route::get('/persen_fee/create', 'PersenFeeController@create')->name('persen_fee_create');
    Route::post('/persen_fee/store', 'PersenFeeController@store')->name('persen_fee_store');
    Route::post('persen_fee/destroy/{id}', 'PersenFeeController@destroy')->name('persen_fee_destroy');
    Route::get('/persen_fee/edit/{id}', 'PersenFeeController@edit')->name('persen_fee_edit');
    Route::post('/persen_fee/update/{id}', 'PersenFeeController@update')->name('persen_fee_update');
    //Route::post('/persen_fee/destroy/{meta_id}/{service_id}/{seq}', 'PersenFeeController@edit')->name('persen_fee_destroy');

    // Route::get('/ranking_lakupandai', 'RankingLakuPandaiController@index')->name('ranking_lakupandai');

    Route::get('/permissions', 'PermissionController@index')->name('permissions.index');
    Route::get('/permissions/create', 'PermissionController@create')->name('permissions.create');
    Route::post('/permissions', 'PermissionController@store')->name('permissions.store');
    Route::get('/permissions/{permission}/edit', 'PermissionController@edit')->name('permissions.edit');
    Route::put('/permissions/{permission}', 'PermissionController@update')->name('permissions.update');    
    Route::post('/permissions/{permission}/destroy', 'PermissionController@destroy')->name('permissions.destroy');    

    Route::get('/roles', 'RoleController@index')->name('roles.list');
    Route::get('/roles/create', 'RoleController@create')->name('roles.add');
    Route::post('/roles', 'RoleController@store')->name('roles.store');
    Route::get('/roles/{role}/edit', 'RoleController@edit')->name('roles.edit');
    Route::put('/roles/{role}', 'RoleController@update')->name('roles.update');
    Route::post('/roles/{role}/destroy', 'RoleController@destroy')->name('roles.destroy'); 
    Route::get('/roles/{role}/give-permissions', 'RoleController@addPermissionToRole')->name('roles.addPermissionToRole');
    Route::put('/roles/{role}/give-permissions', 'RoleController@givePermissionToRole')->name('roles.givePermissionToRole');

    Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/users/create', 'UserController@create')->name('users.create');
    Route::post('/users', 'UserController@store')->name('users.store');
    Route::get('/users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::post('/users/{user}', 'UserController@update')->name('users.update');
    Route::post('/users/{user}/delete', 'UserController@destroy')->name('users.destroy');


    // Route::view('/', 'starter')->name('starter');
    Route::get('large-compact-sidebar/dashboard/dashboard1', function () {
        // set layout sesion(key)
        session(['layout' => 'compact']);
        return view('dashboard.dashboardv1');
    })->name('compact');

    Route::get('large-sidebar/dashboard/dashboard1', function () {
        // set layout sesion(key)
        session(['layout' => 'normal']);
        return view('dashboard.dashboardv1');
    })->name('normal');

    Route::get('horizontal-bar/dashboard/dashboard1', function () {
        // set layout sesion(key)
        session(['layout' => 'horizontal']);
        return view('dashboard.dashboardv1');
    })->name('horizontal');

    Route::get('vertical/dashboard/dashboard1', function () {
        // set layout sesion(key)
        session(['layout' => 'vertical']);
        return view('dashboard.dashboardv1');
    })->name('vertical');


    Route::view('dashboard/dashboard1', 'dashboard.dashboardv1')->name('dashboard_version_1');
    Route::view('dashboard/dashboard2', 'dashboard.dashboardv2')->name('dashboard_version_2');
    Route::view('dashboard/dashboard3', 'dashboard.dashboardv3')->name('dashboard_version_3');
    Route::view('dashboard/dashboard4', 'dashboard.dashboardv4')->name('dashboard_version_4');
    Route::view('dashboard/dashboard5', 'dashboard.dashboardv5')->name('dashboard_version_5');
    Route::view('dashboard/dashboard6', 'dashboard.dashboardv6')->name('dashboard_version_6');
    Route::view('dashboard/dashboard7', 'dashboard.dashboardv7')->name('dashboard_version_7');
    Route::view('dashboard/dashboard8', 'dashboard.dashboardv8')->name('dashboard_version_8');
    Route::view('dashboard/dashboard9', 'dashboard.dashboardv9')->name('dashboard_version_9');
    Route::view('dashboard/dashboard10', 'dashboard.dashboardv10')->name('dashboard_version_10');
    Route::view('dashboard/dashboard11', 'dashboard.dashboardv11')->name('dashboard_version_11');
    Route::view('dashboard/dashboard12', 'dashboard.dashboardv12')->name('dashboard_version_12');
    Route::view('dashboard/dashboard13', 'dashboard.dashboardv13')->name('dashboard_version_13');
    Route::view('dashboard/dashboard14', 'dashboard.dashboardv14')->name('dashboard_version_14');
    Route::view('dashboard/dashboard15', 'dashboard.dashboardv15')->name('dashboard_version_15');
    Route::view('dashboard/dashboard16', 'dashboard.dashboardv16')->name('dashboard_version_16');
    Route::view('dashboard/dashboard17', 'dashboard.dashboardv17')->name('dashboard_version_17');
    Route::view('dashboard/dashboard18', 'dashboard.dashboardv18')->name('dashboard_version_18');
    Route::view('dashboard/dashboard19', 'dashboard.dashboardv19')->name('dashboard_version_19');
    Route::view('dashboard/dashboard20', 'dashboard.dashboardv20')->name('dashboard_version_20');
    // uiKits
    Route::view('uikits/alerts', 'uiKits.alerts')->name('alerts');
    Route::view('uikits/accordion', 'uiKits.accordion')->name('accordion');
    Route::view('uikits/buttons', 'uiKits.buttons')->name('buttons');
    Route::view('uikits/badges', 'uiKits.badges')->name('badges');
    Route::view('uikits/bootstrap-tab', 'uiKits.bootstrap-tab')->name('bootstrap-tab');
    Route::view('uikits/carousel', 'uiKits.carousel')->name('carousel');
    Route::view('uikits/collapsible', 'uiKits.collapsible')->name('collapsible');
    Route::view('uikits/lists', 'uiKits.lists')->name('lists');
    Route::view('uikits/pagination', 'uiKits.pagination')->name('pagination');
    Route::view('uikits/popover', 'uiKits.popover')->name('popover');
    Route::view('uikits/progressbar', 'uiKits.progressbar')->name('progressbar');
    Route::view('uikits/tables', 'uiKits.tables')->name('tables');
    Route::view('uikits/tabs', 'uiKits.tabs')->name('tabs');
    Route::view('uikits/tooltip', 'uiKits.tooltip')->name('tooltip');
    Route::view('uikits/modals', 'uiKits.modals')->name('modals');
    Route::view('uikits/NoUislider', 'uiKits.NoUislider')->name('NoUislider');
    Route::view('uikits/cards', 'uiKits.cards')->name('cards');
    Route::view('uikits/cards-metrics', 'uiKits.cards-metrics')->name('cards-metrics');
    Route::view('uikits/typography', 'uiKits.typography')->name('typography');

    // extra kits
    Route::view('extrakits/dropDown', 'extraKits.dropDown')->name('dropDown');
    Route::view('extrakits/imageCroper', 'extraKits.imageCroper')->name('imageCroper');
    Route::view('extrakits/loader', 'extraKits.loader')->name('loader');
    Route::view('extrakits/laddaButton', 'extraKits.laddaButton')->name('laddaButton');
    Route::view('extrakits/toastr', 'extraKits.toastr')->name('toastr');
    Route::view('extrakits/sweetAlert', 'extraKits.sweetAlert')->name('sweetAlert');
    Route::view('extrakits/tour', 'extraKits.tour')->name('tour');
    Route::view('extrakits/upload', 'extraKits.upload')->name('upload');


    // Apps
    Route::view('apps/invoice', 'apps.invoice')->name('invoice');
    Route::view('apps/inbox', 'apps.inbox')->name('inbox');
    Route::view('apps/chat', 'apps.chat')->name('chat');
    Route::view('apps/calendar', 'apps.calendar')->name('calendar');
    Route::view('apps/task-manager-list', 'apps.task-manager-list')->name('task-manager-list');
    Route::view('apps/task-manager', 'apps.task-manager')->name('task-manager');
    Route::view('apps/toDo', 'apps.toDo')->name('toDo');
    Route::view('apps/ecommerce/products', 'apps.ecommerce.products')->name('ecommerce-products');
    Route::view('apps/ecommerce/product-details', 'apps.ecommerce.product-details')->name('ecommerce-product-details');
    Route::view('apps/ecommerce/cart', 'apps.ecommerce.cart')->name('ecommerce-cart');
    Route::view('apps/ecommerce/checkout', 'apps.ecommerce.checkout')->name('ecommerce-checkout');


    Route::view('apps/contacts/lists', 'apps.contacts.lists')->name('contacts-lists');
    Route::view('apps/contacts/contact-details', 'apps.contacts.contact-details')->name('contact-details');
    Route::view('apps/contacts/grid', 'apps.contacts.grid')->name('contacts-grid');
    Route::view('apps/contacts/contact-list-table', 'apps.contacts.contact-list-table')->name('contact-list-table');

    // forms
    Route::view('forms/basic-action-bar', 'forms.basic-action-bar')->name('basic-action-bar');
    Route::view('forms/multi-column-forms', 'forms.multi-column-forms')->name('multi-column-forms');
    Route::view('forms/smartWizard', 'forms.smartWizard')->name('smartWizard');
    Route::view('forms/tagInput', 'forms.tagInput')->name('tagInput');
    Route::view('forms/forms-basic', 'forms.forms-basic')->name('forms-basic');
    Route::view('forms/form-layouts', 'forms.form-layouts')->name('form-layouts');
    Route::view('forms/form-input-group', 'forms.form-input-group')->name('form-input-group');
    Route::view('forms/form-validation', 'forms.form-validation')->name('form-validation');
    Route::view('forms/form-editor', 'forms.form-editor')->name('form-editor');

    // Charts
    Route::view('charts/echarts', 'charts.echarts')->name('echarts');
    Route::view('charts/chartjs', 'charts.chartjs')->name('chartjs');
    Route::view('charts/apexLineCharts', 'charts.apexLineCharts')->name('apexLineCharts');
    Route::view('charts/apexAreaCharts', 'charts.apexAreaCharts')->name('apexAreaCharts');
    Route::view('charts/apexBarCharts', 'charts.apexBarCharts')->name('apexBarCharts');
    Route::view('charts/apexColumnCharts', 'charts.apexColumnCharts')->name('apexColumnCharts');
    Route::view('charts/apexRadialBarCharts', 'charts.apexRadialBarCharts')->name('apexRadialBarCharts');
    Route::view('charts/apexRadarCharts', 'charts.apexRadarCharts')->name('apexRadarCharts');
    Route::view('charts/apexPieDonutCharts', 'charts.apexPieDonutCharts')->name('apexPieDonutCharts');
    Route::view('charts/apexSparklineCharts', 'charts.apexSparklineCharts')->name('apexSparklineCharts');
    Route::view('charts/apexScatterCharts', 'charts.apexScatterCharts')->name('apexScatterCharts');
    Route::view('charts/apexBubbleCharts', 'charts.apexBubbleCharts')->name('apexBubbleCharts');
    Route::view('charts/apexCandleStickCharts', 'charts.apexCandleStickCharts')->name('apexCandleStickCharts');
    Route::view('charts/apexMixCharts', 'charts.apexMixCharts')->name('apexMixCharts');

    // datatables
    Route::view('datatables/basic-tables', 'datatables.basic-tables')->name('basic-tables');

    // widgets
    Route::view('widgets/card', 'widgets.card')->name('widget-card');
    Route::view('widgets/statistics', 'widgets.statistics')->name('widget-statistics');
    Route::view('widgets/list', 'widgets.list')->name('widget-list');
    Route::view('widgets/app', 'widgets.app')->name('widget-app');
    Route::view('widgets/weather-app', 'widgets.weather-app')->name('widget-weather-app');

    // others
    Route::view('others/notFound', 'others.notFound')->name('notFound');
    Route::view('others/user-profile', 'others.user-profile')->name('user-profile');
    Route::view('others/starter', 'starter')->name('starter');
    Route::view('others/faq', 'others.faq')->name('faq');
    Route::view('others/pricing-table', 'others.pricing-table')->name('pricing-table');
    Route::view('others/search-result', 'others.search-result')->name('search-result');

    // Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
});
