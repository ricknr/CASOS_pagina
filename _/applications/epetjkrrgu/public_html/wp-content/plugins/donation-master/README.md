Openpay for Wordpress
---------------------
### Bug resolved - Version 0.8 - As of Aug 28, 2018.
1. Added remove teste function to donation.js file.
2. Set versioning on js/css files for cache busting. 
3. Restricted to submit tokenize process without required params.


### Bug resolved - Version 0.7 - As of Aug 28, 2018.
To log webhook:
1. Under donation function donation_processing in initial.php uncomment method process_log_openpay_hook
2. Register hook  SITE_NAME/?donation_action=donation_webhook_processing and you will get succesfully message.
3. You will get openpay_hook_xxxs.log file.
4. Get verification_code and verify to Openpay > Configuration section. 

Sample response:
{"ipn_response":{"type":"verification","event_date":"2018-08-29T06:05:57-05:00","verification_code":"cOLWKzJt","id":"wv9kzd1qdnh0ctfsu8el"},"0":"\r\n","1":"\r\n"}

5. After verified clicking on check mark , you will get verification successfully.



### Bug resolved - Version 0.6 - As of Aug 27, 2018.
- Error log stored in /include/logs

### Bug resolved - Version 0.5 - As of Aug 10, 2018
- All error converted to spanish


### Bug resolved - Version 0.4 - As of Aug 10, 2018,
- Issue with 3d secure invalid card. 
- Token added based on merchant and  withou merchant. 
- Added Openpay plugin 3d Security.

### New functionality added - Version 0.3 As of July 05, 2018.
- Openpay plugin 3d Security added.

### New functionality added  - Version 0.2 As of July 02, 2018.
- Openpay plugin to payment over Wordpress.

### Initial release  - Version 0.1