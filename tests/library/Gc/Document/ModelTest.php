<?php
namespace Gc\Document;

use Gc\DocumentType\Model as DocumentTypeModel,
    Gc\Layout\Model as LayoutModel,
    Gc\User\Model as UserModel,
    Gc\View\Model as ViewModel;
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-17 at 20:40:09.
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 * @group Gc
 */
class ModelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Model
     */
    protected $_object;

    /**
     * @var Model
     */
    protected $_parentModel;

    /**
     * @var ViewModel
     */
    protected $_view;

    /**
     * @var LayoutModel
     */
    protected $_layout;

    /**
     * @var UserModel
     */
    protected $_user;

    /**
     * @var DocumentTypeModel
     */
    protected $_documentType;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_view = ViewModel::fromArray(array(
            'name' => 'View Name',
            'identifier' => 'View identifier',
            'description' => 'View Description',
            'content' => 'View Content'
        ));
        $this->_view->save();

        $this->_layout = LayoutModel::fromArray(array(
            'name' => 'Layout Name',
            'identifier' => 'Layout identifier',
            'description' => 'Layout Description',
            'content' => 'Layout Content'
        ));
        $this->_layout->save();

        $this->_user = UserModel::fromArray(array(
            'lastname' => 'User test',
            'firstname' => 'User test',
            'email' => 'test@test.com',
            'login' => 'test',
            'user_acl_role_id' => 1,
        ));

        $this->_user->setPassword('test');
        $this->_user->save();

        $this->_documentType = DocumentTypeModel::fromArray(array(
            'name' => 'Document Type Name',
            'description' => 'Document Type description',
            'icon_id' => 1,
            'default_view_id' => $this->_view->getId(),
            'user_id' => $this->_user->getId(),
        ));

        $this->_documentType->save();

        $this->_parentModel = Model::fromArray(array(
            'name' => 'Document name',
            'url_key' => 'parent',
            'status' => Model::STATUS_ENABLE,
            'show_in_nav' => TRUE,
            'user_id' => $this->_user->getId(),
            'document_type_id' => $this->_documentType->getId(),
            'view_id' => $this->_view->getId(),
            'layout_id' => $this->_layout->getId(),
            'parent_id' => 0
        ));
        $this->_parentModel->save();

        $this->_object = Model::fromArray(array(
            'name' => 'Document name',
            'url_key' => 'url-key',
            'status' => Model::STATUS_ENABLE,
            'show_in_nav' => TRUE,
            'user_id' => $this->_user->getId(),
            'document_type_id' => $this->_documentType->getId(),
            'view_id' => $this->_view->getId(),
            'layout_id' => $this->_layout->getId(),
            'parent_id' => $this->_parentModel->getId()
        ));

        $this->_object->save();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        $this->_object->delete();
        unset($this->_object);

        $this->_view->delete();
        unset($this->_view);

        $this->_layout->delete();
        unset($this->_layout);

        $this->_documentType->delete();
        unset($this->_documentType);

        $this->_user->delete();
        unset($this->_user);
    }

    /**
     * @covers Gc\Document\Model::init
     */
    public function testInit()
    {
        $id = $this->_object->getId();
        $this->_object->init($id);
        $this->assertEquals($id, $this->_object->getId());
    }

    /**
     * @covers Gc\Document\Model::getView
     */
    public function testGetView()
    {
        $this->assertInstanceOf('Gc\View\Model', $this->_object->getView());
    }

    /**
     * @covers Gc\Document\Model::getDocumentType
     */
    public function testGetDocumentType()
    {
        $this->assertInstanceOf('Gc\DocumentType\Model', $this->_object->getDocumentType());
    }

    /**
     * @covers Gc\Document\Model::showInNav
     */
    public function testShowInNav()
    {
        $this->_object->showInNav(TRUE);
        $this->assertTrue($this->_object->showInNav());
    }

    /**
     * @covers Gc\Document\Model::isPublished
     */
    public function testIsPublished()
    {
        $this->_object->setStatus(Model::STATUS_ENABLE);
        $this->assertTrue($this->_object->isPublished());
    }

    /**
     * @covers Gc\Document\Model::fromArray
     */
    public function testFromArray()
    {
        $model = Model::fromArray($this->_object->getData());
        $this->assertInstanceOf('Gc\Document\Model', $model);
    }

    /**
     * @covers Gc\Document\Model::fromId
     */
    public function testFromId()
    {
        $model = Model::fromId($this->_object->getId());
        $this->assertInstanceOf('Gc\Document\Model', $model);
    }

    /**
     * @covers Gc\Document\Model::fromId
     */
    public function testFromFakeId()
    {
        $model = Model::fromId(1000);
        $this->assertFalse($model);
    }

    /**
     * @covers Gc\Document\Model::fromUrlKey
     */
    public function testFromUrlKey()
    {
        $model = Model::fromUrlKey($this->_object->getUrlKey());
        $this->assertInstanceOf('Gc\Document\Model', $model);
    }

    /**
     * @covers Gc\Document\Model::fromUrlKey
     */
    public function testFromFakeUrlKey()
    {
        $model = Model::fromUrlKey($this->_object->getUrlKey(), 1000);
        $this->assertFalse($model);
    }

    /**
     * @covers Gc\Document\Model::save
     */
    public function testSave()
    {
        $this->assertInternalType('integer', $this->_object->save());
    }

    /**
     * @covers Gc\Document\Model::save
     */
    public function testSaveWithWrongValues()
    {
        $this->setExpectedException('Gc\Exception');
        $model = $this->_object->fromArray(array(
            'name' => 'Document name',
            'url_key' => NULL,
            'status' => Model::STATUS_ENABLE,
            'show_in_nav' => TRUE,
            'user_id' => NULL,
            'document_type_id' => NULL,
            'view_id' => NULL,
            'layout_id' => NULL,
            'parent_id' => NULL,
        ));
        $this->assertFalse($model->save());
    }

    /**
     * @covers Gc\Document\Model::delete
     */
    public function testDelete()
    {
        $this->assertTrue($this->_object->delete());
    }

    /**
     * @covers Gc\Document\Model::delete
     */
    public function testDeleteWithoutId()
    {
        $model = new Model();
        $this->assertFalse($model->delete());
    }

    /**
     * @covers Gc\Document\Model::delete
     */
    public function testDeleteWithException()
    {
        $this->setExpectedException('Gc\Exception');
        $model = new Model();
        $model->setId('test');
        $this->assertFalse($model->delete());
    }

    /**
     * @covers Gc\Document\Model::getUrl
     */
    public function testGetUrl()
    {
        $this->assertEquals('/parent/url-key', $this->_object->getUrl());
    }

    /**
     * @covers Gc\Document\Model::getName
     */
    public function testGetName()
    {
        $this->assertEquals('Document name', $this->_object->getName());
    }

    /**
     * @covers Gc\Document\Model::getId
     */
    public function testGetId()
    {
        $this->assertInternalType('integer', $this->_object->getId());
    }

    /**
     * @covers Gc\Document\Model::getParent
     */
    public function testGetParent()
    {
        $this->assertInstanceOf('Gc\Document\Model', $this->_object->getParent());
    }

    /**
     * @covers Gc\Document\Model::getChildren
     */
    public function testGetChildren()
    {
        $this->assertInternalType('array', $this->_object->getChildren());
    }

    /**
     * @covers Gc\Document\Model::getAvailableChildren
     */
    public function testGetAvailableChilren()
    {
        $this->assertInternalType('array', $this->_object->getAvailableChildren());
    }

    /**
     * @covers Gc\Document\Model::getProperty
     */
    public function testGetPropertyWithOutId()
    {
        $fake_model = new Model();
        $this->assertFalse($fake_model->getProperty('fake_property'));
    }

    /**
     * @covers Gc\Document\Model::getProperty
     */
    public function testGetProperty()
    {
        $this->assertFalse($this->_object->getProperty('fake_property'));
    }

    /**
     * @covers Gc\Document\Model::getIcon
     */
    public function testGetIcon()
    {
        $this->assertEquals('/media/icons/home.png', $this->_object->getIcon());
    }
    /**
     * @covers Gc\Document\Model::getIcon
     */
    public function testGetEmptyIcon()
    {
        $this->_object->getDocumentType()->setIconId(42000);
        $this->assertFalse($this->_object->getIcon());
    }

    /**
     * @covers Gc\Document\Model::getIterableId
     */
    public function testGetIterableId()
    {
        $this->assertEquals('document_' . $this->_object->getId(), $this->_object->getIterableId());
    }

    /**
     * @covers Gc\Document\Model::getEditUrl
     */
    public function testGetEditUrl()
    {
        $this->assertInternalType('string', $this->_object->getEditUrl());
    }
}
