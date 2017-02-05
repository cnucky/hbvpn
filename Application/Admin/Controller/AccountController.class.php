<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
use Org\Util\Date;
class AccountController extends CommonController {
	public $phpbean="Account";
    
    public function pageList(){
    	$beanName=$this->phpbean;
		
    	$pageBean['rows']=$_GET['rows'];
    	$pageBean['page']=$_GET['page'];
    	$example['pageBean']=$pageBean;
    	
    	$order['sort']=$_GET['sort'];
    	$order['order']=$_GET['order'];
    	$example['order']=$order;
    	
    	$example['relation']=true;
    	
    	$example['condition']=$condition;
    	
    	$rtr = D($beanName)->pageListAccount($example,$beanName);
    	$total= D($beanName)->countTotalAccount($example,$beanName);
    	
    	$data=array(
    			'rows' => $rtr,
    			'total' => $total
    	);
    	$this->ajaxReturn($data);
    	
    }
    
    public function addOrUpdate(){
    	$user_id=self::getSessionUserId();
    	try {
    		$beanName=$this->phpbean;
    		$data=$_POST['data'];
    		$rtr['flag']=true;
    		if ($data['id']>0){
    			$data['update_time']=time();
    			$data['update_user']=$user_id;
    			$rtr['object'] = D($beanName)->updateRow($data,$beanName);
    			$rtr['msg']="更新成功";
    			$this->ajaxReturn($rtr);
    		}else{
    			$data['create_time']=time();
    			$data['create_user']=$user_id;
    			$rtr['object']= D($beanName)->addRow($data,$beanName);
    			$rtr['msg']="添加成功";
    			$this->ajaxReturn($rtr);
    		}
    	} catch (\Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function addRows(){
        $user_id=self::getSessionUserId();
        $list=array();
        try {
            $beanName=$this->phpbean;
            $data=$_POST['data'];
            $data['vps_id']=$_POST['vps_id'];
            $data['secret_way']=$_POST['secret_way'];
            $count=$_POST['vps_count'];
            $rtr['flag']=true;
            if ($data['id']>0){
                $data['update_time']=time();
                $data['update_user']=$user_id;
                $rtr['object'] = D($beanName)->updateRow($data,$beanName);
                $rtr['msg']="更新成功";
                $this->ajaxReturn($rtr);
            }else{
                if (empty($count)){
                    $count=1;
                }
                $condition['vps_id']=$data['vps_id'];
                D($beanName)->delRowsByCondition($condition,$beanName);
                
                $ip="";
                $port_password="";
                $comment="";
                
                for ($i=0;$i<$count;$i++){
                    $data['password']=getLengthNum(8).getLengthNum(8);
                    $data['port']=40001+$i;
                    $data['create_time']=time();
                    $data['create_user']=$user_id;
                    $object_id= D($beanName)->addRow($data,$beanName);
                    $condition['a.id']=$object_id;
                    $row=D($beanName)->findRowByCondition($condition,$beanName);
                    
                    if(($i+1)==$count){
                        $ip=$row['ip'];
                        $port_password=$port_password."".$row['port'].":".$row['password'];
                        $comment=$comment."".$row['port'].":xiao".$row['port'];
                    }else {
                        $ip=$row['ip'];
                        $port_password=$port_password."".$row['port'].":".$row['password'].',';
                        $comment=$comment."".$row['port'].":xiao".$row['port'].',';
                    }
                    
//                     $data['id']=$rtr['object'];
                    array_push($list, $row);
                }
                
                $rtr['rows']=$list;
                $rtr['ss_config']=str_replace("%vps_ip%",$ip,C('SS_CONFIG_MODEL'));
                $rtr['ss_config']=str_replace("%port_password%",$port_password,$rtr['ss_config']);
                $rtr['ss_config']=str_replace("%comment%",$comment,$rtr['ss_config']);
                
                $this->ajaxReturn($rtr);
            }
        } catch (\Exception $e) {
            $rtr['flag']=false;
            $rtr['msg']="操作失败";
            $this->ajaxReturn($rtr);
        }
    }
    
    public function delRows(){
    	try {
    		$beanName=$this->phpbean;
    		$data=$_POST['data'];
    		$rtr['flag']=true;
    		$rtr['object']= D($beanName)->delRows($data,$beanName);
    		$rtr['msg']="操作成功";
    		$this->ajaxReturn($rtr);
    	} catch (\Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function getAll(){
    	$beanName=$this->phpbean;
    	$example['relation']=false;
    	 
    	$vps_id=$_POST['vps_id'];
    	if (!empty($vps_id)){
    	    $condition['vps_id']=$vps_id;
    	}
    	
    	$example['condition']=$condition;
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
    public function getAllByExample(){
        $beanName=$this->phpbean;
        $example['relation']=false;
    
        $vps_id=$_POST['vps_id'];
        if (!empty($vps_id)){
            $condition['a.vps_id']=$vps_id;
        }
         
        $example['condition']=$condition;
        $rtr=D($beanName)->getAllList($example,$beanName);
        $this->ajaxReturn($rtr);
    }
    
}