<?php
namespace RecipeTest\Model;

use Recipe\Model\Recipe;
use PHPUnit_Framework_TestCase;

/**
 * Testing only the constructor and get methods
 */
class RecipeModelTest extends PHPUnit_Framework_TestCase {
	public function testAllKeysArePresentAndCorrect() {
		$data = array(
			'id' => 1,
			'chef' => 'ramsay',
			'title' => 'wild garlic and mushroom risotto',
			'titleTag' => 'risotto',
			'ingredients' => array ('mushroom', 'garlic', 'rice', 'butter', 'seasoning')
		);
		
		$recipe = new Recipe($data);
		
		$this->assertSame($data['id'],$recipe->getId(), '"id" was not correctly set');
		$this->assertSame($data['chef'],$recipe->getChef(), '"chef" was not correctly set');
		$this->assertSame($data['title'],$recipe->getTitle(), '"title" was not correctly set');
		$this->assertSame($data['titleTag'],$recipe->getTitleTag(), '"titleTag" was not correctly set');
		$this->assertSame($data['ingredients'],$recipe->getIngredients(), '"ingredients" was not correctly set');
	}
	
	public function testAllKeysAreNotPresent() {
		$data = array(
			'id' => 1,
			'chef' => 'ramsay',
			'title' => 'wild garlic and mushroom risotto',
		);
		$recipe = new Recipe($data);
		
		$this->assertSame($data['chef'],$recipe->getChef(), '"chef" was not correctly set');
		$this->assertSame($data['id'],$recipe->getId(), '"id" was not correctly set');
		$this->assertSame($data['title'],$recipe->getTitle(), '"title" was not correctly set');
		$this->assertNull($recipe->getTitleTag(), '"titleTag" should be null');
		$this->assertNull($recipe->getIngredients(), '"ingredients" should be null');
	}
}?>