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
 * レコメンドバナー管理_入力画面 のページクラス.
 *
 * @package Page
 * @author SEED
 * @version $Id: plg_Recommend_LC_Page_Admin_Contents_Recommend_Input.php 21232 2011-09-04 15:44:01Z Seasoft $
 */
class plg_Recommend_LC_Page_Admin_Contents_Recommend_Input extends LC_Page_Admin_Ex {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->tpl_mainpage = 'contents/plg_Recommend_recommend_input.tpl';
        $this->tpl_mainno = 'contents';
        $this->tpl_subno = 'recommend-banner';
        $this->tpl_pager = 'pager.tpl';
        $this->tpl_maintitle = 'コンテンツ管理';
        $this->tpl_subtitle = 'レコメンドバナー管理_登録画面';
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

        // 初期化（オブジェクト作成）
        $objView = new SC_AdminView();
        $objSess = new SC_Session();
        $objDate = new SC_Date(ADMIN_NEWS_STARTYEAR);
        $objQuery = new SC_Query_Ex();

        //---- 日付プルダウン設定
        $this->arrYear = $objDate->getYear(date("Y"));
        $this->arrMonth = $objDate->getMonth();
        $this->arrDay = $objDate->getDay();

        // パラメーター管理クラス
        $objFormParam = new SC_FormParam_Ex();

        
        // モードによる処理分岐
        switch($this->getMode()) {
            case "edit":
                if($_POST["recommend_banner_id"]){
                    $this->arrForm = $this->getBannerData($_POST["recommend_banner_id"]);
                }
                break;
        
            case "confirm":
                // パラメーター処理
                $this->lfInitParam($objFormParam);
                $objFormParam->setParam($_POST);
                $objFormParam->convParam();
                // 入力パラメーターチェック
                $this->arrErr = $this->lfCheckError($objFormParam);
                $this->arrForm = $objFormParam->getHashArray();
                
                if(!$this->arrErr){
                  //画像アップロード
                  $this->checkImgUpload($this->arrErr);
                }

                if(!$this->arrErr){
                  // 確認画面テンプレートに切り替え
                  $this->tpl_subtitle = 'レコメンドバナー管理_確認画面';
                  $this->tpl_mainpage = 'contents/plg_Recommend_recommend_confirm.tpl';
                }
                break;
            
            case "regist":
                // パラメーター処理
                $this->lfInitParam($objFormParam);
                $objFormParam->setParam($_POST);
                $objFormParam->convParam();
                // 入力パラメーターチェック
                $this->arrErr = $this->lfCheckError($objFormParam);
                $this->arrForm = $objFormParam->getHashArray();
                
                if(!$this->arrErr){
                  //登録処理
                  $this->registBanner($this->arrForm);
                  $this->tpl_subtitle = 'レコメンドバナー管理_登録完了';
                  $this->tpl_mainpage = 'contents/plg_Recommend_recommend_complete.tpl';
                }
                break;

            case "back":
                // パラメーター処理
                $this->lfInitParam($objFormParam);
                $objFormParam->setParam($_POST);
                $objFormParam->convParam();
                // 入力パラメーターチェック
                $this->arrErr = $this->lfCheckError($objFormParam);
                $this->arrForm = $objFormParam->getHashArray();
                
                break;


            default:
                $this->lfInitParam($objFormParam);
                $this->arrForm = $objFormParam->getHashArray();
                break;
        }
        
        if($this->arrForm["product_id"]){
            $this->product_name = $this->getProductName($this->arrForm["product_id"]);
        }
        

        $this->start_selected_year  = $this->arrForm["start_year"];
        $this->start_selected_month = $this->arrForm["start_month"];
        $this->start_selected_day   = $this->arrForm["start_day"];
        $this->end_selected_year    = $this->arrForm["end_year"];
        $this->end_selected_month   = $this->arrForm["end_month"];
        $this->end_selected_day     = $this->arrForm["end_day"];
        
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
     * パラメーター情報の初期化
     *
     * @param array $objFormParam フォームパラメータークラス
     * @return void
     */
    function lfInitParam(&$objFormParam) {
        $objFormParam->addParam('バナーID', 'recommend_banner_id', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('商品', 'product_id', INT_LEN, 'n', array('NUM_CHECK','EXIST_CHECK'));
        $objFormParam->addParam('表示箇所', 'view_type', INT_LEN, 'n', array('NUM_CHECK','EXIST_CHECK'));
        $objFormParam->addParam('表示状態', 'show_flg', INT_LEN, 'n', array('NUM_CHECK','EXIST_CHECK'));
        $objFormParam->addParam('購入確認画面_バナー画像_PC', 'file_img_pc', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('購入確認画面_バナー画像_SP', 'file_img_sp', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('購入確認画面_バナー画像_MB', 'file_img_mb', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));

        $objFormParam->addParam('購入完了画面_バナー画像_PC', 'file_img_pc2', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('購入完了画面_バナー画像_SP', 'file_img_sp2', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('購入完了画面_バナー画像_MB', 'file_img_mb2', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));

        $objFormParam->addParam('購入確認画面_リンク先URL', 'link_url_pc', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('購入確認画面_リンク先URL', 'link_url_sp', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('購入確認画面_リンク先URL', 'link_url_mb', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        
        $objFormParam->addParam('購入完了画面_リンク先URL', 'link_url_pc2', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('購入完了画面_リンク先URL', 'link_url_sp2', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('購入完了画面_リンク先URL', 'link_url_mb2', LTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));

        $objFormParam->addParam('表示期間_開始_年', 'start_year', INT_LEN, 'n', array('NUM_CHECK','EXIST_CHECK'));
        $objFormParam->addParam('表示期間_開始_月', 'start_month', INT_LEN, 'n', array('NUM_CHECK','EXIST_CHECK'));
        $objFormParam->addParam('表示期間_開始_日', 'start_day', INT_LEN, 'n', array('NUM_CHECK','EXIST_CHECK'));
        $objFormParam->addParam('表示期間_終了_年', 'end_year', INT_LEN, 'n', array('NUM_CHECK','EXIST_CHECK'));
        $objFormParam->addParam('表示期間_終了_月', 'end_month', INT_LEN, 'n', array('NUM_CHECK','EXIST_CHECK'));
        $objFormParam->addParam('表示期間_終了_日', 'end_day', INT_LEN, 'n', array('NUM_CHECK','EXIST_CHECK'));
    }
    
    /**
     * フォーム入力パラメーターエラーチェック
     *
     * @param array $objFormParam フォームパラメータークラス
     * @return array エラー配列
     */
    function lfCheckError(&$objFormParam) {
        $arrErr = $objFormParam->checkError();
        
        if(!$arrErr["product_id"]){
            //商品IDの存在チェック
            $objQuery =& SC_Query_Ex::getSingletonInstance();
            $result = $objQuery->getRow("*","dtb_products","product_id=?",array($objFormParam->getValue("product_id")));
            if(!$result){
                $arrErr["product_id"] = "※商品が存在しません<br>";
            }
        }
        
        if(!$arrErr["start_year"]&&!$arrErr["start_month"]&&!$arrErr["start_day"]&&!$arrErr["end_year"]&&!$arrErr["end_month"]&&!$arrErr["end_day"]){
            $objErr = new SC_CheckError_Ex($objFormParam->getHashArray());
            $objErr->doFunc(array("開始日", "start_year", "start_month", "start_day"), array("CHECK_DATE"));
            $objErr->doFunc(array("終了日", "end_year", "end_month", "end_day"), array("CHECK_DATE"));
            $objErr->doFunc(array("開始日", "終了日", "start_year", "start_month", "start_day", "end_year", "end_month", "end_day"), array("CHECK_SET_TERM"));
            if($objErr->arrErr){
               foreach($objErr->arrErr as $key=>$data){
                   $arrErr[$key] = $data;
               }
            }
        }
        
        return $arrErr;
    }
    
    
    //バナーの登録処理
    function registBanner($arrData){
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $sqlVal = array();
        $sqlVal["product_id"]  = $arrData["product_id"];
        $sqlVal["view_type"]   = $arrData["view_type"];
        $sqlVal["file_img_pc"] = $arrData["file_img_pc"];
        $sqlVal["file_img_sp"] = $arrData["file_img_sp"];
        $sqlVal["file_img_mb"] = $arrData["file_img_mb"];
        $sqlVal["file_img_pc2"] = $arrData["file_img_pc2"];
        $sqlVal["file_img_sp2"] = $arrData["file_img_sp2"];
        $sqlVal["file_img_mb2"] = $arrData["file_img_mb2"];
        $sqlVal["link_url_pc"] = $arrData["link_url_pc"];
        $sqlVal["link_url_sp"] = $arrData["link_url_sp"];
        $sqlVal["link_url_mb"] = $arrData["link_url_mb"];
        $sqlVal["link_url_pc2"] = $arrData["link_url_pc2"];
        $sqlVal["link_url_sp2"] = $arrData["link_url_sp2"];
        $sqlVal["link_url_mb2"] = $arrData["link_url_mb2"];
        $sqlVal["show_flg"]    = $arrData["show_flg"];
        $sqlVal["del_flg"]     = 0;
        $sqlVal["product_id"]  = $arrData["product_id"];
        $sqlVal["update_date"] = "now()";
        
        $sqlVal["start_time"] = $arrData["start_year"]."-".$arrData["start_month"]."-".$arrData["start_day"]." 00:00:00";
        $sqlVal["end_time"]   = $arrData["end_year"]."-".$arrData["end_month"]."-".$arrData["end_day"]." 23:59:59";
        
        if($arrData["recommend_banner_id"]){
            ///更新
            $sqlVal["recommend_banner_id"] = $arrData["recommend_banner_id"];
            $objQuery->update("dtb_plg_recommend_banner",$sqlVal,"recommend_banner_id=?",array($arrData["recommend_banner_id"]));
        }else{
            //新規追加
            $recommend_banner_id = $objQuery->nextVal("dtb_plg_recommend_banner_recommend_banner_id");
            $sqlVal["recommend_banner_id"] = $recommend_banner_id;
            $objQuery->insert("dtb_plg_recommend_banner",$sqlVal);
        }
        
    }
    
    //商品名を取得
    function getProductName($product_id){
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $result = $objQuery->getRow("name","dtb_products","product_id=?",array($product_id));
        return $result["name"];
    }

    /**
     * アップロードファイルパラメーター情報の初期化
     * - 画像ファイル用
     *
     * @param object $objUpFile SC_UploadFileインスタンス
     * @return void
     */
    function lfInitFile(&$objUpFile) {
        $objUpFile->addFile('購入確認画面_バナー画像_PC', 'file_img_pc', array('jpg', 'gif', 'png'),IMAGE_SIZE, false);
        $objUpFile->addFile('購入確認画面_バナー画像_スマホ', 'file_img_sp', array('jpg', 'gif', 'png'), IMAGE_SIZE, false);
        $objUpFile->addFile('購入確認画面_バナー画像_モバイル', 'file_img_mobile', array('jpg', 'gif', 'png'), IMAGE_SIZE, false);

        $objUpFile->addFile('購入完了画面_バナー画像_PC', 'file_img_pc2', array('jpg', 'gif', 'png'),IMAGE_SIZE, false);
        $objUpFile->addFile('購入完了画面_バナー画像_スマホ', 'file_img_sp2', array('jpg', 'gif', 'png'), IMAGE_SIZE, false);
        $objUpFile->addFile('購入完了画面_バナー画像_モバイル', 'file_img_mobile2', array('jpg', 'gif', 'png'), IMAGE_SIZE, false);
    }

    /**
     * パラメーター情報の初期化
     * - 画像ファイルアップロードモード
     *
     * @param object $objFormParam SC_FormParamインスタンス
     * @return void
     */
    function lfInitFormParam_UploadImage(&$objFormParam) {
        $objFormParam->addParam('image_key', 'image_key', '', '', array());
    }


    /**
     * アップロード画像のチェック
     */
    function checkImgUpload(&$arrErr){
		for($i=0;$i<6;$i++){
		    switch($i){
		        case 0:
        			$up_type = "file_img_pc";
		            break;
		        case 1:
        			$up_type = "file_img_sp";
		            break;
		        case 2:
        			$up_type = "file_img_mb";
		            break;
		        case 3:
        			$up_type = "file_img_pc2";
		            break;
		        case 4:
        			$up_type = "file_img_sp2";
		            break;
		        case 5:
        			$up_type = "file_img_mb2";
		            break;
		    }
	    	// アップロードファイルを変数にセット
			$file = $_FILES[$up_type];
			$type = $file["type"][0];

			if ($file["name"][0]) {
				$upload_flg = true;
			} else {
				$upload_flg = false;
			}

			if ($upload_flg) {

				// ファイル形式チェック
				// ※MIMEタイプではなく、単純に拡張子でのチェックとする
				switch ($type) {
					case "image/gif":
						$img_ex = "gif";
						break;
					case "image/jpg":
					case "image/jpeg":
					case "image/pjpeg":
						$img_ex = "jpg";
						break;
					case "image/png":
					case "image/x-png":
						$img_ex = "png";
						break;
					default:
						$arrErr[$up_type] = "※ 正しい画像のファイルを指定してください。<br />";
						break;
				}

				// ファイルサイズチェック(1000kバイトまで)
				if ($file['size'][0]>1000000) {
					$arrErr[$up_type] = "※ 画像のファイルサイズは1000Kバイト以下にしてください。<br />";
					continue;
				}

				// ファイルサイズチェック(0Byte)
				if (!$file['size'][0]) {
					$arrErr["upfile{$i}"] = "※ 不正な画像ファイルが指定されました。<br />";
					continue;
				}

				// その他のシステムエラー
				if ($file['error'][0] != UPLOAD_ERR_OK) {
					//$arrErr["upfile{$i}"] = "※ 画像ファイルのアップロードに失敗しました。<br />";
					continue;
				}

				if (is_uploaded_file($_FILES[$up_type]["tmp_name"][0])) {
					$upload_file_name = "plg_recommend_".$up_type."_" . date('YmdHis') . "." . $img_ex;
					$upload_path = IMAGE_SAVE_REALDIR . $upload_file_name;
					if (move_uploaded_file($_FILES[$up_type]["tmp_name"][0], $upload_path)) {
						chmod($upload_path, 0644);
					} else {
						$arrErr[$up_type] = "※ 画像ファイルのアップロードに失敗しました。<br />";
					}

					$this->arrForm[$up_type] = $upload_file_name;
				}
			}
		}
	}
	
	//バナーデータを取得(edit用)
	function getBannerData($banner_id){
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $resultData = $objQuery->getRow("*","dtb_plg_recommend_banner","recommend_banner_id = ?",array($banner_id));
        
        $resultData["start_year"]  = substr($resultData["start_time"],0,4);
        $resultData["start_month"] = substr($resultData["start_time"],5,2);
        $resultData["start_day"]   = substr($resultData["start_time"],8,2);
        $resultData["end_year"]    = substr($resultData["end_time"],0,4);
        $resultData["end_month"]   = substr($resultData["end_time"],5,2);
        $resultData["end_day"]     = substr($resultData["end_time"],8,2);
	    return $resultData;
	}
}
?>
