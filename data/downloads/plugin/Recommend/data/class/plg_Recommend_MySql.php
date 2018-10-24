<?php

/**
 * レコメンドプラグインの のMySQLクラス.
 *
 */
class plg_Recommend_MySql{
    
    function plg_Recommend_MySql(){
    
    }
    
    
    /**
     * dtb_plg_recommend_bannerテーブルの作成
     */
    function create_dtb_plg_recommend_banner(){
     
     $sql = "
    CREATE TABLE IF NOT EXISTS dtb_plg_recommend_banner
(
  `recommend_banner_id` integer NOT NULL,
  `product_id` integer NOT NULL,
  `view_type` integer default 0,
  `file_img_pc` text,
  `file_img_sp` text,
  `file_img_mb` text,
  `file_img_pc2` text,
  `file_img_sp2` text,
  `file_img_mb2` text,
  `link_url_pc` text,
  `link_url_sp` text,
  `link_url_mb` text,
  `link_url_pc2` text,
  `link_url_sp2` text,
  `link_url_mb2` text,
  `show_flg` integer default 0,
  `create_date` timestamp NOT NULL DEFAULT now(),
  `update_date` timestamp,
  `start_time` timestamp,
  `end_time` timestamp,
  `click_count_cart` integer DEFAULT 0,
  `click_count_thanks` integer DEFAULT 0,
  `del_flg` integer DEFAULT 0,
  CONSTRAINT dtb_plg_recommend_banner_pkey PRIMARY KEY (recommend_banner_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
";
        return $sql;
    }
    
    
    /**
     *   レコメンドプラグインを削除する際に関連テーブルの削除を行う
     **/
     function deleteTable(){
         $sql = "DROP TABLE IF EXISTS 
dtb_plg_recommend_banner,
dtb_plg_recommend_banner_recommend_banner_id_seq";
        return $sql;
    }
    
}