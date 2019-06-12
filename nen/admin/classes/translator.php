<?php
class Translator {

	private $registry;
    private $language;
    private $translations;
	
    /**
     * Initialize Registry, Current Lang
     *
     * @param  $registry
     */
    public function __construct($registry, $language = 'ru'){
		
		$this->registry = $registry;
        $this->language = $language;
		
		$path = SITE_PATH . 'translation' . DIRSEP . $this->language.'.php';
        if (file_exists($path) == false) {
			trigger_error ('Translation file `' . $this->language . '` does not exist.', E_USER_NOTICE);
            return false;
		}
        include ($path);		
        $this->translations = $translate;

		$path = SITE_PATH . 'translation' . DIRSEP . 'message_' . $this->language.'.php';
        if (file_exists($path) == false) {
			trigger_error ('Translation file `' . 'message_' . $this->language . '` does not exist.', E_USER_NOTICE);
            return false;
		}
        include ($path);		
        $this->messages = $messages;		
    }

    /**
     *  Translate of word
     *
     * @param  $word
     *
     * @return translation word or word 
     */
    public function translate($word){

        if (array_key_exists($word, $this->translations)) {
			return $this->translations[$word];
		}
		return $word;
    }


    /**
     *  Translate message of word
     *
     * @param  $word
     *
     * @return translation word or word 
     */
    public function message($word){

        if (array_key_exists($word, $this->messages)) {
			return $this->messages[$word];
		}
		return $word;
    }
}
?>