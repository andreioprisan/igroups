<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
	**********************************************************
	Usage
	
	$this->load->helper('xml');

	$dom = xml_dom();
	$book = xml_add_child($dom, 'book');
	
	xml_add_child($book, 'title', 'Hyperion');
	$author = xml_add_child($book, 'author', 'Dan Simmons');		
	xml_add_attribute($author, 'birthdate', '1948-04-04');

	xml_print($dom);
	
	**********************************************************
	Result

	<?xml version="1.0"?>
	<book>
	  <title>Hyperion</title>
	  <author birthdate="1948-04-04">Dan Simmons</author>
	</book>

 */


if ( ! function_exists('xml_dom'))
{
	function xml_dom()
	{
		return new DOMDocument('1.0');
	}
}


if ( ! function_exists('xml_add_child'))
{
	function xml_add_child($parent, $name, $value = NULL, $cdata = FALSE)
	{
		if($parent->ownerDocument != "")
		{
			$dom = $parent->ownerDocument;			
		}
		else
		{
			$dom = $parent;
		}
		
		$child = $dom->createElement($name);		
		$parent->appendChild($child);
		
		if($value != NULL)
		{
			if ($cdata)
			{
				$child->appendChild($dom->createCdataSection($value));
			}
			else
			{
				$child->appendChild($dom->createTextNode($value));
			}
		}
		
		return $child;		
	}
}


if ( ! function_exists('xml_add_attribute'))
{
	function xml_add_attribute($node, $name, $value = NULL)
	{
		$dom = $node->ownerDocument;			
		
		$attribute = $dom->createAttribute($name);
		$node->appendChild($attribute);
		
		if($value != NULL)
		{
			$attribute_value = $dom->createTextNode($value);
			$attribute->appendChild($attribute_value);
		}
		
		return $node;
	}
}


if ( ! function_exists('xml_print'))
{
	function xml_print($dom, $return = FALSE)
	{
		$dom->formatOutput = FALSE;
		$xml->preserveWhiteSpace = FALSE; 
		
		$xml = $dom->saveXML();
		if ($return)
		{
			return $xml;
		}
		else
		{
			echo $xml;
		}
	}
}

/* End of file xml_helper.php */
/* Location: ./system/application/helpers/MY_xml_helper.php */
