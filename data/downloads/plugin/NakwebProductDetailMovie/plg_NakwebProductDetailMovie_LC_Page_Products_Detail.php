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

require_once CLASS_EX_REALDIR . 'page_extends/products/LC_Page_Products_Detail_Ex.php';

/**
 * プラグインのメインクラス
 *
 * @package NakwebProductDetailMovie
 * @author NAKWEB CO.,LTD.
 * @version $1.0 Id: $ProductDetailMovie01
 */
class plg_NakwebProductDetailMovie_LC_Page_Products_Detail extends LC_Page_Products_Detail_Ex {


    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        // プラグイン情報の取得（フォルダ名からプラグインコードを取得する）
        $this->plugin_code  = basename(dirname(__FILE__));
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process() {
        parent::process();
        exit();

    }

    /**
     * Page のAction.
     *
     * @return void
     */
    public function action()
    {
        //元のactuin()関数を実行する
        parent::action();

        // プロダクトIDの正当性チェック
        $product_id = $this->lfCheckProductId($this->objFormParam->getValue('admin'), $this->objFormParam->getValue('product_id'));
        //紐付けされたyoutube_tagデータを取得 カスタマイズ追加
        $this->arrYoutube = $this->lfGetYoutubeProductsMovie_FromDB($product_id);
    }

    /* プロダクトIDの正当性チェック
     * @param  object $admin_mode  管理用モードかどうかの判定
     * @param  object $product_id  選択された商品ID
     * @return object $product_id  選択された商品ID
     */
    public function lfCheckProductId($admin_mode, $product_id)
    {
        // 管理機能からの確認の場合は、非公開の商品も表示する。
        if (isset($admin_mode) && $admin_mode == 'on') {
            SC_Utils_Ex::sfIsSuccess(new SC_Session_Ex());
            $status = true;
            $where = 'del_flg = 0';
        } else {
            $status = false;
            $where = 'del_flg = 0 AND status = 1';
        }

        if (!SC_Utils_Ex::sfIsInt($product_id)
            || SC_Utils_Ex::sfIsZeroFilling($product_id)
            || !SC_Helper_DB_Ex::sfIsRecord('dtb_products', 'product_id', (array) $product_id, $where)
        ) {
                SC_Utils_Ex::sfDispSiteError(PRODUCT_NOT_FOUND);
        }

        return $product_id;
    }

    /**
     * DBから紐付けされたyoutube_tagを取得する カスタマイズ追加
     *
     * @param  integer $product_id 商品ID
     * @return array   youtubeデータ配列
     */
    public function lfGetYoutubeProductsMovie_FromDB($product_id)
    {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrYoutubeProductsMovie = array();

        $col = 'youtube_tag_remake,';
        $col .= 'show_flg';
        $table = 'plg_nakweb_product_movie_include_moviedata';
        $where = 'product_id = ?';
        $arrRet = $objQuery->select($col, $table, $where, array($product_id));

        $no = 1;
        foreach ($arrRet as $arrVal) {
            $arrYoutubeProductsMovie['youtube_tag_remake' . $no] = $arrVal['youtube_tag_remake'];
            $arrYoutubeProductsMovie['show_flg' . $no] = $arrVal['show_flg'];
            $no++;
        }
        return $arrYoutubeProductsMovie;
    }

}
?>
