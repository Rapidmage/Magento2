<?php
 
namespace Rapidmage\Firewall\Model;
 
use Magento\Framework\Model\AbstractModel;
 
class Ip extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('Rapidmage\Firewall\Model\ResourceModel\Ip');
    }
}
