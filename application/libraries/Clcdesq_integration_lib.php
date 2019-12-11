<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CLCdesq API REST client Connector
 *
 * Interface for communicating with the CLCdesq Product Push API
 */

class Clcdesq_integration_lib
{
	private $api_key;
	private $api_url;
	
	/**
	 * Constructor
	 */
	public function __construct($api_key = '')
	{
		$CI =& get_instance();

		$this->_api_key	= $CI->encryption->decrypt($CI->Appconfig->get('clcdesq_api_key'));
		$this->_api_url	= $CI->encryption->decrypt($CI->Appconfig->get('clcdesq_api_url'));
	}

	public function new_product_push(array $data)
	{
//TODO: Gather data to send to the Product Push API
//TODO: Format the data to a json request
//TODO: Use the API key and url to send the request
//TODO: The result of the API Product Push should be a GUID.  Store that in the database as an attribute for the pushed product		
		return NULL;
	}
	
	public function update_product_push(array $data)
	{
//TODO: For now, the update product push is identical to the new product push except that we are sending the GUID
		return NULL;
	}
	
	public function delete_product_push(array $data)
	{
		return NULL;
	}
}