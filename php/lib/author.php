<?php
namespace GabrielTown\ObjectOriented;
require_once (dirname(__DIR__) . "/Classes/autoload.php");
use GabrielTown\ObjectOriented\Author;
$hash = password_hash("password", PASSWORD_ARGON2I, ["time_cost" => 7]);
var_dump($hash);
$oliverKlozoff = new Author('6145f31f-8a8f-4492-baf2-ba1082ecc0ef', '66941404092275938727437995023979 ', 'www.twitter.com', 'oklozoff@gmail.com', $hash, 'klozoff' );

var_dump($oliverKlozoff);
