<?php /* * Recommend
 */

/**
 * プラグインのメインクラス
 *
 * @package Recommend
 * @author SEED
 */

require_once PLUGIN_UPLOAD_REALDIR . 'Recommend/data/class/pages/shopping/plg_Recommend_LC_Page_Shopping_Confirm.php';
require_once PLUGIN_UPLOAD_REALDIR . 'Recommend/data/class/pages/shopping/plg_Recommend_LC_Page_Shopping_Complete.php';
require_once PLUGIN_UPLOAD_REALDIR . 'Recommend/data/class/plg_Recommend_MySql.php';
require_once PLUGIN_UPLOAD_REALDIR . 'Recommend/data/class/plg_Recommend_Postgres.php';

class Recommend extends SC_Plugin_Base {


    // コンストラクタ
    public function __construct(array $arrSelfInfo) {
        parent::__construct($arrSelfInfo);
    }

     /* {{{ インストール
     * installはプラグインのインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin plugin_infoを元にDBに登録されたプラグイン情報(dtb_plugin)
     * @return void
     }}} */
    function install($arrPlugin) {


        // 必要なファイルをコピーします.

        //ロゴ
        //copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/logo.png', PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] . '/logo.png');
        //copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/config.php', PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] . '/config.php');
        //mkdir(PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] . '/media');
        //SC_Utils_Ex::sfCopyDir(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] .'/media/', PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] . '/media/');

        //html,tplファイルの削除
        if(ADMIN_DIR){
            $admin_dir = ADMIN_DIR;
        }else{
            $admin_dir = "admin";
        }

        //html
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/html/admin/contents/plg_Recommend_recommend.php', HTML_REALDIR . $admin_dir.'/contents/plg_Recommend_recommend.php');
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/html/admin/contents/plg_Recommend_recommend_input.php', HTML_REALDIR . $admin_dir.'/contents/plg_Recommend_recommend_input.php');
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/html/admin/contents/plg_Recommend_recommend_product.php', HTML_REALDIR . $admin_dir.'/contents/plg_Recommend_recommend_product.php');

        //tpl
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/template/admin/contents/plg_Recommend_recommend.tpl', SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend.tpl');
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/template/admin/contents/plg_Recommend_recommend_input.tpl', SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend_input.tpl');
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/template/admin/contents/plg_Recommend_recommend_complete.tpl', SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend_complete.tpl');
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/template/admin/contents/plg_Recommend_recommend_confirm.tpl', SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend_confirm.tpl');
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/template/admin/contents/plg_Recommend_recommend_product.tpl', SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend_product.tpl');

        //テーブル作成
        self::createPlgTable();

    }

     /* {{{ アンインストール
     * uninstallはアンインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     }}} */
    function uninstall($arrPlugin) {
    
    /**
        // メディアディレクトリ削除.
        SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] .  '/media');
        SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR .  $arrPlugin['plugin_code']);
   */ 
   
        
        //html,tplファイルの削除
        if(ADMIN_DIR){
            $admin_dir = ADMIN_DIR;
        }else{
            $admin_dir = "admin";
        }
        SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR . $admin_dir.'/contents/plg_Recommend_recommend.php');
        SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR . $admin_dir.'/contents/plg_Recommend_recommend_input.php');
        SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR . $admin_dir.'/contents/plg_Recommend_recommend_product.php');
        SC_Helper_FileManager_Ex::deleteFile(SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend.tpl');
        SC_Helper_FileManager_Ex::deleteFile(SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend_complete.tpl');
        SC_Helper_FileManager_Ex::deleteFile(SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend_confirm.tpl');
        SC_Helper_FileManager_Ex::deleteFile(SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend_input.tpl');
        SC_Helper_FileManager_Ex::deleteFile(SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend_product.tpl');

        //プラグイン本体
        SC_Helper_FileManager_Ex::deleteFile(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code']);
        //テーブル削除
        self::deletePlgTable();
        
    }

    /* {{{ 稼働
     * enableはプラグインを有効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
    }}} */
    function enable($arrPlugin) {
        // nop
    }

    /* {{{ 停止
     * disableはプラグインを無効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
    }}} */
    function disable($arrPlugin) {
        // nop
    }


    /* {{{ 処理の介入箇所とコールバック関数を設定
     * registerはプラグインインスタンス生成時に実行されます
     *
     * @param SC_Helper_Plugin $objHelperPlugin
    }}} */
    function register(SC_Helper_Plugin $objHelperPlugin) {
        //テンプレートの変更
        $objHelperPlugin->addAction('prefilterTransform', array(&$this, 'prefilterTransform'));

        //購入確認画面
        $objHelperPlugin->addAction('LC_Page_Shopping_Confirm_action_after', array(&$this, 'LC_PageShopping_Confirm'));

        //購入完了画面
        $objHelperPlugin->addAction('LC_Page_Shopping_Complete_action_before', array(&$this, 'LC_PageShopping_Complete'));
    }

	//プラグイン用の新規テーブルの作成
	function createPlgTable(){
     
        $objQuery = & SC_Query_Ex::getSingletonInstance();
        
        if(DB_TYPE=="mysql"){
            $sqlObj = new plg_Recommend_MySql();        
        }else{
            $sqlObj = new plg_Recommend_Postgres();        
        }
         
        //dtb_plg_recommend_banner        
        $sql = $sqlObj->create_dtb_plg_recommend_banner();
        $objQuery->query($sql);
        
        //indexを追加する
        if(DB_TYPE=="pgsql"){
            $sqlObj->addIndex($objQuery);
        }
	}
	
	//プラグイン用テーブルの削除
	function deletePlgTable(){
        $objQuery = & SC_Query_Ex::getSingletonInstance();
        if(DB_TYPE=="mysql"){
            $sqlObj = new plg_Recommend_MySql();
        }else{
            $sqlObj = new plg_Recommend_Postgres();
            $sql = $sqlObj->deleteSeq();	
            $objQuery->query($sql);
        }
        
        //テーブルの削除
        $sql = $sqlObj->deleteTable();	
        $objQuery->query($sql);
	}


	/**
	*  購入確認画面
	**/
	function LC_PageShopping_Confirm(LC_Page_Ex $objPage){
		$obj = new plg_Recommend_LC_Page_Shopping_Confirm();
		$obj->exec($objPage);
	}

	/**
	*  購入完了画面
	**/
	function LC_PageShopping_Complete(LC_Page_Ex $objPage){
		$obj = new plg_Recommend_LC_Page_Shopping_Complete();
		$obj->exec($objPage);
	}


    /* {{{ プレフィルタコールバック関数
     *
     * @param string &$source テンプレートのHTMLソース
     * @param LC_Page_Ex $objPage ページオブジェクト
     * @param string $filename テンプレートのファイル名
     * @return void
    }}} */
    function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename) {
        $objTransform = new SC_Helper_Transform($source);
        $template_dir = PLUGIN_UPLOAD_REALDIR . 'Recommend/template/';
        

        switch($objPage->arrPageLayout['device_type_id']){
            case DEVICE_TYPE_PC:

                //購入確認画面
                if (strpos($filename, 'shopping/confirm.tpl') !== false) {
                    $objTransform->select('.information')->insertAfter(file_get_contents($template_dir . 'default/shopping/plg_Recommend_confirm.tpl'));
                }

                //購入完了画面
                if (strpos($filename, 'shopping/complete.tpl') !== false) {
                    $objTransform->select('.shop_information')->insertBefore(file_get_contents($template_dir . 'default/shopping/plg_Recommend_complete.tpl'));
                }

                break;

            case DEVICE_TYPE_MOBILE:

                //カート画面
                if (strpos($filename, 'shopping/confirm.tpl') !== false) {
                    $objTransform->select("form")->insertBefore(file_get_contents($template_dir . 'mobile/shopping/plg_Recommend_confirm.tpl'));
                }

                //購入完了画面
                if (strpos($filename, 'shopping/complete.tpl') !== false) {
                    $objTransform->select("br",1)->insertAfter(file_get_contents($template_dir . 'mobile/shopping/plg_Recommend_complete.tpl'));
                }

            	
                break;

            case DEVICE_TYPE_SMARTPHONE:

                //カート画面
                if (strpos($filename, 'shopping/confirm.tpl') !== false) {
                    $objTransform->select('.information')->insertAfter(file_get_contents($template_dir . 'sphone/shopping/plg_Recommend_confirm.tpl'));
                }
                
                //カート画面
                if (strpos($filename, 'shopping/complete.tpl') !== false) {
                    $objTransform->select('.btn_area')->insertBefore(file_get_contents($template_dir . 'sphone/shopping/plg_Recommend_complete.tpl'));
                }
                
                break;
            
            
            case DEVICE_TYPE_ADMIN:
            default:

            	//グローバルナビに追加
            	if(strpos($filename, 'contents/subnavi.tpl') !== false){
            		$objTransform->select('li',2)->insertAfter(file_get_contents($template_dir . 'admin/plg_Recommend_subnavi.tpl'));
            	}

            	break;
        }

        $source = $objTransform->getHTML();
    }
}
