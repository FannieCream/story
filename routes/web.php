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

Route::get('/', function () {
    return view('welcome');
});

Route:: get('/map', 'MapController@index');
Route:: post('/posdata', 'MapController@posdata');
Route:: post('/eventdata', 'MapController@eventdata');

Route:: get('/net', 'NetController@index');
// Route:: post('/netdata', 'NetController@netdata');
Route:: post('/prodata', 'NetController@prodata');

Route:: get('/detail/book1', 'DetailController@book1');
Route:: get('/detail/book2', 'DetailController@book2');
Route:: get('/detail/book3', 'DetailController@book3');
Route:: get('/detail/book4', 'DetailController@book4');
Route:: get('/detail/book5', 'DetailController@book5');

Route:: get('/define/map', 'MapDefineController@mapupload');
Route:: get('/define/net', 'NetDefineController@netupload');
Route:: post('/define/map/upload', 'MapDefineController@upload');
Route:: post('/define/net/upload', 'NetDefineController@upload');
Route:: post('/define/map/define', 'MapDefineController@define');
Route:: post('/define/net/define', 'NetDefineController@define');


Route:: get('/longmarch', 'LongMarchController@index');
Route:: post('/timedata', 'LongMarchController@timedata');
Route:: post('/lmposdata', 'LongMarchController@posdata');
Route:: post('/lmeventdata', 'LongMarchController@eventdata');

