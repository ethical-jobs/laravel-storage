<?php

namespace Tests\Fixtures\Repositories;

use EthicalJobs\Storage\DatabaseRepository;
use Tests\Fixtures\Models;

/**
 * Person database repository fixture
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class PersonDatabaseRepository extends DatabaseRepository
{
	/**
	 * Object constructor
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct(new Models\Person);
	}
}