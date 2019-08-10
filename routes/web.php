<?php

Route::get('/','fileController@index')->name('/');
Route::post('file-upload','fileController@upload')->name('file-upload');
