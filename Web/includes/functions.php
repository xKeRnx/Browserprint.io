<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
function apiRequest($url, $post = FALSE, $headers = array())
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);

	if ($post)
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

	$headers[] = 'Accept: application/json';

	if (session('access_token'))
		$headers[] = 'Authorization: Bearer ' . session('access_token');

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	return json_decode($response);
}

function get($key, $default = NULL)
{
	return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default = NULL)
{
	return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}

function generateRandomString($length)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}