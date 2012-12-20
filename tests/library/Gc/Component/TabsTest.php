<?php
namespace Gc\Component;

use Gc\Document\Collection as DocumentCollection,
    Gc\Document\Model as DocumentModel,
    Gc\DocumentType\Model as DocumentTypeModel,
    Gc\Layout\Model as LayoutModel,
    Gc\User\Model as UserModel,
    Gc\View\Model as ViewModel;
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:09.
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 * @group Gc
 */
class TabsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Tabs
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @covers Gc\Component\Tabs::__construct
     */
    protected function setUp()
    {
        $this->_object = new Tabs(array());
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->_object);
    }

    /**
     * @covers Gc\Component\Tabs::render
     */
    public function testRenderWithIterableInterface()
    {
        $view = ViewModel::fromArray(array(
            'name' => 'View Name',
            'identifier' => 'View identifier',
            'description' => 'View Description',
            'content' => 'View Content'
        ));
        $view->save();

        $layout = LayoutModel::fromArray(array(
            'name' => 'Layout Name',
            'identifier' => 'Layout identifier',
            'description' => 'Layout Description',
            'content' => 'Layout Content'
        ));
        $layout->save();

        $user = UserModel::fromArray(array(
            'lastname' => 'User test',
            'firstname' => 'User test',
            'email' => 'test@test.com',
            'login' => 'test',
            'user_acl_role_id' => 1,
        ));

        $user->setPassword('test');
        $user->save();

        $document_type = DocumentTypeModel::fromArray(array(
            'name' => 'Document Type Name',
            'description' => 'Document Type description',
            'icon_id' => 1,
            'default_view_id' => $view->getId(),
            'user_id' => $user->getId(),
        ));

        $document_type->save();

        $document = DocumentModel::fromArray(array(
            'name' => 'Document name',
            'url_key' => 'url-key',
            'status' => DocumentModel::STATUS_ENABLE,
            'show_in_nav' => TRUE,
            'user_id' => $user->getId(),
            'document_type_id' => $document_type->getId(),
            'view_id' => $view->getId(),
            'layout_id' => $layout->getId(),
            'parent_id' => 0
        ));

        $document->save();
        $collection = new DocumentCollection();
        $collection->load(0);
        $this->assertEquals(sprintf('<ul><li><a href="#tabs-%d">Document name</a></li></ul>', $document->getId()), $this->_object->render($collection->getChildren()));
    }

    /**
     * @covers Gc\Component\Tabs::render
     */
    public function testRenderWithParams()
    {
        $this->assertEquals('<ul><li><a href="#tabs-1">string</a></li></ul>', $this->_object->render(array('string')));
    }

    /**
     * @covers Gc\Component\Tabs::render
     */
    public function testRenderWithoutParams()
    {
        $this->_object->setData(array('string'));
        $this->assertEquals('<ul><li><a href="#tabs-1">string</a></li></ul>', $this->_object->render());
    }

    /**
     * @covers Gc\Component\Tabs::__toString
     */
    public function test__toStringWithEmptyData()
    {
        $this->_object->setData(array());
        $this->assertFalse($this->_object->__toString());
    }

    /**
     * @covers Gc\Component\Tabs::__toString
     */
    public function test__toStringWithoutEmptyData()
    {
        $this->_object->setData(array('string'));
        $this->assertEquals('<ul><li><a href="#tabs-1">string</a></li></ul>', $this->_object->__toString());
    }

    /**
     * @covers Gc\Component\Tabs::setData
     */
    public function testSetData()
    {
        $this->_object->setData(array('string'));
        $this->assertEquals('<ul><li><a href="#tabs-1">string</a></li></ul>', $this->_object->__toString());
    }
}
