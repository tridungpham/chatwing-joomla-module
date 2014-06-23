<?php
/**
 * @author  Tri Dung Pham <dungpt@live.com>
 * @package  ChatWing
 * @subpackage mod_ChatWing
 */

require 'helper.php';
$check = modChatWingHelper::checkInstall() && modChatWingHelper::checkAPIKey();

if($check) {
  echo modChatWingHelper::buildIframe($params->get('chatbox_key'), (int) $params->get('width'), (int) $params->get('height'));
}