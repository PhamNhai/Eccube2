<!--{*
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
*}-->
<script type="text/javascript">
<!--

        // 対象商品表示切替
        function displayCouponTarget() {
            var e = document.getElementsByName("coupon_target");
            var div = document.getElementById("coupon_target_limited");
            for(var i=0;i<e.length;i++) {
                if (e[i].checked)
                    switch(e[i].value) {
                        case '0': div.style.display = "none"; break;
                        case '1': div.style.display = "block";  break;
                    }
            }
        }

        function fnFormRegistConfirm() {
            document.forms['form1']['mode'].value = 'confirm';
            document.form1.submit();
        }
        
        function deleteImg(type){
            if(type==1){
                var div = document.getElementById("file_img_pc_area");
                document.forms["form1"]["file_img_pc"].value = "";
            }else if(type==2){
                var div = document.getElementById("file_img_sp_area");
                document.forms["form1"]["file_img_sp"].value = "";
            }else if(type==3){
                var div = document.getElementById("file_img_mb_area");
                document.forms["form1"]["file_img_mb"].value = "";
            }else if(type==4){
                var div = document.getElementById("file_img_pc2_area");
                document.forms["form1"]["file_img_pc2"].value = "";
            }else if(type==5){
                var div = document.getElementById("file_img_sp2_area");
                document.forms["form1"]["file_img_sp2"].value = "";
            }else if(type==6){
                var div = document.getElementById("file_img_mb2_area");
                document.forms["form1"]["file_img_mb2"].value = "";
            }
            div.style.display="none";
        }

	// onload登録
        function fnFormInit() {
	    if (window.addEventListener) { //for W3C DOM
	        window.addEventListener("load", onChangeDiscountType, false);
	        window.addEventListener("load", displayCouponTarget, false);
	    } else if (window.attachEvent) { //for IE
	        window.attachEvent("onload", onChangeDiscountType);
	        window.attachEvent("onload", displayCouponTarget);
	    }
        }
//-->
</script>

<!--★★メインコンテンツ★★-->
<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data">
  <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
  <input type="hidden" name="mode" value="<!--{$mode}-->">
  <input type="hidden" name="recommend_banner_id" value="<!--{$arrForm.recommend_banner_id}-->">
  <input type="hidden" name="image_key" value="" />
  <table class="form">
    <!--{if $arrForm.recommend_banner_id}-->
    <tr>
      <th colspan="1">No.<span class="red">*</span></th>
      <td colspan="3">
        <!--{$arrForm.recommend_banner_id}-->
      </td>
    </tr>
    <!--{/if}-->
    <tr>
      <th colspan="1">対象商品<span class="red">*</span><br>※選択した商品がカートに追加されると、登録したバナーが該当箇所にて表示されます。</th>
      <td colspan="3">
        <!--{if $arrErr.product_id}--><span class="red"><!--{$arrErr.product_id}--></span><!--{/if}-->
        <a class="btn-normal" href="javascript:;" name="add_product" onclick="win03('<!--{$smarty.const.ROOT_URLPATH}--><!--{$smarty.const.ADMIN_DIR}-->contents/plg_Recommend_recommend_product.php', 'search', '615', '500'); return false;">商品の選択</a>
        <!--<input type="text" name="product_id" size="65" class="box65" <!--{if $arrErr.product_id}--><!--{sfSetErrorStyle}--><!--{/if}--> value="<!--{$arrForm.product_id|escape}-->" />-->
        <input type="hidden" name="product_id" value="<!--{$arrForm.product_id}-->" id="product_id">
        <input type="hidden" name="product_class_id" value="" id="product_class_id">
        <div id="product_name">
            <!--{if $arrForm.product_id}-->
                商品ID:<!--{$arrForm.product_id}--><br>
                商品名:<!--{$product_name}--><br>
            <!--{/if}-->
        </div>
      </td>
    </tr>
  </table>
  
  <table class="form">
    <tr>
      <th colspan="4">①PC (任意)</th>
    </tr>
    <tr>
      <th colspan="4">　　購入確認ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrErr.file_img_pc}-->
            <span class="attention"><!--{$arrErr.file_img_pc}--></span>
        <!--{/if}-->
        <!--{if $arrForm.file_img_pc != ""}-->
            <div id="file_img_pc_area">
                <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_pc|h}-->"><br /><br />
                <a href="#" onClick="deleteImg(1);return false;">[画像削除]</a><br>
            </div>
            <input type="hidden" name="file_img_pc" id="file_img_pc" value="<!--{$arrForm.file_img_pc|h}-->" />
        <!--{/if}-->
        <input type="file" name="file_img_pc[]" size="10" style="<!--{$arrErr.file_img_pc|sfGetErrorColor}-->" /><br />
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <!--{if $arrErr.link_url_pc}--><span class="red12"><!--{$arrErr.link_url_pc}--></span><br><!--{/if}-->
        <input type="text" name="link_url_pc" size="200" class="box65" <!--{if $arrErr.link_url_pc}--><!--{sfSetErrorStyle}--><!--{/if}--> value="<!--{$arrForm.link_url_pc|escape}-->" />
      </td>
    </tr>
    
    <tr>
      <th colspan="4">　　購入完了ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrErr.file_img_pc2}-->
            <span class="attention"><!--{$arrErr.file_img_pc2}--></span>
        <!--{/if}-->
        <!--{if $arrForm.file_img_pc2 != ""}-->
            <div id="file_img_pc2_area">
                <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_pc2|h}-->"><br /><br />
                <a href="#" onClick="deleteImg(4);return false;">[画像削除]</a><br>
            </div>
            <input type="hidden" name="file_img_pc2" id="file_img_pc2" value="<!--{$arrForm.file_img_pc2|h}-->" />
        <!--{/if}-->
        <input type="file" name="file_img_pc2[]" size="10" style="<!--{$arrErr.file_img_pc2|sfGetErrorColor}-->" /><br />
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <!--{if $arrErr.link_url_pc2}--><span class="red12"><!--{$arrErr.link_url_pc2}--></span><br><!--{/if}-->
        <input type="text" name="link_url_pc2" size="200" class="box65" <!--{if $arrErr.link_url_pc2}--><!--{sfSetErrorStyle}--><!--{/if}--> value="<!--{$arrForm.link_url_pc2|escape}-->" />
      </td>
    </tr>
  </table>
  <table class="form">
    <tr>
      <th colspan="4">②スマートフォン (任意)</th>
    </tr>
    <tr>
      <th colspan="4">　　購入確認ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrErr.file_img_sp}-->
            <span class="attention"><!--{$arrErr.file_img_sp}--></span>
        <!--{/if}-->
        <!--{if $arrForm.file_img_sp != ""}-->
            <div id="file_img_sp_area">
                <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_sp|h}-->"><br /><br />
                <a href="#" onClick="deleteImg(2);return false;">[画像削除]</a><br>
            </div>
            <input type="hidden" name="file_img_sp" id="file_img_sp" value="<!--{$arrForm.file_img_sp|h}-->" />
        <!--{/if}-->
        <input type="file" name="file_img_sp[]" size="10" style="<!--{$arrErr.file_img_sp|sfGetErrorColor}-->" /><br />
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <!--{if $arrErr.link_url_sp}--><span class="red12"><!--{$arrErr.link_url_sp}--></span><br><!--{/if}-->
        <input type="text" name="link_url_sp" size="200" class="box65" <!--{if $arrErr.link_url_sp}--><!--{sfSetErrorStyle}--><!--{/if}--> value="<!--{$arrForm.link_url_sp|escape}-->" />
      </td>
    </tr>
    <tr>
      <th colspan="4">　　購入完了ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrErr.file_img_sp2}-->
            <span class="attention"><!--{$arrErr.file_img_sp2}--></span>
        <!--{/if}-->
        <!--{if $arrForm.file_img_sp2 != ""}-->
            <div id="file_img_sp2_area">
                <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_sp2|h}-->"><br /><br />
                <a href="#" onClick="deleteImg(5);return false;">[画像削除]</a><br>
            </div>
            <input type="hidden" name="file_img_sp2" id="file_img_sp2" value="<!--{$arrForm.file_img_sp2|h}-->" />
        <!--{/if}-->
        <input type="file" name="file_img_sp2[]" size="10" style="<!--{$arrErr.file_img_sp2|sfGetErrorColor}-->" /><br />
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <!--{if $arrErr.link_url_sp2}--><span class="red12"><!--{$arrErr.link_url_sp2}--></span><br><!--{/if}-->
        <input type="text" name="link_url_sp2" size="200" class="box65" <!--{if $arrErr.link_url_sp2}--><!--{sfSetErrorStyle}--><!--{/if}--> value="<!--{$arrForm.link_url_sp2|escape}-->" />
      </td>
    </tr>
  </table>
  <table class="form">
    <tr>
      <th colspan="4">③モバイル</th>
    </tr>
    <tr>
      <th colspan="4">　　購入確認ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrErr.file_img_mb}-->
            <span class="attention"><!--{$arrErr.file_img_mb}--></span>
        <!--{/if}-->
        <!--{if $arrForm.file_img_mb != ""}-->
            <div id="file_img_mb_area">
                <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_mb|h}-->"><br /><br />
                <a href="#" onClick="deleteImg(3);return false;">[画像削除]</a><br>
            </div>
            <input type="hidden" name="file_img_mb" id="file_img_mb" value="<!--{$arrForm.file_img_mb|h}-->" />
        <!--{/if}-->
        <input type="file" name="file_img_mb[]" size="10" style="<!--{$arrErr.file_img_mb|sfGetErrorColor}-->" /><br />
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <!--{if $arrErr.link_url_mb}--><span class="red12"><!--{$arrErr.link_url_mb}--></span><br><!--{/if}-->
        <input type="text" name="link_url_mb" size="200" class="box65" <!--{if $arrErr.link_url_mb}--><!--{sfSetErrorStyle}--><!--{/if}--> value="<!--{$arrForm.link_url_mb|escape}-->" />
      </td>
    </tr>
    <tr>
      <th colspan="4">　　購入完了ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrErr.file_img_mb2}-->
            <span class="attention"><!--{$arrErr.file_img_mb2}--></span>
        <!--{/if}-->
        <!--{if $arrForm.file_img_mb2 != ""}-->
            <div id="file_img_mb2_area">
                <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_mb2|h}-->"><br /><br />
                <a href="#" onClick="deleteImg(6);return false;">[画像削除]</a><br>
            </div>
            <input type="hidden" name="file_img_mb2" id="file_img_mb2" value="<!--{$arrForm.file_img_mb2|h}-->" />
        <!--{/if}-->
        <input type="file" name="file_img_mb2[]" size="10" style="<!--{$arrErr.file_img_mb2|sfGetErrorColor}-->" /><br />
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <!--{if $arrErr.link_url_mb2}--><span class="red12"><!--{$arrErr.link_url_mb2}--></span><br><!--{/if}-->
        <input type="text" name="link_url_mb2" size="200" class="box65" <!--{if $arrErr.link_url_mb2}--><!--{sfSetErrorStyle}--><!--{/if}--> value="<!--{$arrForm.link_url_mb|escape}-->" />
      </td>
    </tr>
  </table>
  <table>
    <tr>
      <th colspan="1">表示箇所<span class="red">*</span></th>
      <td colspan="3">
        <!--{if $arrErr.view_type}--><span class="red"><!--{$arrErr.view_type}--></span><!--{/if}-->
        <input type="radio" name="view_type" value="0" id="view_type0" <!--{if ($arrForm.view_type!=1&&$arrForm.view_type!=2)}-->checked<!--{/if}--> ><label for="view_type0">両方</label>
        <input type="radio" name="view_type" value="1" id="view_type1" <!--{if ($arrForm.view_type==1)}-->checked<!--{/if}-->><label for="view_type1">購入確認ページ</label>
        <input type="radio" name="view_type" value="2" id="view_type2" <!--{if ($arrForm.view_type==2)}-->checked<!--{/if}-->><label for="view_type2">購入完了ページ</label>
      </td>
    </tr>
    <tr>
      <th colspan="1">表示状態<span class="red">*</span></th>
      <td colspan="3">
        <!--{if $arrErr.show_flg}--><span class="red"><!--{$arrErr.show_flg}--></span><!--{/if}-->
        <input type="radio" name="show_flg" value="0" id="show_flg0" <!--{if ($arrForm.show_flg!=1)}-->checked<!--{/if}-->><label for="show_flg0">非公開</label>
        <input type="radio" name="show_flg" value="1" id="show_flg1" <!--{if ($arrForm.show_flg==1)}-->checked<!--{/if}-->><label for="show_flg1">公開</label>
      </td>
    </tr>
    <tr>
      <th colspan="1">表示期間<span class="red">*</span></th>
      <td colspan="3">
        <span class="red"><!--{$arrErr.start_year}--><!--{$arrErr.start_month}--><!--{$arrErr.start_day}--></span>
        <span class="red"><!--{$arrErr.end_year}--><!--{$arrErr.end_month}--><!--{$arrErr.end_day}--></span>
        <select name="start_year" <!--{if $arrErr.start_year or $arrErr.start_month or $arrErr.start_day}-->style="background-color:<!--{$smarty.const.ERR_COLOR|escape}-->"<!--{/if}-->>
          <option value="" selected>----</option>
          <!--{html_options options=$arrYear selected=$start_selected_year}-->
        </select>年
        <select name="start_month" <!--{if $arrErr.start_year or $arrErr.start_month or $arrErr.start_day}-->style="background-color:<!--{$smarty.const.ERR_COLOR|escape}-->"<!--{/if}-->>
          <option value="" selected>--</option>
          <!--{html_options options=$arrMonth selected=$start_selected_month}-->
        </select>月
        <select name="start_day" <!--{if $arrErr.start_year or $arrErr.start_month or $arrErr.start_day}-->style="background-color:<!--{$smarty.const.ERR_COLOR|escape}-->"<!--{/if}-->>
          <option value="" selected>--</option>
          <!--{html_options options=$arrDay selected=$start_selected_day}-->
        </select>日
        &nbsp;～&nbsp;
        <select name="end_year" <!--{if $arrErr.end_year or $arrErr.end_month or $arrErr.end_day}-->style="background-color:<!--{$smarty.const.ERR_COLOR|escape}-->"<!--{/if}-->>
          <option value="" selected>----</option>
          <!--{html_options options=$arrYear selected=$end_selected_year}-->
        </select>年
        <select name="end_month" <!--{if $arrErr.end_year or $arrErr.end_month or $arrErr.end_day}-->style="background-color:<!--{$smarty.const.ERR_COLOR|escape}-->"<!--{/if}-->>
          <option value="" selected>--</option>
          <!--{html_options options=$arrMonth selected=$end_selected_month}-->
        </select>月
        <select name="end_day" <!--{if $arrErr.end_year or $arrErr.end_month or $arrErr.end_day}-->style="background-color:<!--{$smarty.const.ERR_COLOR|escape}-->"<!--{/if}-->>
          <option value="" selected>--</option>
          <!--{html_options options=$arrDay selected=$end_selected_day}-->
        </select>日
      </td>
    </tr>
  </table>
  <center><div class="btn-area">
    <ul><li><a class="btn-action" href="<!--{$smarty.server.PHP_SELF|escape}-->" onclick="fnFormRegistConfirm(); return false;"><span class="btn-next">この内容で登録する</span></a></li></ul>
  </div></center>
</form>
<!--★★メインコンテンツ★★-->

