<?php

/* Backend form. Set size form tags of contentype Article */
//function general_form_article_node_form_alter (&$form, &$form_state) {
//	$form['#attached']['js'] = array(
//			array(
//					'data' => 'jQuery(function() { jQuery("#edit-field-tags-und").attr("size","10");; });',
//					'type' => 'inline',
//			),
//	);
//}

/* Overide result for link */
//function general_url_inbound_alter(&$result, $path, $path_language) {
//  if ($path == 'insights/user/435') {
//    $result = 'not found';
//  }
//}


///**
// * Pathauto global for all language
// * hook_pathauto_pattern_alter
// * hook_pathauto_alias_alter
// */
//function general_pathauto_pattern_alter(&$pattern, array &$context) {
//  if ($context['module'] == 'taxonomy_term' && $context['language'] != LANGUAGE_NONE) {
//    $context['language'] = LANGUAGE_NONE;
//  }
//}


///**
// * Create Token URL Alias Enlish
// * Implementation of hook_token_info
// */
//function general_token_info(){
//  $info['tokens']['node']['english-language-path'] = array(
//    'name' => t('URL alias Enlish'),
//    'description' => t('Token used to set URL path alias in English for regional languages.'),
//  );
//  return $info;
//}
///**
// * Implementation of hook_tokens
// */
//function general_tokens($type, $tokens, array $data = array(), array $options = array()) {
//  $replacements = array();
//  $sanitize = !empty($options['sanitize']);
//  // Check if token type is node
//  if($type == 'node' && !empty($data['node'])){
//
//    foreach ($tokens as $name => $original) {
//      switch ($name) {
//        case 'english-language-path':
//          //  get url alias enlish for pathauto add alias to japan; kpr($data['node']);
//          $nid = $data['node']->nid;
//          if (!empty($nid)) {
//            $source_node = node_load($nid);
//            $title_source = $source_node->title;
//            $replacements[$original] = str_replace(array('&amp;', '&'),'and',$sanitize ? filter_xss($title_source) : $title_source);
//          }
//          break;
//      }
//    }
//  }
//  return $replacements;
//}

// /**
// * give path alias at 4-4-2017
// */
//function general_update_7001() {
//  if (db_table_exists('url_alias')) {
//    db_query("
//      INSERT INTO url_alias (source,alias,language) VALUES
//              ('node/2','content/test-0','und'),
//              ('node/4','content/son-nguyen-0','und'),
//              ('node/5','content/hiep-ho-minh-0','und'),
//              ('node/51','content/umbraco','und'),
//              ('node/52','content/ebiserver','und'),
//              ('node/55','content/tung-ha-0','und'),
//              ('node/56','content/thuy-nguyen-thanh-0','und'),
//              ('node/58','content/hilary-do-0','und'),
//              ('node/108','content/magento-expert','und'),
//              ('node/109','content/project-manager','und'),
//              ('node/110','content/senior-php-developer','und'),
//              ('node/111','content/sale-executive','und'),
//              ('node/112','content/fresher-program','und'),
//              ('node/113','content/internal-program','und'),
//              ('node/115','content/question-1','und'),
//              ('node/116','content/question-2','und'),
//              ('node/117','content/question-3','und'),
//              ('node/118','content/question-4','und'),
//              ('node/119','content/question-5','und'),
//              ('node/146','content/hilary-do','und'),
//              ('node/148','content/thuy-nguyen-thanh','und'),
//              ('node/150','content/christian-vu','und'),
//              ('node/152','content/son-nguyen','und'),
//              ('node/155','content/hiep-ho-minh','und'),
//              ('node/156','content/tung-ha','und'),
//              ('node/204','content/kentico','und'),
//              ('taxonomy/term/12','offices/hochiminh-vietnam','und'),
//              ('taxonomy/term/13','offices/hanoi-vietnam','und'),
//              ('taxonomy/term/14','department/manager','und'),
//              ('taxonomy/term/15','department/developer','und'),
//              ('taxonomy/term/16','department/business','und'),
//              ('taxonomy/term/24','offices/melbourne-australia','und'),
//              ('taxonomy/term/36','positions/junior-sitecore-developer-0','und'),
//              ('taxonomy/term/43','news-type/announcement','und'),
//              ('taxonomy/term/45','news-type/business','und'),
//              ('taxonomy/term/46','tags/extension','und'),
//              ('taxonomy/term/47','tags/x-pos','und'),
//              ('taxonomy/term/49','tags/magento','und'),
//              ('taxonomy/term/50','tags/social','und'),
//              ('taxonomy/term/52','news-type/video','und'),
//              ('taxonomy/term/53','news-type/lifestyle','und'),
//              ('taxonomy/term/54','tags/training','und'),
//              ('taxonomy/term/56','tags/uet','und'),
//              ('taxonomy/term/62','tags/award','und'),
//              ('taxonomy/term/63','tags/sao-khue','und'),
//              ('taxonomy/term/64','tags/2007','und'),
//              ('taxonomy/term/65','tags/2011','und'),
//              ('taxonomy/term/66','tags/2012','und'),
//              ('taxonomy/term/67','tags/2013','und'),
//              ('taxonomy/term/68','tags/2014','und'),
//              ('taxonomy/term/69','tags/2015','und'),
//              ('taxonomy/term/70','tags/e-commerce','und'),
//              ('taxonomy/term/71','tags/partner','und'),
//              ('taxonomy/term/72','tags/event','und'),
//              ('taxonomy/term/78','tags/imagine-challenge','und'),
//              ('taxonomy/term/79','tags/magento-imagine','und'),
//              ('taxonomy/term/80','tags/meet-magento','und'),
//              ('taxonomy/term/81','tags/intergration','und'),
//              ('taxonomy/term/82','tags/e-marketing','und'),
//              ('taxonomy/term/83','tags/promotion','und'),
//              ('taxonomy/term/84','tags/certification','und'),
//              ('node/37','work/hardcasa','und'),
//              ('node/38','work/napoleon-perdis-cosmestics','und'),
//              ('node/39','work/termando','und'),
//              ('node/40','work/celebros','und'),
//              ('node/41','work/giant-microbes','und'),
//              ('node/42','work/best-seller-a-s','und'),
//              ('node/64','work/eway','und'),
//              ('node/65','work/w-80s-purple','und'),
//              ('node/66','work/boozt','und'),
//              ('node/67','work/space-x','und'),
//              ('node/68','work/girl-two-doors-down','und'),
//              ('node/69','work/joshs-frog','und'),
//              ('node/87','work/smartbox','und'),
//              ('node/88','work/paypal','und'),
//              ('node/99','case-study','und'),
//              ('node/125','platforms','und'),
//              ('node/136','students','und'),
//              ('node/137','life-smart','und'),
//              ('node/138','internship','und'),
//              ('node/139','fresher','und'),
//              ('node/141','work/api-priceline-pharmacy','und'),
//              ('node/142','work/dreamworks-shop','und'),
//              ('node/157','news/drip-email-campaign-sugarcrm','und'),
//              ('node/158','news/optimize-your-oscommerce-store-performance','und'),
//              ('node/159','news/new-pos-system-magento-coming-soon','und'),
//              ('node/160','news/smartosc-proudly-announces-x-pos-release-new-pos-solution-magento','und'),
//              ('node/161','news/cooperation-between-smartosc-and-uet-vnu-developing-high-quality-human-resources-e-commerce','und'),
//              ('node/162','news/grand-opening-smartosc-representative-office-ho-chi-minh-city','und'),
//              ('node/163','news/x-pos-won-sao-khue-award-2015','und'),
//              ('node/164','news/ecommerce-integration-virtual-logistics-and-smartosc-partner','und'),
//              ('node/165','news/magento-turn-key-solution-multi-vendor-system','und'),
//              ('node/166','news/shopping-cart-migration-magento','und'),
//              ('node/167','news/smartosc-becomes-magento-silver-solution-partner','und'),
//              ('node/168','news/watch-our-entry-magento-challenge-2012','und'),
//              ('node/169','news/magento-integration-supercom','und'),
//              ('node/170','news/magento-imagine-conference-our-video-awarded-best-display-success','und'),
//              ('node/171','news/magento-integration-ingram-micro-ca','und'),
//              ('node/172','news/tripletex-module-integration-magento','und'),
//              ('node/173','news/magento-imagine-2012-recap-–-few-thoughts-asia','und'),
//              ('node/174','news/dropship-integration-magento','und'),
//              ('node/175','news/hardcasa-denmarks-leading-online-shop-men','und'),
//              ('node/176','news/premier-point-sale-solution-your-brick-and-mortar-store','und'),
//              ('node/177','news/x-pospoint-sales-solution-wins-grand-prize-magento-imagine-challenge','und'),
//              ('node/178','news/x-pos-point-sale-v2-advanced-search-configuration','und'),
//              ('node/179','news/strongly-secured-enhancement-credit-card-payment-x-pos-24','und'),
//              ('node/180','news/strongly-secured-enhancement-credit-card-payment-x-pos-24-0','und'),
//              ('node/181','news/x-multiwarehouse-v11-solution-warehouse-management-and-moving-inventory','und'),
//              ('node/182','news/moving-inventory-between-warehouses-now-possible-x-barcoderma-28','und'),
//              ('node/183','news/control-cashier-permissions-access-warehouses','und'),
//              ('node/184','news/magento-community-vs-magento-go-vs-magento-enterprise','und'),
//              ('node/185','news/smartosc-extensions-are-now-compatible-magento-ce-18','und'),
//              ('node/186','news/smartosc-announces-release-x-multi-vendor-20','und'),
//              ('node/187','news/speed-optimization-x-pos-243','und'),
//              ('node/188','news/smartosc-will-be-magento-imagine-2014-will-you','und'),
//              ('node/189','news/x-pos-version-3-simple-and-smart','und'),
//              ('node/190','news/x-pos-31-most-powerful-point-sales-solution-magento','und'),
//              ('node/191','news/x-pos-advanced-smart-point-sales-solution-modern-retail','und'),
//              ('node/192','news/x-b2b-growing-your-wholesale-potentials','und'),
//              ('node/193','news/its-time-say-thanks','und'),
//              ('node/194','news/smartosc-achieves-global-iso-90012008-certification','und'),
//              ('node/195','news/x-pos-33-more-powerful-end-day-report','und'),
//              ('node/196','news/x-pos-33-start-selling-products-custom-options','und'),
//              ('node/197','news/new-magento-module-eway-payment-service','und'),
//              ('node/199','news/support-izettle-payment-gateway-x-pos-app-13-0','und'),
//              ('node/201','careers/junior-sitecore-developer','und'),
//              ('node/202','careers/senior-wordpress-developer','und'),
//              ('node/203','careers/junior-sitecore-developer-0','und'),
//              ('node/206','history','und'),
//              ('node/207','meetmagento_vietnam','en'),
//              ('node/208','news/x-pos-ipad-app-16-time-multi-tasking-cashiers','en'),
//              ('node/211','case-study/delta-apparel','en'),
//              ('node/214','news/meet-magento-vietnam-2015-–-remarkable-milestone-e-commerce-asia','en'),
//              ('node/221','careers/senior-frontend-developer','und'),
//              ('node/233','careers/php-developer','und'),
//              ('node/252','careers/senior-quality-assurance','und'),
//              ('node/258','careers/senior-brse','und'),
//              ('node/259','careers/sales-trainee','und'),
//              ('node/278','careers/senior-graphic-designer','und'),
//              ('node/280','careers/java-developer-fresher','und'),
//              ('node/284','careers/sales-manager','und'),
//              ('node/292','careers/net-team-lead','und'),
//              ('node/293','careers/php-team-lead','und'),
//              ('node/294','careers/senior-net-developer','und'),
//              ('node/295','careers/senior-ios-developer','und'),
//              ('node/218','news/smartosc-contributes-first-meet-magento-conference-japan-2015','und'),
//              ('node/230','news/netatmo-online-shop-experience-sales-increase','und'),
//              ('node/236','news/smartosc-builds-vincom-retails-online-precense','und'),
//              ('node/237','news/smartosc-and-priceline-pharmacy-share-tips-how-successfully-deliver-magento-enterprise-site','und'),
//              ('node/238','news/smartosc-appointed-ecommerce-agency-lotte-vietnam','und'),
//              ('node/241','news/mm16vn-expected-become-one-largest-meet-magento-events','und'),
//              ('node/242','news/americaneaglecom-emerges-asian-market-partnership-smartosc','und'),
//              ('node/250','news/smartosc-and-memberson-partners-provide-better-crm-online-retail','und'),
//              ('node/255','news/smartosc-reinforced-its-expansion-japanese-market','und'),
//              ('node/256','news/five-key-takeaways-meet-magento-vietnam-2016','und'),
//              ('node/266','news/seven-trends-impacting-southeast-asia-e-commerce-2017','und'),
//              ('node/272','news/join-marketing-inspiration-seminar-dotmailer-and-smartosc-dotlive-singapore','und'),
//              ('node/274','news/smartosc-earns-magento-enterprise-partnership-level','und'),
//              ('node/276','news/partner-interview-series-dotmailer-importance-marketing-automation','und'),
//              ('node/281','news/club-21-sucessfully-relaunches-its-omnichannel-commerce','und'),
//              ('node/287','news/smartosc-appoints-past-magento-head-customer-success-bart-jensen-vice-president-americas','und'),
//              ('node/289','news/dotmailer-allies-smartosc-strengthen-southeast-asia-presence','und'),
//              ('node/290','news/courts-singapore-looks-tackle-southeast-asia’s-growing-e-commerce-market-smartosc’s','und')
//      ");
//  }
//  return st('give old path alias');
//}