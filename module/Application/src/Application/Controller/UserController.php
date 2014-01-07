<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Facebook;

class UserController extends AbstractActionController
{
	
	public function facebookAction()
	{
		$config = array(
			'appId' => '715209851845327',
			'secret' => 'a15a5cabac91d4a5c9f4eabd592dc338',
			'allowSignedRequest' => false, // optional but should be set to false for non-canvas apps
		);
		
		$facebook = new Facebook($config);
		$user_id = $facebook->getUser();
		
		if($user_id) {

      // We have a user ID, so probably a logged in user.
      // If not, we'll get an exception, which we handle below.
      try {

        $user_profile = $facebook->api('/me','GET');
        var_dump($user_profile);
        echo "Name: " . $user_profile['name'];

      } catch(FacebookApiException $e) {
        // If the user is logged out, you can have a 
        // user ID even though the access token is invalid.
        // In this case, we'll get an exception, so we'll
        // just ask the user to login again here.
        $login_url = $facebook->getLoginUrl(); 
        echo 'Please <a href="' . $login_url . '">login.</a>';
        error_log($e->getType());
        error_log($e->getMessage());
      }   
    } else {

      // No user, print a link for the user to login
      $login_url = $facebook->getLoginUrl();
      echo 'Please <a href="' . $login_url . '">login.</a>';

    }
    
    
    
    
    
    
    
		
		
		return new ViewModel(array ('user_id' => $user_id,));
		
		
	}
	
	
	public function connectAction()
		{
		$auth = Auth::getInstance();
		if (!$auth->hasIdentity()) {
			throw new Exception('Not logged in!', 404);
		}
		$this->view->providers = $auth->getIdentity();
		}
	
	public function logoutAction()
		{
		Auth::getInstance()->clearIdentity();
		$this->_redirect('/');
		}
}
