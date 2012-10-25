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
	Updated: 	25 October 2012
	Version:	0.3
	
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
// Heading
$_['heading_title']                							= 'NZ Post';
		 
// Text
$_['text_shipping']                							= 'Shipping';
$_['text_success']                 							= 'Success: You have modified NZ post shipping!';
$_['text_test']                    							= 'Test';
$_['text_enabled']                    						= 'Enabled';
$_['text_disabled']                    						= 'Disabled';
$_['text_yes']                    							= 'Yes';
$_['text_no']                    							= 'No';
$_['text_select_all']                    					= 'Select All';
$_['text_unselect_all']                    					= 'Unselect All';
$_['text_all_zones']                    					= 'All Zones';
$_['text_none']                    							= 'None';
$_['text_national_tracking']    							= 'Tracking Required';
$_['text_national_signature']    							= 'Signature Required';
$_['text_national_postage_only']    						= 'Quote for Parcels Only';
$_['text_international_tracking']    						= 'Tracking Required';
$_['text_international_signature']    						= 'Signature Required';

// Entry
$_['entry_api_key']                	= 'API Key:<span class="help">Enter the api key assigned to you by NZ Post.</span>';
$_['entry_source_postcode']        	= 'Origin NZ Postal Code:<span class="help">Enter your origin postalcode.</span>';
$_['entry_test']                   	= 'Test Mode:<span class="help">Use this module in Test (YES) or Production mode (NO)?</span>';
$_['entry_national_options']        = 'National Options:<span class="help">Select the required NZ Post options.</span>';
$_['entry_international_options']   = 'International Options:<span class="help">Select the required NZ Post options.</span>';
$_['entry_display_weight']         	= 'Display Delivery Weight:<br /><span class="help">Do you want to display the shipping weight? (e.g. Delivery Weight : 2.7674 Kg\'s)</span>';
$_['entry_tax']                    	= 'National Tax Class:';
$_['entry_international_tax']       = 'International Tax Class:';
$_['entry_geo_zone']               	= 'Geo Zone:';
$_['entry_status']                 	= 'Status:';
$_['entry_sort_order']             	= 'Sort Order:';

// Error
$_['error_permission']             	= 'Warning: You do not have permission to modify NZ Post shipping!';
$_['error_api_key']                	= 'Access API Key is Required!';
$_['error_source_postcode']        	= 'Origin Postcode is Required!';
$_['error_nzpost_units']        	= 'Sorry, the website does not have Kg or mm units defined for conversion.';

?>