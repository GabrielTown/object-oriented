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
	use ValidateDate;

	/*
	 * State variable containing the id of author in question; This is the Primary key
	 * @var Uuid $authorId
	 */
	private $authorId;
	/*
	 * State variable containing the activation token of author in question
	 * @var $authorActivationToken
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
	 * @var $authorHash
	 */
	private $authorHash;
	/*
	 * State variable containing the Username of author in question
	 * Unique
	 * @var string $authorUserName
	 */
	private $authorUsername;

	/**
	 * constructor for this Author
	 *
	 * @param string|Uuid $newAuthorId id of this Author or null if a new Author
	 * @param string $newAuthorActivationToken activation token of the Author
	 * @param string $newAuthorAvatarUrl string containing avatar url of Author
	 * @param string $newAuthorEmail string containing email of Author
	 * @param string $newAuthorHash string containing hash of Author
	 * @param string $newAuthorUsername string containing Username of Author
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
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
	 * @return Uuid value of author id (or null if new Profile)
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
	public function setAuthorId($newAuthorId): void {
		try {
			$uuid = self::validateUuid($newAuthorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the author id
		$this->authorId = $uuid;
	} //end of setAuthorId function

	/**
	 * accessor method for author activation token
	 *
	 * @return string value of author activation token
	 **/
	public function getAuthorActivationToken(): string {
		return $this->authorActivationToken;
	} //end of getAuthorActivationToken function

	/**
	 * mutator method for activation token
	 *
	 * @param string $newAuthorActivationToken value of activation token
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if $newAuthorActivationToken is not exactly 32 characters
	 * @throws \TypeError if $newAuthorActivationToken is not  string
	 **/
	public function setAuthorActivationToken(string $newAuthorActivationToken): void {
		if($newAuthorActivationToken === null) {
			$this->authorActivationToken = null;
			return;
		}
		$newAuthorActivationToken = strtolower(trim($newAuthorActivationToken));
		if(ctype_xdigit($newAuthorActivationToken) === false) {
			throw(new\RangeException("user activation is not valid"));
		}
		if(strlen($newAuthorActivationToken) !== 32){
			throw(new\RangeException("Activation Token must be 32 characters "));
		}
		$this->authorActivationToken = $newAuthorActivationToken;
	} //end of setAuthorActivationToken function

	/**
	 * accessor method for author avatar url
	 *
	 * @return string value of author avatar url
	 **/
	public function getAuthorAvatarUrl(): string {
		return $this->authorAvatarUrl;
	} //end of getAuthorAvatarUrl function

	/**
	 * mutator method for avatar url
	 *
	 * @param string $newAuthorAvatarUrl new value of avatar url
	 * @throws \InvalidArgumentException if $newAuthorAvatarUrl is not a valid url or insecure
	 * @throws \RangeException if $newAuthorAvatarUrl is > 255 characters
	 * @throws \TypeError if $newAuthorAvatarUrl is not a string
	**/
	public function setAuthorAvatarUrl(string $newAuthorAvatarUrl): string {
		//verify url is secure
		$newAuthorAvatarUrl = trim($newAuthorAvatarUrl);
		$newAuthorAvatarUrl = filter_var($newAuthorAvatarUrl, FILTER_VALIDATE_URL);
		if(empty($newAuthorAvatarUrl)===true) {
			throw(new \InvalidArgumentException("url is empty or insecure"));
		}
		//verify url will fit database
		if(strlen($newAuthorAvatarUrl) > 255) {
			throw(new \RangeException("author avatar url is too large"));
		}
		if(!is_string($newAuthorAvatarUrl)) {
			throw(new \TypeError("incorrect type"));
		}
		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	} //end of set avatar function

	/*
	* @return string value of email
	**/
	public function getAuthorEmail(): string {
		return $this->authorEmail;
	} // end getAuthorEmail function

	/**
	 * mutator method for email
	 *
	 * @param string $newAuthorEmail new value of email
	 * @throws \InvalidArgumentException if $newAuthorEmail is not a valid email or insecure
	 * @throws \RangeException if $newAuthorEmail is > 128 characters
	 * @throws \TypeError if $newAuthorEmail is not a string
	 **/
	public function setAuthorEmail(string $newAuthorEmail): void {
		// verify the email is secure
		$newAuthorEmail = trim($newAuthorEmail);
		$newAuthorEmail = filter_var($newAuthorEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newAuthorEmail) === true) {
			throw(new \InvalidArgumentException("author email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newAuthorEmail) > 128) {
			throw(new \RangeException("author email is too large"));
		}
		// verify email is a string
		if(!is_string($newAuthorEmail)) {
			throw(new \TypeError("incorrect type"));
		}
		// store the email
		$this->authorEmail = $newAuthorEmail;
	} // end of setAuthorEmail function

	/**
	 * accessor method for AuthorHash
	 *
	 * @return string value of hash
	 */
	public function getAuthorHash(): string {
		return $this->authorHash;
	} //end of getAuthorHash function

	/**
	 * mutator method for author hash password
	 *
	 * @param string $newAuthorHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setAuthorHash(string $newAuthorHash): void {
		//enforce that the hash is properly formatted
		$newAuthorHash = trim($newAuthorHash);
		if(empty($newAuthorHash) === true) {
			throw(new \InvalidArgumentException("author password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$authorHashInfo = password_get_info($newAuthorHash);
		if($authorHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("author hash is not a valid hash"));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newAuthorHash) !== 97) {
			throw(new \RangeException("author hash must be 97 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	} //end of setAuthorHash function







} //end of Author class