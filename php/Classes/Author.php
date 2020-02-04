<?php
namespace GabrielTown\ObjectOriented;
require_once("autoload.php");
require_once(dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;
/*
 * A class that takes author data and puts it in a database
 * @author Gabriel Town <rieltown@gmail.com>
 */
class Author implements  \JsonSerializable {
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
	 * @param $newAuthorActivationToken
	 * @param $newAuthorAvatarUrl
	 * @param $newAuthorEmail
	 * @param $newAuthorHash
	 * @param $newAuthorUsername
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct($newAuthorId, $newAuthorActivationToken, $newAuthorAvatarUrl, $newAuthorEmail, $newAuthorHash, $newAuthorUsername) {
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
	public function getAuthorId() : Uuid {
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


	/* Mutator method for avatar url

	 @param string $newAuthorAvatarUrl new value of avatar url
	 @throws \InvalidArgumentException if $newAuthorAvatarUrl is not a valid url or insecure
	 @throws \RangeException if $newAuthorAvatarUrl is > 255 characters
	 @throws \TypeError if $newAuthorAvatarUrl is not a string
	*/

	public function setAuthorAvatarUrl($newAuthorAvatarUrl): void {
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

		$this->authorAvatarUrl = $newAuthorAvatarUrl;
	} //end of set avatar function

	/*
	 *@return string value of email
	 */

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
		//enforce that the hash is exactly 96 characters.
		if(strlen($newAuthorHash) !== 96) {
			throw(new \RangeException("author hash must be 96 characters"));
		}
		//store the hash
		$this->authorHash = $newAuthorHash;
	} //end of setAuthorHash function


	/*
	* @return string value of username
	**/
	public function getAuthorUsername(): string {
		return $this->authorUsername;
	} // end getAuthorUsername function

	/**
	 * mutator method for Username
	 *
	 * @param string $newAuthorUsername new value of username
	 * @throws \InvalidArgumentException if the username is empty
	 * @throws \RangeException if $newAuthorUsername is > 32 characters
	 * @throws \TypeError if $newAuthorUsername is not a string
	 **/
	public function setAuthorUsername(string $newAuthorUsername): void {
		if(empty($newAuthorUsername) === true) {
			throw(new \InvalidArgumentException("author username is empty"));
		}

		// store the username
		$this->authorUsername = $newAuthorUsername;
	} // end of setAuthorUsername function

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["authorId"] = $this->authorId->toString();

		return($fields);
	}

	/**
	 * inserts this Author into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {

		// create query template
		$query = "INSERT INTO author(authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername) VALUES(:authorId, :authorActivationToken, :authorAvatarUrl, :authorEmail, :authorHash, :authorUsername)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["authorId" => $this->authorId->getBytes(), "authorActivationToken" => $this->authorActivationToken, "authorAvatarUrl" => $this->authorAvatarUrl, "authorEmail" => $this->authorEmail, "authorHash" => $this->authorHash, "authorUsername" => $this->authorUsername];
		$statement->execute($parameters);
	}

	/**
	 * updates this Author in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {

		// create query template
		$query = "UPDATE author SET authorActivationToken = :authorActivationToken, authorAvatarUrl = :authorAvatarUrl, authorEmail = :authorEmail, authorHash = :authorHash, authorUsername = :authorUsername WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);


		$formattedDate = $this->tweetDate->format("Y-m-d H:i:s.u");
		$parameters = ["tweetId" => $this->tweetId->getBytes(),"tweetProfileId" => $this->tweetProfileId->getBytes(), "tweetContent" => $this->tweetContent, "tweetDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Author from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {

		// create query template
		$query = "DELETE FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["authorId" => $this->authorId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * gets the Author by authorId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $authorId author id to search for
	 * @return Author|null Author found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getAuthorByAuthorId(\PDO $pdo, $authorId) : ?Author {
		// sanitize the tweetId before searching
		try {
			$authorId = self::validateUuid($authorId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM author WHERE authorId = :authorId";
		$statement = $pdo->prepare($query);

		// bind the author id to the place holder in the template
		$parameters = ["authorId" => $authorId->getBytes()];
		$statement->execute($parameters);

		// grab the tweet from mySQL
		try {
			$author = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($author);
	}

	/**
	 * gets all Authors
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Authors found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllAuthors(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT authorId, authorActivationToken, authorAvatarUrl, authorEmail, authorHash, authorUsername FROM author";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of tweets
		$authors = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$author = new Author($row["authorId"], $row["authorActivationToken"], $row["authorAvatarUrl"], $row["authorEmail"], $row["authorHash"], $row["authorUsername"]);
				$authors[$authors->key()] = $author;
				$authors->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($authors);
	}

} //end of Author class

