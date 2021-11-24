<?php
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
                 
use RobinTheHood\ModifiedStdModule\Classes\StdModule;
use RobinTheHood\HookPointManager\Classes\HookPointManager; 
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
        $this->arr_files=array();  
        $this->arr_files[] = array( "tpl" => "module/autocomplete.html", "checksum_src" => array("1d13fd3dfb3674fdaf682ba6ac17ff4b", "cb612c9ce5110f4a5cb81333087352f1"), "checksum_dest" => array("7c7be325d566bcbd92c26016e0240f1f", "206a2d2a837bbaae246528597208a844"));
        $this->arr_files[] = array( "tpl" => "module/sub_categories_listing.html", "checksum_src" => array("04457858c2be1b9f5d7f290230e8e77d", "b1c56004294d3e83580ed84132fa54af"), "checksum_dest" => array("bdcc02c65bc499f33f272db30876863d", "2afe95fcd7f22edc09a1479d9af7ebf0"));
                                                                                                                                                                                                              
        # Template Abgleich über Checksum      
        if ($dir = opendir(DIR_FS_CATALOG.'templates/')) {
          while (($template = readdir($dir)) !== false) {
            if (is_dir(DIR_FS_CATALOG.'templates/'.$template) && ($template != "CVS") && substr($template, 0, 1) != ".") {
                for($i=0; $i < count($this->arr_files); $i++){  
                      $tpl_src = "templates/" . $template."/".$this->arr_files[$i]["tpl"];
                      $this->text_return .= '<br /><i>' . $tpl_src;
                      
                      if(!is_file(DIR_FS_CATALOG . $tpl_src)) {
                         # nicht vorhanden
                         $this->text_return .= ' ***';
                         $this->not_found = true;
                      }else{
                         for($j=0; $j < count($this->arr_files[$i]["checksum_src"]); $j++){
                              $checksum_src = $this->arr_files[$i]["checksum_src"][$j]; 
                              $checksum_dest = $this->arr_files[$i]["checksum_dest"][$j];  
                              $checksum_file = md5(file_get_contents(DIR_FS_CATALOG . $tpl_src));

                              if($checksum_file == $checksum_dest){
                                  # bereits passend modifiziert
                                  $this->text_return .= ' **';
                              } elseif($checksum_file == $checksum_src) {
                                  # nicht modifiziert und original
                                  $this->text_return .= ' *';
                              }                           
                         }
                         
                      }   
                      $this->text_return .= '</i>';       
                          
                } 
                $this->text_return .= '<br />';    
                
            }
          }
          closedir($dir);
        }    

        if($this->text_return == ""){
          $this->text_return .=  MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_TPL_MOD;
        }else{
          $this->text_return =  MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_TPL_MOD . $this->text_return;
          $this->text_return .=  MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_TPL_ORIG;  
        } 
         
        $this->text_return .= '<a href="../wkkk_geaendert.zip">wkkk_geaendert.zip</a><br />';
        
        if($this->not_found){
            $this->text_return .= MODULE_WK_KATEGORIE_KEYWORDS_INCLUDE_TPL_NONE;
        }    
        
        $this->text_return .=  '<br /><div align="center">' . xtc_button(BUTTON_SAVE) .
          xtc_button_link(BUTTON_CANCEL, xtc_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=' . $this->code)) . 
          "</div>"; 
           
        return array('text' => $this->text_return);    
    }

    public function install() 
    {        
            $hookPointManager = new HookPointManager();
            $hookPointManager->registerDefault();
            $hookPointManager->update();  
                                                                                                                                                                                        
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