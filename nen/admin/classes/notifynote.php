<?php
class NotifyNote
{
    const SESSION_NAMESPACE = 'Notifications';

    const STORAGE_PROPERTY = 'messages';

    const DATA_STACK_ERROR = 'error';

    const DATA_STACK_SUCCESS = 'success';

    const DATA_STACK_INFO = 'info';


    protected static $_storage = null;

    private $_storageStructure = array(
        self::DATA_STACK_ERROR   => array(),
        self::DATA_STACK_SUCCESS => array(),
        self::DATA_STACK_INFO    => array()
    );

    public function gotoListing ($message = null, $type = self::DATA_STACK_SUCCESS)
    {
        if ($message && $type) {
            $this->notify()->addMessage($type,  $message);
        }
    }	
	
	
    public function notify ($namespace=self::SESSION_NAMESPACE)
    {
        if (null === self::$_storage) {
            $this->_initStorageHandler($namespace);
        }
        return $this;
    }

    public function addMessage ($type, $message)
    {
        if (!is_string($message)) {
            throw new Exception('Parameter "$message" must be an string, ' . gettype($message) . ' was given.');
        }

        switch ($type) {
            case self::DATA_STACK_ERROR:
            case self::DATA_STACK_SUCCESS:
            case self::DATA_STACK_INFO:
            case self::DATA_STACK_POPUP:
                $this->_addMessage($type, $message);
                break;
            default:
                throw new Exception("Invalid data stack type \"$type\".");
                break;
        }
    }	
	
    private function _addMessage ($type, $message)
    {

        $stack = $this->_getDataStack($type);
        $stack[] = trim(ucfirst($message));
        $this->_storeDataStack($type, $stack);
	
    }
	
	
    public function error ($messages)
    {
        $type = self::DATA_STACK_ERROR;
		$this->addMessage($type, $messages);
    }
    
    public function success ($messages)
    {
        $type = self::DATA_STACK_SUCCESS;
		$this->addMessage($type, $messages);
    }

    public function info ($messages)
    {
        $type = self::DATA_STACK_INFO;
		$this->addMessage($type, $messages);
    }


    public function getErrorMessages ()
    {
        $type = self::DATA_STACK_ERROR;
        $messages = $this->_getDataStack($type);
        $this->clearMessages($type);

        return $messages;
    }

    public function getSuccessMessages()
    {
        $type = self::DATA_STACK_SUCCESS;
        $messages = $this->_getDataStack($type);
        $this->clearMessages($type);

        return $messages;
    }

    public function getInfoMessages()
    {
        $type = self::DATA_STACK_INFO;
        $messages = $this->_getDataStack($type);
        $this->clearMessages($type);

        return $messages;
    }


    public function getAllMessages ($withoutPopups = true)
    {
        $messages = $this->_getAllDataStacks();
        $this->clearMessages();
        return $messages;
    }

    public function clearMessages ($type = null)
    {
        if (null === $type) {
			unset($_SESSION[self::SESSION_NAMESPACE]);
            return;
        } elseif (is_string($type)) {
			unset($_SESSION[self::SESSION_NAMESPACE][$type]);		
            return;
        }
        throw new Exception("Invalid data stack type \"$type\".");
    }

    private function _storeDataStack ($type, $data)
    {
        if (!is_array($data)) {
            throw new Exception('Parameter "$data" must be an string, ' . gettype($message) . ' was given.');
        }
        
		$_SESSION[self::SESSION_NAMESPACE][$type] = $data;
    }
	

    protected function _getDataStack ($type)
    {

        if (isset($_SESSION[self::SESSION_NAMESPACE][$type])) {
            return $_SESSION[self::SESSION_NAMESPACE][$type];
        }
        throw new Exception("The data stack \"{$type}\" is invalid.");
		
    }
    
    protected function _getAllDataStacks ()
    {
        return $this->_getStorageHandler();
    }



    protected function _getStorageHandler ()
    {
        if (!isset($_SESSION[self::SESSION_NAMESPACE])) {
            $this->_initStorageHandler();
        }
        return $_SESSION[self::SESSION_NAMESPACE];
    }

	
    protected function _initStorageHandler ()
    {
        if (!isset($_SESSION[self::SESSION_NAMESPACE])) {
			$_SESSION[self::SESSION_NAMESPACE]	= $this->_storageStructure;
        }
        return $_SESSION[self::SESSION_NAMESPACE];	
    }	
}