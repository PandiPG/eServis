<?php
declare (strict_types=1);

namespace App\Models;

use Nette;
use Nette\Security\SimpleIdentity;

class Authenticator implements Nette\Security\Authenticator
{
	public $database;
	public $passwords;

	public function __construct(Nette\Database\Explorer $database, Nette\Security\Passwords $passwords) {
		$this->database = $database;
        $this->passwords = $passwords;
	}

	public function authenticate(string $user, string $password): Nette\Security\IIdentity
	{
		$row = $this->database->table('user')
			->where('jmeno', $user)
			->fetch();
		bdump($row);

			if (!$row) {
				throw new Nette\Security\AuthenticationException('Použivatelske jmeno se nenašlo');
			}

			if (!$this->passwords->verify($password, $row->heslo)) {
				throw new Nette\Security\AuthenticationException('Špatné heslo!');
			}

			return new SimpleIdentity(
				$row->id,
				['jmeno' => $row->jmeno],
			);

	}
}