<?php

/**
 * レコメンドプラグインの のSQLクラス(Postgres用).
 *
 */
class plg_Recommend_Postgres{
    
    function plg_Recommend_Postgres(){
    
    }
    
    
    /**
     * dtb_plg_recommend_bannerテーブルの作成
     */
    function create_dtb_plg_recommend_banner(){
     
     $sql = "
    CREATE TABLE  dtb_plg_recommend_banner
(
  recommend_banner_id integer NOT NULL,
  product_id integer NOT NULL,
  view_type integer default 0,
  file_img_pc text,
  file_img_sp text,
  file_img_mb text,
  file_img_pc2 text,
  file_img_sp2 text,
  file_img_mb2 text,
  link_url_pc text,
  link_url_sp text,
  link_url_mb text,
  link_url_pc2 text,
  link_url_sp2 text,
  link_url_mb2 text,
  show_flg integer default 0,
  create_date timestamp NOT NULL DEFAULT now(),
  update_date timestamp,
  start_time timestamp,
  end_time timestamp,
  click_count_cart integer default 0,
  click_count_thanks integer default 0,
  del_flg integer default 0,
  CONSTRAINT dtb_plg_recommend_banner_pkey PRIMARY KEY (recommend_banner_id)
) 
";
        return $sql;
    }

    
    
    /**
     *   レコメンドプラグインを削除する際に関連テーブルの削除を行う
     **/
     function deleteTable(){
         $sql = "DROP TABLE dtb_plg_recommend_banner";
         return $sql;
    }
    
     /**
         inexを追加する(POSTGRES限定処理）
     */
     function addIndex(&$objQuery){

         $sql = "CREATE sequence dtb_plg_recommend_banner_recommend_banner_id_seq";
         $objQuery->query($sql);

         $sql = "CREATE INDEX dtb_plg_recommend_banner_recommend_banner_id_key ON dtb_plg_recommend_banner (product_id)";
         $objQuery->query($sql);
         
     }
     
     
     //シーケンステーブルを削除(postgres限定処理)
     function deleteSeq(){
         $sql = "drop sequence dtb_plg_recommend_banner_recommend_banner_id_seq";
         return $sql;
     }
}