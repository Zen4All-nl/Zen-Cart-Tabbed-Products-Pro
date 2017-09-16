<?php

/**
 * Tabs module - prepares information for use in Tabbed Products Pro
 * Tabbed Products Pro 1.10
 * 2-Aug-2008 - QHome (qhomezone@gmail.com)
 * 10-Oct-2013 - C Jones (http://overthehillweb.com)
 *
 * @package modules
 * @copyright Copyright 2003-2008 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tabbed_products_pro.php 3018 2013-10-10 10:04:04Z cjones $
 *
 */
$proddata = stripslashes($products_description);
if ($proddata != '') {

  //-=-=-=- BOF: Tabbed Products Config -=-=-=-
  //############   DB VALUES   #############
  $bGblEnableTabs = TPP_GLOBAL_ENABLE_TABS;  // Enable or Disable tabs
  $bGblMainImageOnTab = TPP_GLOBAL_MAIN_IMAGE_ON_TAB;  // Puts Main Image First tab
  $bGblProdDescTab = TPP_GLOBAL_PROD_DESC_ON_TAB;  // Forces the Product Description to globally be in a tab
  $bGblAddToCart = TPP_GLOBAL_ADD_TO_CART_ON_TAB;  // adds Add to Cart and Qty Discount to its own tab
  $bGblAttribsOnTab = TPP_GLOBAL_ATTRIBUTES_ON_TAB;  // adds Attribute Options to its own a tab
  $bGblAttribsOnATCTab = TPP_GLOBAL_ATTRIBUTES_ON_ATC_TAB;  // adds Attribute Options to the Add-To-Cart tab. Overrides the standalone tab.
  $bGblDetailsOnTab = TPP_GLOBAL_DETAILS_ON_TAB;  // adds Attribute Options to its own a tab
  $bGblAdditionalImages = TPP_GLOBAL_ADDL_IMAGES_ON_TAB;  // adds Additional Images on its own tab
  $bGblCustomersAlsoPurchased = TPP_GLOBAL_CUST_ALSO_PURCH_ON_TAB;  // adds Customers Also Purchased as its own tab
  $bGblReviews_Tab = TPP_GLOBAL_REVIEWS_ON_TAB;  // adds Reviews as its own tab
  $bGblCustom1_Tab = TPP_GLOBAL_CUSTOM1_ON_TAB;  // adds Custom1 as its own tab
  $bGblCustom2_Tab = TPP_GLOBAL_CUSTOM2_ON_TAB;  // adds Custom2 as its own tab
  $bGblCustom3_Tab = TPP_GLOBAL_CUSTOM3_ON_TAB;  // adds Custom3 as its own tab
  //#######  3RD PARTY CONTRIB SUPPORT  ######
  $bGblCrossSell_Tab = TPP_GLOBAL_CROSS_SELL_ON_TAB;  // adds Cross Sell as its own tab only if it is already installed
  //############   HEADERS   ##############  
  $bShowHeaders = TPP_SHOW_TAB_HEADERS;  // Turns the headers underneath each tab on. Headers bear the tab name for a nice look.
  //###########   TAB NAMES   #############
  /* ++ Added to Language File:  tabbed_products_pro.php ++ */
  $gbl_proddesc_tab_name = TEXT_TAB_TITLE_PROD_DESC; // If using the tabbed view for this info, set the tab title for Gbl Product Description
  $addtocart_tab_name = TEXT_TAB_TITLE_ADD_TO_CART; // if using this tab, set the tab title for the Add To Cart Tab
  $attribs_tab_name = TEXT_TAB_TITLE_ATTRIBS; // if using this tab, set the tab title for the Add To Cart Tab
  $details_tab_name = TEXT_TAB_TITLE_DETAILS; // if using this tab, set the tab title for the Add To Cart Tab
  $add_images_tab_name = TEXT_TAB_TITLE_ADDITONAL_IMAGES; // if using this tab, set the tab title for the Additional Images Tab 
  $cust_also_purchased_tab_name = TEXT_TAB_TITLE_CUST_ALSO_PURCHASED; // if using this tab, set the tab title for the Cust Also Purchased Tab 
  $cross_sell_tab_name = TEXT_TAB_TITLE_CROSS_SELL; // if using this tab, set the tab title for the CrossSell Tab
  $reviews_tab_name = TEXT_TAB_TITLE_REVIEWS; // if using this tab, set the tab title for the Reviews
  $custom1_tab_name = TEXT_TAB_TITLE_CUSTOM1; // if using this tab, set the tab title for the Custom Tab 1
  $custom2_tab_name = TEXT_TAB_TITLE_CUSTOM2; // if using this tab, set the tab title for the Custom Tab 2
  $custom3_tab_name = TEXT_TAB_TITLE_CUSTOM3; // if using this tab, set the tab title for the Custom Tab 3
  //########################################	
  //-=-=-=- EOF: Tabbed Products Config -=-=-=-
  //-=-=-=- BOF: Tabbed Products Initialization -=-=-=-

  if ($bGblEnableTabs != true) {

    $chkTabStart = false;
    $chkTabEnd = false;
    $bMainImageOnTab = false;
    $bAddToCart = false;
    $bAttribsOnTab = false;
    $bAttribsOnATCTab = false;
    $bDetailsOnTab = false;
    $bAdditionalImages = false;
    $bCustomersAlsoPurchased = false;
    $bCrossSell_Tab = false;
    $bReviews_Tab = false;
    $bCustom1_Tab = false;
    $bCustom2_Tab = false;
    $bCustom3_Tab = false;
    $bsubtab_AttributeOptions = false;
    $bsubtab_DetailsOnTab = false;
    $bsubtab_AddToCart = false;
    $bsubtab_AdditionalImages = false;
    $bsubtab_CustomersAlsoPurchased = false;
    $bsubtab_CrossSell = false;
    $bsubtab_Reviews = false;
  } else {

    //###########   INIT VARS  #############
    $IgnoreGlobals = strpos($proddata, '<!--@IgnoreGlobals@-->');
    $chkTabStart = strpos($proddata, '<!--%');
    $chkTabEnd = strpos($proddata, '%-->');

    //If IgnoreGlobals tag is found, then override the global prod desc tag to be false and read only the values from the product description tags
    if (strval($IgnoreGlobals) != NULL) {
      $bGblProdDescTab = false;
    }

    //Check if Product Description already has a tag so it doesn't create another one with the Global tag, otherwise add the tag
    $first_char_tag = strpos($proddata, '<!--%');
    if (intval($first_char_tag) != 0 || strval($first_char_tag) == '') {
      if ($bGblProdDescTab == true) {
        $proddata = '<!--%' . $gbl_proddesc_tab_name . '%-->' . $proddata;
      }
    }

    //###########   ZEN TAGS   #############
    $bAddToCart = strpos($proddata, '<!--#AddToCart#-->');
    $bAttribsOnTab = strpos($proddata, '<!--#AttributeOptions#-->');
    $bDetailsOnTab = strpos($proddata, '<!--#ProductDetails#-->');
    $bAdditionalImages = strpos($proddata, '<!--#AdditionalImages#-->');
    $bCustomersAlsoPurchased = strpos($proddata, '<!--#CustomersAlsoPurchased#-->');
    $bReviews_Tab = strpos($proddata, '<!--#Reviews#-->');
    $bMainImageOnTab = strpos($proddata, '<!--#MainImageOnTab#-->');
    //###########   SUB TAGS   #############
    $sub_AddToCart = '<!--*sub_AddToCart(';
    $sub_AttributeOptions = '<!--*sub_AttributeOptions(';
    $sub_DetailsOnTab = '<!--*sub_DetailsOnTab(';
    $sub_AdditionalImages = '<!--*sub_AdditionalImages(';
    $sub_CustomersAlsoPurchased = '<!--*sub_CustomersAlsoPurchased(';
    $sub_CrossSell = '<!--*sub_CrossSell(';
    $sub_Reviews = '<!--*sub_Reviews(';

    //If IgnoreGlobals is false, then set all the proper values for Built-in Zen features
    if ($IgnoreGlobals === false) {
      if ($bGblAddToCart == true) {
        $bAddToCart = 1;
      }
      if ($bGblAttribsOnTab == true) {
        $bAttribsOnTab = 1;
      }
      if ($bGblAttribsOnATCTab == true && $bGblAddToCart == true) {
        $bAttribsOnATCTab = 1;
      }
      if ($bGblDetailsOnTab == true) {
        $bDetailsOnTab = 1;
      }
      if ($bGblAdditionalImages == true) {
        $bAdditionalImages = 1;
      }
      if ($bGblCustomersAlsoPurchased == true) {
        $bCustomersAlsoPurchased = 1;
      }
      if ($bGblReviews_Tab == true && $IgnoreGlobals === false) {
        $bReviews_Tab = 1;
      }
      if ($bGblMainImageOnTab == true && $IgnoreGlobals === false) {
        $bMainImageOnTab = 1;
      }
      if ($bGblCustom1_Tab == true && $IgnoreGlobals === false) {
        $bCustom1_Tab = 1;
      }
      if ($bGblCustom2_Tab == true && $IgnoreGlobals === false) {
        $bCustom2_Tab = 1;
      }
      if ($bGblCustom3_Tab == true && $IgnoreGlobals === false) {
        $bCustom3_Tab = 1;
      }
    }

    //Check if CrossSell contrib is installed and enabled to create its tab data
    if (file_exists(DIR_WS_MODULES . 'xsell_products.php') || file_exists(DIR_WS_MODULES . $template_dir . '/' . 'xsell_products.php')) {
      $bCrossSell_Tab = strpos($proddata, '<!--#CrossSell#-->');
      if ($bGblCrossSell_Tab == true && $IgnoreGlobals === false) {
        $bCrossSell_Tab = 1;
      }
    } else {
      $bCrossSell_Tab = 0;
    }

    //Check for Sub Tags
    $bsubtab_AttributeOptions = strpos($proddata, $sub_AttributeOptions);
    $bsubtab_DetailsOnTab = strpos($proddata, $sub_DetailsOnTab);
    $bsubtab_AddToCart = strpos($proddata, $sub_AddToCart);
    $bsubtab_AdditionalImages = strpos($proddata, $sub_AdditionalImages);
    $bsubtab_CustomersAlsoPurchased = strpos($proddata, $sub_CustomersAlsoPurchased);
    $bsubtab_CrossSell = strpos($proddata, $sub_CrossSell);
    $bsubtab_Reviews = strpos($proddata, $sub_Reviews);

    //-=-=-=- EOF: Tabbed Products Initialization -=-=-=-	
    //-=-=-=- BOF: Tabbed Products Calculations -=-=-=-	

    $FindEnd = explode('<!--@EndTabs@-->', $proddata);  // Find where the EndTabs override is reached
    $CstmTags = explode('<!--%', $FindEnd[0]);   // Parse Custom Tags up to the EndTabs tag
    $ZenTags = explode('<!--#', $FindEnd[0]);   // Parse Zen Tags up to the EndTabs tag

    if ($CstmTags[0] != '') { // check for text before the tabs
      $tabstrip = '<div id="productDescription" class="productGeneral biggerText">' . $CstmTags[0] . '</div>' . "\n\n";
    }

    if (count($CstmTags) >= 1 || count($ZenTags) >= 1) {

      //$tabstrip .= '<br style="clear: both" />';
      $tabstrip .= "\n" . '<div id="tabsMenu">';
      $tabstrip .= "\n" . '<ul class="resp-tabs-list">';

      //Create a tab for each custom tag
      for ($g = 1; $g < count($CstmTags); $g++) {
        $sTmp = explode('%-->', $CstmTags[$g]);
        $sName[$g] = $sTmp[0];
        $sText[$g] = $sTmp[1];
        $tabstrip .= "\n" . '<li>' . $sName[$g] . '</li>';
      }

      //Create a tab for each zen tag
      $g = count($CstmTags);

      if ($bAttribsOnTab != false && $bAttribsOnATCTab != true) {
        if ($pr_attr->fields['total'] > 0) {
          $bAttribsExist = 1;
          $tabstrip .= "\n" . '<li>' . $attribs_tab_name . '</li>';
          $g++;
        }
      }

      if ($bDetailsOnTab != false) {
        if ((($flag_show_product_info_model == 1 && $products_model != '') || ( $flag_show_product_info_weight == 1 && $products_weight != 0) || ( $flag_show_product_info_quantity == 1) || ( $flag_show_product_info_manufacturer == 1 && ! empty($manufacturers_name)))) {
          $bDetailsExist = 1;
          $tabstrip .= "\n" . '<li>' . $details_tab_name . '</li>';
          $g++;
        }
      }

      if ($bAddToCart != false) {
        $tabstrip .= "\n" . '<li>' . $addtocart_tab_name . '</li>';
        $g++;
      }


      if ($bAdditionalImages != false) {
        ob_start();
        require($template->get_template_dir('/tpl_modules_additional_images.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_additional_images.php');
        $images_exist = ob_get_contents();
        $num_images = sizeof($images_array);
        ob_end_clean();
        if ($num_images != 0 && strval($num_images != '')) {
          $tabstrip .= "\n" . '<li>' . $add_images_tab_name . '</li>';
          $g++;
        }
        unset($images_array);
      }

      if ($bCustomersAlsoPurchased != false) {
        $also_purchased_products = $db->Execute(sprintf(SQL_ALSO_PURCHASED, (int)$_GET['products_id'], (int)$_GET['products_id']));
        $CustAlsoPur = $also_purchased_products->RecordCount();
        if ($CustAlsoPur != 0) {
          $tabstrip .= "\n" . '<li>' . $cust_also_purchased_tab_name . '</li>';
          $g++;
        }
      }

      if ($bCrossSell_Tab != 0) {
        $xsell_query = $db->Execute("SELECT distinct p.products_id, p.products_image, pd.products_name
                                     FROM " . TABLE_PRODUCTS_XSELL . " xp, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
                                     WHERE xp.products_id = '" . $_GET['products_id'] . "'
                                     AND xp.xsell_id = p.products_id
                                     AND p.products_id = pd.products_id
                                     AND pd.language_id = '" . $_SESSION['languages_id'] . "'
                                     AND p.products_status = 1
                                     ORDER BY xp.sort_order ASC LIMIT " . MAX_DISPLAY_XSELL);
        $num_products_xsell = $xsell_query->RecordCount();
        if ($num_products_xsell != 0) {
          $tabstrip .= "\n" . '<li>' . $cross_sell_tab_name . '</li>' . "\n";
          $g++;
        }
      }

      if ($bReviews_Tab != false) {
        $tabstrip .= "\n" . '<li>' . $reviews_tab_name . '</li>' . "\n";
        $g++;
      }
      // ===> Add Custom Tab 1 to tabs (tabstrip)
      if ($bCustom1_Tab != false) {
        $tabstrip .= "\n" . '<li>' . $custom1_tab_name . '</li>' . "\n";
        $g++;
      }
      // ===> Add Custom Tab 2 to tabs (tabstrip)
      if ($bCustom2_Tab != false) {
        $tabstrip .= "\n" . '<li>' . $custom2_tab_name . '</li>' . "\n";
        $g++;
      }
      // ===> Add Custom Tab 3 to tabs (tabstrip)
      if ($bCustom3_Tab != false) {
        $tabstrip .= "\n" . '<li>' . $custom3_tab_name . '</li>' . "\n";
        $g++;
      }

      $tabstrip .= '</ul>' . "\n\n"; //end the slidetabsmenu
      //create the main tab content container

      // ------------------------------------------------------------
      // -------- Zen Tag - Tab Contents Pre-load ---------
      // ------------------------------------------------------------
      // This is used by both the ZenTags and the sub tags. So I pre-load it to allow it to be ready for use.
      // I also hack the div ids for the magic version.
      // Preload Attributes
      if ($bAttribsOnTab != false && $bAttribsOnATCTab != true) {
        ob_start();
        require($template->get_template_dir('/tpl_modules_attributes.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_attributes.php');
        $fmtAttr .= ob_get_contents();
        ob_end_clean();
        $fmtAttr = str_replace('"attrib-', '"tab_attrib-', $fmtAttr);
      }

      // Preload Details
      if ($bDetailsOnTab != false) {
        $fmtDOT .= '<ul id="productDetailsList" class="floatingBox back">';
        $fmtDOT .= (($flag_show_product_info_model == 1 && $products_model != '') ? '<li>' . TEXT_PRODUCT_MODEL . $products_model . '</li>' : '') . "\n";
        $fmtDOT .= (($flag_show_product_info_weight == 1 && $products_weight != 0) ? '<li>' . TEXT_PRODUCT_WEIGHT . $products_weight . TEXT_PRODUCT_WEIGHT_UNIT . '</li>' : '') . "\n";
        $fmtDOT .= (($flag_show_product_info_quantity == 1) ? '<li>' . $products_quantity . TEXT_PRODUCT_QUANTITY . '</li>' : '') . "\n";
        $fmtDOT .= (($flag_show_product_info_manufacturer == 1 && ! empty($manufacturers_name)) ? '<li>' . TEXT_PRODUCT_MANUFACTURER . $manufacturers_name . '</li>' : '') . "\n";
        $fmtDOT .= '</ul>';
        $fmtDOT .= "\n" . '<br class="clearBoth" />';
      }

      // Preload AddToCart and Qty Discount box
      if ($bAddToCart != false) {

        // display attribs on ATC tab
        if ($bAttribsOnATCTab != false) {
          ob_start();
          require($template->get_template_dir('/tpl_modules_attributes.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_attributes.php');
          $fmtATC .= ob_get_contents();
          ob_end_clean();
          $fmtATC = str_replace('"attrib-', '"tab_attrib-', $fmtATC);
        }

        // display the products quantity discount
        if ($products_discount_type != 0) {
          ob_start();
          require($template->get_template_dir('/tpl_modules_products_quantity_discounts.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_products_quantity_discounts.php');
          $fmtATC .= ob_get_contents();
          ob_end_clean();
        }
        //<!--eof Quantity Discounts table -->
        $fmtATC .= "\n" . '<br />';

        //<!--bof Add to Cart Box -->
        if (CUSTOMERS_APPROVAL == 3 && TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM == '') {
          // do nothing
        } else {
          $display_qty = (($flag_show_product_info_in_cart_qty == 1 && $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p>' . PRODUCTS_ORDER_QTY_TEXT_IN_CART . $_SESSION['cart']->get_quantity($_GET['products_id']) . '</p>' : '');
          if ($products_qty_box_status == 0 || $products_quantity_order_max == 1) {
            // hide the quantity box and default to 1
            $the_button = '<input type="hidden" name="cart_quantity" value="1" />' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
          } else {
            // show the quantity box
            $the_button = PRODUCTS_ORDER_QTY_TEXT . '<input type="text" name="cart_quantity" value="' . (zen_get_buy_now_qty($_GET['products_id'])) . '" maxlength="6" size="4" /><br />' . zen_get_products_quantity_min_units_display((int)$_GET['products_id']) . '<br />' . zen_draw_hidden_field('products_id', (int)$_GET['products_id']) . zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
          }
          $display_button = zen_get_buy_now_button($_GET['products_id'], $the_button);
          if ($display_qty != '' || $display_button != '') {
            $fmtATC .= "\n" . '<div id="cartAdd">' . "\n";
            $fmtATC .= $display_qty;
            $fmtATC .= $display_button;
            $fmtATC .= "\n" . '</div>' . "\n\n";
          } // display qty and button
        } // CUSTOMERS_APPROVAL == 3
        //<!--eof Add to Cart Box-->
      }

      // Pre-load Additional Images
      if ($bAdditionalImages != false) {
        ob_start();
        require($template->get_template_dir('/tpl_modules_additional_images.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_additional_images.php');
        $fmtAddIm .= ob_get_contents();
        ob_end_clean();
      }

      // Pre-load Custom Tab 1
      if ($bCustom1_Tab != false) {
        $fmtCust1 = "\n" . '<div class="centerColumn" id="customTab1Default">' . "\n";
        ob_start();
        require (zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PRODUCT_INFO_CUSTOM_TAB_1, 'false'));
        $fmtCust1 .= ob_get_contents();
        ob_end_clean();
        $fmtCust1 .= "\n" . '</div>' . "\n\n";
      }

      // Pre-load Custom Tab 2
      if ($bCustom2_Tab != false) {
        $fmtCust2 = "\n" . '<div class="centerColumn" id="customTab2Default">' . "\n";
        ob_start();
        require (zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PRODUCT_INFO_CUSTOM_TAB_2, 'false'));
        $fmtCust2 .= ob_get_contents();
        ob_end_clean();
        $fmtCust2 .= "\n" . '</div>' . "\n\n";
      }

      // Pre-load Custom Tab 3
      if ($bCustom3_Tab != false) {
        $fmtCust3 = "\n" . '<div class="centerColumn" id="customTab3Default">' . "\n";
        ob_start();
        require (zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_PRODUCT_INFO_CUSTOM_TAB_3, 'false'));
        $fmtCust3 .= ob_get_contents();
        $fmtCust3 .= "\n" . '</div>' . "\n\n";
        ob_end_clean();
      }

      // Pre-load Customers Also Purchased
      if ($bCustomersAlsoPurchased != false) {
        ob_start();
        require($template->get_template_dir('tpl_modules_also_purchased_products.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_also_purchased_products.php');
        $fmtCAP .= ob_get_contents();
        ob_end_clean();
        $fmtCAP = str_replace('class="centerBoxWrapper"', '', $fmtCAP);
        if ($bShowHeaders != true) {
          $fmtCAP = str_replace('class="alsoPurchasedHeading"', 'class="alsoPurchasedHeading" style="display: none;"', $fmtCAP);
        }
        if ($bShowHeaders != true) {
          $fmtCAP = str_replace('class="centerBoxHeading"', 'class="centerBoxHeading" style="display: none;"', $fmtCAP);
        }
      }

      // Pre-load Cross Sell
      if ($bCrossSell_Tab != 0 && $num_products_xsell != 0) {
        ob_start();
        require($template->get_template_dir('tpl_modules_xsell_products.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_modules_xsell_products.php');
        $fmtXSL .= ob_get_contents();
        ob_end_clean();
        $fmtXSL = str_replace('class="centerBoxWrapper"', '', $fmtXSL);
        if ($bShowHeaders != true) {
          $fmtXSL = str_replace('class="centerBoxHeading"', 'class="centerBoxHeading" style="display: none;"', $fmtXSL);
        }
      }
      //Pre-load Reviews
      if ($bReviews_Tab != false) {
        $old_products_name = $products_name;
        ob_start();
        require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/reviews.php');
        require(DIR_WS_MODULES . '/pages/product_reviews/header_php.php');
        require($template->get_template_dir('tpl_product_reviews_default.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . 'tpl_product_reviews_default.php');
        // Hack the output a bit to remove the copy of the main image that reviews normally has on it and other duplicate stuff
        $products_name = $old_products_name;
        $fmtRVW .= ob_get_contents();
        ob_end_clean();
        $fmtRVW = str_replace('id="productMainImage"', 'id="productMainImageReview" style="display:none;"', $fmtRVW);
        $fmtRVW = str_replace('id="productReviewsDefaultProductImage"', 'id="productReviewsDefaultProductImage" style="display:none;"', $fmtRVW);
        $fmtRVW = str_replace('class="forward"', 'class="forward" style="display:none;"', $fmtRVW);
        $fmtRVW = str_replace('class="buttonRow"', 'class="buttonRow" style="display:none;"', $fmtRVW);
        //$fmtRVW = str_replace('class="buttonRow forward"', 'class="buttonRow forward" style="display:none;"', $fmtRVW);
        // don't hide read reviews button causes write reviews to float drop off tab. To fix, adding float to .tabcontent and width 100%. Lets see how it works.
        $fmtRVW = str_replace('id="productReviewsDefaultHeading"', 'id="productReviewsDefaultHeading" style="display:none;"', $fmtRVW);
        $fmtRVW = str_replace('id="productReviewsDefaultPrice"', 'id="productReviewsDefaultPrice" style="display:none;"', $fmtRVW);
        $fmtRVW = str_replace('span class="normalprice"', 'span class="normalprice" style="display:none;"', $fmtRVW);
        $fmtRVW = str_replace('span class="productSalePrice"', 'span class="productSalePrice" style="display:none;"', $fmtRVW);
        $fmtRVW = str_replace('span class="productPriceDiscount"', 'span class="productPriceDiscount" style="display:none;"', $fmtRVW);
      }

      //$fmtMainIm
      if ($bMainImageOnTab != false) {
        ob_start();
        require($template->get_template_dir('/tpl_modules_main_product_image.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_main_product_image.php');
        $fmtMainIm = ob_get_contents();
        $fmtMainIm .= '<h1 id="productName" class="productGeneral">' . $products_name . '</h1>'; // Product Name
        $fmtMainIm .= '<h2 id="productPrices" class="productGeneral">';
        if ($show_onetime_charges_description == 'true') {
          $one_time = '<span>' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</span><br />';
        } else {
          $one_time = TEXT_PRODUCT_PRICE_LABEL;
        }
        $fmtMainIm .= $one_time . ((zen_has_product_attributes_values((int)$_GET['products_id']) && $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : TEXT_PRODUCT_PRICE_LABEL) . zen_get_products_display_price((int)$_GET['products_id']);
        $fmtMainIm .= '</h2>';
        if (zen_get_product_is_always_free_shipping($products_id_current) && $flag_show_product_info_free_shipping) {
          $fmtMainIm .= '<div id="freeShippingIcon">' . TEXT_PRODUCT_FREE_SHIPPING_ICON . '</div>';
        }
        ob_end_clean();
      }

      // -----------------------------------------------------------
      // ------------- Custom Tab - Tab Contents -----------
      // -----------------------------------------------------------
      //if ($chkTabStart != false || $chkTabEnd != false) { //if tags aren't created properly, do not apply tabs
       $tabcontent .= "\n" . '<div class="resp-tabs-container">';
      if (count($CstmTags) >= 1) { //if tags aren't created properly, do not apply tabs
        for ($a = 1; $a < count($CstmTags); $a++) {
          $tabcontent .= "\n" . '<!--bof Custom sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent">';
          $tabcontent .= AddHeader($sName[$a], $a, $bShowHeaders);
          if ($bMainImageOnTab == true && $a == 1) {
            $tabcontent .= $fmtMainIm; // pre-loaded Main Image
          }
          $tabcontent .= "\n" . '<div id="productDescription_' . $a . '" class="productGeneral biggerText">' . $sText[$a] . '</div>';
          if ($bShowHeaders != true) {
            $tabcontent .= ("<script type=\"text/javascript\">if (document.getElementById('CustomHeader_" . $a . "') != null) {document.getElementById('CustomHeader_" . $a . "').style.display = \"none\"; }</script>");
          }
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>';
          $tabcontent .= "\n" . '<!--eof Custom sc' . $a . '-->' . "\n\n";
        } // End FOR loop
      } //end the Tab tag check
      // ------------------------------------------------------------
      // ------------- Zen Tag - Tab Contents ---------------
      // ------------------------------------------------------------
      // idea: Preload stuff to fmtXXX variables before this point. Then when doing the actual load of tabcontent, just reference the pre-existing variable.
      // example:
      //if $bAttribsOnTab != false && $bAttribsExist) {
      //fmtAttr = blah blah
      //}
      //
      // then later on below when calling it again, just use $tabcontent .= fmtAttr;
      // this would allow same reference in subtag file to make it smaller. but might make this file uglier.
      // ===> Check for any zen tabs
      if (count($ZenTags) >= 1) {
        $a = count($CstmTags);
        // ===> Check if Attributes should be on tabs (content)
        if ($bAttribsOnTab != false && $bAttribsExist && $bAttribsOnATCTab != true) {
          $tabcontent .= "\n" . '<!--bof AttribsOnTab sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent">';
          $tabcontent .= AddHeader($attribs_tab_name, $a, $bShowHeaders);
          $tabcontent .= $fmtAttr; //from pre-load
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>' . "\n" . '<!--eof AttribsOnTab sc' . $a . '-->' . "\n\n";
          $a++;
        }
        //<!--eof Attributes Module -->
        // ===> Check if Product Details should be on tabs (content)
        if ($bDetailsOnTab != false && $bDetailsExist) {
          $tabcontent .= "\n" . '<!--bof DetailsOnTab sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent">';
          $tabcontent .= AddHeader($details_tab_name, $a, $bShowHeaders);
          $tabcontent .= $fmtDOT;
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>' . "\n" . '<!--eof DetailsOnTab sc' . $a . '-->' . "\n\n";
          $a++;
        }
        //<!--eof Details on Tab -->
        // ===> if AddToCart is true, then create a tab with add to cart and qty discount in it.
        if ($bAddToCart != false) {
          $tabcontent .= "\n" . '<!--bof AddtoCart_Tab sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent" title="cartAdd">';
          $tabcontent .= AddHeader($addtocart_tab_name, $a, $bShowHeaders);
          $tabcontent .= $fmtATC;
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>' . "\n" . '<!--eof AddtoCart_Tab sc' . $a . '-->' . "\n\n";
          $a++;
        } // end add to cart 
        // ===> Check if Additional Images should be on tabs (content)
        if ($bAdditionalImages != false && $num_images != 0) {
          $tabcontent .= "\n" . '<!--bof Additional_Images_Tab sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent">';
          $tabcontent .= AddHeader($add_images_tab_name, $a, $bShowHeaders);
          $tabcontent .= $fmtAddIm;
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>';
          $tabcontent .= "\n" . '<!--eof Additional_Images_Tab sc' . $a . '-->' . "\n\n";
          $a++;
        }

        //===> Check if Customers Also Purchased should be on tabs (content)
        if ($bCustomersAlsoPurchased != false && $CustAlsoPur != 0) {
          $tabcontent .= "\n" . '<!--bof Customers_Also_Purchased_Tab sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent">';
          $tabcontent .= $fmtCAP;
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>' . "\n" . '<!--eof Customers_Also_Purchased_Tab sc' . $a . '-->' . "\n\n";
          $a++;
        }

        // ===> Check if Cross Sell should be on tabs (content)
        if ($bCrossSell_Tab != false && $num_products_xsell != 0) {
          $tabcontent .= "\n" . '<!--bof CrossSell_Tab sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent">';
          $tabcontent .= $fmtXSL;
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>' . "\n" . '<!--eof CrossSell_Tab sc' . $a . '-->' . "\n\n";
          $a++;
        }

        // ===> Check if Reviews should be on tabs (content)
        if ($bReviews_Tab != false) {
          $tabcontent .= "\n" . '<!--bof Reviews_Tab sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent">';
          $tabcontent .= AddHeader($reviews_tab_name, $a, $bShowHeaders);
          $tabcontent .= $fmtRVW;
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>' . "\n" . '<!--eof Reviews_Tab sc' . $a . '-->' . "\n\n";
          $a++;
        }

        // ===> Add Custom Tab 1 to tabs (content)
        if ($bCustom1_Tab != false) {
          $tabcontent .= "\n" . '<!--bof Custom Tab 1 sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent">';
          $tabcontent .= AddHeader($custom1_tab_name, $a, $bShowHeaders);
          $tabcontent .= "\n" . $fmtCust1;
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>' . "\n" . '<!--eof Custom Tab 1 sc' . $a . '-->' . "\n\n";
          $a++;
        }

        // ===> Add Custom Tab 2 to tabs (content)
        if ($bCustom2_Tab != false) {
          $tabcontent .= "\n" . '<!--bof Custom Tab 2 sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent">';
          $tabcontent .= AddHeader($custom2_tab_name, $a, $bShowHeaders);
          $tabcontent .= "\n" .$fmtCust2;
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>' . "\n" . '<!--eof Custom Tab 2 sc' . $a . '-->' . "\n\n";
          $a++;
        }

        // ===> Add Custom Tab 3 to tabs (content)
        if ($bCustom3_Tab != false) {
          $tabcontent .= "\n" . '<!--bof Custom Tab 3 sc' . $a . '-->';
          $tabcontent .= "\n" . '<div id="sc' . $a . '" class="tabcontent">';
          $tabcontent .= AddHeader($custom3_tab_name, $a, $bShowHeaders);
          $tabcontent .= "\n" . $fmtCust3;
          $tabcontent .= CheckSubTags($a);
          $tabcontent .= "\n" . '</div>' . "\n" . '<!--eof Custom Tab 3 sc' . $a . '-->' . "\n\n";
          $a++;
        }
      }
      // ===> Close the tab content container 
      $tabcontent .= "\n" . '</div>';
      $tabcontent .= "\n"  . '</div>' . '<!--end of tabcontentcontainer -->' . "\n\n";

      $tabcontent .= "\n" . '<br class="clearBoth" />' . "\n\n";

      // If there is an EndTab tag, then display the rest of the text below the tabs.
      if ($FindEnd[1] != '') {
        $tabcontent .= "\n" . '<div class="productGeneral biggerText">' . $FindEnd[1] . '</div>' . "\n\n";
      }

      //Begin magic!
      if ($CstmTags[0] != '') {
        $tabstrip = str_replace('id="productDescription"', 'id="productDescription_tab"', $tabstrip);
      }
      $tabcontent = str_replace('id="cartAdd"', 'id="cartAdd_tab"', $tabcontent);
      $tabcontent = str_replace('id="productDetailsList"', 'id="productDetailsList_tab"', $tabcontent);
      $tabcontent = str_replace('id="productAttributes"', 'id="productAttributes_tab"', $tabcontent);
      $tabcontent = str_replace('id="attribsOptionsText"', 'id="attribsOptionsText_tab"', $tabcontent);
      $tabcontent = str_replace('id="productQuantityDiscounts"', 'id="productQuantityDiscounts_tab"', $tabcontent);
      $tabcontent = str_replace('id="productAdditionalImages"', 'id="productAdditionalImages_tab"', $tabcontent);
      $tabcontent = str_replace('id="alsoPurchased"', 'id="alsoPurchased_tab"', $tabcontent);
      $tabcontent = str_replace('id="crossSell"', 'id="crossSell_tab"', $tabcontent);
      $tabcontent = str_replace('id="reviewsDefault"', 'id="reviewsDefault_tab"', $tabcontent);
      $tabcontent = str_replace('id="productMainImage"', 'id="productMainImage_tab"', $tabcontent);
      $tabcontent = str_replace('id="productName"', 'id="productName_tab"', $tabcontent);
      $tabcontent = str_replace('id="productPrices"', 'id="productPrices_tab"', $tabcontent);
      $tabcontent = str_replace('id="freeShippingIcon"', 'id="freeShippingIcon_tab"', $tabcontent);
      //End magic!
      $tabData = $tabstrip . $tabcontent;
      $tabjscript .= ('<script type="text/javascript">$(\'#tabsMenu\').easyResponsiveTabs();</script>');
    }
  }
}