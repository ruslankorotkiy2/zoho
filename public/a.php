<?php

function generate_refresh_token()
{
	$post = [
		'code' => '1000.2de63349362137eff6a8b17705c3d3aa.859b9d12e43e77127952aa34881abdc9',
		'redirect_url' => 'http;//zoho',
    'client_id' => '1000.AW2DOD5SYKF2MC13SSPS3M5IXA3YDZ',
    'client_secret' => '7ecb945ff2bd1891cc74f5d2ee16af9ae4fa7339ea',
	'grant_type' => 'authorization_code'
	];
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL , "https://accounts.zoho.com/oauth/v2/token");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_HEADER, array('Content-Type: application/x-www-form-urlencoded'));

	$response = curl_exec($ch);
	$response = json_encode($response);
	var_dump($response);
}

generate_refresh_token();

/*
Scope
ZohoCRM.modules.ALL
*/
?>