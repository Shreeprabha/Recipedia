<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function init($moduleManager)
    {
        $moduleManager->loadModule('ZfcUser');
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager = $e->getApplication()->getEventManager();
        //nothing's available for non logged user, so redirect him to login page
        $eventManager->attach("dispatch", function($e) {
            $sm = $e->getApplication()->getServiceManager();
            $controller = $e->getTarget();
            $auth = $sm->get('zfcuser_auth_service');
            if (!$auth->hasIdentity() && $e->getRouteMatch()->getMatchedRouteName() !== 'zfcuser/login' && $e->getRouteMatch()->getMatchedRouteName() !== 'zfcuser/register') {
                $application = $e->getTarget();

                $e->stopPropagation();
                $response = $e->getResponse();
                $response->setStatusCode(302);
                $response->getHeaders()->addHeaderLine('Location', $e->getRouter()->assemble(array(), array('name' => 'zfcuser/login')));
                //returning response will cause zf2 to stop further dispatch loop
                return $response;
            }
        }, 100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}