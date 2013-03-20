<?php

class Stripe_Charge extends Stripe_ApiResource
{
  public static function constructFrom($values, $apiKey=null)
  {
    $class = get_class();
    return self::_scopedConstructFrom($class, $values, $apiKey);
  }

  public static function retrieve($id, $apiKey=null)
  {
    $class = get_class();
    $a = self::_scopedRetrieve($class, $id, $apiKey);
	return $a->_values;
  }

  public static function all($params=null, $apiKey=null)
  {
    $class = get_class();
    $a = self::_scopedAll($class, $params, $apiKey);
	return $a->_values;
  }

  public static function create($params=null, $apiKey=null)
  {
    $class = get_class();
	try
	{
	    $a = self::_scopedCreate($class, $params, $apiKey);
	} catch (Stripe_CardError $e) {
		throw new Exception('Problem with Stripe Charge: ', 1, $e);
	}
	return $a;
  }

  public function refund($params=null)
  {
    $requestor = new Stripe_ApiRequestor($this->_apiKey);
    $url = $this->instanceUrl() . '/refund';
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    $this->refreshFrom($response, $apiKey);
    return $this;
  }

  public function capture($params=null)
  {
    $requestor = new Stripe_ApiRequestor($this->_apiKey);
    $url = $this->instanceUrl() . '/capture';
    list($response, $apiKey) = $requestor->request('post', $url, $params);
    $this->refreshFrom($response, $apiKey);
    return $this;
  }
}
