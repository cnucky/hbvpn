<?php
namespace Admin\Model;
use Admin\Common\Model\CommonRelationModel;
class AccountModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_account';
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
    
    
    public static function pageListAccount($example,$beanName){
        $object = D($beanName);
        $order=$example['order'];
        $condition=$example['condition'];
        $pageBean=$example['pageBean'];
        $relation=$example['relation'];
        $result=$object->
            distinct(true)->
            field('a.id,a.port,a.password,a.secret_way,a.port,a.use_qq,a.use_time,a.start_time,v.id as vps_id,v.ip')->
            alias('a')->
            join('LEFT JOIN __VPS__ v ON v.id = a.vps_id')->
            where($condition)->
            order($order['sort'].' '.$order['order'])->
            page($pageBean['page'],$pageBean['rows'])->relation($relation)->select();
        return $result;
    }
    
    public static function countTotalAccount($example,$beanName){
        $condition=$example['condition'];
        return $count = D($beanName)->where($condition)->count();
    }
    
    
    public static function findRowByCondition($condition,$beanName){
        $object = D($beanName);
        $result=$object->
            distinct(true)->
            field('a.id,a.port,a.password,a.secret_way,a.port,v.id as vps_id,v.ip')->
            alias('a')->
            join('LEFT JOIN __VPS__ v ON v.id = a.vps_id')->
            where($condition)->find();
        return $result;
    }
    
    
    public function getAllList($example,$beanName){
        $condition=$example['condition'];
        $relation=$example['relation'];
        return D($beanName)->
                distinct(true)->
                field('a.id,a.port,a.password,a.secret_way,a.port,v.id as vps_id,v.ip')->
                alias('a')->
                join('LEFT JOIN __VPS__ v ON v.id = a.vps_id')->
            where($condition)->relation($relation)->select();
    }
}

?>