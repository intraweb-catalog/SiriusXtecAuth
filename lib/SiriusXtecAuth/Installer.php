<?php

/**
 * Zikula Application Framework
 *
 * @license    GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @author     Joan Guillén i Pelegay (jguille2@xtec.cat)
 * 
 * @category   Sirius Modules
 */

class SiriusXtecAuth_Installer extends Zikula_AbstractInstaller
{
    /**
    * Initialise SiriusXtecAuth module.
    */
    public function install()
    {
        // create module vars
        // ldap configuration
        $this->setVars(array('ldap_server'  => 'host.domain',
                             'ldap_basedn'  => 'cn=users,dc=host,dc=domain',
                             'ldap_searchattr' => 'cn'));
        // module configutation
        $defaultGroupId = ModUtil::getVar('Groups', 'defaultgroup');
        $initGroups = array($defaultGroupId);
        $this->setVars(array('ldap_active' => false,
                             'users_creation' => false,
                             'new_users_activation' => false,
                             'new_users_groups' => $initGroups,
                             'iw_write' => false,
                             'iw_lastnames' => false));
        // register handler
        EventUtil::registerPersistentModuleHandler('SiriusXtecAuth', 'module.users.ui.login.failed', array('SiriusXtecAuth_Listeners', 'trySiriusXtecAuth'));
        // finish
        return true;
    }
    /**
    * Remove SiriusXtecAuth module and all associative information.
    */
    public function uninstall()
    {
        $this->delVars;
        EventUtil::unregisterPersistentModuleHandler('SiriusXtecAuth');
        return true;
    }
    public function upgrade($oldversion)
    {
        return true;
    }
}

