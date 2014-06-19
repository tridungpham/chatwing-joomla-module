<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
require dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'helper.php';;
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldChatwingbox extends JFormFieldList
{
  protected $type = 'chatwingbox';

  public function getLabel(){
    return parent::getLabel();
  }

  protected function getInput()
  {
    if(modChatWingHelper::checkInstall() && modChatWingHelper::checkAPIKey()) {
      return parent::getInput();
    } else {
      return '<span>'.JText::_('MOD_CHATWING_ERROR_CHATBOX_NOT_AVAILABLE').'</span>';
    }
  }

  protected function getOptions()
  {
    if(modChatWingHelper::checkAPIKey()){
      $chatwingModel = JModelLegacy::getInstance('chatwing', 'chatwingmodel');
      if($chatwingModel){
        $boxes = $chatwingModel->getBoxList();
        $data = array();
        foreach($boxes as $box){
          $obj = new stdClass();
          $obj->value = $box['key'];
          $obj->text = $box['name'];
          $data[] = $obj;
        }
        return $data;
      }
    } 
    return array();
  }

}