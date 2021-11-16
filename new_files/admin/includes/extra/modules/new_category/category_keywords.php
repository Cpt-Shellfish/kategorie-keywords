<?php   
/* -----------------------------------------------------------------------------------------
   Modul Kategorie-Keywords für modified eCommerce Shopsoftware 2.0.6.0     
   Autor: Daniel Lonn, Agentur Webknecht [webknecht.net | modified-multishop.de]
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

if(defined('MODULE_WK_KATEGORIE_KEYWORDS_STATUS') && MODULE_WK_KATEGORIE_KEYWORDS_STATUS == 'true'){   
  ?>                                              
  <div style="clear:both;"></div>
    <div style="padding:5px;clear:both;">
      <?php   
        for ($i = 0; $i < sizeof($languages); $i++) {  
          $categories_desc_fields = $catfunc->get_categories_desc_fields($cInfo->categories_id, $languages[$i]['id']);
          $lng_image = xtc_image(DIR_WS_LANGUAGES . $languages[$i]['directory'] .'/admin/images/'. $languages[$i]['image'], $languages[$i]['name']);
          ?>                                
          <div class="main" style="vertical-align:top; padding: 3px; line-height:20px;">                    
            <?php echo $lng_image . '&nbsp;' . MODULE_WK_KATEGORIE_KEYWORDS_TEXT_CATEGORY_KEYWORDS; ?> <br />
            <?php echo xtc_draw_input_field('categories_keywords[' . $languages[$i]['id'] . ']',(isset($_POST['categories_keywords'][$languages[$i]['id']]) ? stripslashes($_POST['categories_keywords'][$languages[$i]['id']]) : $categories_desc_fields['categories_keywords']),'style="width:100%"'); ?>
          </div>
        <?php } ?>                              
    </div>
  <?php
}    
?>