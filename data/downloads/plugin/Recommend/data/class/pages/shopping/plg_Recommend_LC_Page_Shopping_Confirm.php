<?php

require_once CLASS_EX_REALDIR . 'page_extends/shopping/LC_Page_Shopping_Confirm_Ex.php';

/**
 * 購入確認画面 のページクラス.
 *
 * @package Recommend
 */
class plg_Recommend_LC_Page_Shopping_Confirm extends LC_Page_Shopping_Confirm_Ex {

	function plg_Recommend_LC_Page_Shopping_Confirm(){

	}

	function exec(&$objPage){
		$this->action($objPage);
	}

	function action(&$objPage){
	
	    $cartItems = array();
	    $cartItems = $objPage->arrCartItems;
	    foreach($cartItems as $key=>$data){
	        $product_id = $data["productsClass"]["product_id"];
	        $objPage->bannerData = $this->checkBanner($product_id);
	        if($objPage->bannerData){
	            break;
	        }
	    }
	}
	
	//バナーのチェック
	function checkBanner($product_id){
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrVal = array();
        $from = "dtb_plg_recommend_banner";
        $where = "product_id = ? and del_flg = 0 and show_flg = 1 and start_time <= ? and end_time > ? and (view_type=0 or view_type=1)";
        $arrVal[] = $product_id;
        $arrVal[] = date("Y-m-d H:i:s");
        $arrVal[] = date("Y-m-d H:i:s");
        $result = $objQuery->getRow("*",$from,$where,$arrVal);
        return $result;
	}
}