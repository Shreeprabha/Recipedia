<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Facebook;

use Application\Model\User;

class AuthController extends AbstractActionController
{
	protected $form;
	protected $storage;
	protected $authservice;
	
	public function getAuthService()
	{
		if (! $this->authservice) {
			$this->authservice = $this->getServiceLocator()
				->get('AuthService');
		}
		
		return $this->authservice;
	}
	
	public function getSessionStorage()
		{
		if (! $this->storage) {
			$this->storage = $this->getServiceLocator()
				->get('Application\Model\AuthStorage');
		}
		
		return $this->storage;
		}
	
	public function getForm()
		{
		if (! $this->form) {
			$user       = new User();
			$builder    = new AnnotationBuilder();
			$this->form = $builder->createForm($user);
		}
		
		return $this->form;
		}
	
	public function loginAction()
		{
		if ($this->getAuthService()->hasIdentity()){
			return $this->redirect()->toRoute('success');
		}
		
		$form       = $this->getForm();
		
		return array(
			'form'      => $form,
			'messages'  => $this->flashmessenger()->getMessages()
		);
		}
	
	public function authenticateAction()
		{
		$form       = $this->getForm();
		$redirect = 'login';
		
		$request = $this->getRequest();
		if ($request->isPost()){
			$form->setData($request->getPost());
			if ($form->isValid()){
				$this->getAuthService()->getAdapter()
				->setIdentity($request->getPost('username'))
				->setCredential($request->getPost('password'));
				
				$result = $this->getAuthService()->authenticate();
				foreach($result->getMessages() as $message)
				{
					$this->flashmessenger()->addMessage($message);
				}
				
				if ($result->isValid()) {
					$redirect = 'success';
					//check if it has rememberMe :
					if ($request->getPost('rememberme') == 1 ) {
						$this->getSessionStorage()
						->setRememberMe(1);
						$this->getAuthService()->setStorage($this->getSessionStorage());
					}
					$this->getAuthService()->getStorage()->write($request->getPost('username'));
				}
			}
		}
		
		return $this->redirect()->toRoute($redirect);
	}
	
	public function logoutAction()
	{
		$this->getSessionStorage()->forgetMe();
		$this->getAuthService()->clearIdentity();
		
		$this->flashmessenger()->addMessage("You've been logged out");
		return $this->redirect()->toRoute('login');
	}
	
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
}