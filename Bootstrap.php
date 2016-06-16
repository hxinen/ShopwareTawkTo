<?php

class Shopware_Plugins_Frontend_ShopwareTawkTo_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    private $plugin_info = [
        'version' => '1.0.0',
        'label' => 'ShopwareTawkTo',
        'source' => null,
        'changes' => null,
        'license' => null,
        'revision' => null,
        'support' => 'https://github.com/shyim/ShopwareTawkTo/issues',
        'link' => 'https://github.com/shyim/ShopwareTawkTo',
        'autor' => 'Shyim',
    ];

    private $plugin_capabilities = [
        'install' => true,
        'update' => true,
        'enable' => true,
    ];

    private $invalidateCacheArray = [
        'config',
        'template'
    ];

    public function getVersion()
    {
        return $this->plugin_info['version'];
    }

    public function getLabel()
    {
        return $this->plugin_info['label'];
    }

    public function getInfo()
    {
        return $this->plugin_info;
    }

    public function getCapabilities()
    {
        return $this->plugin_capabilities;
    }

    public function install()
    {
        if (!$this->assertMinimumVersion('5')) {
            throw new Exception("Only Shopware 5 upper is supported");
        }

        $this->registerController('Widgets', 'Tawk');
        $this->subscribeEvent('Enlight_Controller_Action_PostDispatchSecure_Frontend', 'onControllerActionPostDispatchSecureFrontend');
        $this->createPluginConfig();


        return [
            'success' => true,
            'invalidateCache' => $this->invalidateCacheArray,
        ];
    }

    public function enable()
    {
        return [
            'success' => true,
            'invalidateCache' => $this->invalidateCacheArray,
        ];
    }

    public function onControllerActionPostDispatchSecureFrontend(Enlight_Event_EventArgs $args)
    {
        $args->get('subject')->View()->addTemplateDir($this->Path() . '/Views/');
    }

    public function getDefaultControllerPath(Enlight_Event_EventArgs $arguments)
    {
        $this->disableControllerCache();
        return parent::getDefaultControllerPath($arguments);
    }

    private function createPluginConfig()
    {
        $form = $this->Form();

        $form->setElement('text', 'tawk_id', [
            'label' => 'Tawk.to URL',
            'value' => 'https://embed.tawk.to/XXXXXXXXXXXXXXXXXX/default'
        ]);
    }
}
