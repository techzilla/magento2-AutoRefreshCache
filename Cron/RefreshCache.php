<?php

namespace Cyberpunkspike\AutoRefreshCache\Cron;

use Magento\Backend\App\Action\Context;


class RefreshCache
{

    /**
     * @var \Psr\Log\LoggerInterface
     */
     protected $_logger;

     /**
     * Constructor
     *
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
    )
    {
        $this->_cacheTypeList = $cacheTypeList;
        $this->_logger = $logger;

    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $invalidcache = $this->_cacheTypeList->getInvalidated();
        foreach($invalidcache as $key => $value) {
          $this->_cacheTypeList->cleanType($key);
          $this->_logger->info("Refresh Cache $key");
        }

    }
}

