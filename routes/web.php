<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Http\Requests;


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


//return dutyholder details when AIMS dropdown changes
Route::get('/dutyholders/getdutyholder/{id}','DutyHolderController@getdutyholder');

//save dutyholder position, remark or mobile fields
Route::post('/dutyholders/editdutyholder','DutyHolderController@editdutyholder');

//add dutyholder position, remark or mobile fields
Route::post('/dutyholders/adddutyholder','DutyHolderController@adddutyholder');

Route::resource('/dutyholders', 'DutyHolderController');
Route::resource('/branches', 'BranchController');
Route::resource('/departments', 'DepartmentController');
Route::resource('/regions', 'RegionsController');


Route::any('/postajax','DutyHolderController@selectAjax')->name('DutyHolderControllers.selectAjax');
//To import and export to excel
Route::get('importExport', 'ImportExportController@importExport');
Route::get('downloadExcel/{type}', 'ImportExportController@downloadAllExcel');
Route::get('/downloadDeptExcel/{addDeptId}', 'ImportExportController@downloadDeptExcel');
Route::get('/downloadDoubleDutiesExcel', 'ImportExportController@downloadDoubleDutiesExcel');

Route::get('deleteAllDutyholders/{id}', 'DutyHolderController@deleteAll');
Route::post('importExcel', 'ImportExportController@importExcel');
Route::post('importBranchesExcel', 'ImportExportController@importBranchesExcel');
Route::post('importdutyHoldersExcel', 'ImportExportController@importdutyHoldersExcel');
Route::get('autocomplete', [
    'as' => 'autocomplete', 
    'uses' => 'AutoCompleteController@autoComplete'
  ]);

Route::get('/upload', function () {
    return view('importExport');
});

Route::get('/', function () {
    return view('welcome');
});


