<?php
class Es_Model_DbTable_Tab_Collection extends Es_Db_Table
{
	protected $_name = 'tabs';

	public function init($document_type_id = NULL)
	{
		$this->setDocumentTypeId($document_type_id);
	}

	public function getTabs($force_reload = FALSE)
	{
		$tabs = $this->getData('tabs');
		$document_type_id = $this->getDocumentTypeId();
		if(empty($tabs) or $force_reload == TRUE)
		{
			$select = $this->select();
			if(!empty($document_type_id))
			{
				$select->where('document_type_id = ?', $document_type_id);
			}

			$rows = $this->fetchAll($select);
			$tabs = array();
			foreach($rows as $value)
			{
				$tabs[] = Es_Model_DbTable_Tab_Model::fromArray($value);
			}

			$this->setData('tabs', $tabs);
		}

		return $this->getData('tabs');
	}

	public function setTabs(Array $tabs)
	{
		$array = array();
		foreach($tabs as $tab)
		{
			$array[] = Es_Model_DbTable_Tab_Model::fromArray($tab);
		}

		$this->setData('tabs', $array);
	}

	public function addTab(Array $tab)
	{
		$tabs = $this->getTabs();
		$tabs[] = Es_Model_DbTable_Tab_Model::fromArray($tab);

		$this->setData('tabs', $tabs);
	}

	public function save()
	{
		$tabs = $this->getTabs();
		foreach($tabs as $tab)
		{
			$tab->save();
		}
	}
}
