<?php

defined('DS') or define('DS', DIRECTORY_SEPARATOR);

class modChatWingHelper
{
  const DEBUG = false;
  const DEFAULT_BOX_WIDTH = 400;
  const DEFAULT_BOX_HEIGHT = 200;

  static $COMPONENT_PATH = null;
  static $token_set = null;

  private static function buildComponentPath()
  {
    self::$COMPONENT_PATH = JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_chatwing';
  }

  /**
   * Check if ChatWing component is installed
   * @return
   */
  static function checkInstall()
  {
    // check if ChatWing component is installed
    if (!JComponentHelper::getComponent('com_chatwing', true)->enabled)
    {
      if (self::DEBUG)
      {
        JFactory::getApplication()->enqueueMessage('ChatWing component is not installed!!', 'error');
      }
      return false;
    }
    else
    {
      return true;
    }
  }

  /**
   * Check if API Key is set (note that this function does not ensure that API Key is a valid key)
   * @return boolean
   */
  static function checkAPIKey()
  {
    if(is_null(self::$token_set)){
      if(is_null(self::$COMPONENT_PATH)) {
        self::buildComponentPath();
      }
      $configModelPath = self::$COMPONENT_PATH . DS . 'models' . DS .'config.php';
      if(!file_exists($configModelPath)){
        return false;
      }
      JModelLegacy::addIncludePath(self::$COMPONENT_PATH . DS . 'models');
      $configModel = JModelLegacy::getInstance('config', 'chatwingmodel');
      self::$token_set = $configModel->isTokenSet();
    }
    return self::$token_set;
  }

  /**
   * Return iframe tag that displays the chatbox
   * @param  string  $key    Chatbox key
   * @param  integer $width  width of the chatbox
   * @param  integer $height height of the chatbox
   * @return string          
   */
  static function buildIframe($key, $width = 400, $height = 200)
  {
    $url = JModelLegacy::getInstance('chatwing', 'chatwingmodel')->getBoxUrl($key);
    return '<iframe src="'.$url.'" width="'. ($width ? $width : self::DEFAULT_BOX_WIDTH) .'" height="'.($height ? $height : self::DEFAULT_BOX_HEIGHT).'" frameborder="0" scrolling="0">Please contact us at info@chatwing.com if you cant embed the chatbox</iframe>';
  }
}