<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CLCdesq API REST client Connector
 *
 * Interface for communicating with the CLCdesq Product Push API
 */

class Clcdesq_integration_lib
{
	private $CI;
	private $api_key;
	private $api_url;
	
	/**
	 * Constructor
	 */
	public function __construct($api_key = '')
	{
		$this->CI =& get_instance();
		
		$this->_api_key	= $this->CI->encryption->decrypt($this->CI->Appconfig->get('clcdesq_api_key'));
		$this->_api_url	= $this->CI->encryption->decrypt($this->CI->Appconfig->get('clcdesq_api_url'));
	}
	
	public function new_product_push(array $data)
	{
		if(!$this->is_enabled())
		{
			return NULL;
		}
		//TODO: Gather data to send to the Product Push API
		//TODO: Format the data to a json request
		//TODO: Use the API key and url to send the request
		//TODO: The result of the API Product Push should be a GUID.  Store that in the database as an attribute for the pushed product
		return NULL;
	}
	
	public function update_product_push(array $data)
	{
		if(!$this->is_enabled())
		{
			return NULL;
		}
		
		//TODO: For now, the update product push is identical to the new product push except that we are sending the GUID
		return NULL;
	}
	
	public function delete_product_push(array $data)
	{
		if(!$this->is_enabled())
		{
			return NULL;
		}
		
		//TODO: Gather data to send to the Product Push API.  Sending the same thing as a product push but with a false on the published flag
		//TODO: Format the data to a json request
		//TODO: Use the API key and url to send the request
		//TODO: The result of the API Product Push should be a GUID.  Store that in the database as an attribute for the pushed product
		
		
		return NULL;
	}
	
	private function is_enabled()
	{
		if($this->CI->Appconfig->get('clcdesq_enable') != 1)
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}