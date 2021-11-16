<?php
# Modul Kategorie-Keywords: Ergänzung relevanter Artikel IDs                                
if(defined('MODULE_WK_KATEGORIE_KEYWORDS_STATUS') 
   && MODULE_WK_KATEGORIE_KEYWORDS_STATUS == 'true'){          
     require_once (DIR_WS_INCLUDES.'extra/default/listing_sql/category_keywords.php'); 
     # Ergänzung relevanter Artikel IDs 
     if(isset($arr_included_products)){
        $autocomplete_search_query = str_replace("AND (  (", "AND (  ( p.products_id IN (".join($arr_included_products, ",") . ") OR ", $autocomplete_search_query);  
     }   
     # Ergänzung relevanter Kategorien 
     if(count($categories_keyword_content) > 0) {  
            $module_smarty->assign('categories_content', $categories_keyword_content);
     }  
}
?>