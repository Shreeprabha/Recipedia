<?php

namespace Application\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Form\Element\File;

class Recipe implements InputFilterAwareInterface
{
    public $id;
    public $title;
    public $image;
    public $preptime;
    public $cooktime;
    public $servings;
    public $ingredients;
    public $method;
    public $visibility;
    public $author;

	protected $inputFilter;
	
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->title  = (isset($data['title'])) ? $data['title'] : null;
        $this->author = (isset($data['author'])) ? $data['author'] : null;
        $this->preptime     = (isset($data['preptime'])) ? $data['preptime'] : null;
        $this->cooktime     = (isset($data['cooktime'])) ? $data['cooktime'] : null;
        $this->servings     = (isset($data['servings'])) ? $data['servings'] : null;
        $this->ingredients     = (isset($data['ingredients'])) ? $data['ingredients'] : null;
        $this->method     = (isset($data['method'])) ? $data['method'] : null;
        $this->visibility     = (isset($data['visibility'])) ? $data['visibility'] : null;       
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

           
			
			$inputFilter->add($factory->createInput(array(
                'name'     => 'author',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'EmailAddress',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 8,
                        ),
                    ),
                ),
            )));
			
			
            $inputFilter->add($factory->createInput(array(
                'name'     => 'preptime',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'cooktime',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                   
                ),
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'servings',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                   
                ),
            )));
             $inputFilter->add($factory->createInput(array(
                'name'     => 'ingredients',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                        ),
                    ),
                ),
            )));
             $inputFilter->add($factory->createInput(array(
                'name'     => 'method',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                        ),
                    ),
                ),
            )));
             $inputFilter->add($factory->createInput(array(
                'name'     => 'visibility',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                        ),
                    ),
                ),
            )));
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}