<?php
declare (strict_types=1);

use Nette\Security\IIdentity;

class Authenticator implements \Nette\Security\Authenticator
{
	public function __construct(private \Nette\Database\Explorer $database, private \Nette\Security\Passwords $passwords)
	{
		
	}

	public function authenticate(string $user, string $password): IIdentity
	{
		$user = $this->database->table('user')->where('jmeno', $user)->fetch();
		
		if ($this->passwords->verify($password, $user->password) === false ) {
			throw new Nette\Security\AuthenticationException('Špatné heslo!');
		}

		if ($user === null) {
			throw new Nette\Security\AuthenticationException('Uživatel neexistuje');
		}
				return new IIdentity($user);
		
	}


}