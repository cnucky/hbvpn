<?php if (!defined('THINK_PATH')) exit();?><script language="javascript">
$(function(){
	var tableList="tableList_account";
	var auForm ="addForm_account";
	var saveBtn="saveBtn_account";
	var addDiv="addDiv_account";
	var cancelBtn="cancelBtn_account";
	
	var th = $(".top").height();
	th = 204-th
	var wh = $(window).height()-th;
	var pr = 30;
	var pn = false;
	if(pr>0){
		pn = true;
	}
	$("#"+tableList).datagrid({
		//title:'用户列表',
		idField:'id',
		fix:true, 
		height:wh,
		autoRowHeight:false,
		singleSelect:true,
		striped:true,
		method:'get',
		sortName:'id',
		sortOrder:'desc',
		rownumbers:true,
		pagination:pn,
		pageSize:pr,
		pageList:[30,50,80,100],
		url:'/hbvpn/Admin/Account/pageList',
		fitColumns:true,
		nowrap:true,
		selectOnCheck:false,
		animate:true,
		checkOnSelect:true,
		onBeforeLoad: function () {  
			
		},
		onDblClickRow:function(e,rowIndex,rowData){
			
		},
		toolbar:[{
		iconCls: 'fa fa-easyui fa-plus-square',
			text : '添加',
			handler: function(){
				$('#'+auForm).form('clear');
				$('#'+auForm).form('load',{
					
				});
				$("#"+addDiv).window('open');
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-edit',
			text : '编辑',
			handler: function(){
				var selectedRow=$('#'+tableList).datagrid('getSelected');
				if(null==selectedRow){
					$.message.alert('警告','请先选择一行！','warning');
				}else{
					$('#'+auForm).form('load',{
						'data[id]':selectedRow.id,
						'data[name]':selectedRow.name,
						'data[url]':selectedRow.url,
						'data[content]':selectedRow.content,
						'data[type]':selectedRow.type,
					});
					$("#"+addDiv).window('open');
				}
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-times',
			text : '删除',
			handler: function(){
				var selectedRow=$('#'+tableList).datagrid('getSelected');
				if(null==selectedRow){
					$.message.alert('警告','请先选择一行！','warning');
				}else{
					var ids=selectedRow.id;
					ajaxDelRowsDatagrid('/hbvpn/Admin/Account/delRows',ids,tableList);
				}
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-check-square-o',
			text : '取消选择',
			handler: function(){
				$('#'+tableList).datagrid('clearSelections'); 
			}
		},'-',{
			iconCls: 'fa fa-easyui fa-retweet',
			text : '重载',
			handler: function(){
				$("#"+tableList).datagrid('reload');
			}
		}],
		frozenColumns:[[   
		    
		]],
		columns:[[  
			{field:'ip',title:'IP',width:40,sortable:true},
			{field:'port',title:'端口',width:40,sortable:true},
			{field:'password',title:'密码',width:40,sortable:true},
			{field:'secret_way',title:'加密方式',width:40,sortable:true}
		]]
	});
	$("#"+saveBtn).click(function(){
		ajaxSubmitForm(auForm,'/hbvpn/Admin/Account/addOrUpdate',addDiv,tableList);
	});
	$("#"+cancelBtn).click(function(){
		$('#'+addDiv).window('close');
	});
});

</script>
<div>
 
	<table id="tableList_account"></table>

</div>
<div id="addDiv_account" class="easyui-window" title="添加" data-options="iconCls:'fa fa-dot-circle-o',closed:true" style="width:600px;height:360px;padding:5px;">
	<div class="easyui-layout" data-options="fit:true">
		<div data-options="region:'center',border:true">
			<form id="addForm_account" class="easyui-form" method="post" data-options="novalidate:true">
				<input name="data[id]" type="hidden" />
		    	<table cellpadding="5">
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">名称:</div></td>
		    			<td><input class="easyui-textbox" name="data[name]" data-options="required:true" style="width:455px;height:30px;" type="text"></input></td>
		    			
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">链接:</div></td>
		    			<td><input class="easyui-textbox" name="data[url]" data-options="required:true" style="width:455px;height:30px;" type="text"></input></td>
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">类型:</div></td>
		    			<td>
		    				<select id="type_account" name="data[type]" class="easyui-combobox" data-options="required:true" style="width:455px;height:30px;" ></select>
		    			</td>
		    		
		    		</tr>
		    		<tr>
		    			<td><div style="width:62px;text-align: right;">内容:</div></td>
		    			<td colspan="1"><input class="easyui-textbox" name="data[content]" data-options="multiline:true,required:true" style="height:100px;width:455px;"></input></td>
		    		</tr>
		    	</table>
		    </form>
		</div>
		<div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
			<a id="saveBtn_account" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-check'" href="javascript:void(0)" style="width:80px">保存</a>
			<a id="cancelBtn_account" class="easyui-linkbutton" data-options="iconCls:'fa fa-easyui fa-times'" href="javascript:void(0)" style="width:80px">取消</a>
		</div>
	</div>
</div>