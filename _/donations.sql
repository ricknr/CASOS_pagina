CREATE TABLE IF NOT EXISTS `w0lap_donation_donors`(			
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(255) COLLATE utf8_general_ci NOT NULL,
				`email` varchar(150) COLLATE utf8_general_ci NOT NULL,
				`status` enum('Active','Deactive') COLLATE utf8_general_ci NOT NULL DEFAULT 'Active',
				`customer_id` varchar(50) COLLATE utf8_general_ci DEFAULT NULL,
				`created_at` datetime DEFAULT NULL,
				`modified_at` datetime DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  INDEX `idx_name_email` (`name`, `email`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `w0lap_donation_payment_history` (				
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`order_id` varchar(100) COLLATE utf8_general_ci NOT NULL DEFAULT '0',
				`donor_id` int(11) NOT NULL,
				`type` enum('Subscription','One Time') COLLATE utf8_general_ci NOT NULL DEFAULT 'One Time',
				`subscription_plan` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
				`amount` decimal(10,2) DEFAULT NULL,
				`payment_date` datetime DEFAULT NULL,
				`next_payment_date` datetime DEFAULT NULL,
				`status` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
				`created_at` datetime DEFAULT NULL,
				`modified_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`),
				KEY `idx_donor_id` (`donor_id`),
				KEY `idx_subscription_id` (`subscription_plan`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `w0lap_donation_subscriptions`  (
				  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `donor_id` int(11) DEFAULT NULL,
				  `customer_id` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
				  `subscription_id` varchar(255) COLLATE utf8_general_ci NOT NULL,
				  `plan_id` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
				  `amount` decimal(10,2) DEFAULT NULL,
				  `status` varchar(50) COLLATE utf8_general_ci DEFAULT NULL,
				  `cancel_at` datetime DEFAULT NULL,
				  `created_at` datetime DEFAULT NULL,
				  `modified_at` datetime DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  KEY `idx_donor_id` (`donor_id`),
				  KEY `idx_subscription_id` (`subscription_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `w0lap_donation_payment_log` (			
			`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			`order_id` varchar(100) COLLATE utf8_general_ci DEFAULT '0',
			`donor_id` int(11) NOT NULL,
			`subscription_id` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
			`transaction_id` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
			`request_id` varchar(150) COLLATE utf8_general_ci DEFAULT NULL,
			`description` varchar(255) COLLATE utf8_general_ci NOT NULL,
			`subscription_plan` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
			`amount` decimal(10,2) DEFAULT NULL,
			`status` varchar(100) COLLATE utf8_general_ci NOT NULL,
			`log` text COLLATE utf8_general_ci,
			`created_at` datetime DEFAULT NULL,
			`modified_at` datetime DEFAULT NULL,
			PRIMARY KEY (`id`),
			KEY `idx_donor_id` (`donor_id`),
			KEY `idx_subscription_id` (`subscription_id`),
			KEY `idx_payment_history_id` (`order_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=0;

CREATE TABLE IF NOT EXISTS `w0lap_donation_emails` (
				`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				`name` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
				`subject` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
				`message` text COLLATE utf8_general_ci,
				`type` varchar(100) COLLATE utf8_general_ci DEFAULT NULL,
				`status` enum('Active','Deactive') COLLATE utf8_general_ci DEFAULT 'Active',
				`created_at` datetime DEFAULT NULL,
				`modified_at` datetime DEFAULT NULL,
				PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=0;
				
INSERT INTO `w0lap_donation_emails` (`id`, `name`, `subject`, `message`, `type`, `status`, `created_at`, `modified_at`) VALUES
(1, 'Payment Failure', 'Donation is failure. - Cáritas de Monterrey', 'Dear {{name}} <br/> ,\r\nYour donation could not be done.<br/>Here is Donation Ref. No:{{order_id}}<br/>Donation Amount:{{amount}} MXN<br/>Date:{{date}}<br/>Sorry for incovenience, You can try it again.<br/>Error Message:{{error_message}}<br/>Feel free to talk with Us.<br/>- Thanks and Regards<br/>  Cáritas de Monterrey', 'payment_failure', 'Active', '2018-06-29 17:23:34', '2018-07-01 20:18:56'),

(2, 'Payment Success', 'Your donation is successfully done. - Cáritas de Monterrey', 'Dear {{name}} <br/> ,\r\nYour donation is successfully done.<br/>Here is Donation Ref. No:{{order_id}}<br/>Donation Amount:{{amount}} MXN<br/>Date:{{date}}<br/>Feel free to talk with Us.<br/>- Thanks and Regards<br/>  Cáritas de Monterrey', 'payment_success', 'Active', '2018-06-29 17:23:34', '2018-07-01 20:18:56'),

(3, 'Payment Subscription', 'Thank you for kind support. - Cáritas de Monterrey', 'Dear {{name}} <br/> ,\r\nYour donation is successfully done.<br/>Here is Donation Ref. No:{{order_id}}<br/>Donation Amount:{{amount}} MXN<br/>Date:{{date}}<br/>Donation Type : Subscription<br/>Next Payment Date:{{next_payment_date}}<br/>Feel free to talk with Us.<br/>- Thanks and Regards<br/>  Cáritas de Monterrey', 'payment_subscription', 'Active', '2018-06-29 17:26:51', '2018-07-01 20:18:56'),

(4, 'Payment Subscription Cancel', 'Cancel subscription. - Cáritas de Monterrey', 'Dear {{name}} <br/> ,\r\nYour donation subscription is cancelled successfully.<br/>Donation Amount:{{amount}} MXN<br/>Cancel Date:{{cancel_date}}<br/>Feel free to talk with Us.<br/>- Thanks and Regards<br/>  Cáritas de Monterrey', 'payment_subscription_cancel', 'Active', '2018-06-29 17:27:58', '2018-07-01 20:18:56'),

(5, 'Payment Subscription Cancel Request', 'Request for cancel subscription. - Cáritas de Monterrey', 'Dear Admin <br/> ,\r\nYou have new cancel subscription request.<br/>Donor Email:{{email}} <br/>Request Date:{{date}}<br/>Please look into this asap.<br/>- Thanks and Regards<br/>  Cáritas de Monterrey', 'payment_subscription_cancel_request', 'Active', '2018-07-01 01:47:15', '2018-07-01 20:18:56');
