<?php
/**
 * プラグイン のアップデート用クラス.
 *
 * @package Coupon
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
        $newVer = 1.1;

        switch ($arrPlugin['plugin_version']) {
           // バージョン1.0からのアップデート
           case "1.0":
               plugin_update::update_1_1($arrPlugin);
               $update_ver = $newVer;
               break;
           default:
               $update_ver = 1.0;
               break;
        }
        
        // dtb_pluginを更新します.
        plugin_update::updateDtbPluginVersion($arrPlugin['plugin_id'], $update_ver);
    }

    /**
     * 1.1へのアップデートを実行します.
     * @param type $param
     */
    function update_1_1($arrPlugin) {
        $plugin_id = $arrPlugin['plugin_id'];

        // 変更のあったファイルを上書きします.
        $arrChangeFiles[] = 'config.php';
        $arrChangeFiles[] = 'data/class/pages/admin/contents/plg_Recommend_LC_Page_Admin_Contents_Recommend.php';
        $arrChangeFiles[] = 'data/class/pages/admin/contents/plg_Recommend_LC_Page_Admin_Contents_Recommend_Input.php';
        foreach ($arrChangeFiles AS $file) {
            copy(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR . $file, PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/' . $file);
        }
        
        //テンプレート部分の更新
        copy(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR . "template/admin/contents/plg_Recommend_recommend.tpl", SMARTY_TEMPLATES_REALDIR . 'admin/contents/plg_Recommend_recommend.tpl');
    }

    /**
     * dtb_pluginを更新します.
     *
     * @param int $plugin_id プラグインID
     * @return void
     */
    function updateDtbPluginVersion ($plugin_id, $plugin_version) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $sqlval = array();
        $table = "dtb_plugin";
        $sqlval['plugin_version'] = $plugin_version;
        $sqlval['update_date'] = 'CURRENT_TIMESTAMP';
        $where = "plugin_id = ?";
        $objQuery->update($table, $sqlval, $where, array($plugin_id));
    }
}
