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

/**
 * プラグイン のアップデート用クラス.
 *
 * @package NakwebProductDetailMovie
 * @author NAKWEB CO.,LTD.
 * @version $Id: $
 */
class plugin_update{
   /**
     * アップデート
     * updateはアップデート時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function update($arrPlugin) {
        switch($arrPlugin['plugin_version']){
        // バージョン1.0からのアップデート
        case("1.0"):
        case("1.01"):
            plugin_update::updatever($arrPlugin);
            plugin_update::insertFookPoint($arrPlugin);
           break;
        default:
           break;
        }
    }

    /**
     * 1.0のアップデートを実行します.
     * @param type $param 
     */
    function updatever($arrPlugin) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->begin();

        // 変更のあったファイルを上書きします.
        //// プログラムファイル
        copy(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR . "/plg_NakwebProductDetailMovie_LC_Page_Admin_Products_Product.php", PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/plg_NakwebProductDetailMovie_LC_Page_Admin_Products_Product.php");
        copy(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR . "/NakwebProductDetailMovie.php", PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/NakwebProductDetailMovie.php");

        switch(DB_TYPE){
            case 'pgsql':
                //シーケンステーブルの処理
                $data_id_val = $objQuery->get('MAX(data_id)', 'plg_nakweb_product_movie_include_moviedata');
                if($data_id_val == ""){
                    $data_id_val = 0;
                }
                $data_id_val++;

                //まずはシーケンス一覧を取得し、このプラグインのシーケンスが存在するのか確認をする。
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
            default:
                break;
        }

        // dtb_pluginを更新します.
        plugin_update::updateDtbPluginData($arrPlugin, $plugin_data);

        $objQuery->commit();

    }

    /**
     * dtb_pluginを更新します.
     * 各バージョンに対するアップデートです
     *
     * @param int $arrPlugin プラグイン情報
     * @return void
     */
    function updateDtbPluginData($arrPlugin, $plugin_data = '') {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->begin();

        $sqlval = array();
        $table = "dtb_plugin";
        if (strlen($plugin_data) > 0) {
            // データが存在している場合は更新する（シリアライズ化を事前に行なっておくこと）
            $sql_conf['free_field1']    = $plugin_data;
        }
        $sql_conf['plugin_name']        = '動画埋め込みプラグイン ProductMovies!';
        $sql_conf['plugin_description'] = '商品詳細ページにYouTube(c)のストリーミング動画を埋め込みます。';
        $sql_conf['plugin_version']     = '1.1.1';
        $sql_conf['compliant_version']  = '2.12.2 ～ 2.13.5';
        $sql_conf['update_date']        = 'CURRENT_TIMESTAMP';
        $where = "plugin_id = ?";
        $objQuery->update($table, $sql_conf, $where, array($arrPlugin['plugin_id']));

        $objQuery->commit();
    }

    /**
     * バージョン1.0では登録されていなかったフックポイントを登録する。
     * 
     * @param int $arrPlugin プラグイン情報
     * @return void
     */
    function insertFookPoint($arrPlugin) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        // フックポイントをDB登録.
        $hook_point = array(
            array("LC_Page_Admin_Products_Product_action_before", 'plg_admin_products_action'),
            array("LC_Page_Products_Detail_action_before", 'plg_products_detail_action')
        );
        /**
         * FIXME コードが重複しているため、要修正
         */
        // フックポイントが配列で定義されている場合
        if (is_array($hook_point)) {
            foreach ($hook_point as $h) {
                $arr_sqlval_plugin_hookpoint = array();
                $id = $objQuery->nextVal('dtb_plugin_hookpoint_plugin_hookpoint_id');
                $arr_sqlval_plugin_hookpoint['plugin_hookpoint_id'] = $id;
                $arr_sqlval_plugin_hookpoint['plugin_id'] = $arrPlugin['plugin_id'];
                $arr_sqlval_plugin_hookpoint['hook_point'] = $h[0];
                $arr_sqlval_plugin_hookpoint['callback'] = $h[1];
                $arr_sqlval_plugin_hookpoint['update_date'] = 'CURRENT_TIMESTAMP';
                $objQuery->insert('dtb_plugin_hookpoint', $arr_sqlval_plugin_hookpoint);
            }
        // 文字列定義の場合
        } else {
            $array_hook_point = explode(',', $hook_point);
            foreach ($array_hook_point as $h) {
                $arr_sqlval_plugin_hookpoint = array();
                $id = $objQuery->nextVal('dtb_plugin_hookpoint_plugin_hookpoint_id');
                $arr_sqlval_plugin_hookpoint['plugin_hookpoint_id'] = $id;
                $arr_sqlval_plugin_hookpoint['plugin_id'] = $arrPlugin['plugin_id'];
                $arr_sqlval_plugin_hookpoint['hook_point'] = $h;
                $arr_sqlval_plugin_hookpoint['update_date'] = 'CURRENT_TIMESTAMP';
                $objQuery->insert('dtb_plugin_hookpoint', $arr_sqlval_plugin_hookpoint);
            }
        }
        
        $objQuery->commit();
    }

}
?>
