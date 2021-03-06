<?php
/*
	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
	
	---------------------------------------------------------------------
	Name:		NZ Post Shipping Module
	
	OpenCart:	Version 1.5.4
	
	Author: 	Andy Carroll andy@goldfishinteractive.co.nz
				www.goldfishinteractive.co.nz
				Google+		https://plus.google.com/108980982867245444635
				Twitter 	https://twitter.com/GoldfishNZ
				Facebook 	http://www.facebook.com/pages/Goldfish-Interactive-Ltd/363786527000
				LinkedIn 	http://www.linkedin.com/company/goldfish-interactive-ltd
				
	Created:	30 September 2011,
	Updated: 	6 November 2012
	Version:	0.5
	
	Notes:		This module is provided for free, I hope it proves useful
				to you or your clients. Please consider my time and effort
				by providing some reward either by donation, positive
				comment, a link, a like or fb follow using the contact
				details above.
				
				Suggestions or error reports are welcome but please
				consider I have paying work which takes priority. If
				you require customisations, help or urgent support
				I will happily provide a budget estimate.
				
	Thanks:		Thanks to Daniel Kerr at Open Cart for providing the best
				Open Source Cart I have ever worked with and the Development
				Team at NZ Post for providing the API.
				
	---------------------------------------------------------------------
*/
class ModelShippingNZPost extends Model {
	function getQuote($address) {
		$this->load->language('shipping/nzpost');
		
		$method_data = array();
		
		$length_class = $this->getLengthClassId('mm');
		$weight_class = $this->getWeightClassId('kg');
		
		if($length_class == 0 || $weight_class == 0)
		{
			$quote_data = array();
			$method_data = array(
				'code'       => 'nzpost',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('nzpost_sort_order'),
				'error'      => $this->language->get('error_units')
			);
			return $method_data;
		}
		
		// Sing Items
		if($this->getItemsCount() == 1)
		{
			// Weight and Dimensions
			$weightAndDimension = $this->getItemWeightAndDimension($length_class, $weight_class);
			// For Parcel Only Deliveries, Ensure Minimum 75mm Dimensions
			$packageLength = ($this->config->get('nzpost_national_postage_only')=='' || $weightAndDimension['length']>75)? $weightAndDimension['length']:75;
			$packageWidth = ($this->config->get('nzpost_national_postage_only')=='' || $weightAndDimension['width']>75)? $weightAndDimension['width']:75;
			$packageHeight = ($this->config->get('nzpost_national_postage_only')=='' || $weightAndDimension['height']>75)? $weightAndDimension['height']:75;
			
			// Weight
			$weight = $weightAndDimension['weight'];
			$weight = ($weight < 0.1 ? 0.1 : $weight);
		}
		else
		{
			// Cubic Volume
			$volume = $this->getCubicVolume($length_class);
			if($volume == 0)
			{
				$quote_data = array();
				$method_data = array(
					'code'       => 'nzpost',
					'title'      => $this->language->get('text_title'),
					'quote'      => $quote_data,
					'sort_order' => $this->config->get('nzpost_sort_order'),
					'error'      => $this->language->get('error_volume')
				);
				return $method_data;
			}
			// For Parcel Only Deliveries, Ensure Minimum 75mm Dimensions
			$packageLength = ($this->config->get('nzpost_national_postage_only')=='' || pow($volume, 1/3)>75)? pow($volume, 1/3): 75;
			$packageWidth = ($this->config->get('nzpost_national_postage_only')=='' || pow($volume, 1/3)>75)? pow($volume, 1/3): 75;
			$packageHeight = ($this->config->get('nzpost_national_postage_only')=='' || pow($volume, 1/3)>75)? pow($volume, 1/3): 75;
			
			// Weight
			$weight = $this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $weight_class);
			$weight = ($weight < 0.1 ? 0.1 : $weight);
		}
		
		if ($this->config->get('nzpost_status')) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('nzpost_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
			if (!$this->config->get('nzpost_geo_zone_id')) {
				$status = TRUE;
			} elseif ($query->num_rows) {
				$status = TRUE;
			} else {
				$status = FALSE;
			}
		} else {
			$status = FALSE;
		}
		
		// NZ National
		if ($status && $address['iso_code_2'] == 'NZ') {
			
			$url = 'http://api.nzpost.co.nz/ratefinder/rate.json';
			$url .= '?api_key=' . $this->config->get('nzpost_api_key');
			$url .= '&format=' . 'json';
			$url .= '&carrier=' . $this->config->get('nzpost_carrier');
			$url .= '&weight=' . $weight;
			$url .= '&length=' . $packageLength;
			$url .= '&thickness=' . $packageWidth;
			$url .= '&height=' . $packageHeight;
			$url .= '&postcode_src=' . $this->config->get('nzpost_source_postcode');
			$url .= '&postcode_dest=' . $address['postcode'];
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$response = curl_exec($ch);
			curl_close($ch);
			
			$result = json_decode($response);
			
			$quote_data = array();
			if ($result->status == "success") {
				foreach ($result->products as $product) {
					$exclusive = ($product->cost - (($product->cost*3)/23));
					if((($this->config->get('nzpost_national_signature')=='') || $product->signature == '1') && 
					   (($this->config->get('nzpost_national_tracking')=='') || $product->tracked == '1') &&
					   ((($this->config->get('nzpost_national_standard')=='1') && $product->delivery_rank == '1.5') ||
					   (($this->config->get('nzpost_national_express')=='1') && $product->delivery_rank == '1')) &&
					   (($this->config->get('nzpost_national_postage_only')=='') || $product->packaging == 'postage_only')){
						$quote_data['nzpost_'.$product->code] = array(
							'code'         => 'nzpost.nzpost_'.$product->code,
							'title'        => $product->description.' '.$product->speed_description,
							'cost'         => $this->currency->convert($exclusive, 'NZD', $this->config->get('config_currency')),
							'tax_class_id' => $this->config->get('nzpost_tax_class_id'),
							'text'         => $this->currency->format($this->tax->calculate($this->currency->convert($exclusive, $this->config->get('config_currency'), $this->currency->getCode()), $this->config->get('nzpost_tax_class_id'), $this->config->get('config_tax')))
						);
					}
				}
				
				if(count($quote_data) == 0)
				{
					$method_data = array(
						'code'       => 'nzpost',
						'title'      => $this->language->get('text_title'),
						'quote'      => $quote_data,
						'sort_order' => $this->config->get('nzpost_sort_order'),
						'error'      => $this->language->get('error_no_services')
					);
					return $method_data;
				}
				
			} else {
				$method_data = array(
					'code'       => 'nzpost',
					'title'      => $this->language->get('text_title'),
					'quote'      => $quote_data,
					'sort_order' => $this->config->get('nzpost_sort_order'),
					'error'      => $this->language->get('error_failed')
				);
				return $method_data;
			}
			
			$title = $this->language->get('text_title');
			
			if ($this->config->get('nzpost_display_weight')) {	  
				$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('nzpost_weight_class_id')) . ')';
			}
		}
		else
		{
			$destination_city = $address['city'];
			$destination_zone_code = $address['zone_code'];
			$destination_iso_code_2 = $address['iso_code_2'];
			$destination_postcode = $address['postcode'];
			
			$url = 'http://api.nzpost.co.nz/ratefinder/international.json';
			$url .= '?api_key=' . $this->config->get('nzpost_api_key');
			$url .= '&format=' . 'json';
			$url .= '&weight=' . $weight;
			$url .= '&length=' . $packageLength;
			$url .= '&thickness=' . $packageWidth;
			$url .= '&height=' . $packageHeight;
			$url .= '&country_code=' . $address['iso_code_2'];
			$url .= '&value=' . $this->cart->getTotal();
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$response = curl_exec($ch);
			curl_close($ch);
			
			$result = json_decode($response);
			
			$quote_data = array();
			if ($result->status == "success") {
				foreach ($result->products as $product) {
					if((($this->config->get('nzpost_international_TIEX')=='1') && $product->service_code == 'TIEX') || 
					   (($this->config->get('nzpost_international_TIEC')=='1') && $product->service_code == 'TIEC') || 
					   (($this->config->get('nzpost_international_TIALP')=='1') && $product->service_code == 'TIALP') || 
					   (($this->config->get('nzpost_international_TIELP')=='1') && $product->service_code == 'TIELP')){
						$quote_data['nzpost_'.$product->service_code] = array(
							'code'         => 'nzpost.nzpost_'.$product->service_code,
							'title'        => $product->group.' - '.$product->min_delivery_target.'-'.$product->max_delivery_target.' days.',
							'cost'         => $this->currency->convert($product->price, 'NZD', $this->config->get('config_currency')),
							'tax_class_id' => $this->config->get('nzpost_international_tax_class_id'),
							'text'         => $this->currency->format($this->tax->calculate($this->currency->convert($product->price, 'NZD', $this->currency->getCode()), $this->config->get('nzpost_international_tax_class_id'), $this->config->get('config_tax')), $this->currency->getCode(), 1.0000000)
						);
					}
				}
				
				if(count($quote_data) == 0)
				{
					$method_data = array(
						'code'       => 'nzpost',
						'title'      => $this->language->get('text_title'),
						'quote'      => $quote_data,
						'sort_order' => $this->config->get('nzpost_sort_order'),
						'error'      => $this->language->get('error_no_services')
					);
					return $method_data;
				}
				
			} else {
				$method_data = array(
					'code'       => 'nzpost',
					'title'      => $this->language->get('text_title'),
					'quote'      => $quote_data,
					'sort_order' => $this->config->get('nzpost_sort_order'),
					'error'      => $this->language->get('error_failed')
				);
				return $method_data;
			}
			
			$title = $this->language->get('text_title');
			
			if ($this->config->get('nzpost_display_weight')) {	  
				$title .= ' (' . $this->language->get('text_weight') . ' ' . $this->weight->format($weight, $this->config->get('nzpost_weight_class_id')) . ')';
			}
		}
		
		if ($quote_data) {
			$method_data = array(
				'code'       => 'nzpost',
				'title'      => $this->language->get('text_title'),
				'quote'      => $quote_data,
				'sort_order' => $this->config->get('nzpost_sort_order'),
				'error'      => false
			);
		}
			
		return $method_data;
	}

	function getItemsCount()
	{
		$items = 0;
		foreach ($this->cart->getProducts() as $key=>$attrs) {
			if ($attrs['shipping']) {
				$quantity = trim($attrs['quantity']);
				$items += $quantity;
			}
		}
		return $items;
	}
	
	function getItemWeightAndDimension($nzpost_length_class_id, $nzpost_weight_class_id)
	{
		$details = array();
		foreach ($this->cart->getProducts() as $key=>$attrs) {
			if ($attrs['shipping']) {
				$length = trim($attrs['length']);
				$width = trim($attrs['width']);
				$height = trim($attrs['height']);
				$weight = trim($attrs['weight']);
				if (is_numeric($length) && $length > 0 && is_numeric($width) && $width > 0 && is_numeric($height) && $height > 0) {
					$details['length'] = $this->length->convert($length, $attrs['length_class_id'], $nzpost_length_class_id);
					$details['width'] = $this->length->convert($width, $attrs['length_class_id'], $nzpost_length_class_id);
					$details['height'] = $this->length->convert($height, $attrs['length_class_id'], $nzpost_length_class_id);
					$details['weight'] = $this->length->convert($weight, $attrs['weight_class_id'], $nzpost_weight_class_id);
				}
			}
		}
		return $details;
	}
	
	function getCubicVolume($nzpost_length_class_id)
	{
		$totalVolume = 0;
		foreach ($this->cart->getProducts() as $key=>$attrs) {
			if ($attrs['shipping']) {
				$quantity = trim($attrs['quantity']);
				$length = trim($attrs['length']);
				$width = trim($attrs['width']);
				$height = trim($attrs['height']);
				if (is_numeric($length) && $length > 0 && is_numeric($width) && $width > 0 && is_numeric($height) && $height > 0) {
					
					$length = $this->length->convert($length, $attrs['length_class_id'], $nzpost_length_class_id);
					$width = $this->length->convert($width, $attrs['length_class_id'], $nzpost_length_class_id);
					$height = $this->length->convert($height, $attrs['length_class_id'], $nzpost_length_class_id);
					
					$totalVolume = $totalVolume + ($quantity * ($length * ($width * $height)));
				}
				else
				{
					return 0;
				}
			}
		}
		return $totalVolume;
	}

	function getLengthClassId($unit)
	{
		$length_class_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "length_class_description");
    
    	foreach ($length_class_query->rows as $result) {
			if(strtolower($result['unit'])==strtolower($unit))
			{
				return $result['length_class_id'];
			}
    	}
		return 0;
	}
	
	function getWeightClassId($unit)
	{
		$weight_class_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "weight_class_description");
    	
		foreach ($weight_class_query->rows as $result) {
			if(strtolower($result['unit'])==strtolower($unit))
			{
				return $result['weight_class_id'];
			}
    	}
		return 0;
	}
}
?>