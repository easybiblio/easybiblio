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
	
	public function __($str) {	
        if (!array_key_exists($this->language, $this->lang)) {
            $filename = 'lang/'.$this->language.'.txt';
            if (file_exists($filename)) {
                $strings = array_map(array($this,'splitStrings'), file($filename));
                foreach ($strings as $k => $v) {
					$this->lang[$this->language][$v[0]] = $v[1];
                }
                return $this->findString($str);
            } else {
                return $str;
            }
        } else {
            return $this->findString($str);
        }
    }
}
?>