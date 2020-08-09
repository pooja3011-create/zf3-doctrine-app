<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ApplicationTest\Controller;

use Application\Controller\NotificationController;
use Zend\Stdlib\ArrayUtils;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class NotificationControllerTest extends AbstractHttpControllerTestCase {
    
    protected $traceError = true;
    
    public function setUp(): void {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
                        include __DIR__ . '/../../../../config/application.config.php',
                        $configOverrides
        ));
        parent::setUp();
    }
    
    public function testSubscriberActionCanBeAccessed() {
        $this->dispatch('/subscriber');
        $this->assertResponseStatusCode(200);
        $this->assertModuleName('application');
        $this->assertControllerName(NotificationController::class); // as specified in router's controller name alias
        $this->assertControllerClass('NotificationController');
        $this->assertMatchedRouteName('subscriber');
    }

//    public function testSubscriberActionViewModelTemplateRenderedWithinLayout() {
//        $this->dispatch('/', 'GET');
//        $this->assertQuery('.container .jumbotron');
//    }

//    public function testInvalidRouteDoesNotCrash() {
//        $this->dispatch('/invalid/route', 'GET');
//        $this->assertResponseStatusCode(404);
//    }

}
