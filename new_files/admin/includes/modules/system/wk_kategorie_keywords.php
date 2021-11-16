<?php
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
                 
use RobinTheHood\ModifiedStdModule\Classes\StdModule;
require_once DIR_FS_DOCUMENT_ROOT . '/vendor-no-composer/autoload.php';
             

class wk_kategorie_keywords extends StdModule
{
    public function __construct()
    {
        $this->init('MODULE_WK_KATEGORIE_KEYWORDS');
    }

    public function display()
    {   
    
        $this->text_return = "";
        $this->text_mod = "";   
        # $this->mmlc_tpl_path = "/ModifiedModuleLoaderClient/Modules/webknecht/kategorie-keywords/new_files/templates/";
        $template_array=array();
        $this->arr_files=array();  
        $this->arr_files["tpl_modified_responsive"][] = array( "tpl" => "module/autocomplete.html", "checksum_src" => "1d13fd3dfb3674fdaf682ba6ac17ff4b", "checksum_dest" => "7c7be325d566bcbd92c26016e0240f1f");
        $this->arr_files["tpl_modified_responsive"][] = array( "tpl" => "module/sub_categories_listing.html", "checksum_src" => "04457858c2be1b9f5d7f290230e8e77d", "checksum_dest" => "bdcc02c65bc499f33f272db30876863d");
        $this->arr_files["tpl_modified"][] = array( "tpl" => "module/autocomplete.html", "checksum_src" => "cb612c9ce5110f4a5cb81333087352f1", "checksum_dest" => "206a2d2a837bbaae246528597208a844");
        $this->arr_files["tpl_modified"][] = array( "tpl" => "module/sub_categories_listing.html", "checksum_src" => "b1c56004294d3e83580ed84132fa54af", "checksum_dest" => "3fc9d1d1927fd9a54531276a720b7807");

        # todo Zieldateien: Abgleich über Checksum anstelle von Template Pfad
        /*
        if ($dir = opendir(DIR_FS_CATALOG.'templates/')) {
          while (($template = readdir($dir)) !== false) {
            if (is_dir(DIR_FS_CATALOG.'templates/'.$template) && ($template != "CVS") && substr($template, 0, 1) != ".") {
              $template_array[] = $template;
            }
          }
          closedir($dir);
          sort($template_array);
        }    
        */
        
        foreach ($this->arr_files as $template => $data) {
          for($i=0; $i < count($data); $i++){     
              $mmlc_tpl = str_replace("/", "/wkkk_", $data[$i]["tpl"]); 
              $tpl_dest = "templates/" . $template  . "/" . $mmlc_tpl;                       
              $tpl_src = "templates/" . $template . "/" . $data[$i]["tpl"];
              if(is_file(DIR_FS_CATALOG . $tpl_src)) {
                 $checksum_src = md5(file_get_contents(DIR_FS_CATALOG . $tpl_src));  
                 if($checksum_src == $data[$i]["checksum_dest"]) {
                    # bereits passend modifiziert
                 }elseif($checksum_src == $data[$i]["checksum_src"]) {
                   # nicht modifiziert und original
                   $this->text_return .= '<br /><i>' . $tpl_src . ' *</i>';
                 }  
                 if(is_file(DIR_FS_CATALOG . $tpl_dest)) {
                   # Vorlagen vorhanden
                   #$this->text_mod .= '<br /><i><a href="../' . $tpl_dest . '">' .  $tpl_dest . '</a></i>';
                   $this->text_mod .= '<br /><i>' .  $tpl_dest . '</i>';
                 }                              
              }                    
          }                         
        }    
        
        if($this->text_return == ""){
          $this->text_return .=  MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_TPL_MOD;
        }else{
          $this->text_return =  MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_TPL_MOD . $this->text_return;
          $this->text_return .=  MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_TPL_ORIG;  
        }
        if($this->text_mod != ""){
          $this->text_return .=  $this->text_mod;
        } 
        
        $this->text_return .=  '<br /><div align="center">' . xtc_button(BUTTON_SAVE) .
          xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $this->code)) . 
          "</div>"; 
           
        return array('text' => $this->text_return);    
    }

    public function install() 
    {                                                                                                                                                                                          
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_WK_KATEGORIE_KEYWORDS_STATUS', 'True',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_WK_KATEGORIE_KEYWORDS_SHOW', 'True',  '6', '2', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
            xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_CATEGORIES', 'True',  '6', '3', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
            $this->install_db(); 
    }
    public function keys() 
    {
        return array('MODULE_WK_KATEGORIE_KEYWORDS_STATUS', 'MODULE_WK_KATEGORIE_KEYWORDS_SHOW', 'MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_CATEGORIES');
    }
    
    public function install_db() 
    {  
        $this->uninstall_db(); 
        xtc_db_query("ALTER TABLE " . TABLE_CATEGORIES_DESCRIPTION . " ADD categories_keywords VARCHAR( 255 ) NOT NULL AFTER categories_description");
    }
    
    public function uninstall_db() 
    {      
        xtc_db_query("ALTER TABLE " . TABLE_CATEGORIES_DESCRIPTION . " DROP categories_keywords");
    }
    public function remove()
    {
        parent::remove();
    }
}



/*
class hp_adminer_dba_tool extends StdModule
{
    public function __construct()
    {
        $this->init('MODULE_HP_ADMINER_DBA_TOOL');
    }

    public function display()
    {
        return array('text' => '<br /><div align="center">' . xtc_button(BUTTON_SAVE) .
        xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $this->code)) . "</div>");
    }

    public function install()
    {
        xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added)
              				VALUES ('MODULE_HP_ADMINER_DBA_TOOL_STATUS', 'true',  '6', '1', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
        xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added)
              				VALUES ('MODULE_HP_ADMINER_DBA_TOOL_FILL_LOGIN', 'true',  '6', '2', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
        xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added)
              				VALUES ('MODULE_HP_ADMINER_DBA_TOOL_LOG_SQL', 'true',  '6', '3', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");  
        xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added)
              				VALUES ('MODULE_HP_ADMINER_DBA_TOOL_PASSWORD', '',  '6', '4', 'xtc_cfg_password_field_module(', now())");                                                                    

        xtc_db_query("ALTER TABLE `" . TABLE_ADMIN_ACCESS . "` ADD `" . $this->code . "` INT(1) NOT NULL DEFAULT '0'");
        xtc_db_query("UPDATE `" . TABLE_ADMIN_ACCESS . "` SET `" . $this->code . "` = '1' WHERE customers_id = '1'");
        
        require_once(DIR_FS_INC . 'xtc_random_charcode.inc.php');
        
        $random_charcode_1 = xtc_random_charcode(10);
        $random_charcode_2 = xtc_random_charcode(10);
        
        rename(DIR_FS_CATALOG . DIR_ADMIN . (defined('DIR_ADMINER') ? DIR_ADMINER : 'adminer') . '/' . (defined('ADMINER_INDEX_FILE') ? ADMINER_INDEX_FILE : 'index.php'), DIR_FS_CATALOG . DIR_ADMIN . (defined('DIR_ADMINER') ? DIR_ADMINER : 'adminer') . '/index_' . $random_charcode_2 . '.php');        
        rename(DIR_FS_CATALOG . DIR_ADMIN . (defined('DIR_ADMINER') ? DIR_ADMINER : 'adminer'), DIR_FS_CATALOG . DIR_ADMIN . 'adminer_' . $random_charcode_1);
                                            
        $file_contents = '<?php' . "\n" .                    
                         '' . "\n" .
                         'define(\'ADMINER_DBA_TOOL_TOKEN\', \'' . xtc_random_charcode(10) . '\');' . "\n" .
                         'define(\'ADMINER_DBA_TOOL_LOG_SQL\', \'true\');' . "\n" .
                         'define(\'DIR_ADMINER\', \'adminer_' . $random_charcode_1 . '\');' . "\n" .
                         'define(\'ADMINER_INDEX_FILE\', \'index_' . $random_charcode_2 . '.php\');';                             
                        
        $fp = fopen(DIR_FS_CATALOG . 'includes/extra/configure/hp_adminer_dba_tool.php', 'w');
        fputs($fp, $file_contents);
        fclose($fp);    
        @chmod(DIR_FS_CATALOG . 'includes/extra/configure/hp_adminer_dba_tool.php', 0644);
    }

    public function remove()
    {
        xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key LIKE 'MODULE_HP_ADMINER_DBA_TOOL_%'");
      
        $query_result = xtc_db_query("SHOW COLUMNS FROM `" . TABLE_ADMIN_ACCESS . "`");
        $db_table_rows = [];
        while ($row = xtc_db_fetch_array($query_result)) {
          $db_table_rows[] = $row['Field'];
        }
        
        if (in_array($this->code, $db_table_rows)) {
          xtc_db_query("ALTER TABLE `" . TABLE_ADMIN_ACCESS . "` DROP `" . $this->code . "`;");
        }      
                
        if (defined('DIR_ADMINER') && defined('ADMINER_INDEX_FILE')) { 
        
          rename(DIR_FS_CATALOG . DIR_ADMIN . DIR_ADMINER . '/' . ADMINER_INDEX_FILE, DIR_FS_CATALOG . DIR_ADMIN . DIR_ADMINER . '/index.php');        
          rename(DIR_FS_CATALOG . DIR_ADMIN . DIR_ADMINER , DIR_FS_CATALOG . DIR_ADMIN . 'adminer');        
                                    
          $fp = fopen(DIR_FS_CATALOG . 'includes/extra/configure/hp_adminer_dba_tool.php', 'w');
          fputs($fp, '<?php');
          fclose($fp);    
          @chmod(DIR_FS_CATALOG . 'includes/extra/configure/hp_adminer_dba_tool.php', 0644);                             
       }
    }
    
    public function keys() 
    {
        return ['MODULE_HP_ADMINER_DBA_TOOL_STATUS','MODULE_HP_ADMINER_DBA_TOOL_FILL_LOGIN','MODULE_HP_ADMINER_DBA_TOOL_LOG_SQL','MODULE_HP_ADMINER_DBA_TOOL_PASSWORD'];
    }    
}

*/