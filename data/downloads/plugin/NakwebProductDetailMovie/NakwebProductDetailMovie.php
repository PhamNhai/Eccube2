<?php
/*
 * NakwebProductDetailMovie
 * Copyright (C) 2014 NAKWEB CO.,LTD. All Rights Reserved.
 * http://www.nakweb.com/
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

require_once "plg_NakwebProductDetailMovie_LC_Page_Admin_Products_Product.php";
require_once "plg_NakwebProductDetailMovie_LC_Page_Products_Detail.php";

/**
 * プラグインのメインクラス
 *
 * @package NakwebProductDetailMovie
 * @author NAKWEB CO.,LTD.
 * @version $1.0 Id: $ProductDetailMovie01
 */
class NakwebProductDetailMovie extends SC_Plugin_Base {

    // 静的定数(CONSTはPHP5.3以降)
    protected static $nakweb_plgin_individual = 'plg_nakweb_00005';    // nakweb プラグイン番号

    /**
     * コンストラクタ
     */
    public function __construct(array $arrSelfInfo) {
        parent::__construct($arrSelfInfo);
    }

    /**
     * インストール
     * installはプラグインのインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin plugin_infoを元にDBに登録されたプラグイン情報(dtb_plugin)
     * @return void
     */
    function install($arrPlugin) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->begin();

        // 必要なファイルをコピーします.
        // 管理画面用ファイル
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/config.php", PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] . "/config.php");
        //ロゴ
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/logo.png", PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] . "/logo.png");

        //テーブルの追加
        //データベースのタイプによって値を変える
        switch(DB_TYPE) {
            case 'pgsql':
                //データベース登録用の初期設定
                $setting = <<<EOS
SET client_encoding = 'UTF8'
EOS;
                $objQuery->query($setting);

                //テーブルを検索する
                $table_search_result = true;
                $table_search = $objQuery->listTables();
                foreach($table_search as $val) {
                    if($val == 'plg_nakweb_product_movie_include_moviedata') {
                        $table_search_result = false;
                    }
                }
                //存在しない時のみ作成
                if($table_search_result) {
                    //テーブル作成
                    $newtable = <<<EOS
CREATE TABLE plg_nakweb_product_movie_include_moviedata (
    data_id integer NOT NULL,
    product_id integer DEFAULT NULL,
    product_id_seq integer DEFAULT NULL,
    youtube_tag_base text,
    youtube_tag_remake text,
    src_data text,
    width integer DEFAULT NULL,
    height integer DeFAULT NULL,
    width_base integer DEFAULT NULL,
    height_base integer DEFAULT NULL,
    other_movie_flg integer DEFAULT NULL,
    loop_flg integer DEFAULT NULL,
    fullscreen_flg integer DEFAULT NULL,
    show_flg integer DEFAULT NULL,
    create_date timestamp without time zone NOT NULL,
    PRIMARY KEY (data_id),
    UNIQUE (product_id, product_id_seq)
)
EOS;
                    $objQuery->query($newtable);
                }

                //シーケンス一覧を取得、その中にこのプラグインのシーケンスが無い場合、新たにシーケンスを作成する。(以前にインストールして正規の削除方法にて削除されずにデータベースに項目が残っている場合を考慮)
                $sequences_search_result = true;
                $sequences_search = $objQuery->listSequences();
                foreach($sequences_search as $val) {
                    if($val == 'plg_nakweb_product_movie_include_moviedata_data_id') {
                        $sequences_search_result = false;
                    }
                }
                if($sequences_search_result) {
                    $newseq = <<<EOS
CREATE SEQUENCE plg_nakweb_product_movie_include_moviedata_data_id_seq MAXVALUE 9223372036854775807
EOS;
                        $objQuery->query($newseq);
                }
                break;

            case 'mysql':
                $newtable = <<<EOS
CREATE TABLE IF NOT EXISTS `plg_nakweb_product_movie_include_moviedata` (
    `data_id` int(11) NOT NULL,
    `product_id` int(11) DEFAULT NULL,
    `product_id_seq` int(11) DEFAULT NULL,
    `youtube_tag_base` text COLLATE utf8_bin,
    `youtube_tag_remake` text COLLATE utf8_bin,
    `src_data` text COLLATE utf8_bin,
    `width` int(11) DEFAULT NULL,
    `height` int(11) DeFAULT NULL,
    `width_base` int(11) DEFAULT NULL,
    `height_base` int(11) DEFAULT NULL,
    `other_movie_flg` smallint(6) DEFAULT NULL,
    `loop_flg` smallint(6) DEFAULT NULL,
    `fullscreen_flg` smallint(6) DEFAULT NULL,
    `show_flg` int(11) DEFAULT NULL,
    `create_date` timestamp NOT NULL,
    PRIMARY KEY (data_id),
    UNIQUE (product_id, product_id_seq)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
EOS;
        $objQuery->query($newtable);
                break;

            default:
                $newtable = null;
                break;
        }

        // プラグイン用データベース設定（plugin config）
        //各動画タグ登録のためのステータス設定
         $arrData  = array();
         $arrData['how_movie'] = 3;
         $arrData['other_movie_flg'] = 0;
         $arrData['loop_flg']  = 0;
         $arrData['fullscreen_flg'] = 0;
         $objQuery = SC_Query_Ex::getSingletonInstance();
         $sql_conf = array();
         $sql_conf['free_field1'] = serialize($arrData);
         $sql_conf['update_date'] = 'CURRENT_TIMESTAMP';
         $where = "plugin_code = ?";
         // UPDATEの実行
         $objQuery->update('dtb_plugin', $sql_conf, $where, array($arrPlugin['plugin_code']));
         $objQuery->commit();
    }

    /**
     * アンインストール
     * uninstallはアンインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function uninstall($arrPlugin) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->begin();

        // テーブル削除
        
        $table_search_result = false;
        $sequences_search_result = false;
        switch(DB_TYPE){
            case 'pgsql':
                //テーブル一覧を取得、その中にこのプラグインのテーブルが存在する場合、テーブルを削除する。
                $table_search = $objQuery->listTables();
                foreach($table_search as $val) {
                    if($val == 'plg_nakweb_product_movie_include_moviedata') {
                        $table_search_result = true;
                    }
                }
                if($table_search_result) {
                    $objQuery->query("DROP TABLE plg_nakweb_product_movie_include_moviedata");
                }

                //シーケンス一覧を取得、その中にこのプラグインのシーケンスが存在する場合、シーケンスを削除する。
                $sequences_search = $objQuery->listSequences();
                foreach($sequences_search as $val) {
                    if($val == 'plg_nakweb_product_movie_include_moviedata_data_id') {
                        $sequences_search_result = true;
                    }
                }
                if($sequences_search_result) {
                    $objQuery->query('DROP SEQUENCE plg_nakweb_product_movie_include_moviedata_data_id_seq');
                }

                break;
            case 'mysql':
                $objQuery->query("DROP TABLE IF EXISTS plg_nakweb_product_movie_include_moviedata");
                $objQuery->query("DROP TABLE IF EXISTS plg_nakweb_product_movie_include_moviedata_data_id_seq");
                break;
            default:
                break;
        }
        $objQuery->commit();
    }

    /**
     * 稼働
     * enableはプラグインを有効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function enable($arrPlugin) {
        // nop
    }

    /**
     * 停止
     * disableはプラグインを無効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function disable($arrPlugin) {
        // nop
    }

    // // スーパーフックポイント（preProcess）
    // function preProcess() {
    //     // nop
    // }

    // // スーパーフックポイント（prosess）
    // function prosess() {
    //     // nop
    // }

    /**
     * 処理の介入箇所とコールバック関数を設定
     * registerはプラグインインスタンス生成時に実行されます
     *
     * @param $objHelperPlugin
     * @param $priority
     */
    function register($objHelperPlugin, $priority) {
        parent::register($objHelperPlugin, $priority);
        ///youtubeタグ入力欄の追加、確認画面の変更、商品詳細画面の条件文追加 各テンプレートに介入
        $objHelperPlugin->addAction('prefilterTransform', array(&$this, 'prefilterTransform'), $this->arrSelfInfo['priority']);
    }


    //==========================================================================
    // Original Function
    //==========================================================================

    // テンプレートのフック（商品登録、商品登録確認画面i、 商品詳細画面(公開側)）
    function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename) {
        $objTransform = new SC_Helper_Transform($source);
        $template_dir = PLUGIN_UPLOAD_REALDIR . $this->arrSelfInfo['plugin_code'] . '/templates/';
        switch($objPage->arrPageLayout['device_type_id']){
            case DEVICE_TYPE_MOBILE:
            case DEVICE_TYPE_SMARTPHONE:
                break;
            case DEVICE_TYPE_PC:
                if (strpos($filename, 'products/detail.tpl') !== false) {
                    $objTransform->select('#undercolumn', 0)->insertBefore(file_get_contents($template_dir . 'plg_NakwebProductDetailMovie_detail.tpl'));
                }
                break;
            case DEVICE_TYPE_ADMIN:
            default:
                if (strpos($filename, 'products/product.tpl') !== false) {
                    $objTransform->select('.btn-area', 0)->insertBefore(file_get_contents($template_dir . 'plg_NakwebProductDetailMovie_product.tpl'));
                } elseif (strpos($filename, 'products/confirm.tpl') !== false) {
                    $objTransform->select('.btn-area', 0)->insertBefore(file_get_contents($template_dir . 'plg_NakwebProductDetailMovie_confirm.tpl'));
                }
                break;
        }
        $source = $objTransform->getHTML();
    }


    // 商品詳細情報登録画面での介入
    function plg_admin_products_action($objPage) {
        switch ($objPage->mode) {
            case 'json':
                // 処理を行わない
                break;
            default:
                // 商品登録に介入
                $objAdminProduct = new plg_NakwebProductDetailMovie_LC_Page_Admin_Products_Product();
                $objAdminProduct->init($plg_head);
                $objAdminProduct->process();
                break;
        }
    }

     // 商品詳細ページでの介入
     function plg_products_detail_action($objPage) {
         switch ($objPage->mode) {
             case 'json':
                 // 処理を行わない
                 break;
             default:
                 // 商品詳細表示に介入
                 $objProductDetail = new plg_NakwebProductDetailMovie_LC_Page_Products_Detail();
                 $objProductDetail->init($plg_head);
                 $objProductDetail->process();
                 break;
         }
     }

}
?>
