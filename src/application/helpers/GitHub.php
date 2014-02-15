<?php
/**
 * Created by IntelliJ IDEA.
 * User: gfisher
 * Date: 2/11/14
 * Time: 11:38 AM
 */

namespace Application\Helper;

use \Gria\Helper;
use \GitHub;

class GitHub
{

	private $_client;

	public function __construct()
	{
		$this->_client = new \Github\Client(
			new \Github\HttpClient\CachedHttpClient(array('cache_dir' => '/tmp/github-api-cache'))
		);
		//$this->_client->authenticate('', '', \Github\Client::AUTH_HTTP_PASSWORD);
	}

	public function getAllRepositories($owner)
	{
		$orgClient = $this->getClient()->api('organization');
		$iterator = new ResultPager($this->getClient());
		$parameters = array($owner);
		$repositories = $iterator->fetchAll($orgClient, 'repositories', $parameters);
		return $repositories;
	}

	public function api($name)
	{
		return $this->getClient()->api($name);
	}

	public function getClient()
	{
		return $this->_client;
	}

} 