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
		'postcode' => strtoupper(trim($_POST['Postcode'])),
		'msg' => ''
	];

	$client = new GuzzleHttp\Client(
		['http_errors' => false]
	);
	$res = $client->get("http://api.postcodes.io/postcodes/{$vars['postcode']}");
	//echo $res->getBody();
	if(200 === $res->getStatusCode()) {
		// postcode OK, add to database
		$valid = true;
		$sql = "
		INSERT INTO users 
		(name,email,postcode)
		VALUES
		(?,?,?);";
		DB::insert($sql, [$vars['name'],$vars['email'],$vars['postcode']]);
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
