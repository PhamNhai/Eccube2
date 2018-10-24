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
            //document.forms['form1']['mode'].value = 'regist';
            document.form1.submit();
        }
        function fnFormRegistBack() {
            document.forms['form1']['mode'].value = 'back';
            document.form1.submit();
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
  <input type="hidden" name="mode" value="regist">
  <input type="hidden" name="recommend_banner_id" value="<!--{$arrForm.recommend_banner_id}-->">
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
      <th colspan="1">対象商品<span class="red">*</span></th>
      <td colspan="3">
        <input type="hidden" name="product_id" value="<!--{$arrForm.product_id|escape}-->" />
        商品ID：<!--{$arrForm.product_id|escape}--><br>
        商品名：<!--{$product_name}-->
      </td>
    </tr>
    <tr>
      <th colspan="4">①PC</th>
    </tr>
    <tr>
      <th colspan="4">　　購入確認ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrForm.file_img_pc}-->
          <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_pc}-->">
        <!--{else}-->
          未登録
        <!--{/if}-->
        <input type="hidden" name="file_img_pc" value="<!--{$arrForm.file_img_pc}-->">
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <input type="hidden" name="link_url_pc" value="<!--{$arrForm.link_url_pc|escape}-->" />
        <!--{if $arrForm.link_url_pc}-->
            <!--{$arrForm.link_url_pc|escape}-->
        <!--{else}-->
            未設定
        <!--{/if}-->
      </td>
    </tr>
    <tr>
      <th colspan="4">　　購入完了ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrForm.file_img_pc2}-->
          <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_pc2}-->">
        <!--{else}-->
          未登録
        <!--{/if}-->
        <input type="hidden" name="file_img_pc2" value="<!--{$arrForm.file_img_pc2}-->">
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <input type="hidden" name="link_url_pc2" value="<!--{$arrForm.link_url_pc2|escape}-->" />
        <!--{if $arrForm.link_url_pc2}-->
            <!--{$arrForm.link_url_pc2|escape}-->
        <!--{else}-->
            未設定
        <!--{/if}-->
      </td>
    </tr>
    <tr>
      <th colspan="4">②スマートフォン</th>
    </tr>
    <tr>
      <th colspan="4">　　購入確認ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrForm.file_img_sp}-->
          <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_sp}-->">
        <!--{else}-->
          未登録
        <!--{/if}-->
        <input type="hidden" name="file_img_sp" value="<!--{$arrForm.file_img_sp}-->">
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <input type="hidden" name="link_url_sp" value="<!--{$arrForm.link_url_sp|escape}-->" />
        <!--{if $arrForm.link_url_sp}-->
            <!--{$arrForm.link_url_sp|escape}-->
        <!--{else}-->
            未設定
        <!--{/if}-->
      </td>
    </tr>
    <tr>
      <th colspan="4">　　購入完了ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrForm.file_img_sp2}-->
          <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_sp2}-->">
        <!--{else}-->
          未登録
        <!--{/if}-->
        <input type="hidden" name="file_img_sp2" value="<!--{$arrForm.file_img_sp2}-->">
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <input type="hidden" name="link_url_sp2" value="<!--{$arrForm.link_url_sp2|escape}-->" />
        <!--{if $arrForm.link_url_sp2}-->
            <!--{$arrForm.link_url_sp2|escape}-->
        <!--{else}-->
            未設定
        <!--{/if}-->
      </td>
    </tr>
    <tr>
      <th colspan="4">③モバイル</th>
    </tr>
    <tr>
      <th colspan="4">　　購入確認ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrForm.file_img_mb}-->
          <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_mb}-->">
        <!--{else}-->
          未登録
        <!--{/if}-->
        <input type="hidden" name="file_img_mb" value="<!--{$arrForm.file_img_mb}-->">
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <input type="hidden" name="link_url_mb" value="<!--{$arrForm.link_url_mb|escape}-->" />
        <!--{if $arrForm.link_url_mb}-->
            <!--{$arrForm.link_url_mb|escape}-->
        <!--{else}-->
            未設定
        <!--{/if}-->
      </td>
    </tr>
    <tr>
      <th colspan="4">　　購入完了ページ</th>
    </tr>
    <tr>
      <th colspan="1">　　　　・バナー画像</th>
      <td colspan="3">
        <!--{if $arrForm.file_img_mb2}-->
          <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrForm.file_img_mb2}-->">
        <!--{else}-->
          未登録
        <!--{/if}-->
        <input type="hidden" name="file_img_mb2" value="<!--{$arrForm.file_img_mb2}-->">
      </td>
    </tr>
    <tr>
      <th colspan="1">　　　　・リンク先URL</th>
      <td colspan="3">
        <input type="hidden" name="link_url_mb2" value="<!--{$arrForm.link_url_mb2|escape}-->" />
        <!--{if $arrForm.link_url_mb2}-->
            <!--{$arrForm.link_url_mb2|escape}-->
        <!--{else}-->
            未設定
        <!--{/if}-->
      </td>
    </tr>
    <tr>
      <th colspan="1">表示箇所<span class="red">*</span></th>
      <td colspan="3">
        <input type="hidden" name="view_type" value="<!--{$arrForm.view_type|escape}-->" />
        <!--{if ($arrForm.view_type==1)}-->
            購入確認画面
        <!--{elseif ($arrForm.view_type==2)}-->
            購入完了画面
        <!--{else}-->
            購入確認画面/購入完了画面
        <!--{/if}-->
      </td>
    </tr>
    <tr>
      <th colspan="1">表示状態<span class="red">*</span></th>
      <td colspan="3">
        <input type="hidden" name="show_flg" value="<!--{$arrForm.show_flg|escape}-->" />
        <!--{if ($arrForm.show_flg==1)}-->
            公開
        <!--{else}-->
            未公開
        <!--{/if}-->
      </td>
    </tr>
    <tr>
      <th colspan="1">表示期間<span class="red">*</span></th>
      <td colspan="3">
          <input type="hidden" name="start_year" value="<!--{$arrForm.start_year}-->">
          <input type="hidden" name="start_month" value="<!--{$arrForm.start_month}-->">
          <input type="hidden" name="start_day" value="<!--{$arrForm.start_day}-->">
          <input type="hidden" name="end_year" value="<!--{$arrForm.end_year}-->">
          <input type="hidden" name="end_month" value="<!--{$arrForm.end_month}-->">
          <input type="hidden" name="end_day" value="<!--{$arrForm.end_day}-->">
          <!--{$arrForm.start_year}-->年<!--{$arrForm.start_month}-->月<!--{$arrForm.start_day}-->日～<!--{$arrForm.end_year}-->年<!--{$arrForm.end_month}-->月<!--{$arrForm.end_day}-->日
      </td>
    </tr>
  </table>
  <center><div class="btn-area">
    <ul>
        <li><a class="btn-action" href="<!--{$smarty.server.PHP_SELF|escape}-->" onclick="fnFormRegistBack(); return false;"><span class="btn-next">戻る</span></a></li>
        <li><a class="btn-action" href="<!--{$smarty.server.PHP_SELF|escape}-->" onclick="fnFormRegistConfirm(); return false;"><span class="btn-next">この内容で登録する</span></a></li>
    </ul>
  </div></center>
</form>
<!--★★メインコンテンツ★★-->

