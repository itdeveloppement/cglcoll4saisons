<?php
/**
 * Role : test
 */

use App\Modeles\User;

require_once __DIR__ . "/../Utils/init.php";
$rowidTiers = 15004;
$user = new User($rowidTiers);
var_dump($user->get("datec"));
var_dump(formatDateEntier ($user->get("datec")));