<?php
namespace Recipe\Model;
use RedBean_SimpleModel;

class Model_Recipe extends RedBean_SimpleModel {
	protected $_id;
	protected $_chef;
	protected $_title;
	protected $_titleTag;
	protected $_ingredients;
	
	public function __construct(array $data = null) {
		if (is_array($data) && $data != null) {
			$this->_id	= (isset($data['id'])) ? $data['id'] : null;
			$this->_chef = (isset($data['chef'])) ? $data['chef'] : null;
			$this->_title = (isset($data['title'])) ? $data['title'] : null;
			$this->_titleTag = (isset($data['titleTag'])) ? $data['titleTag'] : null;
			$this->_ingredients = (isset($data['ingredients'])) ? $data['ingredients'] : null;
		}
	}
	
	public function getId() {
		return $this->_id;
	}
	
	public function setId($id) {
		$this->_id = $id;
		return $this;
	}
	
	public function getChef() {
		return $this->_chef;
	}
	
	public function setChef($chef) {
		$this->_chef = $chef;
		return $this;
	}
	
	public function getTitle() {
		return $this->_title;
	}
	
	public function setTitle($title) {
		$this->_title = $title;
		return $this;
	}
	
	public function getTitleTag() {
		return $this->_titleTag;
	}
	
	public function setTitleTag($titleTag) {
		$this->_titleTag = $titleTag;
		return $this;
	}
	
	public function getIngredients() {
		return $this->_ingredients;
	}
	
	public function setIngredients(array $ingredients = null) {
		if(is_array($ingredients) && $ingredients != null)
			$this->_ingredients = $ingredients;
		return $this;
	}
}?>