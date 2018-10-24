<!--{*
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
*}-->

<!-- start NackwebProductDetailMovie -->
<table>
            <!--▼youtube埋め込みタグ-->
            <!--{section name=cnt loop=$arrIncludeMovieStatus.how_movie}-->
                <tr>
                    <th>埋め込むyoutubeタグ(<!--{$smarty.section.cnt.iteration}-->)<br />
                    </th>
                    <td>
                        <!--{assign var=count value="`$smarty.section.cnt.iteration`"}-->
                        ・
                        <!--{if $arrResult[$count] == 'true'}-->
                            <!--{assign var=key value="youtube_tag_base`$smarty.section.cnt.iteration`"}-->
                            youtubeコード：<!--{$arrForm[$key]|h|nl2br}--><br />
                        <!--{else if $arrResult[$count] == 'false'}-->
                            <!--{assign var=key value="youtube_tag_base`$smarty.section.cnt.iteration`"}-->
                            youtubeコード：<!--{$arrForm[$key]|h|nl2br}-->
                            <span class="attention">　※入力されたデータはタグとして登録できません</span><br />
                        <!--{/if}-->
                        <!--{assign var=wkey value="width`$smarty.section.cnt.iteration`"}-->
                        <!--{assign var=wbkey value="`$smarty.section.cnt.iteration`"}-->
                        <!--{assign var=hkey value="height`$smarty.section.cnt.iteration`"}-->
                        ・
                        <!--{if $arrForm[$wkey] != ""}-->
                            横幅：<!--{$arrForm[$wkey]}-->　
                        <!--{elseif $arrForm[$wkey] == "" &&$arrWidth_base[$wbkey] != ""}-->
                            横幅：<!--{$arrWidth_base[$wbkey]}-->(<span class="attention">元動画の初期値です</span>)　
                        <!--{elseif $arrForm[$wkey] == "" && $arrWidth_base[$wbkey] == ""}-->
                            横幅：<span class="attention">値が取得できませんでした</span>　
                        <!--{/if}-->
                        <!--{assign var=name value="width_base`$smarty.section.cnt.iteration`"}-->
                        <input type="hidden" name="<!--{$name}-->" value="<!--{$arrWidth_base[$wbkey]}-->" />
                        ・
                        <!--{if $arrForm[$hkey] != ""}-->
                            縦幅：<!--{$arrForm[$hkey]}--><br />
                        <!--{elseif $arrForm[$hkey] == "" &&$arrHeight_base[$wbkey] != ""}-->
                            縦幅：<!--{$arrHeight_base[$wbkey]}-->(<span class="attention">元動画の初期値です</span>)<br />
                        <!--{elseif $arrForm[$hkey] == "" && $arrHeight_base[$wbkey] == ""}-->
                            縦幅：<span class="attention">値が取得できませんでした</span><br />
                        <!--{/if}-->
                        <!--{assign var=name value="height_base`$smarty.section.cnt.iteration`"}-->
                        <input type="hidden" name="<!--{$name}-->" value="<!--{$arrHeight_base[$wbkey]}-->" />
                        <!--{assign var=okey value="other_movie_flg`$smarty.section.cnt.iteration`"}-->
                        <!--{assign var=lkey value="loop_flg`$smarty.section.cnt.iteration`"}-->
                        <!--{assign var=fkey value="fullscreen_flg`$smarty.section.cnt.iteration`"}-->
                        <!--{assign var=skey value="show_flg`$smarty.section.cnt.iteration`"}-->
                        <!--{if $arrForm[$okey] != "" || $arrForm[$lkey] != "" || $arrForm[$fkey] != ""}-->
                        ・
                        <!--{/if}-->
                        <!--{if $arrForm[$okey] != ""}-->
                            <!--{if $arrForm[$okey] == 0}-->
                                関連動画の表示：許可
                            <!--{else}-->
                                関連動画の表示：<span class="attention">不許可</span>
                            <!--{/if}-->　
                        <!--{/if}-->
                        <!--{if $arrForm[$lkey] != ""}-->
                            <!--{if $arrForm[$lkey] == 0}-->
                                ループ再生：許可
                            <!--{else}-->
                                ループ再生：<span class="attention">不許可</span>
                            <!--{/if}-->　
                        <!--{/if}-->
                        <!--{if $arrForm[$fkey] != ""}-->
                            <!--{if $arrForm[$fkey] == 0}-->
                                フルスクリーン再生の許可：許可
                            <!--{else}-->
                                フルスクリーン再生の許可：<span class="attention">不許可</span>
                            <!--{/if}-->
                        <!--{/if}-->
                        <br />・
                        <!--{if $arrForm[$skey] == 0}-->
                        動画を表示：する<br />
                        <!--{else}-->
                        動画を表示：<span class="attention">しない</span><br />
                        <!--{/if}-->
                        <!--{if $arrResult[$count] == 'true'}-->
                           ※ この動画のタグは&lt;!--&#123;$Nakweb_plg00005movie<!--{$smarty.section.cnt.iteration}-->&#125;--&gt;となります。<br />
                        <!--{/if}-->
                    </td>
                </tr>
            <!--{/section}-->
            <!--▲youtube埋め込みタグ-->
    </table>
<!-- end   NakwebProductDetailMovie -->

