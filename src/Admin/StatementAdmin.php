<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Statements;
use App\Entity\Categories;

class StatementAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        
        // get the current Image instance
        $statement = $this->getSubject();

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = ['required' => false];
        if ($statement) {
            // get the container so the full path to the image can be set
            $container = $this->getConfigurationPool()->getContainer();
            $fullPath = $this->getConfigurationPool()->getContainer()->getParameter('screenshots_directory') . '/' . $statement->getScreenshot();

            // add a 'help' option containing the preview's img tag
            $fileFieldOptions['help'] = '<img src="'.$fullPath.'" class="admin-preview" />';
        }
        
        $formMapper
            ->add('name', TextType::class)
            ->add('description', TextareaType::class, array(
            'attr' => array('class' => 'tinymce')))
            ->add('category_id', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'required' => true
            ])
            ->add('content', CKEditorType::class) 
            ->add('update_date', DateTimeType::class, [
                'widget' => 'choice',
            ])    
            ->add('seo_path', TextType::class, [
                'required' => true
            ])
            ->add('enable', CheckboxType::class, [
                'label'    => 'Show this entry publicly?',
                'required' => false
            ])
            ->add('screenshot', FileType::class, [
                'label' => 'Скрин документа',
                'data_class' => null,
                'help' => $fileFieldOptions['help']
            ])
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        //$datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name')->add('seo_path')->add('enable');
    }
}