<?php

namespace AppBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController {

//	Usuario
	public function createNewUserEntity() {
		return $this->get( 'fos_user.user_manager' )->createUser();
	}

	public function prePersistUserEntity( $user ) {
		$this->get( 'fos_user.user_manager' )->updateUser( $user, false );
	}

	public function preUpdateUserEntity( $user ) {
		$this->get( 'fos_user.user_manager' )->updateUser( $user, false );
	}

//    Combo

	public function prePersistComboEntity( $entity ) {
		foreach ( $entity->getProductos() as $productoCombo ) {
			$productoCombo->setCombo( $entity );
		}
	}

	public function preUpdateComboEntity( $entity ) {
		$this->prePersistComboEntity( $entity );
	}
}
