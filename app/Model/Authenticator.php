<?php
declare (strict_types=1);
namespace App\Model;
use Nette;

class Authenticator implements \Nette\Security\Authenticator
{
	public $database;
	public $passwords;

	public function __construct(\Nette\Database\Explorer $database, \Nette\Security\Passwords $passwords) {
		$this->database = $database;
		$this->passwords = $passwords;
	}
		
	public function authenticate(string $username, string $password): Nette\Security\IIdentity
	{
		$user = $this->database->table('user')->where('jmeno', $username)->fetch();

		if ($user === null) {
			throw new \Nette\Security\AuthenticationException('Not Found');
		}
		
	}


}