<?php

namespace Cyberpunkspike\AutoRefreshCache\Cron;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\App\Cache\Manager as CacheManager;

use Magento\Framework\App\Cache\TypeListInterface as CacheTypeListInterface;


class RefreshCache
{

    protected $logger;

    /**
     * Constructor
     *
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
    )
    {
        $this->cacheTypeList = $cacheTypeList;
        $this->cacheFrontendPool = $cacheFrontendPool;
        $this->logger = $logger;

    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $invalidcache = $this->cacheTypeList->getInvalidated();
        foreach($invalidcache as $key => $value) {
          $this->cacheTypeList->cleanType($key);
          $this->logger->addInfo("RefreshCache Cleaned $key");
        }

    }
}

