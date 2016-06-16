<?php

class Shopware_Controllers_Widgets_Tawk extends Enlight_Controller_Action
{


    public function indexAction()
    {
        $this->View()->shopName = $this->container->get('shop')->getName();
        $this->View()->tawkUrl = $this->container->get('config')->get('tawk_id');

        if ($this->container->get('session')->offsetExists('sUserId')) {
            if (version_compare(Shopware::VERSION, '5.1', '>') or Shopware::VERSION == '___VERSION___') {
                $userData = $this->container->get('dbal_connection')->fetchAssoc('SELECT email, CONCAT(firstname, " ", lastname) as name, customernumber FROM s_user WHERE id = ?', [
                    $this->container->get('session')->offsetGet('sUserId')
                ]);
            } else {
                $userData = $this->container->get('dbal_connection')->fetchAssoc('SELECT s_user.email, CONCAT(s_user_billingaddress.firstname, " ", s_user_billingaddress.lastname) as name, s_user_billingaddress.customernumber FROM s_user LEFT JOIN s_user_billingaddress ON(s_user_billingaddress.userID = s_user.id) WHERE s_user.id = ?', [
                    $this->container->get('session')->offsetGet('sUserId')
                ]);
            }
            $this->View()->userData = $userData;
        }
    }
}
