<?php
 
namespace Rapidmage\Firewall\Model\ResourceModel;
 
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
 
class Ip extends AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('rapidmage_firewall', 'id');
    }
}
