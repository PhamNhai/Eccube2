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

require_once CLASS_EX_REALDIR . 'page_extends/admin/products/LC_Page_Admin_Products_Product_Ex.php';

/**
 * プラグインのメインクラス
 *
 * @package NakwebProductDetailMovie
 * @author NAKWEB CO.,LTD.
 * @version $1.0 Id: $ProductDetailMovie01
 */
class plg_NakwebProductDetailMovie_LC_Page_Admin_Products_Product extends LC_Page_Admin_Products_Product_Ex {


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
     * Page のアクション.
     *
     * @return void
     */
    public function action()
    {
        //動画情報取得時のオプション読み込み
        $this->arrIncludeMovieStatus = $this->lfGetIncludeMovieStatus_FromDB();

        //元のaction()関数を呼び出す
        parent::action();

        $objFormParam = new SC_FormParam_Ex();
        $mode = $this->getMode();
        // アップロードファイル情報の初期化
        $objUpFile = new SC_UploadFile_Ex(IMAGE_TEMP_REALDIR, IMAGE_SAVE_REALDIR);
        $this->lfInitFile($objUpFile);
        $objUpFile->setHiddenFileList($_POST);

        // ダウンロード販売ファイル情報の初期化
        $objDownFile = new SC_UploadFile_Ex(DOWN_TEMP_REALDIR, DOWN_SAVE_REALDIR);
        $this->lfInitDownFile($objDownFile);
        $objDownFile->setHiddenFileList($_POST);
        switch($mode){
            case 'pre_edit':
            case 'copy' :
                // パラメーター初期化(商品ID取得のため)
                $this->lfInitFormParam_PreEdit($objFormParam, $_POST);
                // 編集中の商品ID取得
                $product_id = $objFormParam->getValue('product_id');
                //データベースから取得した値を配列に格納
                $arrMovieForm = $this->lfGetYoutubeProductsMovie_FromDB($product_id);
                //元の配列を先ほどの配列を結合させる
                $this->arrForm = array_merge($this->arrForm, $arrMovieForm);
                break;

            case 'edit' :
                //パラメータを初期化、YouTube(c)タグをフォームから取得
                $this->lfMovietagFormParam($objFormParam, $_POST);
                $arrMovieForm = $objFormParam->getHashArray();
                // エラーチェック
                $this->arrErrM = $this->lfCheckError_Movie($objFormParam, $arrMovieForm);
                $this->arrWidth_base = $this->lfExplodeWidth($arrMovieForm);
                $this->arrHeight_base = $this->lfExplodeHeight($arrMovieForm);
                $this->arrResult = $this->lfCheckYoutube_Tags_Edit($arrMovieForm);
                //元のエラーチェックとこのプラグイン内でのエラーチェックの値を反映させる
                if (count($this->arrErr) == 0 && count($this->arrErrM) == 0) {
                    //元の配列を先ほどの配列を結合させる
                    $this->arrForm = array_merge($this->arrForm, $arrMovieForm);
                } else {
                    // 確認画面表示設定
                    $this->tpl_mainpage = 'products/product.tpl';
                    //元の配列を先ほどの配列を結合させる
                    $arrForm = array_merge($this->arrForm, $arrMovieForm);
                    // 入力画面表示設定
                    $this->arrForm = $this->lfSetViewParam_InputPage($objUpFile, $objDownFile, $arrForm);
                    // ページonload時のJavaScript設定
                    $this->tpl_onload = $this->lfSetOnloadJavaScript_InputPage();
                }
                break;
            // 画像のアップロード
            case 'upload_image':
            case 'delete_image':
            // ダウンロード商品ファイルアップロード
            case 'upload_down':
            case 'delete_down':
            // 関連商品選択
            case 'recommend_select' :
            // 確認ページからの戻り
            case 'confirm_return':
                //パラメータを初期化、YouTube(c)タグをフォームから取得
                $this->lfMovietagFormParam($objFormParam, $_POST);
                $arrMovieForm = $objFormParam->getHashArray();
                //元の配列を先ほどの配列を結合させる
                $this->arrForm = array_merge($this->arrForm, $arrMovieForm);
                break;
            case 'complete':
                //パラメータを初期化、YouTube(c)タグをフォームから取得
                $this->lfMovietagFormParam($objFormParam, $_POST);
                $arrMovieForm = $this->lfGetFormParam_Complete($objFormParam);
                $this->arrWidth_base = $this->lfExplodeWidth($arrMovieForm);
                $this->arrHeight_base = $this->lfExplodeHeight($arrMovieForm);
                //入力された動画タグをチェックする。
                $this->lfRegistMovietag($arrMovieForm, $_POST['product_id']);
                break;
            default:
                //パラメータを初期化、YouTube(c)タグをフォームから取得
                $this->lfMovietagFormParam($objFormParam, $_POST);
                break;
        }
    }

    /**
     * DBからYouTube(c)タグ取得用データを取得する
     *
     * @return array   YouTube(c)タグ取得時のオプションデータ配列
     */
    public function lfGetIncludeMovieStatus_FromDB()
    {
        $plugin_data   = SC_Plugin_Util_Ex::getPluginByPluginCode($this->plugin_code);
        $arrRet = unserialize($plugin_data['free_field1']);
            $arrIncludeMovieStatus['how_movie'] = $arrRet['how_movie'];
            $arrIncludeMovieStatus['other_movie_flg'] = $arrRet['other_movie_flg'];
            $arrIncludeMovieStatus['loop_flg'] = $arrRet['loop_flg'];
            $arrIncludeMovieStatus['fullscreen_flg'] = $arrRet['fullscreen_flg'];
        return $arrIncludeMovieStatus;
    }

    /**
     * フォームからYouTube(c)タグデータ各種を取得する
     *
     * @param  object $objFormParam  SC_FormParamインスタンス
     * @param  array  $arrPost  送信されたフォームデータ
     * @return void
     */
    public function lfMovietagFormParam(&$objFormParam, $arrPost)
    {
        for($a = 1;$a <= $this->arrIncludeMovieStatus['how_movie'];$a++){
            $name_n = '動画tag';
            $name_n .= $a;
            $name_t = 'youtube_tag_base';
            $name_t .= $a;
            $objFormParam->addParam($name_n, $name_t, INT_LEN, 'n', array());
            $name_n = '横幅';
            $name_n .= $a;
            $name_t = 'width';
            $name_t .= $a;
            $objFormParam->addParam($name_n, $name_t, INT_LEN, 'n', array('SPTAB_CHECK', 'NUM_CHECK'));
            $name_n = '縦幅';
            $name_n .= $a;
            $name_t = 'height';
            $name_t .= $a;
            $objFormParam->addParam($name_n, $name_t, INT_LEN, 'n', array('SPTAB_CHECK', 'NUM_CHECK'));
            $name_n = '関連動画表示フラグ';
            $name_n .= $a;
            $name_t = 'other_movie_flg';
            $name_t .= $a;
            $objFormParam->addParam($name_n, $name_t, INT_LEN, 'n', array());
            $name_n = 'ループ再生フラグ';
            $name_n .= $a;
            $name_t = 'loop_flg';
            $name_t .= $a;
            $objFormParam->addParam($name_n, $name_t, INT_LEN, 'n', array());
            $name_n = '全体画面表示許可フラグ';
            $name_n .= $a;
            $name_t = 'fullscreen_flg';
            $name_t .= $a;
            $objFormParam->addParam($name_n, $name_t, INT_LEN, 'n', array());
            $name_n = '商品ID_SEQ';
            $name_n .= $a;
            $name_t = 'product_id_seq';
            $name_t .= $a;
            $objFormParam->addParam($name_n, $name_t, INT_LEN, 'n', array());
            $name_n = '元の横幅';
            $name_n .= $a;
            $name_t = 'width_base';
            $name_t .= $a;
            $objFormParam->addParam($name_n, $name_t, INT_LEN, 'n', array());
            $name_n = '元の縦幅';
            $name_n .= $a;
            $name_t = 'height_base';
            $name_t .= $a;
            $objFormParam->addParam($name_n, $name_t, INT_LEN, 'n', array());
            $name_n = '表示フラグ';
            $name_n .= $a;
            $name_t = 'show_flg';
            $name_t .= $a;
            $objFormParam->addParam($name_n, $name_t, INT_LEN, 'n', array());
        }
        $objFormParam->addParam('データID', 'data_id', INT_LEN, 'n', array());

        $objFormParam->setParam($arrPost);
        $objFormParam->convParam();
    }

    /**
     * DBから紐付けされたyoutube_tagを取得する
     *
     * @param  integer $product_id 商品ID
     * @return array   youtubeデータ配列
     */
    public function lfGetYoutubeProductsMovie_FromDB($product_id)
    {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrYoutubeProductsMovie = array();

        $col = 'youtube_tag_base,';
        $col.= 'width,';
        $col.= 'height,';
        $col.= "other_movie_flg,";
        $col.= "loop_flg,";
        $col.= "fullscreen_flg,";
        $col.= "data_id,";
        $col.= "show_flg,";
        $col.= "width_base,";
        $col.= "height_base,";
        $col.= 'product_id_seq';
        $table = 'plg_nakweb_product_movie_include_moviedata';
        $where = 'product_id = ?';
        $arrRet = $objQuery->select($col, $table, $where, array($product_id));

        $no = 1;
        foreach ($arrRet as $arrVal) {
            $arrYoutubeProductsMovie['youtube_tag_base' . $no] = $arrVal['youtube_tag_base'];
            $arrYoutubeProductsMovie['width' . $no] = $arrVal['width'];
            $arrYoutubeProductsMovie['height' . $no] = $arrVal['height'];
            $arrYoutubeProductsMovie['other_movie_flg' . $no] = $arrVal['other_movie_flg'];
            $arrYoutubeProductsMovie['loop_flg' . $no] = $arrVal['loop_flg'];
            $arrYoutubeProductsMovie['fullscreen_flg' . $no] = $arrVal['fullscreen_flg'];
            $arrYoutubeProductsMovie['show_flg' . $no] = $arrVal['show_flg'];
            $arrYoutubeProductsMovie['width_base' . $no] = $arrVal['width_base'];
            $arrYoutubeProductsMovie['height_base' . $no] = $arrVal['height_base'];
            $arrYoutubeProductsMovie['data_id'] = $arrVal['data_id'];
            $arrYoutubeProductsMovie['product_id_seq' . $no] = $arrVal['product_id_seq'];
            $no++;
        }
        return $arrYoutubeProductsMovie;
    }

     /**
     * 埋め込む動画タグを希望されたとおりに再編し、DBに登録する カスタマイズ追加
     *
     * @param  array   $arrList     フォーム入力パラメーター配列
     * @param  integer $product_id 登録商品ID
     * @return void
     */
    public function lfRegistMovietag($arrList, $product_id)
    {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objDb = new SC_Helper_DB_Ex();

        //登録されようとしている元のtagから希望されているtagに再編する。
        $arrSrc = array();
        $arrRemake_tag_com = array();
        for ($make = 1; $make <= $this->arrIncludeMovieStatus['how_movie']; $make++) { //設定された回数分tagを再編する。
            $base_tag = "";
            $base_tag = $arrList['youtube_tag_base'.$make];

            $check_width = "";
            if($arrList['width'.$make] != ""){
                $check_width = $arrList['width'.$make];
            } else {
                $check_width = $this->arrWidth_base[$make];
            }

            $check_height = "";
            if($arrList['height'.$make] != ""){
                $check_height = $arrList['height'.$make];
            } else {
                $check_height = $this->arrHeight_base[$make];
            }

            //入力された文字列がyoutubeの埋め込みタグかチェックする
            $remake = $this->lfCheckYoutube_Tag_Edit($base_tag, $check_width, $check_height);
            //チェックが通れば再編し、再編したタグを発行、チェックが通らなければNULLを発行
            if($remake == 'true'){
                $remake_tag = array();
                $remake_tag = explode(" ",$base_tag);
                $remake_src = "";
                foreach($remake_tag as $val){
                    if(strstr($val, 'src')){
                        //2015年4月1日現在、このプラグインを作成した時期に発行されていたyoutube埋め込みタグの形式が今と違うため、処理を分割。
                        if(strstr($val, 'https')) {
                            //今現在(2015年4月1日)の形式用処理
                            $remake_src_base = explode("\"", $val);
                            $remake_src = explode("https:", $remake_src_base[1]);
                        } else {
                            //旧環境のタグ用処理
                            $remake_src = explode("\"", $val);
                        }
                    }
                }
                if(strstr($remake_src[1], '?')) {
                    $remake_src_base = "";
                    $remake_src_base = explode("?",$remake_src[1]);
                    $remake_src = $remake_src_base[0];
                } else {
                    $remake_src = $remake_src[1];
                }
                $arrSrc['src_data'.$make] = $remake_src;
                if($arrList['width'.$make] != ""){
                    $remake_width = $arrList['width'.$make];
                } else {
                    $remake_width = $arrList['width_base'.$make];
                }
                if($arrList['height'.$make] != ""){
                    $remake_height = $arrList['height'.$make];
                } else {
                    $remake_height = $arrList['height_base'.$make];
                }

                $code = "";
                $code .= $remake_src;
                if($arrList['loop_flg'.$make] == 0) {
                    if(strstr($code, '?')) {
                        $code_ID = explode("/",$code);
                        $code = $code . "&loop=1&playlist=" . $code_ID[4];
                    } else {
                        $code_ID = explode("/",$code);
                        $code = $code . "?loop=1&playlist=" . $code_ID[4];
                    }
                }

                    if($arrList['other_movie_flg'.$make] == 1) {
                        if(strstr($code, 'rel')) {
                        } else if(strstr($code, '?')) {
                            $code = $code . "&rel=0";
                        } else {
                            $code = $code . "?rel=0";
                        }
                    }

                //埋め込みtagを再編する。
                $arrRemake_tag_com['tag'.$make] = "<iframe width=\"";
                $arrRemake_tag_com['tag'.$make] .= $remake_width;
                $arrRemake_tag_com['tag'.$make] .= "\" height=\"";
                $arrRemake_tag_com['tag'.$make] .= $remake_height;
                $arrRemake_tag_com['tag'.$make] .= "\" src=\"https:";
                $arrRemake_tag_com['tag'.$make] .= $code;
                if($arrList['fullscreen_flg'.$make] == 0) {
                    $arrRemake_tag_com['tag'.$make] .= "\"frameborder=\"0\" allowfullscreen></iframe>";
                } else {
                    $arrRemake_tag_com['tag'.$make] .= "\"frameborder=\"0\"></iframe>";
                }
            }
        }

        //登録される商品IDを取得
        //もし、$product_idがNULLだった場合(新規登録時)新規登録時の商品IDは一番大きい値になるので最大値を取得
        if($product_id == ""){
            $product_id = $objQuery->max('product_id', 'dtb_products');
        }
        $sqlval['product_id'] = $product_id;
        // 一旦関連商品を全て削除する
        $objQuery->delete('plg_nakweb_product_movie_include_moviedata', 'product_id = ?', array($product_id));
        // INSERTする値を作成する。
        for ($cnt = 1; $cnt <= $this->arrIncludeMovieStatus['how_movie']; $cnt++) { //設定された回数分DBに登録>     する。
            $sqlval['youtube_tag_base'] = $arrList['youtube_tag_base'.$cnt];
            $sqlval['src_data'] = $arrSrc['src_data'.$cnt];
            $sqlval['youtube_tag_remake'] = $arrRemake_tag_com['tag'.$cnt];
            $sqlval['width'] = $arrList['width'.$cnt];
            $sqlval['height'] = $arrList['height'.$cnt];
            $sqlval['other_movie_flg'] = $arrList['other_movie_flg'.$cnt];
            $sqlval['loop_flg'] = $arrList['loop_flg'.$cnt];
            $sqlval['fullscreen_flg'] = $arrList['fullscreen_flg'.$cnt];
            $sqlval['show_flg'] = $arrList['show_flg'.$cnt];
            $sqlval['width_base'] = $arrList['width_base'.$cnt];
            $sqlval['height_base'] = $arrList['height_base'.$cnt];
            $sqlval['product_id_seq'] = $cnt;
            $sqlval['create_date'] = "CURRENT_TIMESTAMP";
            $data_id = $objQuery->nextVal('plg_nakweb_product_movie_include_moviedata_data_id');
            $sqlval['data_id'] = $data_id;

            $objQuery->begin();

            $objQuery->insert('plg_nakweb_product_movie_include_moviedata', $sqlval);

            //シーケンスデータを一番最後のdata_idの次の値に更新する
            $data_id++;
            $objQuery->setVal('plg_nakweb_product_movie_include_moviedata_data_id', $data_id);
        }

        $objQuery->commit();
    }

     /**
     * 入力された動画データ確認用メソッド
     *
     * @param  text    $tag  フォーム入力タグデータ
     * @param  integer $width フォーム入力横幅データ(初期値はNULL)
     * @param  integer $height フォーム入力縦幅データ(初期値はNULL)
     * @return result  結果をtureかfalesで返す
     */
    public function lfCheckYoutube_Tag_Edit($tag, $width, $height)
    {
        $check_tag = "";
        $check_tag = $tag;

        $check_width = "";
        $check_width = $width;

        $check_height = "";
        $check_height = $height;

        //入力された文字列がyoutubeの埋め込みタグかチェックする
        $result = 'fales';
        if(strstr($check_tag, 'iframe')){
            if(strstr($check_tag, 'src')){
                if(strstr($check_tag, 'youtube')){
                    if(strstr($check_tag, 'embed')){
                        $result = 'true';
                    }
                }
            }
        }

        if(($result == 'true' && $check_width == "") || ($result == 'true' && $check_height == "")){
            $result = 'fales';
        }
        return $result;
    }

    /**
     * 入力された動画データ確認用メソッド カスタマイズ追加
     *
     * @param  array  $arrForm フォーム入力パラメーター配列
     * @return result  結果をtureかfalesで返す
     */
    public function lfCheckYoutube_Tags_Edit($arrForm)
    {
        $arrResult = array();
        for ($check = 1; $check <= $this->arrIncludeMovieStatus['how_movie']; $check++) { //設定された回数分tagの値をチェックする。
            $check_tags = "";
            $check_tags = $arrForm['youtube_tag_base'.$check];

            $check_width = "";
            if($arrForm['width'.$check] != "") {
                $check_width = $arrForm['width'.$check];
            } else {
                $check_width = $this->arrWidth_base[$check];
            }

            $check_height = "";
            if($arrForm['height'.$check] != "") {
                $check_height = $arrForm['height'.$check];
            } else {
                $check_height = $this->arrHeight_base[$check];
            }
            //入力された文字列がYouTube(c)の埋め込みタグかチェックする
            $arrResult[$check] = $this->lfCheckYoutube_Tag_Edit($check_tags, $check_width, $check_height);
        }
        return $arrResult;
    }

   /**
     * 元のタグデータを分割し、初期の動画サイズ(横幅)として出力するメソッド カスタマイズ追加
     *
     * @param  array  $arrForm      フォーム入力パラメーター配列
     * @return width  結果を配列で返す
     */
    public function lfExplodeWidth($arrForm)
    {
        for ($check = 1; $check <= $this->arrIncludeMovieStatus['how_movie']; $check++) { //設定された回数分tagを分割する。
            $width[$check] = "";
            $base_tag = "";
            $base_tag = $arrForm['youtube_tag_base'.$check];

            $base_tag_width = array();
            $base_tag_width = explode(" ",$base_tag);
            foreach($base_tag_width as $val) {
                if(strstr($val, 'width')){
                    $width_base = explode("\"",$val);
                    $width[$check] = $width_base[1];
                }
            }
        }
        return $width;
    }

    /**
     * 元のtagデータを分割し、初期の動画サイズ(縦幅)として出力するメソッド カスタマイズ追加
     *
     * @param  array  $arrForm      フォーム入力パラメーター配列
     * @return height  結果を配列で返す
     */
    public function lfExplodeHeight($arrForm)
    {
        for ($check = 1; $check <= $this->arrIncludeMovieStatus['how_movie']; $check++) { //設定された回数分tagを分割する。
            $height[$check] = "";
            $base_tag = "";
            $base_tag = $arrForm['youtube_tag_base'.$check];

            $base_tag_height = array();
            $base_tag_height = explode(" ",$base_tag);
            foreach($base_tag_height as $val) {
                if(strstr($val, 'height')){
                    $height_base = explode("\"",$val);
                    $height[$check] = $height_base[1];
                }
            }
        }
        return $height;
    }

    /**
     * フォーム入力パラメーターのエラーチェック
      *
      * @param  object $objFormParam SC_FormParamインスタンス
      * @param  array  $arrForm      フォーム入力パラメーター配列
      * @return array  エラー情報を格納した連想配列
      */
     public function lfCheckError_Movie(&$objFormParam, $arrForm)
    {
        $objErr = new SC_CheckError_Ex($arrForm);
        $arrErr = array();

        // 入力パラメーターチェック
        $arrErr = $objFormParam->checkError();

        $arrErr = array_merge((array) $arrErr, (array) $objErr->arrErr);
        return $arrErr;
    }

}
?>
