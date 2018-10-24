<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2011 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

// {{{ requires
require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';
//require_once PLUGIN_UPLOAD_REALDIR . 'Recommend/data/class/SC_Recommend.php';


/**
 * レコメンドバナー管理 のページクラス.
 *
 * @package Page
 * @author SEED
 * @version $Id: plg_Recommend_LC_Page_Admin_Contents_Recommend.php 21232 2011-09-04 15:44:01Z Seasoft $
 */
class plg_Recommend_LC_Page_Admin_Contents_Recommend extends LC_Page_Admin_Ex {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->tpl_mainpage = 'contents/plg_Recommend_recommend.tpl';
        $this->tpl_mainno = 'contents';
        $this->tpl_subno = 'recommend-banner';
        $this->tpl_pager = 'pager.tpl';
        $this->tpl_maintitle = 'コンテンツ管理';
        $this->tpl_subtitle = 'レコメンドバナー管理';
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process() {
        $this->action();
        $this->sendResponse();
    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    function action() {
       
       switch($this->getMode()){
           case "delete":
              if($_POST["recommend_banner_id"]){
                  $this->deleteBanner($_POST["recommend_banner_id"]);
                  $this->message = "※バナーを削除しました<br>";
              }
              break;
           default:
               break;
       }
       
       // データの取得
       $this->list_data = $this->getBannerData();

    }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy() {
        parent::destroy();
    }

    /**
     * 検索結果の行数を取得する.
     *
     * @param string $where 検索条件の WHERE 句
     * @param array $arrValues 検索条件のパラメーター
     * @return integer 検索結果の行数
     */
    function getNumberOfLines($where, $arrValues) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        return $objQuery->count('dtb_coupon', $where, $arrValues);
    }
    
    
    //バナー一覧を取得
    function getBannerData(){
      $objQuery =& SC_Query_Ex::getSingletonInstance();

      $col = "b.*,p.name";
      $from = "dtb_plg_recommend_banner as b inner join dtb_products as p on b.product_id=p.product_id";
      $where = "b.del_flg=0";
      $arrval = array();
      

      // 行数の取得
      $linemax = $objQuery->count($from, $where);
      $this->tpl_linemax = $linemax;
      // ページナビ用
      $this->tpl_pageno = isset($_POST['search_pageno']) ? $_POST['search_pageno'] : "";
      // ページ送りの取得
      $objNavi = new SC_PageNavi_Ex($this->tpl_pageno,
                                      $this->tpl_linemax, SEARCH_PMAX,
                                      'fnNaviSearchPage', NAVI_PMAX);
      $this->arrPagenavi = $objNavi->arrPagenavi;
      $startno = $objNavi->start_row;
      // 取得範囲の指定(開始行番号、行数のセット)
      $objQuery->setlimitoffset(SEARCH_PMAX, $startno);
      // 表示順序
      $order = "start_time DESC, recommend_banner_id DESC" ;
      $objQuery->setorder($order);
      // データの取得
      $resultData = $objQuery->select($col, $from, $where);
      return $resultData;
    }
    
    //バナー削除
    function deleteBanner($banner_id){
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $sqlVal = array();
        $sqlVal["del_flg"] = 1;
        $objQuery->update("dtb_plg_recommend_banner",$sqlVal,"recommend_banner_id=?",array($banner_id));
    }

}
?>
