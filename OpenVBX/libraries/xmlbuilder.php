<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * Array to XML document builder
 *
 * @package		xmlbuilder
 * @copyright	Copyright (c) 2011, Lycos, Inc.
 * @author		Andrei Oprisan
 * @license		internal
 * @link		http://www.lycos.com
 * @version		1.0
 */

// ------------------------------------------------------------------------

class xmlbuilder
{
	var $xmldoc;
	var $debug = true;
	
	public function __construct($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if ($this->debug)
					echo "param ".$key." val ".$val."<br>";
				$this->$key = $val;
			}
		}
	}
	
	public function index()
	{
		$this->xmldoc = NULL;
		return true;
	}

	// encode xml file -> &lt;xml&gt; tag to <xml>
	public function encode($array)
	{
		$this->xmldoc = NULL;
		$this->writeXMLTree($array);
		return htmlentities(html_entity_decode($this->xmldoc));
	}

	// decoded xml file -> <xml> tag to &lt;xml&gt;
	public function decode($array)
	{
		$this->xmldoc = NULL;
		$this->writeXMLTree($array);
		return html_entity_decode($this->xmldoc);
	}
	
	public function writeXMLTree($array)
	{
		if (is_array($array))
		{
			foreach ($array as $key => $value)
			{
				if ($key == "value")
				{
					$this->xmldoc .= '<'.$this->stripStartTag($key).'><![CDATA[';
					$this->xmldoc .= $this->writeXMLTree($value);
					$this->xmldoc .= ']]></'.$this->stripEndTag($key).'>';
				} else {
					$this->xmldoc .= '<'.$this->stripStartTag($key).'>';
					$this->xmldoc .= $this->writeXMLTree($value);
					$this->xmldoc .= '</'.$this->stripEndTag($key).'>';
				}
			}
		} else {
			return $array;
		}
	}

	public function stripStartTag($tag)
	{
		return $tag;
	}
	
	public function stripEndTag($tag)
	{
		$tmp = explode(" ", $tag);
		return $tmp[0];
	}
}

?>