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

Route::view('/', 'welcome');

Route::get('slack/redirect', 'SlackController@redirect')->name('slack.redirect');
Route::get('slack/callback', 'SlackController@callback')->name('slack.callback');

Route::get('slacks/{slack}/dashboard', 'Slack\DashboardController')->name('slack.dashboard');
Route::put('slacks/{slack}/settings', 'Slack\SettingController@update')->name('slack.settings.update');
