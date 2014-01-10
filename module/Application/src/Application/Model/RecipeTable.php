<?php

namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Recipe\Model\RecipeImageUpload;
use Zend\Db\ResultSet\HydratingResultSet;

class RecipeTable extends AbstractTableGateway
{
	protected $table = 'recipe';
	
	public function __construct(Adapter $adapter)
		{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet();
		$this->resultSetPrototype->setArrayObjectPrototype(new Recipe());
		$this->initialize();
		}
	
	public function fetchLiterallyAll()
		{  
		$resultSet = $this->select(); 
		return $resultSet;
		}
	public function fetchAll($email)
		{  
		
		$resultSet = $this->select(function (Select $select) use ($email)  {
			$select->where(array('author' => $email));
		}); 
		return $resultSet;
		}
	
	public function getRecipe($id)
		{
		$id  = (int) $id;
		$rowset = $this->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
		}
	
	public function findRecipe($email)
		{
		$rowset =$this->select(function (Select $select) use ($email)  {
			$select->where(array('author' => $email));
		});
		
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $email");
		}
		return $row;
		}
	
	public function saveRecipe(Recipe $recipe)
		{
		$data = array(
			'title' => $recipe->title,
			'author'=>$recipe->author,
			'preptime'=>$recipe->preptime,
			'cooktime'=>$recipe->cooktime,
			'servings'=>$recipe->servings,
			'ingredients'=>$recipe->ingredients,
			'method'=>$recipe->method,
			'visibility'=>$recipe->visibility,		
		);
		
		$id = (int)$recipe->id;
		if ($id == 0) {
			$this->insert($data);
		} else {
			if ($this->getRecipe($id)) {
				$this->update($data, array('id' => $id));
			} else {
				throw new \Exception('Form id does not exist');
			}
		}
		}
	
	public function addRecipeImage(RecipeImageUpload $recipe)
		{
		$data = array(
			'image' => $recipe->path,
		);
		if ($this->findRecipe($recipe->author)) {
			$this->update($data, array('title' => $recipe->recipename, 'author' => $recipe->author));
		} else {
			throw new \Exception('Form id does not exist');
		}
		}
	
	
	public function deleteRecipe($id)
		{
		$this->delete(array('id' => $id));
		}
}