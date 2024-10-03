<?php
/**
 * Role : test
 */

use App\Modeles\User;

require_once __DIR__ . "/../Utils/init.php";
$rowidTiers = 15007;
$user = new User($rowidTiers);
var_dump($user->get("datec"));
$date = "2024-08-14 2008:14:31";
var_dump(formatDateEntier ($user->get("datec")));