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
use Zend\Session\SessionManager;

class IndexController extends AbstractActionController
{
	public function indexAction()
		{
//		if(isset($_SESSION['name'])) {
//			
//			echo '<script>jQuery(function(){
//			$( "#loginList" ).children().css("display","none");
//			});</script>';
//			
//			var_dump($_SESSION);
//		}
//		
//		/* Do login */
//		else {
//			echo '<script>jQuery(function(){
//			$( "#loginList" ).children().css("display","block");
//			});</script>';
//			echo"gahedh";
//		}
		return new ViewModel();
		}
}
