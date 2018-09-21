<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class MemberListModel extends RelationModel{
	protected $_link=array(
		'Auth_group' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'Auth_group',
			'foreign_key'   => 'member_list_groupid',
			'as_fields'  => 'title',
		),
		'Userinfo' => array(
			'mapping_type'  => self::BELONGS_TO,
			'class_name'    => 'Userinfo',
			'foreign_key'   => 'member_list_userinfoid',
			'as_fields'  => 'member_name',
		),
	);

}
?>