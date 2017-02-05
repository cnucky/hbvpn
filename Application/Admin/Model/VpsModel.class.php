<?php
namespace Admin\Model;
use Admin\Common\Model\CommonRelationModel;
class VpsModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_vps';
    protected $_link = array(
    		'createUser'=>array(
    				'mapping_type'  => self::BELONGS_TO,
    				'class_name'  => 'User',
    				'foreign_key' => 'create_user',
    				'mapping_name' => 'createUser'
    		),
    		'updateUser'=>array(
    				'mapping_type'  => self::BELONGS_TO,
    				'class_name'  => 'User',
    				'foreign_key' => 'update_user',
    				'mapping_name' => 'updateUser'
    		),
    );
    
    
    public static function pageListVps($example,$beanName){
        $object = D($beanName);
        $order=$example['order'];
        $condition=$example['condition'];
        $pageBean=$example['pageBean'];
        $relation=$example['relation'];
        $result=$object->
            distinct(true)->
            field('v.id,v.ip,v.sshport,v.account,v.password,v.server_id,s.name as serverName,1 as action')->
            alias('v')->
            join('LEFT JOIN __SERVER__ s ON s.id = v.server_id')->
            where($condition)->
            order($order['sort'].' '.$order['order'])->
            page($pageBean['page'],$pageBean['rows'])->relation($relation)->select();
        return $result;
    }
    
    public static function countTotalVps($example,$beanName){
        $condition=$example['condition'];
        return $count = D($beanName)->where($condition)->count();
    }
    
    
    public static function updateSSConfigVps($data,$beanName){
        return $count = D($beanName)->field('ss_config')->save($data);
    }
    
    public static function findRowByCondition($condition,$beanName){
        $object = D($beanName);
        $result=$object->
        where($condition)->find();
        return $result;
    }
}

?>