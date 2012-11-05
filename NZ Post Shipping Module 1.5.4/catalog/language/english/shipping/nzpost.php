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
				Open Source Cart around and the Development
				Team at NZ Post for providing the API.
				
	---------------------------------------------------------------------
*/
// Text
$_['text_title']           				= 'New Zealand Post Service';
$_['text_weight']          				= 'Weight:';

$_['error_units']          				= 'Sorry, shipping can\'t be calculated. The website does not have Kg or mm units defined for conversion. Please contact the site owner to resolve this issue.';
$_['error_volume']         				= 'Sorry, shipping can\'t be calculated. The website does not have dimensions and weight assigned for some products. Please contact the site owner to resolve this issue.';
$_['error_no_services']         		= 'Sorry, the services available may not be suitabale, please contact the merchant to arrange shipping.';
$_['error_failed']         				= 'Sorry, your items may be too big for NZ Post to calculate as one shipment. Please create separate orders or contact the merchant to arrange shipping.';

?>