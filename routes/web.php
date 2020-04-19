<?php


Auth::routes();

//Manual Logout
Route::get('/logout-manual', function () {
    request()->session()->invalidate();
    return redirect('/');
});

Route::get('/{any}', 'AppController@index')->where('any', '.*');
