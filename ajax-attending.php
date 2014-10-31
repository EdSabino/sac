<?php 
require_once dirname(__FILE__).'/inc/globals.php';

authAllowAuthenticated();

$aEventId 	= isset($_REQUEST['event']) ? (int)$_REQUEST['event'] : '';
$aAction 	= isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$aRet 		= '';

header('Content-Type: text/html; charset=utf-8');

switch($aAction) {
	case 'subscribe':
		$aEvent = eventGetById($aEventId);
		$aUser	= authGetAuthenticatedUserInfo();

		if ($aEvent != null) {
			try {
				attendingAdd($aUser['id'], $aEvent['id'], 0);
				$aRet = '<span class="label label-success">Inscrito</span>';
				$aRet .= ' <a href="#" onclick="SAC.unsubscribe('.$aEventId.')">[X]</a>';
				
			} catch(Exception $aError) {
				$aRet = 'Oops! ' . $aError->getMessage();
			}
			
		} else {
			$aRet = 'Evento desconhecido!';
		}
		break;
		
	case 'unsubscribe':
		$aEvent = eventGetById($aEventId);
		$aUser	= authGetAuthenticatedUserInfo();

		if ($aEvent != null) {
			try {
				attendingRemove($aUser['id'], $aEvent['id'], 0);
				$aRet = '<a href="#" onclick="SAC.subscribe('.$aEventId.', '.($aEvent['capacity'] != 0 ? 'true' : 'false').')">[S]</a>';
				
			} catch(Exception $aError) {
				$aRet = 'Oops! ' . $aError->getMessage();
			}
			
		} else {
			$aRet = 'Evento desconhecido!';
		}
		break;
		
	default:
		$aRet['msg'] = 'Opção inválida!';
}

echo $aRet;

?>