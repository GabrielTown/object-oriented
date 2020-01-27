<?php
namespace GabrielTown\ObjectOriented;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/*
 * A class that does something
 * @author Gabriel Town
 */

class Author {
	use ValidateUuid;

	/*
	 * State variable containing the id of author in question
	 * Primary key
	 * @var Uuid $authorId
	 */
	private $authorId;
	/*
	 * State variable containing the activation token of author in question
	 * @var string $authorActivationToken
	 */
	private $authorActivationToken;
	/*
	 * State variable containing the avatar URL of author in question
	 * @var string $authorAvatarUrl
	 */
	private $authorAvatarUrl;
	/*
	 * State variable containing the email of author in question
	 * Unique
	 * @var string $authorEmail
	 */
	private $authorEmail;
	/*
	 * State variable containing the Hash of author in question
	 * @var string $authorHash
	 */
	private $authorHash;
	/*
	 * State variable containing the Username of author in question
	 * Unique
	 * @var string $authorUserName
	 */
	private $authorUsername;

	public function __construct($authorId, $authorActivationToken, $authorAvatarUrl, $authorEmail, $authorHash, $authorUsername) {
		try {
			$this->setAuthorId($newAuthorId);
			$this->setAuthorActivationToken($newAuthorActivationToken);
			$this->setAuthorAvatarUrl($newAuthorAvatarUrl);
			$this->setAuthorEmail($newAuthorEmail);
			$this->setAuthorHash($newAuthorHash);
			$this->setAuthorUsername($newAuthorUsername);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	} //end of construct function

	/**
	 * accessor method for author id
	 *
	 * @return Uuid value of author id
	 **/
	public function getAuthorId() : \Ramsey\Uuid\Uuid {
		return($this->authorId);
	} //end of getAuthorId function

	/**
	 * mutator method for tweet id
	 *
	 * @param Uuid|string $newAuthorId new value of author id
	 * @throws \RangeException if $newAtuhorId is not positive
	 * @throws \TypeError if $newAuthorId is not a uuid or string
	 **/
	public function setAuthorId($newAuthorId) {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the author id
		$this->authorId = $uuid;
	} //end of setAuthorId function

	public function getAuthorActivationToken() : string {
		return $this->authorActivationToken;
	} //end of getAuthorActivationToken function

	public function setAuthorActivationToken(string $newAuthorActivationToken) {
		if(strlen($newAuthorActivationToken) != 32){
			throw new \Exception("Activation Token must be 32 characters ", 1);
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	} //end of setAuthorActivationToken function




} //end of Author class