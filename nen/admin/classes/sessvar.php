<?php
class Sessvar {

	private $registry;
	
    /**
     * Initialize Registry
     *
     * @param  $registry
     */
	function __construct($registry, $availableLocale) {
		$this->registry = $registry;
		$this->langs = $this->setAvailableLocale($availableLocale);		
		$this->translateLangs = $this->getTranslableLocale($availableLocale);				
	}

    /**
     *  set Define locale
     *
     * @param  string $locale
     *
     * @return var SESSION
     */
    public function setCurrentLocale () {
		return $_SESSION['locale'] = LOCALE;
	}
	
    /**
     *  set available loacles
     *
     * @param  
     *
     * @return var SESSION
     */
    public function setAvailableLocale ($availableLocale) {
		unset ($_SESSION['locales']);			
		return $_SESSION['locales'] = $availableLocale;		
    }
	
    /**
     *  set available locales wihtout default
     *
     * @param  
     *
     * @return var SESSION
     */
    public function getTranslableLocale ($availableLocale) {
		unset($availableLocale[LOCALE]);
		return $availableLocale; 
    }	
    /**
     *  Translate of word
     *
     * @param  $word
     *
     * @return translation word or word 
     */
    public function getCurrentLocale(){
		return $_SESSION['locale'];
    }	
}
?>