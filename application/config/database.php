<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!defined('ENVIRONMENT')) {
	define('ENVIRONMENT', 'development'); // fallback untuk editor
}

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'      => '',
	'hostname' => 'localhost',
	'username' => 'root',       // default user XAMPP
	'password' => '',           // default password XAMPP kosong
	'database' => 'perkara_db', // ganti sesuai nama database kamu
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8mb4',       // lebih aman untuk UTF-8 lengkap
	'dbcollat' => 'utf8mb4_general_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
