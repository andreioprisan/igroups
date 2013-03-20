<?php

/**
  * Copyright (C) 2009 Andy Leon (acleon@acleon.co.uk)
  *
  * This program is free software: you can redistribute it and/or modify
  * it under the terms of the GNU General Public License as published by
  * the Free Software Foundation, either version 3 of the License, or
  * (at your option) any later version.
  *
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  * GNU General Public License for more details.
  *
  * You should have received a copy of the GNU General Public License
  * along with this program.  If not, see <http://www.gnu.org/licenses/>.
  *
  */

class Galvanize {

	protected $Profile = NULL;
	protected $Hostname = NULL;
	protected $Referer = '-';
	protected $DomainName = 'auto';
	protected $CookiePath = '/';
	
	// Timeouts
	protected $CookieTimeout = 15724800;
	protected $SessionTimeout = 1800;
	
	protected $ScreenResolution = '-';
	protected $ScreenColourDepth = '-';
	protected $Language = '-';
	protected $Charset = '-';
	protected $UserVariable = '-';
	protected $JavaEnabled = '-';
	protected $FlashVersion = '-';
	
	public $Response = NULL;
	public $Request = NULL;
	
	// Problems with duplicate array keys here!
	protected $Organics = array(
	'google' => 'q', 'yahoo' => 'p', 'msn' => 'q', 'aol' => 'q',
	/* 'aol' => 'enquery', */ 'lycos' => 'query', 'ask' => 'q',
	'altavista' => 'q', 'netscape' => 'query', 'cnn' => 'query',
	'looksmart' => 'qt', 'about' => 'terms', 'mamma' => 'query',
	'alltheweb' => 'q', 'gigablast' => 'q', 'voila' => 'rdata',
	'virgilio' => 'qs', 'live' => 'q', 'baidu' => 'wd', 'alice' => 'qs',
	'yandex' => 'text', 'najdi' => 'q', 'club-internet' => 'query',
	'mama' => 'query', 'seznam' => 'q', 'search' => 'q',
	'wp' => 'szukaj', 'onet' => 'qt', 'netsprint' => 'q',
	'google.interia' => 'q', 'szukacz' => 'q', 'yam' => 'k',
	'pchome' => 'q', 'kvasir' => 'searchExpr', 'sesam' => 'q',
	'ozu' => 'q', 'terra' => 'query', 'nostrum' => 'query',
	'mynet' => 'q', 'ekolay' => 'q', 'search.ilse' => 'search_for');
	protected $IgnoredRefs = array();
	
	protected $RedirectType = 1;
	protected $NumberOfPageViews = 0;
	
	function __construct($Profile = NULL) {
		if(is_null($Profile)) throw new Exception('Google Analytics code not supplied');
		// Add some validation of the code in here
		else $this->Profile = $Profile;
		
		$this->Hostname = $_SERVER['HTTP_HOST'];
		if(isset($_SERVER['HTTP_REFERER'])) $this->Referer = $_SERVER['HTTP_REFERER'];
		if(isset($_COOKIE['__utmsr'])) $this->ScreenResolution = $_COOKIE['__utmsr'];
		if(isset($_COOKIE['__utmsc'])) $this->ScreenColourDepth = $_COOKIE['__utmsc'];
		if(isset($_COOKIE['__utmje'])) $this->JavaEnabled = $_COOKIE['__utmje'];
		if(isset($_COOKIE['__utmfl'])) $this->FlashVersion = $_COOKIE['__utmfl'];
		if(isset($_SERVER['HTTP_ACCEPT_CHARSET'])) $this->Charset = current(explode(',', current(explode(';', $_SERVER['HTTP_ACCEPT_CHARSET']))));
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) $this->Language = current(explode(',', current(explode(';', $_SERVER['HTTP_ACCEPT_LANGUAGE']))));
		
		$Timestamp = time();
		
		if(isset($_COOKIE['__utma'])) {
			// If UTMA is set, get the UTMA value
			$this->UTMA = explode('.', $_COOKIE['__utma']);
			if(!isset($_COOKIE['__utmb']) || !isset($_COOKIE['__utmc'])) {
				$this->UTMA[5]++; // Increase the UTMA visit number
				$this->UTMA[3] = $this->UTMA[4]; // Bump the previous visit timestamp left
				$this->UTMA[4] = $Timestamp; // Insert the new visit timestamp
				$this->UTMB = array($this->UTMA[0], 1, 10, $Timestamp); // Create UTMB from UTMA
				$this->UTMC = array($this->UTMA[0]); // Create UTMC from UTMA
				// Recreate the UTMZ value here
			} else {
				// Just read the UTMB, UTMC and UTMZ cookies and then increase the impression count in UTMB
				$this->UTMB = explode('.', $_COOKIE['__utmb']);
				$this->UTMB[1]++;
				$this->UTMC = explode('.', $_COOKIE['__utmc']);
				$this->UTMZ = explode('.', $_COOKIE['__utmz']);
			}
		} else {
			// if the UTMA isn't set, set it and the UTMB and UTMC. Get the the UTMZ referer and write that as well
			$this->UTMA = array(rand(10000000,99999999), rand(1000000000,2147483647), $Timestamp, $Timestamp, $Timestamp, 1);
			$this->UTMB = array($this->UTMA[0], 1, 10, $Timestamp);
			$this->UTMC = array($this->UTMA[0]);
			// Get the traffic source and build the UTMZ variable
			$TS = $this->getTrafficSource();
			$this->UTMZ = array($this->UTMA[0], $Timestamp, 1, 1, 'utmcsr='.$TS[0].'|utmccn='.$TS[1].'|utmcmd='.$TS[2]);
			if(!is_null($TS[3])) $this->UTMZ[4] .= '|utmctr='.$TS[3];
			if(!is_null($TS[4])) $this->UTMZ[4] .= '|utmcct='.$TS[4];
		}
		
		// If we can save the cookies down, then let's do so...
		if(!headers_sent()) {
			setcookie('__utma', implode('.', $this->UTMA), $Timestamp + 63072000, $this->CookiePath, $this->getDomain());
			setcookie('__utmb', implode('.', $this->UTMB), $Timestamp + $this->SessionTimeout, $this->CookiePath, $this->getDomain());
			setcookie('__utmc', implode('.', $this->UTMC), 0, $this->CookiePath, $this->getDomain());
			setcookie('__utmz', implode('.', $this->UTMZ), $Timestamp + $this->CookieTimeout, $this->CookiePath, $this->getDomain());
		}
	}
	
	function outputJavascript() { ?>

		<script type="text/javascript">
			var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
			document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
			try{
				var pageTracker = _gat._getTracker("<?=$this->Profile;?>");
				pageTracker._trackPageview();
			} catch(err) {}
		</script>
		<script type="text/javascript">
			// Calculate some variables and set them as cookies so we can find them later
			
			// Create an expiry date for cookies
			var CookieDate = new Date();
			CookieDate.setTime(CookieDate.getTime() + <?=$this->SessionTimeout;?>); // Use the same expiration as the session
			
			var ScreenRes = window.screen.width + '.' + window.screen.height;
			var ColourDepth = window.screen.colorDepth + '-bit';
			// Need code to detect whether Java is enabled and which
			// Flash version is running. These values need to be saved
			// into cookies called __utmje and __utmfl.
			document.cookie = '__utmsr='+ScreenRes+'; expires='+CookieDate.toGMTString()+'; path=/';
			document.cookie = '__utmsc='+ColourDepth+'; expires='+CookieDate.toGMTString()+'; path=/';
		</script>

	<?php }
	
	function outputRedirect($PageURL = NULL) {
		// Polish function for relative / absolute URLS and https:// connections
		if($PageURL == NULL) return false;
		if(substr($PageURL, 0, 7) != "http://") {
			$PageURL = 'http://'.$_SERVER['HTTP_HOST'].$PageURL;
		}
		header('HTTP/1.1 301 Moved Permanently');
		header('Location: '.$PageURL);
	}
	
	function trackPageView($PageURL = NULL, $PageTitle = NULL) {
		if($this->NumberOfPageViews == 0) {
			// Give the user the option to supply a custom page URL or,
			// if not set, then use the $_SERVER variable
			if(is_null($PageURL)) $PageURL = $_SERVER['REQUEST_URI'];

			$var_uservar='-'; //enter your own user defined variable
		
			$urchinUrl = '/__utm.gif';
			$urchinUrl .= "?utmwv=4.5.7";
			$urchinUrl .= '&utmn='.rand(1000000000,9999999999);
			$urchinUrl .= '&utmhn='.$this->Hostname;
			$urchinUrl .= '&utmcs='.$this->Charset;
			$urchinUrl .= '&utmsr='.$this->ScreenResolution;
			$urchinUrl .= '&utmsc='.$this->ScreenColourDepth;
			$urchinUrl .= '&utmul='.$this->Language;
			$urchinUrl .= '&utmje='.$this->JavaEnabled;
			$urchinUrl .= '&utmfl='.$this->FlashVersion;
			$urchinUrl .= '&utmdt='.rawurlencode($PageTitle);
			$urchinUrl .= '&utmr='.$this->Referer;
			$urchinUrl .= '&utmp='.$PageURL;
			$urchinUrl .= '&utmac='.$this->Profile;
			// $urchinUrl .= '&utmt='.$this->UserVariable; // Check if we should put this in if it's blank
			$urchinUrl .= '&utmcc=__utma%3D'.implode('.', $this->UTMA).'%3B%2B__utmz%3D'.implode('.', $this->UTMZ).'%3B';
			
			$this->NumberOfPageViews++; // Increment the number of page views processed
			
			echo $this->retrieveGif($urchinUrl);
		} else {
			throw new Exception('Attempting to register a second page view.');
		}
	}
	
	function trackEvent($Category, $Action, $Label = NULL, $Value = NULL) {
		// Add event tracking code in here. Label (string) and Value (int) are optional.
	}
	
	// Cookie and timeout related functions
	
	function setDomain($DomainName = 'auto') {
		$this->Domain = $DomainName;
	}
	
	function setCookieTimeout($CookieTimeout = 15724800) {
		if(is_int($CookieTimeout)) {
			$this->CookieTimeout = $CookieTimeout;
			return true;
		} else return false;
	}
	
	function setCookiePath($CookiePath = '/') {
		if(substr($CookiePath, 0, 1) != '/') $CookiePath = '/'.$CookiePath;
		if(substr($CookiePath, -1, 1) != '/') $CookiePath .= '/';
		$this->CookiePath = $CookiePath;
	}
	
	function setSessionTimeout($SessionTimeout = 1800) {
		if(is_int($SessionTimeout)) {
			$this->SessionTimeout = $SessionTimeout;
			return true;
		} else return false;
	}
	
	/* Functions to add organics to the list, and also
	to clear the organics list. Need to check whether the
	Javascript version of the clearOrganic() functions clears
	everything or just ones the user has set */
	
	function addOrganic($Engine, $Keyword) {
		$this->Organics[$Engine] = $Keyword;
		return true;
	}
	
	function clearOrganic() {
		$this->Organics = array();
		return true;
	}
	
	/* Functions for adding and clearing ingnored referrals. */
	
	function addIgnoredRef($IgnoredReferer) {
		$this->IgnoredRefs[] = $IgnoredReferer;
		return true;
	}
	
	function clearIgnoredRef() {
		$this->IgnoredRefs = array();
		return true;
	}
	
	/* PROTECTED / PRIVATE FUNCTIONS */
	
	/* This function returns an array of the various UTMZ
	properties. It tries to build organic or referral-based
	UTMZ values. If it can't, it will return a (direct) */
	
	function getDomain() {
		if($this->DomainName == "auto") return $_SERVER['HTTP_HOST'];
		else return $this->DomainName;
	}

	function retrieveGif($urchinUrl) {
		$this->Request = '';
		$this->Response = NULL;
		$fp = fsockopen('www.google-analytics.com', 80);
		$this->Request .= 'GET '.$urchinUrl.' HTTP/1.0'."\r\n";
		$this->Request .= "Host: www.google-analytics.com\r\n";
		$this->Request .= "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n";
		$this->Request .= "Referer: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\r\n";
		$this->Request .= "Accept: image/png,image/*;q=0.8,*/*;q=0.5\r\n";
		$this->Request .= "Accept-Language: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."\r\n";
		$this->Request .= "Accept-Encoding: ".$_SERVER['HTTP_ACCEPT_ENCODING']."\r\n";
		$this->Request .= "Accept-Charset: ".$_SERVER['HTTP_ACCEPT_CHARSET']."\r\n";
		$this->Request .= "Connection: close\r\n";
		$this->Request .= "\r\n\r\n";
		fwrite($fp, $this->Request);
		while(!feof($fp)) $this->Response .= fgets($fp, 128);
		fclose($fp);
	}
	
	function cookieFromIP() {
		$IPAddress = $_SERVER['REMOTE_ADDR'];
		$IP = explode('.', $IPAddress);
		$IPNumber = ($IP[0] + 1) * ($IP[1] + 1) * ($IP[2] + 1) * ($IP[3] + 1);
		$IPNumber = $IPNumber % 99999999;
		return $IPNumber;
	}

	function getTrafficSource() {
		/* Constructs an array of the same format as the getSourceFromUTMZ()
		function, only using the referring URL to detect organics and
		referrals. */
		
		$Direct = array('(direct)', '(direct)', '(none)', NULL, NULL);
		
		// If the referer's not set, pass back a (direct)
		if(!isset($_SERVER['HTTP_REFERER'])) {
			return $Direct;
		} else {
			// Parse the referring URL
			$ParsedURL = parse_url($_SERVER['HTTP_REFERER']);
				
			// Check for organic search engine referrals
			// Need to add code for ignored organics in here as well
			foreach($this->Organics as $Organic => $Variable) {
				if(strstr($ParsedURL['host'], $Organic) && strstr($ParsedURL['query'], $Variable.'=')) {
					$Query = explode('&', $ParsedURL['query']);
					foreach($Query as $QueryItem) {
						if(substr($QueryItem, 0, strlen($Variable) + 1) == $Variable."=")
							$UTMCTR = substr($QueryItem, strlen($Variable) + 1);
					}
					return array($Organic, '(organic)', 'organic', $UTMCTR, NULL);
				}
			}
			
			// CHECK FOR REFERRALS
			// See if we can match the tracking domain to the referring host. If
			// we can then return a (direct), if not return a (referral).
			if(preg_match('/'.$this->Domain.'$/', $ParsedURL['host'])) {
				return $Direct;
			} else {
				// Loop through ignored referers. If there's a match, return (direct)
				foreach($this->IgnoredRefs as $IgnoredRed) {
					if(preg_match('/'.$IgnoredRef.'$/', $ParsedURL['host'])) {
						return $Direct;
					}
				}
				// Finally, return (referral) if nothing else has returned so far
				return array($ParsedURL['host'], '(referral)', 'referral', NULL, $ParsedURL['path']);
			}
		}
	}

}

?>
