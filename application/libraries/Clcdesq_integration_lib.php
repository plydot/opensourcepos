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
		
		$this->api_key	= $this->CI->encryption->decrypt($this->CI->Appconfig->get('clcdesq_api_key'));
		$this->api_url	= $this->CI->encryption->decrypt($this->CI->Appconfig->get('clcdesq_api_url'));
	}
	
	public function new_product_push(array $data)
	{
		if(!$this->is_enabled())
		{
			return NULL;
		}
		
		$pushdata	= $this->populate_api_data($data);
		
		$json = json_encode($pushdata);
		//		$clcdesq_guid = $this->send_data($this->api_url, $this->api_key, $json);
		
		//log_message("ERROR", "API Results: $clcdesq_guid");
		//TODO: The result of the API Product Push should be a GUID.  Store that in the database as an attribute for the pushed product
		return NULL;
	}
	
	/**
	 * Send API request to update the item. Since CLCdesq does not have a partial update function, it sends the item with all the same information as before, but also including the GUID.
	 *
	 * @param	array	$data	Partial data needed to
	 * @return 	boolean			TRUE is returned if the push was successful or FALSE if there was some error.
	 */
	public function update_product_push(array $data)
	{
		if(!$this->is_enabled())
		{
			return NULL;
		}
		
		$pushdata	= $this->populate_api_data($data);
		
		$json = json_encode($pushdata);
		//		$clcdesq_guid = $this->send_data($this->api_url, $this->api_key, $json);
		
		//TODO: For now, the update product push is identical to the new product push except that we are sending the GUID
		return NULL;
	}
	
	/**
	 * Send API request to delete the item. Since CLCdesq does not have a true delete function, it sends the item with Published and ShowOnWebsite set to FALSE.
	 *
	 * @param	array	$data
	 * @return 	boolean			TRUE is returned if the push was successful or FALSE if there was some error.
	 */
	public function delete_product_push(array $data)
	{
		if(!$this->is_enabled())
		{
			return NULL;
		}
		
		$pushdata	= $this->populate_api_data($data);
		
		//Delete specific flags
		$pushdata['Published'] 		= FALSE;
		$pushdata['ShowOnWebsite']	= FALSE;
		
		$json = json_encode($pushdata);
		//		$clcdesq_guid = $this->send_data($this->api_url, $this->api_key, $json);
		
		//TODO: Figure out exactly what the results that it sends back are and return a failure on error.
		return NULL;
	}
	
	/**
	 * Checks to see if the CLCdesq Integration is enabled
	 *
	 * @return	boolean	TRUE if enabled or FALSE if disabled.
	 */
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
	
	/**
	 * Sends the POST JSON request via cURL
	 *
	 * @param	string	$url	The API URL to call.
	 * @param	string	$key	The API key to use in the request.
	 * @param 	string	$json	The JSON formatted data to send.
	 * @return	string			Returns the resulting error or GUID from the API
	 */
	private function send_data(string $url, string $key, string $json)
	{
		$curl_resource	= curl_init($url);
		curl_setopt($curl_resource, CURLOPT_HTTPHEADER, array('Content-type: application/json',"APIKEY: $key"));
		curl_setopt($curl_resource, CURLOPT_POST, TRUE);
		curl_setopt($curl_resource, CURLOPT_POSTFIELDS, $json);
		curl_setopt($curl_resource, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl_resource, CURLOPT_SSL_VERIFYPEER, FALSE);
		
		$result = curl_exec($curl_resource);
		curl_close($curl_resource);
		return $result;
	}
	
	//TODO: This probably belongs in a model?
	/**
	 * Populates the API data needed for the push.  This is used by all three product_push member functions.
	 *
	 * @param 	array	data	Complete data needed to build the Array.
	 * @return	array			Array to be used in the product push.
	 */
	private function populate_api_data($data)
	{
		//TODO: Figure out how to have Items pass the item_id for an item update
		$item_id = $data['item_id'];
		
		$api_data = array(
			'AspectRatio' 			=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_aspectratio'))->attribute_value,
			'AudienceRating' 		=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_audiencerating'))->attribute_value,
			'AudioFormat' 			=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_audioformat'))->attribute_value,
			'AudioTrackListing' 	=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_audiotracklisting'))->attribute_value,
			'AuthorsText' 			=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_authorstext'))->attribute_value,
			'Barcode' 				=> $data['item_number'],
			'Binding' 				=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_binding'))->attribute_value,
			'BookForeword' 			=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_bookforeward'))->attribute_value,
			'BookIndex' 			=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_bookindex'))->attribute_value,
			'BookSampleChapter' 	=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_booksamplechapter'))->attribute_value,
			'Contributors' 			=> array('Contributors' => $this->get_contributor_ao_array($item_id)),
			'DateAdded'	 			=> $this->get_date_added($item_id),
			'Depth'		 			=> (float)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_depth'))->attribute_decimal,
			'Description' 			=> $data['description'],
			'DimensionUnit' 		=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_depth'))->attribute_decimal !== NULL ? $this->CI->Attribute->get_info((int)$this->CI->Appconfig->get('clcdesq_depth'))->definition_unit : NULL,
			//'DiscountGroup' 		=> $this->get_Product_discount_group_ao_array($item_id),
			'EAN' 					=> $this->get_ean($this->get_isbn((int)$data['item_number'])),
			'Format' 				=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_format'))->attribute_value,
			'Height'		 		=> (float)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_height'))->attribute_decimal,
			'InternalCode' 			=> $item_id,
			'ISBN'		 			=> $this->get_isbn((int)$data['item_number']),
			'KindId'		 		=> $data['category'] == 'Books' ? 1 : NULL,		/* Regular Book*/
			'Language'	 			=> $this->get_language_ao_array((int)$item_id),
			'MediaType'	 			=> $this->get_media_type_ao_array($data['category']),
			'NumberOfDiscs' 		=> (int)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_numberofdiscs'))->attribute_decimal,
			'NumberOfPages' 		=> (int)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_numberofpages'))->attribute_decimal,
			'OriginalTitle' 		=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_originaltitle'))->attribute_value,
			'Price' 				=> $data['unit_price'],
			'PriceWithoutVAT'		=> $this->get_price_without_VAT($data['unit_price']),
			'PriceNote'				=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_pricenote'))->attribute_value,
			'Producer'				=> $this->get_producer_user_ao_array($item_id),
			'ProductStatusProducer' => $this->get_product_status_producer_ao_array($item_id),
			'PriceCurrency'			=> $this->CI->Appconfig->get('currency_code') !== '' ? $this->CI->Appconfig->get('currency_code') : NULL,
			'Published' 			=> $data['deleted'] == FALSE ? TRUE : FALSE,
			'PublisherRRP'			=> (float)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_publisherrrp'))->attribute_decimal,
			'ReducedPrice'			=> (float)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_reducedprice'))->attribute_decimal,
			'ReducedPriceStartDate'	=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_reducedpricestartdate'))->attribute_date,
			'ReducedPriceEndDate'	=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_reducedpriceenddate'))->attribute_date,
			'ReleaseDate' 			=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_releasedate'))->attribute_date,
			'RunningTime'			=> (int)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_runningtime'))->attribute_decimal,
			'Series'				=> $this->get_product_series_ao_array($item_id),
			'StockCount'			=> get_total_quantity($item_id),
			'StockOnOrder'			=> (int)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_stockonorder'))->attribute_decimal,
			'Supplier'				=> $this->get_supplier_user_ao_array($data['supplier_id']),
			'ShowOnWebsite'			=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_showonwebsite'))->attribute_value,
			'Subtitle'				=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_subtitle'))->attribute_value,
			'Subtitles'				=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_subtitles'))->attribute_value,
			'TeaserDescription'		=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_teaserdescription'))->attribute_value,
			'Title' 				=> $data['name'],
			'UniqueId'				=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_uniqueid'))->attribute_value,
			'UPC' 					=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_upc'))->attribute_value,
			'VatPercent'			=> (float)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_vatpercent'))->attribute_decimal,
			'VideoTrailerEmbedCode'	=> $data['videotrailerembedcode'],
			'Weight'				=> (float)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_weight'))->attribute_decimal,
			'WeightForShipping'		=> (float)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_weightforshipping'))->attribute_decimal,
			'WeightUnit'			=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_weight'))->attribute_decimal !== NULL ? $this->CI->Attribute->get_info((int)$this->CI->Appconfig->get('clcdesq_weight'))->definition_unit : NULL,
			'Width'					=> (float)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_width'))->attribute_decimal,
			'Categories' 			=> array('Categories' => $this->get_category_ao_array($item_id, 'Products', 0))
		);
		ob_start();
		var_dump($api_data);
		$dump = ob_get_clean();
		log_message("ERROR", $dump);
		return $api_data;
	}
	
	/**
	 *
	 * @param unknown $item_id
	 * @return NULL[]|string[]|boolean[]
	 */
	private function get_contributor_ao_array($item_id)
	{
		$contributor 		= $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_authorstext'))->attribute_value;
		
		if($contributor != NULL)
		{
			$author = $this->parse_author($contributor);
		}
		
		if($author == NULL)
		{
			return NULL;
		}
		else
		{
			$contributor_ao	= array(
				'id'			=> null,
				'Guid'			=> null,
				'FirstName'		=> $author['first_name'],
				'LastName'		=> $author['last_name'],
				'DisplayName'	=> $author['display_name'],
				'Description'	=> null,
				'Role'			=> 'A01',	//Only authors are submitted at this time
				'Published'		=> TRUE
			);
			
			return $contributor_ao;
		}
	}
	
	/**
	 * Parses out the First Name, Last Name and Display Name of a Given input
	 *
	 * @param	string	$input	Text to parse for author details
	 * @return	array			An array containing First Name, Last Name and Display Name Strings
	 */
	private function parse_author(string $input)
	{
		//Not Last, First or First Last format
		if(strpos($input,',') === FALSE && strpos($input,' ') === FALSE)
		{
			$author 	= array('display_name' => trim($input));
		}
		//Last, First format
		else if(strpos($input,',') !== FALSE)
		{
			$author		= array(
				'last_name'		=> trim(strtok($input,',')),
				'first_name'	=> trim(substr($input, strpos($input, ',') + 1)),
				'display_name'	=> trim($input)
			);
		}
		//First Last format
		else
		{
			$author		= array(
				'last_name'		=> trim(substr($input, strrpos($input, ' ') + 1)),
				'first_name'	=> trim(substr($input, 0, strrpos($input, ' ')))
			);
			
			$author +=	['display_name'	=> trim($author['last_name'] . ', ' .$author['first_name'])];
		}
		
		return $author;
	}
	
	/**
	 * Retrieve the date that the item was first added.
	 *
	 * @param	int		$item_id	The ID of the item to retrieve date added.
	 * @return	string				The Date this item was first added.
	 */
	private function get_date_added(int $item_id)
	{
		$date_added = $this->CI->Inventory->get_inventory_data_for_item($item_id)->result_array();
		
		return $date_added[0]['trans_date'];
	}
	
	private function get_ean(string $isbn)
	{
		if($isbn !== NULL)
		{
			return preg_replace('/[^0-9]/', '', $isbn);
		}
		
		return NULL;
	}
	
	private function get_isbn(string $barcode)
	{
		if(strlen($barcode) != 10 && strlen($barcode) !== 13)
		{
			return NULL;
		}
		else
		{
			return preg_replace("/[^a-zA-Z0-9]/", '', $string);
		}
	}
	
	/**
	 * Prepares a LanguageAO array to be sent in the API.
	 *
	 * @param	int		$item_id	The unique identifier for which to get
	 * @return	array				An associative array containing the LanguageAO information.
	 */
	private function get_language_ao_array(int $item_id)
	{
		$language_shortname = $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_language'))->attribute_value;
		
		$language_ao = array(
			'ShortName'			=> $language_shortname,
			'OnixLanguageCode'	=> NULL
		);
		
		return $language_ao;
	}
	
	/**
	 * Prepares a MediaTypeAO array to be sent in the API.
	 *
	 * @param	string	$category	The category translates specifically to the MediaTypeAO Title.
	 * @return	array				An associative array containing the MediaTypeAO information
	 */
	private function get_media_type_ao_array(string $category)
	{
		$mediatype_ao	= array(
			'Id'				=> NULL,
			'Title'				=> $category,
			'Description'		=> NULL,
			'DefaultWeight'		=> NULL,
			'Published'			=> TRUE,
			'ShortName'			=> NULL,
			'DefaultVatPercent'	=> NULL
		);
		
		return $mediatype_ao;
	}
	
	/**
	 * Given the price of the item determines the price without VAT included.
	 *
	 * @param	float		$price	Price of the item.
	 * @return 	float|NULL			Returns the price of the item without VAT included. If VAT is not included in the price, then it returns the given price.
	 */
	private function get_price_without_vat(float $price)
	{
		$tax_rate		= (float)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('default_tax_1_rate'));
		$tax_included	= (bool)$this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('default_tax_1_rate'));
		
		if($tax_rate != NULL && $tax_included)
		{
			$tax_percent = $tax_rate/100;
			return 	$price - roundup($price * $tax_percent,2);
		}
		else if($tax_rate != NULL)
		{
			return $price;
		}
		else
		{
			return NULL;
		}
	}
	
	/**
	 * Prepares a ProducerUserAO array to be sent in the API.
	 *
	 * @param	int		$item_id	The unique identifier of the item to generate the ProducerUserAO for.
	 * @return	array				An associative array containing the ProducerUserAO information
	 */
	private function get_producer_user_ao_array(int $item_id)
	{
		$producer_user_ao	= array(
			'UniqeId'				=> NULL,
			'FirstName'				=> NULL,
			'LastName'				=> NULL,
			'Email'					=> NULL,
			'DateAdded'				=> NULL,
			'AllowPaymentOnAccount'	=> NULL,
			'ActivePublic'			=> FALSE,
			'ActiveAdmin'			=> FALSE,
			'IsSupplier'			=> FALSE,
			'IsProducer'			=> TRUE,
			'PasswordHash'			=> NULL,
			'PasswordSalt'			=> NULL,
			'Username'				=> NULL,
			'CompanyName'			=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_producer'))->attribute_value,
			'CompanyRegistration'	=> NULL,
			'CompanyVatCode'		=> NULL,
			'DiscountGroup'			=> NULL
		);
		
		return $producer_user_ao;
	}
	
	/**
	 * Prepares a ProductStatusProducerAO array to be sent in the API.
	 *
	 * @param	int		$item_id	The unique identifier of the item to generate the ProductStatusProducerAO for.
	 * @return	array				An associative array containing the ProductStatusProducerAO information.
	 */
	private function get_product_status_producer_ao_array(int $item_id)
	{
		$product_status_producer_ao	= array(
			'id'							=> NULL,
			'Name'							=> "Available or Order",
			'DisplayStatus'					=> TRUE,
			'DisplayProduct'				=> TRUE,
			'AllowOrdering'					=> TRUE,
			'AllowOrderingMinStockAmount'	=> 0,
			'EnforceActualStock'			=> TRUE,
			'DisplayStock'					=> TRUE,
			'StatusExplanation'				=> NULL,
			'StatusColorHex'				=> NULL
		);
		
		return $product_status_producer_ao;
	}
	
	/**
	 * Prepares a ProductSeriesAO array to be sent in the API
	 *
	 * @param	int		$item_id	The unique identifier of the item to generate the ProductSeriesAO for.
	 * @return	array				An associative array containing the ProductSeriesAO information.
	 */
	private function get_product_series_ao_array(int $item_id)
	{
		$product_series_ao	= array(
			'id'			=> NULL,
			'UID'			=> NULL,
			'Title'			=> $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_series'))->attribute_value,
			'Description'	=> NULL,
			'DateAdded'		=> $this->get_date_added($item_id),
			'Published'		=> TRUE
		);
		
		return $product_series_ao;
	}
	
	//TODO: We may want to move this to the Item_quantity model
	/**
	 * Returns the total quantity available from all suppliers.
	 *
	 * @param	int	$item_id	The unique identifier of the item to get the total quantity for.
	 * @return	int				The total quantity between all stock locations.
	 */
	private function get_total_quantity($item_id)
	{
		$total_quantity		= 0;
		$stock_locations	= $this->CI->Stock_Location->get_all()->result_array[0];
		
		foreach($stock_locations as $location_id)
		{
			$total_quantity += $this->CI->Item_quantity->get_item_quantity($item_id, $location_id['location_id']);
		}
		
		return $total_quantity;
	}
	
	/**
	 * Prepares a SupplierUserAO array to be sent in the API
	 *
	 * @param	int		$item_id	The unique identifier of the item to generate the SupplierUserAO for.
	 * @return	array				An associative array containing the SupplierUserAO information.
	 */
	private function get_supplier_user_ao_array(int $supplier_id)
	{
		$supplier_info = $this->CI->Supplier->get_info($supplier_id)->result_array()[0];
		
		$supplier_user_ao	= array(
			'UniqeId'				=> NULL,
			'FirstName'				=> $supplier_info['first_name'],
			'LastName'				=> $supplier_info['last_name'],
			'Email'					=> $supplier_info['email'],
			'DateAdded'				=> NULL,
			'AllowPaymentOnAccount'	=> NULL,
			'ActivePublic'			=> FALSE,
			'ActiveAdmin'			=> FALSE,
			'IsSupplier'			=> TRUE,
			'IsProducer'			=> FALSE,
			'PasswordHash'			=> NULL,
			'PasswordSalt'			=> NULL,
			'Username'				=> NULL,
			'CompanyName'			=> $supplier_info['company_name'],
			'CompanyRegistration'	=> NULL,
			'CompanyVatCode'		=> $supplier_info['tax_id'],
			'DiscountGroup'			=> NULL
		);
		
		return $supplier_user_ao;
	}
	
	/**
	 * Prepares a CategoryAO array to be sent in the API
	 *
	 * @param	int		$item_id	The unique identifier of the item to generate the ProductSeriesAO for.
	 * @return	array				An associative array containing the ProductSeriesAO information.
	 */
	private function get_category_ao_array(int $item_id, string $title = NULL, int $level)
	{
		if($title == NULL)
		{
			return NULL;
		}
		else
		{
			//Products->$data['category']->$attribute['location']->$attribute->['category']
			
			switch($level)
			{
				case 0:	//Products
					break;
					
				case 1: //Category (Books, Media, Gifts, etc.)
					$next_title = $this->CI->Item->get_info($item_id)['category'];
					break;
					
				case 2: //Location Attribute(Gift and Travel, Reference, Azerbaijani, etc.)
					$next_title = $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_location'))->attribute_value;
					break;
					
				case 3: //Category Attribute(Travel Guides, Prayer, etc)
					$next_title = $this->CI->Attribute->get_attribute_value($item_id, (int)$this->CI->Appconfig->get('clcdesq_category'))->attribute_value;
					break;
					
				default:
					$next_title = NULL;
					break;
			}
			
			$category_ao	= array(
				'Id'	=> NULL,
				'Title'	=> $title,
				'children' => $this->get_category_ao_array($iten_id, $next_title, $level+1)
			);
		}
		
		return $category_ao;
	}
}