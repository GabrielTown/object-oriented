<?php

/*
 * A class that does something
 * @author Gabriel Town
 */

class Author {
	/*
	 * State variable containing the id of author in question
	 * Primary key
	 * @var UUID $authorId
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

	public function __construct() {

	} //end of construct function

	public function getAuthorId() : string {
		return $this->authorId;
	} //end of getAuthorId function

	public function setAuthorId(string $newAuthorId) {
		if(strlen($newAuthorId) != 32){
			throw new \Exception("Author ID must be a UUID ", 1);
		}
		$this->authorId = $newAuthorId;
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