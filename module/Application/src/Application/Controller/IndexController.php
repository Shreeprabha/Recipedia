<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\File\Size;

use Application\Model\RecipeImageUpload;
use Application\Form\UploadRecipeImageForm;
use Application\Model\RecipeTable;   
use Application\Form\RecipeForm;

class IndexController extends AbstractActionController
{
	
	protected $recipeTable;
	
	public function getRecipeTable(){
		if (!$this->recipeTable) {
			$sm = $this->getServiceLocator();
			$this->recipeTable = $sm->get('Application\Model\RecipeTable');
		}
		return $this->recipeTable;
	}
	
	public function indexAction(){
	
		return new ViewModel(array(
			'recipes' => $this->getRecipeTable()->fetchAll($this->zfcUserAuthentication()->getIdentity()->getEmail()),
		));
	}
	
	public function uploadAction() {
		$form = new UploadRecipeImageForm();
		$request = $this->getRequest();  
		if ($request->isPost()) {
			
			$recipeImageUpload = new RecipeImageUpload();
			$form->setInputFilter($recipeImageUpload->getInputFilter());
			
			$nonFile = $request->getPost()->toArray();
			$File    = $this->params()->fromFiles('fileupload');
			$data = array_merge(
				$nonFile,
				array('fileupload'=> $File['name'])
			);
			$form->setData($data);
			if ($form->isValid()) {
				
				$size = new Size(array('min'=>20000)); //minimum bytes filesize
				
				$adapter = new \Zend\File\Transfer\Adapter\Http(); 
				$adapter->setValidators(array($size), $File['name']);
				if (!$adapter->isValid()){
					$dataError = $adapter->getMessages();
					$error = array();
					foreach($dataError as $key=>$row)
					{
						$error[] = $row;
					}
					$form->setMessages(array('fileupload'=>$error ));
				} else {
					$adapter->setDestination(dirname(__DIR__).'/assets');
					if ($adapter->receive($File['name'])) {
						$recipeImageUpload->exchangeArray($form->getData());
						$recipeImageUpload->author = $this->zfcUserAuthentication()->getIdentity()->getEmail();
						$this->getRecipeTable()->addRecipeImage($recipeImageUpload);
						return $this->redirect()->toRoute('recipe');
					}
				}  
			} 
		}
		
		
		return array('form' => $form);	
		
	}
	
	public function addAction()	{
		$form = new RecipeForm();
		$form->get('submit')->setValue('Add');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$recipe = new Recipe();
			$form->setInputFilter($recipe->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$recipe->exchangeArray($form->getData());
				$this->getRecipeTable()->saveRecipe($recipe);
				
				return $this->redirect()->toRoute('recipe');
			}  
			
		}
		return array('form' => $form);
	}
	
	public function editAction()
		{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('recipe', array(
				'action' => 'add'
			));
		}
		$recipe = $this->getRecipeTable()->getRecipe($id);
		
		$form  = new RecipeForm();
		$form->bind($recipe);
		$form->get('submit')->setAttribute('value', 'Edit');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($recipe->getInputFilter());
			$form->setData($request->getRecipe());
			
			if ($form->isValid()) {
				$this->getRecipeTable()->saveRecipe($recipe);
				
				return $this->redirect()->toRoute('recipe');
			}
		}
		
		return array(
			'id' => $id,
			'form' => $form,
		);
		}
	
	public function deleteAction()
		{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('recipe');
		}
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$del = $request->getRecipe('del', 'No');
			
			if ($del == 'Yes') {
				$id = (int) $request->getRecipe('id');
				$this->getRecipeTable()->deletePost($id);
			}
			
			// Redirect to list of albums
			return $this->redirect()->toRoute('recipe');
		}
		
		return array(
			'id'    => $id,
			'recipe' => $this->getRecipeTable()->getRecipe($id)
		);
		}   
	
}