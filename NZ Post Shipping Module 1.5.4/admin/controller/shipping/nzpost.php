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
	Version:	0.4
	
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
				Open Source Cart around and the Development
				Team at NZ Post for providing the API.
				
	---------------------------------------------------------------------
*/
class ControllerShippingNZPost extends Controller {
	private $error = array(); 
	
	public function index() {
		$this->load->language('shipping/nzpost');
			
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('nzpost', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');		
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');		
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['text_nzpost_national_tracking'] = $this->language->get('text_national_tracking');
		$this->data['text_nzpost_national_signature'] = $this->language->get('text_national_signature');
		$this->data['text_nzpost_national_standard'] = $this->language->get('text_national_standard');
		$this->data['text_nzpost_national_express'] = $this->language->get('text_national_express');
		$this->data['text_nzpost_national_postage_only'] = $this->language->get('text_national_postage_only');
		
		$this->data['text_nzpost_international_tracking'] = $this->language->get('text_international_tracking');
		$this->data['text_nzpost_international_signature'] = $this->language->get('text_international_signature');

		$this->data['text_nzpost_international_TIEX'] = $this->language->get('text_TIEX');
		$this->data['text_nzpost_international_TIEC'] = $this->language->get('text_TIEC');
		$this->data['text_nzpost_international_TIALP'] = $this->language->get('text_TIALP');
		$this->data['text_nzpost_international_TIELP'] = $this->language->get('text_TIELP');

		
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_api_key'] = $this->language->get('entry_api_key');
		$this->data['entry_format'] = $this->language->get('entry_format');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_national_options'] = $this->language->get('entry_national_options');
		$this->data['entry_international_options'] = $this->language->get('entry_international_options');
		$this->data['entry_display_weight'] = $this->language->get('entry_display_weight');
		$this->data['entry_source_postcode'] = $this->language->get('entry_source_postcode');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['api_key'])) {
			$this->data['error_api_key'] = $this->error['api_key'];
		} else {
			$this->data['error_api_key'] = '';
		}

		if (isset($this->error['error_source_postcode'])) {
			$this->data['error_source_postcode'] = $this->error['error_source_postcode'];
		} else {
			$this->data['error_source_postcode'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/nzpost', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('shipping/nzpost', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['nzpost_api_key'])) {
			$this->data['nzpost_api_key'] = $this->request->post['nzpost_api_key'];
		} else {
			$this->data['nzpost_api_key'] = $this->config->get('nzpost_api_key');
		}
			
		if (isset($this->request->post['nzpost_source_postcode'])) {
			$this->data['nzpost_source_postcode'] = $this->request->post['nzpost_source_postcode'];
		} else {
			$this->data['nzpost_source_postcode'] = $this->config->get('nzpost_source_postcode');
		}
		
		if (isset($this->request->post['nzpost_test'])) {
			$this->data['nzpost_test'] = $this->request->post['nzpost_test'];
		} else {
			$this->data['nzpost_test'] = $this->config->get('nzpost_test');
		}
		
		if (isset($this->request->post['nzpost_national_tracking'])) {
			$this->data['nzpost_national_tracking'] = $this->request->post['nzpost_national_tracking'];
		} else {
			$this->data['nzpost_national_tracking'] = $this->config->get('nzpost_national_tracking');
		}
		if (isset($this->request->post['nzpost_national_signature'])) {
			$this->data['nzpost_national_signature'] = $this->request->post['nzpost_national_signature'];
		} else {
			$this->data['nzpost_national_signature'] = $this->config->get('nzpost_national_signature');
		}
		if (isset($this->request->post['nzpost_national_standard'])) {
			$this->data['nzpost_national_standard'] = $this->request->post['nzpost_national_standard'];
		} else {
			$this->data['nzpost_national_standard'] = $this->config->get('nzpost_national_standard');
		}
		if (isset($this->request->post['nzpost_national_express'])) {
			$this->data['nzpost_national_express'] = $this->request->post['nzpost_national_express'];
		} else {
			$this->data['nzpost_national_express'] = $this->config->get('nzpost_national_express');
		}
		if (isset($this->request->post['nzpost_national_postage_only'])) {
			$this->data['nzpost_national_postage_only'] = $this->request->post['nzpost_national_postage_only'];
		} else {
			$this->data['nzpost_national_postage_only'] = $this->config->get('nzpost_national_postage_only');
		}
		
		if (isset($this->request->post['nzpost_international_TIEX'])) {
			$this->data['nzpost_international_TIEX'] = $this->request->post['nzpost_international_TIEX'];
		} else {
			$this->data['nzpost_international_TIEX'] = $this->config->get('nzpost_international_TIEX');
		}
		if (isset($this->request->post['nzpost_international_TIEC'])) {
			$this->data['nzpost_international_TIEC'] = $this->request->post['nzpost_international_TIEC'];
		} else {
			$this->data['nzpost_international_TIEC'] = $this->config->get('nzpost_international_TIEC');
		}
		if (isset($this->request->post['nzpost_international_TIALP'])) {
			$this->data['nzpost_international_TIALP'] = $this->request->post['nzpost_international_TIALP'];
		} else {
			$this->data['nzpost_international_TIALP'] = $this->config->get('nzpost_international_TIALP');
		}
		if (isset($this->request->post['nzpost_international_TIELP'])) {
			$this->data['nzpost_international_TIELP'] = $this->request->post['nzpost_international_TIELP'];
		} else {
			$this->data['nzpost_international_TIELP'] = $this->config->get('nzpost_international_TIELP');
		}

		if (isset($this->request->post['nzpost_display_weight'])) {
			$this->data['nzpost_display_weight'] = $this->request->post['nzpost_display_weight'];
		} else {
			$this->data['nzpost_display_weight'] = $this->config->get('nzpost_display_weight');
		}
								
		if (isset($this->request->post['nzpost_tax_class_id'])) {
			$this->data['nzpost_tax_class_id'] = $this->request->post['nzpost_tax_class_id'];
		} else {
			$this->data['nzpost_tax_class_id'] = $this->config->get('nzpost_tax_class_id');
		}
		
		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		if (isset($this->request->post['nzpost_geo_zone_id'])) {
			$this->data['nzpost_geo_zone_id'] = $this->request->post['nzpost_geo_zone_id'];
		} else {
			$this->data['nzpost_geo_zone_id'] = $this->config->get('nzpost_geo_zone_id');
		}
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['nzpost_status'])) {
			$this->data['nzpost_status'] = $this->request->post['nzpost_status'];
		} else {
			$this->data['nzpost_status'] = $this->config->get('nzpost_status');
		}

		if (isset($this->request->post['nzpost_sort_order'])) {
			$this->data['nzpost_sort_order'] = $this->request->post['nzpost_sort_order'];
		} else {
			$this->data['nzpost_sort_order'] = $this->config->get('nzpost_sort_order');
		}	
		
		$this->template = 'shipping/nzpost.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		
 		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/nzpost')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['nzpost_api_key']) {
			$this->error['api_key'] = $this->language->get('error_api_key');
		}
		
		if (!$this->request->post['nzpost_source_postcode']) {
			$this->error['source_postcode'] = $this->language->get('error_source_postcode');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>