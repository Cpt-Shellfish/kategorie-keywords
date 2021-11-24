<?php
/* -----------------------------------------------------------------------------------------
   Modul Kategorie-Keywords für modified eCommerce Shopsoftware 2.0.6.0     
   Autor: Daniel Lonn [www.webknecht.net]
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
          
if(defined('MODULE_WK_KATEGORIE_KEYWORDS_STATUS') 
    && MODULE_WK_KATEGORIE_KEYWORDS_STATUS == 'true' 
    && (basename($PHP_SELF) == FILENAME_ADVANCED_SEARCH_RESULT || basename($PHP_SELF) == 'autocomplete.php')
    && $categories_id == false // adv. search: subcategories not selected
    && sizeof($search_keywords) > 0
    ) {   
      $sql_categories_keywords = '';
      $where_str_cat = " ( ";

      for ($i = 0, $n = sizeof($search_keywords); $i < $n; $i ++) {      
          switch ($search_keywords[$i]) {
            case '(' :
            case ')' :
            case 'and' :
            case 'or' :
              $where_str .= " ".$search_keywords[$i]." ";
              break;
            default :
              $ent_keyword = encode_htmlentities($search_keywords[$i]);
              $ent_keyword = $ent_keyword != $search_keywords[$i] ? xtc_db_input($ent_keyword) : false;
              $keyword = xtc_db_input($search_keywords[$i]);
              $where_str_cat .= " ( ";
              $where_str_cat .= "cd.categories_keywords LIKE ('%".$keyword."%') ";
              $where_str_cat .= $ent_keyword ? "OR cd.categories_keywords LIKE ('%".$ent_keyword."%') " : '';
              
              if (MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_CATEGORIES == 'true') {
                 $where_str_cat .= "OR cd.categories_name LIKE ('%".$keyword."%') ";
                 $where_str_cat .= $ent_keyword ? "OR cd.categories_name LIKE ('%".$ent_keyword."%') " : '';
                 $where_str_cat .= "OR cd.categories_heading_title LIKE ('%".$keyword."%') ";
                 $where_str_cat .= $ent_keyword ? "OR cd.categories_heading_title LIKE ('%".$ent_keyword."%') " : '';
              }
                      
              $where_str_cat .= " ) OR ";        
            break;
          }
      } 
      if($where_str_cat != " ( "){
        $where_str_cat = substr($where_str_cat, 0, strlen($where_str_cat)-3);
        $where_str_cat .= " ) ";
        $listing_sql_categories = "Select * from ".TABLE_CATEGORIES." c LEFT JOIN ".TABLE_CATEGORIES_DESCRIPTION." cd on c.categories_id = cd.categories_id where $where_str_cat AND cd.language_id = '".(int)$_SESSION['languages_id']."'";
        $categories_query = xtc_db_query($listing_sql_categories);
        $categories_keyword_content = array();     
        $arr_categories_affected = array();
        while ($categories = xtc_db_fetch_array($categories_query)) {
           if(!in_array($categories['categories_id'], $arr_categories_affected)){
              $arr_categories_affected[]=$categories['categories_id'];
           }
           if(MODULE_WK_KATEGORIE_KEYWORDS_SHOW == 'true') {
             $cPath_new = xtc_category_link($categories['categories_id'],$categories['categories_name']);
             $image = '';
             if ($categories['categories_image'] != '') {
                $image = DIR_WS_IMAGES.'categories/'.$categories['categories_image'];
                if(!file_exists($image)){
                   $image = DIR_WS_IMAGES.'categories/noimage.gif';
                }
                $image = $image;
             }     
             $categories_keyword_content[] = array ('CATEGORIES_NAME' => $categories['categories_name'],
             'CATEGORIES_HEADING_TITLE' => $categories['categories_heading_title'],
             'CATEGORIES_IMAGE' => (($image != '') ? DIR_WS_BASE . $image : ''),
             'CATEGORIES_LINK' => xtc_href_link(FILENAME_DEFAULT, $cPath_new),
             'CATEGORIES_DESCRIPTION' => $categories['categories_description']);
           } 
        }  

        if(count($arr_categories_affected)>0){
           $str_categories = ",".join($arr_categories_affected, ",").",";
           $sql_categories_keywords = " (INSTR('$str_categories', concat(',',p2c.categories_id,',')))";
        }     
      }
      if($sql_categories_keywords){  
        $listing_sql_keywords = "SELECT p.products_id
                                        FROM ".TABLE_PRODUCTS." p
                                        JOIN ".TABLE_PRODUCTS_TO_CATEGORIES." AS p2c ON (p.products_id = p2c.products_id) ";
        if($pfrom_check != '' || $pto_check != '') {
            $listing_sql_keywords .= "LEFT OUTER JOIN ".TABLE_SPECIALS." AS s ON (p.products_id = s.products_id) ".SPECIALS_CONDITIONS_S." ";  
        }                
        if($NeedTax) {
          $listing_sql_keywords .= " LEFT OUTER JOIN ".TABLE_TAX_RATES." tr ON (p.products_tax_class_id = tr.tax_class_id) 
                         LEFT OUTER JOIN ".TABLE_ZONES_TO_GEO_ZONES." gz ON (tr.tax_zone_id = gz.geo_zone_id) ";
        }                            
        $listing_sql_keywords .= "WHERE p.products_status = '1'
                                        ".PRODUCTS_CONDITIONS_P."
                                        AND $sql_categories_keywords $pfrom_check $pto_check";
        if($manu_check!="") {
            $listing_sql_keywords .= " AND p.manufacturers_id = '".$manufacturers_id."' ";         
        }                      
        if($NeedTax) {
          $listing_sql_keywords .= " AND (gz.zone_country_id IS NULL OR gz.zone_country_id = '0' OR gz.zone_country_id = '".(int) $_SESSION['customer_country_id']."') 
                         AND (gz.zone_id is null OR gz.zone_id = '0' OR gz.zone_id = '".(int) $_SESSION['customer_zone_id']."')";
        } 
                                    
        $keywords_query = xtc_db_query($listing_sql_keywords);
        $arr_included_products=array();
        while ($products_from_keywords = xtc_db_fetch_array($keywords_query)) {
           $arr_included_products[] = "'" . $products_from_keywords['products_id'] . "'";                  
        }     
        if(count($arr_included_products)>0){
           $listing_sql = str_replace("WHERE p.products_id IN (", "WHERE p.products_id IN (".join($arr_included_products, ",") . ",", $listing_sql);  
 
        }
        
      }
}     
 
?>