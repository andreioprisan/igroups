<?php

class Cron extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		echo "[cron] - index @ ".date("m-d-Y h:m:s")."";
	}
	
	function builddnsfile()
	{
		echo "[cron] - Domains BuildDNSFile @ ".date("m-d-Y h:m:s")." - STARTED\n";
		$this->load->library("Dns/builddnsfile", array('debug' => '0'));
		$tinydnsfile = $this->builddnsfile->writedns();
		echo "[cron] - Domains BuildDNSFile @ ".date("m-d-Y h:m:s")." - ";
		if ($tinydnsfile)
		{
			echo "SUCCESS";
		} else {
			echo "FAILURE";
		}
		echo "\n";
		echo "[cron] - Domains BuildDNSFile @ ".date("m-d-Y h:m:s")." - ENDED\n";
	}
	
	function getexpiring()
	{
		$domain_name = "lycostest".mt_rand().".com";
		$defInfo = array(	'domain_name'	=>	$domain_name,
							'debug'			=>	'0',
							'slimInit'		=>	'0');
		$this->load->library('Registrars/Registrar', $defInfo);

		var_dump($this->registrar->getExpiringDomainsList(30));
	}
	
	function getexpiringmonth()
	{
		$domain_name = "lycostest".mt_rand().".com";
		$defInfo = array(	'domain_name'	=>	$domain_name,
							'debug'			=>	'1',
							'slimInit'		=>	'0');
		$this->load->library('Registrars/Registrar', $defInfo);

		var_dump($this->registrar->getExpiringDomainsList(30));
	}
	
	function getexpiringyear()
	{
		$domain_name = "lycostest".mt_rand().".com";
		$defInfo = array(	'domain_name'	=>	$domain_name,
							'debug'			=>	'0',
							'live'			=>	'1',
							'slimInit'		=>	'0');
		$this->load->library('Registrars/Registrar', $defInfo);
		
		var_dump($this->registrar->getExpiringDomainsList(365));

//		var_dump($this->registrar->registrarInstance->melbourneit->getExpiringDomainsList(365));
	}
	
	function getexpired()
	{
		$domain_name = "lycostest".mt_rand().".com";
		$defInfo = array(	'domain_name'	=>	$domain_name,
							'debug'			=>	'1',
							'slimInit'		=>	'0');
		$this->load->library('Registrars/Registrar', $defInfo);

		var_dump($this->registrar->getExpiredDomainsList(3));
	}
	
	function getexpiredmonth()
	{
		$domain_name = "lycostest".mt_rand().".com";
		$defInfo = array(	'domain_name'	=>	$domain_name,
							'debug'			=>	'1',
							'slimInit'		=>	'0');
		$this->load->library('Registrars/Registrar', $defInfo);

		var_dump($this->registrar->getExpiredDomainsList(30));
	}
	
	
	function renewexpiring()
	{
		$domain_name = "lycostest".mt_rand().".com";
		$defInfo = array(	'domain_name'	=>	$domain_name,
							'debug'			=>	'1',
							'slimInit'		=>	'0');
		$this->load->library('Registrars/Registrar', $defInfo);

		var_dump($this->registrar->renewExpiringDomains(3));
	}
	
	function renewexpiringmonth()
	{
		$domain_name = "lycostest".mt_rand().".com";
		$defInfo = array(	'domain_name'	=>	$domain_name,
							'debug'			=>	'1',
							'slimInit'		=>	'0');
		$this->load->library('Registrars/Registrar', $defInfo);

		var_dump($this->registrar->renewExpiringDomains(30));
	}
	
	function renewexpired()
	{
		$domain_name = "lycostest".mt_rand().".com";
		$defInfo = array(	'domain_name'	=>	$domain_name,
							'debug'			=>	'1',
							'slimInit'		=>	'0');
		$this->load->library('Registrars/Registrar', $defInfo);

		var_dump($this->registrar->renewExpiredDomains(3));
	}
	
	function renewexpiredmonth()
	{
		$domain_name = "lycostest".mt_rand().".com";
		$defInfo = array(	'domain_name'	=>	$domain_name,
							'debug'			=>	'1',
							'slimInit'		=>	'0');
		$this->load->library('Registrars/Registrar', $defInfo);

		var_dump($this->registrar->renewExpiredDomains(30));
	}
	
	function isAvailable()
	{
		$this->load->library('Registrars/Registrar');

		var_dump($this->registrar->registrarInstance->default->isAvailable());
//		var_dump($this->registrar->registrarInstance->default);
	}
	
	function xmlbuilder()
	{
		$this->load->library('xmlbuilder');
		
		$this->xmlbuilder->index();
		
	}

	function localeze()
	{
		$this->load->library('Localeze');
		
		$this->localeze->index();
		
		
	}
	
	function reseller()
	{
		$this->load->library('ResellerBiz');
		
		$this->resellerbiz->index();
	}
}

?>