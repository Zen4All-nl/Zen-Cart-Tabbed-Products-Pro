<?php

/*
 * Tabbed Products Pro 1.20
 * 16-Nov-2015 - Zen4all (http://zen4al.nl)
 */

function AddHeader($sHeaderName, $iTabNum, $bHeadersEnabled) {
  if ($bHeadersEnabled != 0) {
    $DaHeader .= "\n" . '<div id="ProductDescriptionHeader' . $iTabNum . '" style="display:block;">'; //class="centerBoxWrapper"
    $b[$iTabNum] = str_replace('<br>', ' ', $sHeaderName);
    $b[$iTabNum] = str_replace('<br/>', ' ', $b[$iTabNum]);
    $b[$iTabNum] = str_replace('<br />', ' ', $b[$iTabNum]);
    $DaHeader .= "\n" . '<h2 class="centerBoxHeading">' . strip_tags($b[$iTabNum]) . '</h2>';
    $DaHeader .= "\n" . '</div>' . "\n";
    return $DaHeader;
  }
}

function CheckSubTags($iTabNum) {
  global $fmtAttr;
  global $fmtDOT;
  global $fmtATC;
  global $fmtAddIm;
  global $fmtCAP;
  global $fmtRVW;
  global $fmtXSL;
  global $fmtCust1;
  global $fmtCust2;
  global $fmtCust3;
  global $proddata;
  global $sub_AttributeOptions;
  global $sub_DetailsOnTab;
  global $sub_AddToCart;
  global $sub_AdditionalImages;
  global $sub_CustomersAlsoPurchased;
  global $sub_CrossSell;
  global $sub_Reviews;

  //<!-- bof sub_AttribOptions -->
  if (strpos($proddata, $sub_AttributeOptions . $iTabNum . ')*-->') > 0) {
    $subtagvalue .= $fmtAttr;
  }
  //<!-- eof sub_AttribOptions -->
  //<!-- sub_DetailsOnTab -->
  if (strpos($proddata, $sub_DetailsOnTab . $iTabNum . ')*-->') > 0) {
    $subtagvalue .= $fmtDOT;
  }
  //<!-- eof sub_DetailsOnTab -->
  //<!-- sub_AddToCart -->
  if (strpos($proddata, $sub_AddToCart . $iTabNum . ')*-->') > 0) {
    $subtagvalue .= $fmtATC;
  }
  //<!-- eof sub_AddToCart -->
  //<!-- bof sub_AddlImages -->
  if (strpos($proddata, $sub_AdditionalImages . $iTabNum . ')*-->') > 0) {
    $subtagvalue .= $fmtAddIm;
  }
  //<!-- eof sub_AddlImages -->
  //<!-- bof sub_CustAlsoPurch -->
  if (strpos($proddata, $sub_CustomersAlsoPurchased . $iTabNum . ')*-->') > 0) {
    $subtagvalue .= $fmtCAP;
  }
  //<!-- eof sub_CustAlsoPurch -->
  //<!-- bof sub_CrossSell -->
  if (strpos($proddata, $sub_CrossSell . $iTabNum . ')*-->') > 0) {
    $subtagvalue .= $fmtXSL;
  }
  //<!-- eof sub_CrossSell -->
  //<!-- bof sub_Reviews -->
  if (strpos($proddata, $sub_Reviews . $iTabNum . ')*-->') > 0) {
    $subtagvalue .= $fmtRVW;
  }
  //<!-- eof sub_Reviews -->
  return $subtagvalue;
}
