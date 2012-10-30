******************************************************************************************
NZ Post Shipping Module for OpenCart 1.5.4
******************************************************************************************

Important:		This is a pre-release beta, do not use in production without taking the
			usual precautions and tests. Also dont rely on the shipping estimates
			until you understand the limitations of the module.

Name:			NZ Post Shipping Module

OpenCart:		Version 1.5.4

Author: 		Andy Carroll andy@goldfishinteractive.co.nz

			www.goldfishinteractive.co.nz

			Google+	https://plus.google.com/108980982867245444635
			Twitter 	https://twitter.com/GoldfishNZ
			Facebook 	http://www.facebook.com/pages/Goldfish-Interactive-Ltd/363786527000
			LinkedIn 	http://www.linkedin.com/company/goldfish-interactive-ltd


Created:		30 September 2011,

Updated: 		31 October 2012

Version:		0.3 (Its a beta)


Requirements:	1)	This version is tested with Open Cart v1.5.4

			2)	This module requires an active API key available 
				from NZ Post's Developer Team.

			3)	Ensure your open cart install contains the required
				NZ Post units of measure (mm and kilograms). Products can
				be assigned with other units but the system needs mm and 
				kilograms for the conversion process.

			4)	Ensure your products have been correctly assigned with
				weight and dimensions. Missing or inaccurate data will result 
				in errors or inaccurate estimates.

Limitations:	NZ Post API currently requires weight and dimension. Because multiple
			items need to be processed the module calculates a cubic volume based 
			on the total dimensions of all items. This assumes a cubic parcel which 
			may introduce inaccuracies if your packages are unusually proportioned.
			It is recommended you choose "Quote for Parcels Only" which excludes
			services for envelopes and flat packs. 


Description:	This module for Open Cart calls the NZ Post API to retrieve 
			quotes for shipping. The module processes the shopping cart 
			items, adds weights and dimensions and provides a cubic volume 
			total and weight total for passing to NZ Post for an estimate. 
			The resulting services are then provided as shipping choices.

			Read more about the API here: 
			http://www.nzpost.co.nz/business/developer-centre/rate-finder-api

			Request an API key here: 
			http://www.nzpost.co.nz/products-services/iphone-apps-apis/rate-finder-api/get-a-rate-finder-api-key 


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
