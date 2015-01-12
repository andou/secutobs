<?php

define('ABSPATH', __DIR__);
require_once 'inc/presentation.php';
require_once 'inc/bl.php';
$request = isset($_GET['q']) ? $_GET['q'] : "index";
bit_access_only_with_cookie_or_password();
bit_include_template($request);