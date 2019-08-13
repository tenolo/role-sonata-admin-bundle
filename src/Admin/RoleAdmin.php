<?php

namespace Tenolo\Bundle\RoleAdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Tenolo\Bundle\UserBundle\Form\Type\Entities\UserEntityType;
use Tenolo\Bundle\UserBundle\Form\Type\Entities\UserGroupEntityType;

/**
 * Class RoleAdmin
 *
 * @package Tenolo\Bundle\RoleAdminBundle\Admin
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class RoleAdmin extends AbstractAdmin
{

    /**
     * @inheritdoc
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name', TextType::class)
                ->add('internalName', TextType::class)
            ->end()
            ->with('Assignments')
                ->add('userGroups', UserGroupEntityType::class, [
                    'label'    => 'Benuter-Gruppen',
                    'multiple' => true,
                    'attr'     => [
                        'class' => 'dual-list',
                    ]
                ])
                ->add('users', UserEntityType::class, [
                    'label'    => 'Benuter',
                    'multiple' => true,
                    'attr'     => [
                        'class' => 'dual-list',
                    ]
                ])
            ->end()
            ->with('Settings')
                ->add('deletable', CheckboxType::class, [
                    'label'    => 'Rolle kann gelöscht werden.',
                    'required' => false,
                    'attr'     => [
                        'align_with_widget' => true
                    ]
                ])
                ->add('priority', IntegerType::class, [
                    'label'       => 'Priorität',
                    'constraints' => [
                        new NotBlank()
                    ],
                    'attr'        => [
                        'help_text' => 'Umso höher der Wert, desto mehr Priorität bestitzt diese Rolle'
                    ]
                ])
                ->add('internalName', TextType::class)
            ->end();
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    /**
     * @inheritdoc
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name');
        $listMapper->add('internalName');
        $listMapper->add('priority');
        $listMapper->add('deletable', null, array('editable' => true));
    }
}
