<?php

Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function(){

    Route::get('historic','BalanceController@historic')->name('admin.historic');
    Route::post('transfer.concluir','BalanceController@transferConcluir')->name('transfer.concluir');
    Route::post('transfer','BalanceController@transferStore')->name('transfer.store');
    Route::get('transfer','BalanceController@transfer')->name('balance.transfer');
    Route::post('withdrawn','BalanceController@withdrawnStore')->name('withdrawn.store');
    Route::get('withdrawn','BalanceController@withdrawn')->name('balance.withdrawn');
    Route::post('deposit', 'BalanceController@depositStore')->name('deposit.store');
    Route::get('deposit', 'BalanceController@deposit')->name('balance.deposit');
    Route::get('balance', 'BalanceController@index')->name('admin.balance');
    Route::get('/', 'AdminController@index')->name('admin.home');

});

Route::post('atualizar-perfil','Admin\UserController@profileUpdate')->name('profile.update')->middleware('auth');
Route::get('meu-perfil','Admin\UserController@profile')->name('profile')->middleware('auth');

Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();


