<?php
namespace Application\Controller;

use \Gria\Controller;
use \Application\Helper;

class Dashboard extends Controller\Controller
{

	private $_helper = array();

	public function indexAction()
	{
		$stats = array();
		$weeks = array(49, 50);
		$repoCount = 0;
		$github = new Helper\GitHub;
		$repositories = $github->getAllRepositories('griasolutions');

		foreach ($repositories as $repo) {
			$repoName = $repo['name'];
			$activity = $github->api('repo')->activity('griasolutions', $repoName);
			foreach ($weeks as $week) {
				if (isset($activity[$week]) && isset($activity[$week]['total'])) {
					$stats[$week][$repoName] = $activity[$week]['total'];
				}
			}
			$repoCount++;
		}
		echo 'repo count: ' . $repoCount . '<br>';
		echo sprintf('week 49: %d ' . '<br>' . 'week 50: %d',
			array_sum(array_values($stats[49])), array_sum(array_values($stats[50])));
		exit;
	}

}