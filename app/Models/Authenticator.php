<?php
declare (strict_types=1);

use Nette\Security\Identity;
use Nette\Security\IIdentity;

class Authenticator implements \Nette\Security\Authenticator
{
	public function __construct(private \Nette\Database\Explorer $database, private \Nette\Security\Passwords $passwords,)
	{}

	public function authenticate(string $user, string $password): IIdentity
	{
		$user = $this->database->table('user')->where('jmeno', $user)->fetch();

		if (!$this->passwords->verify($password, $user->password)) {
			throw new Nette\Security\AuthenticationException('Invalid password.');
		}
				return new IIdentity($user);   
		
	}


}