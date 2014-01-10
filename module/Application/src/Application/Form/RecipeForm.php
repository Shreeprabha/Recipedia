<?php

namespace Application\Form;

use Zend\Form\Form;

class RecipeForm extends Form
{
	public function __construct($name = null)
		{
		// we want to ignore the name passed
		parent::__construct('post');
		$this->setAttribute('method', 'post');
		
		$this->add(array(
			'name' => 'id',
			'attributes' => array(
				'type'  => 'hidden',
			),
		));
		$this->add(array(
			'name' => 'title',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label' => 'Title',
			),
		));
		$this->add(array(
			'name' => 'preptime',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label' => 'Prep Time',
			),
		));
		$this->add(array(
			'name' => 'cooktime',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label' => 'Cook Time',
			),
		));
		$this->add(array(
			'name' => 'servings',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label' => 'Servings',
			),
		));
		
		$this->add(array(
			'name' => 'ingredients',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label' => 'Ingredients',
			),
		));
		
		$this->add(array(
			'name' => 'author',
			'attributes' => array(
				'type'  => 'hidden',
			),
		));
		$this->add(array(
			'name' => 'method',
			'attributes' => array(
				'type'  => 'textarea',
			),
			'options' => array(
				'label' => 'Method',
			),
		));
		$this->add(array(
			'name' => 'visibility',
			'attributes' => array(
				'type'  => 'text',
			),
			'options' => array(
				'label' => 'Visibility',
			),
		));
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type'  => 'submit',
				'value' => 'Go',
				'id' => 'submitbutton',
			),
		));
		}
}
