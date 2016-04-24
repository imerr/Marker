<?php
Route::any(config('marker.route'), 'imer\Marker\MarkerController@handle')->middleware('web');