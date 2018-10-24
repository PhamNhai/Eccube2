<?php

require_once CLASS_EX_REALDIR . 'page_extends/shopping/LC_Page_Shopping_Complete_Ex.php';

/**
 * ご注文完了 のページクラス.
 *
 * @package Coupon
 */
class plg_Recommend_LC_Page_Shopping_Complete extends LC_Page_Shopping_Complete_Ex {

	function plg_Recommend_LC_Page_Shopping_Complete(){

	}

    //決済モジュールを使用している場合のみ処理を行う
	function exec(&$objPage){
	    
	    if($_SESSION['order_id']){
	        $objQuery =& SC_Query_Ex::getSingletonInstance();
	        //注文詳細を取得
	        $resultProduct = $objQuery->select("*","dtb_order_detail","order_id = ? ",array($_SESSION["order_id"]));
    	    foreach($resultProduct as $key=>$data){
    	        $product_id = $data["product_id"];
    	        $objPage->bannerData = $this->checkBanner($product_id);
    	        if($objPage->bannerData){
    	            break;
    	        }
    	    }
	    }
	}

	//バナーのチェック
	function checkBanner($product_id){
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrVal = array();
        $from = "dtb_plg_recommend_banner";
        $where = "product_id = ? and del_flg = 0 and show_flg = 1 and start_time <= ? and end_time > ? and (view_type=0 or view_type=2)";
        $arrVal[] = $product_id;
        $arrVal[] = date("Y-m-d H:i:s");
        $arrVal[] = date("Y-m-d H:i:s");
        $result = $objQuery->getRow("*",$from,$where,$arrVal);
        return $result;
	}
	
}