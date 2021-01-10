<?php

use App\Models\User;

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

Route::get('/address', function () {
    return view('address');
});

Route::get('/register', function () {
	// load the registration form view
    return view('register');
});

Route::post('/register', function (\Illuminate\Http\Request $request) {

	// get posted vars
	$vars = [
		'name' => trim($request->Name),
		'email' => strtolower(trim($request->Email)),
		'postcode' => strtoupper(trim($request->Postcode)),
		'msg' => ''
	];

	// check postcode
	$client = new GuzzleHttp\Client(
		['http_errors' => false]
	);
	$res = $client->get("http://api.postcodes.io/postcodes/{$vars['postcode']}");
	//echo $res->getBody();

	if(200 === $res->getStatusCode()) {

		// postcode OK, add to database
		$valid = true;
		$user = new User();
		$user->name = $vars['name'];
		$user->email = $vars['email'];
		$user->postcode = $vars['postcode'];
		$user->save();

		// send confirmation email
		Mail::send(
			'email',
			$vars,
			function($message) use ($vars) {
				$message
					->to($vars['email'])
					->from('test@localhost.com', 'RMR')
					->subject('Registration confirmed');
			}
		);
		if (Mail::failures()) {
			// show errors
			var_dump(Mail::failures()); exit;
		}

	} else {
		// postcode failed
		$valid = false;
		$vars['msg'] = 'Postcode is invalid';
	}

	return view('register-result',[
		'valid' => $valid,
		'vars' => $vars,
	]);

});
