<?php

/**
 * Description of CoreController
 *
 * @author andrei
 */
class CoreController extends Controller
{

    protected $_cache;

    public function init()
    {
        if (!$this->_cache) {
            fb('creating cache');
            $this->_cache = new Cache();
        }
        parent::init();
    }

    public function getChache()
    {
        return $this->_cache;
    }

}

?>
