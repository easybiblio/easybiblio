<?php
class Translator {

    private $language	= 'en';
	private $lang 		= array();
	
	public function __construct($language){
		$this->language = $language;
	}
	
    private function findString($str) {
        if (array_key_exists($str, $this->lang[$this->language])) {
			return $this->lang[$this->language][$str];
        }
        return $str;
    }
    
	private function splitStrings($str) {
        return explode('=', trim($str));
    }
    
	public function __($str, $arg1 = "", $arg2 = "") {
        if (!array_key_exists($this->language, $this->lang)) {
            $filename = 'lang/'.$this->language.'.txt';
            if (file_exists($filename)) {
                $strings = array_map(array($this,'splitStrings'), file($filename));
                foreach ($strings as $k => $v) {
					$this->lang[$this->language][$v[0]] = $v[1];
                }
                $toReturn = $this->findString($str);
            } else {
                $toReturn = $str;
            }
        } else {
            $toReturn = $this->findString($str);
        }
        
        // Documentation to generate: <body text='black'>
        // $bodytag = str_replace("%1", "black", "<body text='%1'>");
        
        if (strpos($toReturn, "%1") !== false && $arg1 != "") {
            $toReturn = str_replace("%1", $arg1, $toReturn);
        }
        
        if (strpos($toReturn, "%2") !== false && $arg2 != "") {
            $toReturn = str_replace("%2", $arg2, $toReturn);
        }
        
        return $toReturn;
    }
}
?>