<?php
use Illuminate\Http\Request;
use App\form_data;
use App\User;
use Illuminate\Support\Facades\DB;

 Route::get('/payment/initiate', function(){
    return view('initiate');
 });
 Route::post('/payment/initiate', 'PaymentController@initiatePayment')->name('initiate');
Route::get('/payment/success', 'PaymentController@paymentSuccess')->name('success');

Route::get('/payment/fail', 'PaymentController@paymentFail')->name('fail');

Route::get('/payment/cancel', 'PaymentController@paymentCancel')->name('cancel');      




Route::get('/', 'HomeController@index')->name('welcome');

Route::get('/descending-order-houses-price', 'HomeController@highToLow')->name('highToLow');
Route::get('/ascending-order-houses-price', 'HomeController@lowToHigh')->name('lowToHigh');

Route::get('/search-result', 'HomeController@search')->name('search');
Route::get('/search-result-by-range', 'HomeController@searchByRange')->name('searchByRange');

Route::get('/houses/details/{id}', 'HomeController@details')->name('house.details');
Route::get('/all-available/houses', 'HomeController@allHouses')->name('house.all');
Route::get('/available-houses/area/{id}', 'HomeController@areaWiseShow')->name('available.area.house');

Route::post('/house-booking/id/{id}', 'HomeController@booking')->name('booking');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');

Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');
Route::get('/form', function(){
    $err = false;
    $e_msg = "";
    return view('form', ['e_msg' => $e_msg, 'err' => $err]);
});

Route::post('/form', function(Request $request){
    $err = false;
    $e_msg = "";
    // $f = new form_data;
    $data = $request->all();
    $name = $request->input('name');
    $username = $request->input('username');
    $role_id = $request->input('role_id');
    $nid = $request->input('nid');
    $contact = $request->input('contact');
    $email = $request->input('email');
    $password = $request->input('password');
    $password_confirmation = $request->input('password_confirmation');
    if (empty($_POST['name']) || empty($_POST['username']) || empty($_POST['role_id']) ||
    empty($_POST['nid']) || empty($_POST['contact']) || empty($_POST['email']) || empty($_POST['password'])){
        $err = true;
        $e_msg = $e_msg."Some fields are left empty. ";
    }
    function isUsernameTaken($username) {
        $count = DB::table('users')
        ->Where('username', $username)
        ->count();
    
        // If count is greater than 0, username is taken
        return $count > 0;
    }

    function isNidTaken($nid) {
        $count = DB::table('users')
        ->Where('nid', $nid)
        ->count();
    
        // If count is greater than 0, username is taken
        return $count > 0;
    }
    
    if(isUsernameTaken($username)){
        $err = true;
        $e_msg = $e_msg."username is already taken. ";
    }
    if(isNidTaken($nid)){
        $err = true;
        $e_msg = $e_msg."NID is already taken. ";
    }
    if(strlen($password) < 8){
        $err = true;
        $e_msg = $e_msg."Password length should be at least 8. ";
    }

    if(!($password === $password_confirmation)){
        $err = true;
        $e_msg = $e_msg."Password confirmation does not match. ";
    }

    if(!$err){
        User::create([
            'role_id' => $data['role_id'],
            'name' => $data['name'],
            'username' => str_slug($data['username']),
            'email' => $data['email'],
            'nid' => $data['nid'],
            'contact' => $data['contact'],
            'password' => Hash::make($data['password']),
        ]);
    $e_msg = "successful";
    $err = true;
    }
    
    
    
    return view('form', ['err' => $err, 'e_msg' => $e_msg]);
});




//admin

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']],
    function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('area', 'AreaController');
        Route::resource('house', 'HouseController');
        Route::get('manage-landlord', 'HouseController@manageLandlord')->name('manage.landlord');
        Route::delete('manage-landlord/destroy/{id}', 'HouseController@removeLandlord')->name('remove.landlord');

        Route::get('manage-renter', 'HouseController@manageRenter')->name('manage.renter');
        Route::delete('manage-renter/destroy/{id}', 'HouseController@removeRenter')->name('remove.renter');

        Route::get('profile-info', 'SettingsController@showProfile')->name('profile.show');
        Route::get('profile-info/edit/{id}', 'SettingsController@editProfile')->name('profile.edit');
        Route::post('profile-info/update/', 'SettingsController@updateProfile')->name('profile.update');

        Route::get('booked-houses-list', 'BookingController@bookedList')->name('booked.list');
        Route::get('booked-houses-history', 'BookingController@historyList')->name('history.list');

    });

//landlord

Route::group(['as' => 'landlord.', 'prefix' => 'landlord', 'namespace' => 'Landlord', 'middleware' => ['auth', 'landlord']],
    function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('area', 'AreaController');
        Route::resource('house', 'HouseController');
        Route::get('house/switch-status/{id}', 'HouseController@switch')->name('house.status');

        Route::get('booking-request-list', 'BookingController@bookingRequestListForLandlord')->name('bookingRequestList');
        Route::post('booking-request/accept/{id}', 'BookingController@bookingRequestAccept')->name('request.accept');
        Route::post('booking-request/reject/{id}', 'BookingController@bookingRequestReject')->name('request.reject');
        Route::get('booking/history', 'BookingController@bookingHistory')->name('history');
        Route::get('booked/currently/renter', 'BookingController@currentlyStaying')->name('currently.staying');
        Route::post('renter/leave/{id}', 'BookingController@leaveRenter')->name('leave.renter');

        Route::get('profile-info', 'SettingsController@showProfile')->name('profile.show');
        Route::get('profile-info/edit/{id}', 'SettingsController@editProfile')->name('profile.edit');
        Route::post('profile-info/update/', 'SettingsController@updateProfile')->name('profile.update');
    });

//renter

Route::group(['as' => 'renter.', 'prefix' => 'renter', 'namespace' => 'renter', 'middleware' => ['auth', 'renter']],
    function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');

        Route::get('areas', 'DashboardController@areas')->name('areas');

        Route::get('houses', 'DashboardController@allHouses')->name('allHouses');
        Route::get('house/details/{id}', 'DashboardController@housesDetails')->name('houses.details');

        Route::get('profile-info', 'SettingsController@showProfile')->name('profile.show');
        Route::get('profile-info/edit/{id}', 'SettingsController@editProfile')->name('profile.edit');
        Route::post('profile-info/update/', 'SettingsController@updateProfile')->name('profile.update');

        Route::get('booking/history', 'DashboardController@bookingHistory')->name('booking.history');
        Route::get('pending/booking', 'DashboardController@bookingPending')->name('booking.pending');
        Route::post('pending/booking/cancel/{id}', 'DashboardController@cancelBookingRequest')->name('cancel.booking.request');

        Route::post('review', 'DashboardController@review')->name('review');
        Route::get('review-edit/{id}', 'DashboardController@reviewEdit')->name('review.edit');
        Route::post('review-update/{id}', 'DashboardController@reviewUpdate')->name('review.update');
    });
