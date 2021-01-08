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

Route::get('/address', function () {
    return view('address');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', function () {
	$vars = [
		'name' => trim($_POST['Name']),
		'email' => strtolower(trim($_POST['Email'])),
		'postcode' => trim($_POST['Postcode']),
		'msg' => ''
	];

	$client = new GuzzleHttp\Client(
		['http_errors' => false]
	);
	$res = $client->get("http://api.postcodes.io/postcodes/{$vars['postcode']}");
	//echo $res->getBody();
	if(200 === $res->getStatusCode()) {
		// postcode OK
		$valid = true;
		$sql = "
		INSERT INTO users 
		(name,email,postcode)
		VALUES
		(?,?,?);";
		DB::insert($sql, [$vars['name'],$vars['email'],$vars['postcode']]);

		$body = "Thank you for registering!";
		Mail::raw($body, function ($message) use($vars) {
			$message->to($vars['email']);
			$message->from('rmanleyreeve@gmail.com', 'RMR');
			$message->subject('Laravel test email');
		});
		if (Mail::failures()) {
			// return response showing failed emails
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
