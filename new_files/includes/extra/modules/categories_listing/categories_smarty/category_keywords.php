<?php   
/* -----------------------------------------------------------------------------------------
   Modul Kategorie-Keywords für modified eCommerce Shopsoftware 2.0.6.0     
   Autor: Daniel Lonn, Agentur Webknecht [webknecht.net | modified-multishop.de]
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
  if(defined('MODULE_WK_KATEGORIE_KEYWORDS_STATUS') 
      && MODULE_WK_KATEGORIE_KEYWORDS_STATUS == 'true' 
      && MODULE_WK_KATEGORIE_KEYWORDS_SHOW == 'true' 
      && basename($PHP_SELF) == FILENAME_ADVANCED_SEARCH_RESULT
      && count($categories_keyword_content) > 0 
      ) {  
          $categorie_smarty->assign('categories_content', $categories_keyword_content);
          $categorie_smarty->assign('KEYWORD_RESULT', true);
  }
   
?>