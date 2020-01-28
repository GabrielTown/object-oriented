<?php
namespace GabrielTown\ObjectOriented;
require_once (dirname(__DIR__) . "/Classes/autoload.php");

use GabrielTown\ObjectOriented\Author;
$hash = password_hash("password", PASSWORD_ARGON2I, ["time_cost" => 7]);
//var_dump($hash);
$oliverKlozoff = new Author('6145f31f-8a8f-4492-baf2-ba1082ecc0ef', '66941404092275938727437995023979 ', 'https://www.twitter.com', 'oklozoff@gmail.com', $hash, 'klozoff' );

echo "Author Id:  {$oliverKlozoff->getAuthorId()}";
echo "<br>";
echo "Author Activation Hash: {$oliverKlozoff->getAuthorActivationToken()}";
echo "<br>";
echo "Author Avatar Url: {$oliverKlozoff->getAuthorAvatarUrl()}";
echo "<br>";
echo "Author Email: {$oliverKlozoff->getAuthorEmail()}";
echo "<br>";
echo "Author Hash: {$oliverKlozoff->getAuthorHash()}";
echo "<br>";
echo "Author Username: {$oliverKlozoff->getAuthorUsername()}";

