
CREATE TABLE `payment_settings` (
  `id` int(11) NOT NULL,
  `currency_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paypal_payment_on_off` int(1) NOT NULL DEFAULT 1,
  `paypal_mode` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sandbox',
  `paypal_client_id` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paypal_secret` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_payment_on_off` int(1) NOT NULL DEFAULT 1,
  `stripe_secret_key` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stripe_publishable_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_payment_on_off` int(1) NOT NULL DEFAULT 0,
  `razorpay_key` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `razorpay_secret` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_payment_on_off` int(1) NOT NULL DEFAULT 0,
  `paystack_secret_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paystack_public_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `currency_code`, `paypal_payment_on_off`, `paypal_mode`, `paypal_client_id`, `paypal_secret`, `stripe_payment_on_off`, `stripe_secret_key`, `stripe_publishable_key`, `razorpay_payment_on_off`, `razorpay_key`, `razorpay_secret`, `paystack_payment_on_off`, `paystack_secret_key`, `paystack_public_key`) VALUES
(1, 'USD', 1, 'sandbox', 'AcHrwP4VHD8x4EOB1UlIcof3bMB0oYYYjHfwO8STmh4JtncocJ3HK03lqy3YXYVGC3i6P-XdyqXQ-Aq2', 'EJwVTBGDKymCNfoKi5PEmOyo-Ipdrl18K3RpetS1UB_hTyYNSZ92a3ysB8Sjo2Dpie7yfesGl3GB8VJW', 1, 'sk_test_51IHwhFFXS6WK0zS83bsA4hR0r7EPszmPvkFfhF4xKOB9oTYvyd4vRDXhcTplYEdXtfyF45OjVLtZtdWORLRz4gwW005R1rSkU9', 'pk_test_51IHwhFFXS6WK0zS8eDi7RSZ3TzJj5ch8lmTlnMmmRTVdkCZWfbhSOSicNKVyKRLUfXJreUnByn4aJauZVCDBoNKb00qngD7CKZ', 1, 'rzp_test_0K5kgDdmTYKw1C', '4Nogo1qIfeIoE4SDmh3vrXkO', 1, 'sk_test_b3a005e485d55c4dc47696c29f27705918f98a15', 'pk_test_03ee87c23e8815638f5c4ef582aca392e8b3c39b');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plan`
--

CREATE TABLE `subscription_plan` (
  `id` int(11) NOT NULL,
  `plan_name` varchar(255) NOT NULL,
  `plan_details` text NOT NULL,
  `plan_days` int(11) NOT NULL,
  `plan_duration` varchar(255) NOT NULL,
  `plan_duration_type` varchar(255) NOT NULL,
  `plan_price` decimal(11,2) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `plan_days_2` int(11) NOT NULL,
  `plan_duration_2` varchar(255) NOT NULL,
  `plan_duration_type_2` varchar(255) NOT NULL,
  `plan_price_2` decimal(11,2) NOT NULL,
  `plan_days_3` int(11) NOT NULL,
  `plan_duration_3` varchar(255) NOT NULL,
  `plan_duration_type_3` varchar(255) NOT NULL,
  `plan_price_3` decimal(11,2) NOT NULL,
  `promote_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subscription_plan`
--

INSERT INTO `subscription_plan` (`id`, `plan_name`, `plan_details`, `plan_days`, `plan_duration`, `plan_duration_type`, `plan_price`, `status`, `plan_days_2`, `plan_duration_2`, `plan_duration_type_2`, `plan_price_2`, `plan_days_3`, `plan_duration_3`, `plan_duration_type_3`, `plan_price_3`, `promote_image`) VALUES
(1, 'Daily Bump Up', 'Get a fresh start every day and get up to 10 times more responses!', 7, '3', '1', 3.00, 1, 0, '7', '1', 7.00, 0, '15', '1', 10.00, 'daily_bump_up.png'),
(2, 'Top Ad', 'Get up to 5 times more views by displaying your ad at the top!', 30, '3', '1', 2.00, 1, 0, '7', '1', 5.00, 0, '15', '1', 12.00, 'top_ad.png'),
(3, 'Spotlight', 'Boost sales by showing your ad in this premium slot.', 365, '3', '1', 10.00, 1, 0, '7', '1', 15.00, 0, '15', '1', 20.00, 'spotlight.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_active_log`
--

CREATE TABLE `tbl_active_log` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `email`, `image`) VALUES
(1, 'admin', 'admin', 'info.nemosofts@gmail.com', 'profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banner`
--

CREATE TABLE `tbl_banner` (
  `bid` int(11) NOT NULL,
  `banner_title` varchar(255) NOT NULL,
  `banner_sort_info` varchar(500) NOT NULL,
  `banner_image` varchar(255) NOT NULL,
  `banner_songs` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `date_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cid` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `aid` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comments`
--

CREATE TABLE `tbl_comments` (
  `cid` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post`
--

CREATE TABLE `tbl_post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `money` varchar(20) NOT NULL,
  `phone_1` varchar(20) NOT NULL,
  `phone_2` varchar(20) NOT NULL,
  `image_1` varchar(255) NOT NULL,
  `image_2` varchar(255) NOT NULL,
  `image_3` varchar(255) NOT NULL,
  `image_4` varchar(255) NOT NULL,
  `image_5` varchar(255) NOT NULL,
  `con` varchar(255) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `scat_id` int(11) NOT NULL,
  `cit_id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `date_time` varchar(200) NOT NULL,
  `total_views` int(11) NOT NULL DEFAULT 0,
  `total_share` int(11) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1,
  `active` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_post_promote`
--

CREATE TABLE `tbl_post_promote` (
  `vid` bigint(20) NOT NULL,
  `pt_id` int(11) NOT NULL,
  `us_id` int(11) NOT NULL,
  `dailyBumpUp_start_date` varchar(255) NOT NULL,
  `dailyBumpUp_exp_date` varchar(255) NOT NULL,
  `topAd_start_date` varchar(255) NOT NULL,
  `topAd_exp_date` varchar(255) NOT NULL,
  `spotLight_start_date` varchar(255) NOT NULL,
  `spotLight_exp_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reports`
--

CREATE TABLE `tbl_reports` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `report` text NOT NULL,
  `date_time` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_logo` varchar(255) NOT NULL,
  `envato_buyer_name` varchar(200) NOT NULL,
  `envato_purchase_code` text NOT NULL,
  `envato_buyer_email` varchar(150) NOT NULL,
  `envato_purchased_status` int(1) NOT NULL DEFAULT 0,
  `package_name` varchar(150) NOT NULL,
  `app_api_key` varchar(255) NOT NULL,
  `onesignal_app_id` varchar(255) NOT NULL,
  `onesignal_rest_key` varchar(255) NOT NULL,
  `publisher_id` varchar(500) NOT NULL,
  `interstital_ad` varchar(500) NOT NULL,
  `interstital_ad_id` varchar(500) NOT NULL,
  `interstital_ad_click` varchar(500) NOT NULL,
  `banner_ad` varchar(500) NOT NULL,
  `banner_ad_id` varchar(500) NOT NULL,
  `facebook_interstital_ad` varchar(255) NOT NULL,
  `facebook_interstital_ad_id` varchar(255) NOT NULL,
  `facebook_interstital_ad_click` varchar(255) NOT NULL,
  `facebook_banner_ad` varchar(255) NOT NULL,
  `facebook_banner_ad_id` varchar(255) NOT NULL,
  `facebook_native_ad` varchar(255) NOT NULL,
  `facebook_native_ad_id` varchar(255) NOT NULL,
  `facebook_native_ad_click` varchar(255) NOT NULL,
  `admob_nathive_ad` varchar(255) NOT NULL,
  `admob_native_ad_id` varchar(255) NOT NULL,
  `admob_native_ad_click` varchar(255) NOT NULL,
  `currency_code` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `app_privacy_policy` text NOT NULL,
  `banner_size` varchar(255) NOT NULL DEFAULT 'SMART_BANNER',
  `banner_size_fb` varchar(255) NOT NULL DEFAULT 'BANNER_HEIGHT_90',
  `auto_post` varchar(255) NOT NULL,
  `currency_position` varchar(255) NOT NULL DEFAULT 'true',
  `google_login` varchar(255) NOT NULL DEFAULT 'true',
  `facebook_login` varchar(255) NOT NULL DEFAULT 'true',
  `home_page` varchar(255) NOT NULL DEFAULT 'true',
  `ad_promote` varchar(255) NOT NULL DEFAULT 'true',
  `isRTL` varchar(255) NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `app_name`, `app_logo`, `envato_buyer_name`, `envato_purchase_code`, `envato_buyer_email`, `envato_purchased_status`, `package_name`, `app_api_key`, `onesignal_app_id`, `onesignal_rest_key`, `publisher_id`, `interstital_ad`, `interstital_ad_id`, `interstital_ad_click`, `banner_ad`, `banner_ad_id`, `facebook_interstital_ad`, `facebook_interstital_ad_id`, `facebook_interstital_ad_click`, `facebook_banner_ad`, `facebook_banner_ad_id`, `facebook_native_ad`, `facebook_native_ad_id`, `facebook_native_ad_click`, `admob_nathive_ad`, `admob_native_ad_id`, `admob_native_ad_click`, `currency_code`, `company`, `email`, `website`, `contact`, `status`, `app_privacy_policy`, `banner_size`, `banner_size_fb`, `auto_post`, `currency_position`, `google_login`, `facebook_login`, `home_page`, `ad_promote`, `isRTL`) VALUES
(1, ' Buy and Sell', 'logo.jpg', '', '', '', 0, 'nemosofts.classified.ads', '', '', '', 'ca-app-pub-3940256099942544', 'true', 'ca-app-pub-3940256099942544/1033173712', '10', 'true', 'ca-app-pub-3940256099942544/6300978111', 'false', '2721335228135997_2721337748135745', '10', 'false', '1119558491760939_1119560848427370', 'false', '307990203845854_307990370512504', '6', 'true', 'ca-app-pub-3940256099942544/2247696110', '6', 'Rs', 'nemosofts', 'info.nemosofts@gmail.com', 'https://www.nemosoftscom/', '+00 020456089', 1, '', 'SMART_BANNER', 'BANNER_HEIGHT_90', '0', 'true', 'true', 'true', 'false', 'true', 'false');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_smtp_settings`
--

CREATE TABLE `tbl_smtp_settings` (
  `id` int(5) NOT NULL,
  `smtp_type` varchar(20) NOT NULL DEFAULT 'server',
  `smtp_host` varchar(150) NOT NULL,
  `smtp_email` varchar(150) NOT NULL,
  `smtp_password` text NOT NULL,
  `smtp_secure` varchar(20) NOT NULL,
  `port_no` varchar(10) NOT NULL,
  `smtp_ghost` varchar(150) NOT NULL,
  `smtp_gemail` varchar(150) NOT NULL,
  `smtp_gpassword` text NOT NULL,
  `smtp_gsecure` varchar(20) NOT NULL,
  `gport_no` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_smtp_settings`
--

INSERT INTO `tbl_smtp_settings` (`id`, `smtp_type`, `smtp_host`, `smtp_email`, `smtp_password`, `smtp_secure`, `port_no`, `smtp_ghost`, `smtp_gemail`, `smtp_gpassword`, `smtp_gsecure`, `gport_no`) VALUES
(1, 'server', 'mail.test.com', 'test@test.com', 'test', 'ssl', '465', 'smtp.gmail.com', 'test@gmail.com', 'test', 'tls', 587);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_category`
--

CREATE TABLE `tbl_sub_category` (
  `sid` int(11) NOT NULL,
  `sub_cat_id` int(11) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `sub_category_image` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_update`
--

CREATE TABLE `tbl_update` (
  `id` int(11) NOT NULL,
  `version` text NOT NULL,
  `version_name` text NOT NULL,
  `description` text NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_update`
--

INSERT INTO `tbl_update` (`id`, `version`, `version_name`, `description`, `url`) VALUES
(1, '1', '1.0.0', 'Kindly you can update new version app.', 'https://play.google.com/store/apps/details?id=nemosofts.classified.ads');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE tbl_users (
  id int(10) NOT NULL,
  user_type varchar(20) NOT NULL DEFAULT 'Normal',
  name varchar(60) NOT NULL,
  email varchar(70) NOT NULL,
  password text NOT NULL,
  phone varchar(20) NOT NULL,
  auth_id varchar(255) NOT NULL DEFAULT '0',
  registered_on varchar(200) NOT NULL DEFAULT '0',
  status int(1) NOT NULL DEFAULT 1,
  images varchar(255) NOT NULL DEFAULT 'Normal',
  images_bg varchar(255) NOT NULL DEFAULT 'Normal',
  app_otp varchar(255) NOT NULL DEFAULT '2468',
  otp_status int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `gateway` varchar(255) NOT NULL,
  `daily_bump_up` int(1) NOT NULL DEFAULT 1,
  `top_ad` int(1) NOT NULL DEFAULT 1,
  `spot_light` int(1) NOT NULL DEFAULT 1,
  `payment_amount` varchar(255) NOT NULL,
  `date_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_plan`
--
ALTER TABLE `subscription_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_post`
--
ALTER TABLE `tbl_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_post_promote`
--
ALTER TABLE `tbl_post_promote`
  ADD PRIMARY KEY (`vid`);

--
-- Indexes for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `tbl_update`
--
ALTER TABLE `tbl_update`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscription_plan`
--
ALTER TABLE `subscription_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_active_log`
--
ALTER TABLE `tbl_active_log`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_banner`
--
ALTER TABLE `tbl_banner`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_comments`
--
ALTER TABLE `tbl_comments`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_post`
--
ALTER TABLE `tbl_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_post_promote`
--
ALTER TABLE `tbl_post_promote`
  MODIFY `vid` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_reports`
--
ALTER TABLE `tbl_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_smtp_settings`
--
ALTER TABLE `tbl_smtp_settings`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_sub_category`
--
ALTER TABLE `tbl_sub_category`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_update`
--
ALTER TABLE `tbl_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

