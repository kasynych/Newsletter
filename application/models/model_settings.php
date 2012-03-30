<?php
class Model_settings extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function get(){
		$settings=parse_ini_file($this->config->item('settings_path'));
		foreach($settings as $field=>$value)
			$this->config->set_item($field,$value);
		return $settings;
	}
	
	function store($data){
		if(!is_array($data)||empty($data))
			throw new Exception('No Input Data');
			
		if(!$this->writeIniFile($data,'application/settings.ini'))
			throw new Exception('Error storing settings');
		
		return true;
	}
	
	function writeIniFile($assoc_arr, $path, $has_sections=FALSE) { 
	    $content = ""; 
	    if ($has_sections) { 
	        foreach ($assoc_arr as $key=>$elem) { 
	            $content .= "[".$key."]\n"; 
	            foreach ($elem as $key2=>$elem2) { 
	                if(is_array($elem2)) 
	                { 
	                    for($i=0;$i<count($elem2);$i++) 
	                    { 
	                        $content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
	                    } 
	                } 
	                else if($elem2=="") $content .= $key2." = \n"; 
	                else $content .= $key2." = \"".$elem2."\"\n"; 
	            } 
	        } 
	    } 
	    else { 
	        foreach ($assoc_arr as $key=>$elem) { 
	            if(is_array($elem)) 
	            { 
	                for($i=0;$i<count($elem);$i++) 
	                { 
	                    $content .= $key."[] = \"".$elem[$i]."\"\n"; 
	                } 
	            } 
	            else if($elem=="") $content .= $key." = \n"; 
	            else $content .= $key." = \"".$elem."\"\n"; 
	        } 
	    } 
	
	    if (!$handle = fopen($path, 'w')) { 
	        return false; 
	    } 
	    if (!fwrite($handle, $content)) { 
	        return false; 
	    } 
	    fclose($handle); 
	    return true; 
	}	
}