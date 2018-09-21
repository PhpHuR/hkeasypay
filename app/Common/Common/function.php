<?php
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
use Think\Db;
use Org\Util\Stringnew;
use Think\Storage;
use OT\File;

/**
 * 发送邮件
 * @author xiaofeng<1034023036@qq.com>
 */
function sendMail($to, $title, $content)
{
    $email_options = get_email_options();
    if ($email_options && $email_options['email_open']) {
        Vendor('PHPMailer.PHPMailerAutoload');
        $mail = new PHPMailer(); //实例化
        // 设置PHPMailer使用SMTP服务器发送Email
        $mail->IsSMTP();
        $mail->Mailer = 'smtp';
        $mail->IsHTML(true);
        // 设置邮件的字符编码，若不指定，则为'UTF-8'
        $mail->CharSet = 'UTF-8';
        // 添加收件人地址，可以多次使用来添加多个收件人
        $mail->AddAddress($to);
        // 设置邮件正文
        $mail->Body = $content;
        // 设置邮件头的From字段。
        $mail->From = $email_options['email_name'];
        // 设置发件人名字
        $mail->FromName = $email_options['email_rename'];
        // 设置邮件标题
        $mail->Subject = $title;
        // 设置SMTP服务器。
        $mail->Host = $email_options['email_smtpname'];
        // 设置SMTPSecure。
        $mail->SMTPSecure = $email_options['smtpsecure'];
        // 设置SMTP服务器端口。
        $mail->Port = $email_options['smtp_port'];
        // 设置为"需要验证"
        $mail->SMTPAuth = true;
        // 设置用户名和密码。
        $mail->Username = $email_options['email_emname'];
        $mail->Password = $email_options['email_pwd'];
        // 发送邮件。
        if (!$mail->Send()) {
            $mailerror = $mail->ErrorInfo;
            return array("error" => 1, "message" => $mailerror);
        } else {
            return array("error" => 0, "message" => "success");
        }
    } else {
        return array("error" => 1, "message" => '未开启邮件发送或未配置');
    }
}

function subtext($text, $length)
{
    if (mb_strlen($text, 'utf8') > $length)
        return mb_substr($text, 0, $length, 'utf8') . '...';
    return $text;
}

/**
 * 格式化字节大小
 * @param  number $size 字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author xiaofeng<1034023036@qq.com>
 */
function format_bytes($size, $delimiter = '')
{
    $units = array(' B', ' KB', ' MB', ' GB', ' TB', ' PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}

/**
 * 递归重组节点信息为多维数组
 *
 * @param array $node
 * @param number $pid
 * @author xiaofeng<1034023036@qq.com>
 */
function node_merge(&$node, $pid = 0, $id_name = 'id', $pid_name = 'pid', $child_name = '_child')
{
    $arr = array();

    foreach ($node as $v) {
        if ($v [$pid_name] == $pid) {
            $v [$child_name] = node_merge($node, $v [$id_name], $id_name, $pid_name, $child_name);
            $arr [] = $v;
        }
    }

    return $arr;
}

/**
 * 数据表导出excel
 *
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param string $table ,不含前缀表名,必须
 * @param string $file ,保存的excel文件名,默认表名为文件名
 * @param string $fields ,需要导出的字段名,默认全部,以半角逗号隔开
 * @param string $field_titles ,需要导出的字段标题,需与$field一一对应,为空则表示直接以字段名为标题,以半角逗号隔开
 * @param stting $tag ,筛选条件 以字符串方式传入,例："limit:0,8;order:post_date desc,listorder desc;where:id>0;"
 *      limit:数据条数,可以指定从第几条开始,如3,8(表示共调用8条,从第3条开始)
 *      order:排序方式，如：post_date desc
 *      where:查询条件，字符串形式，和sql语句一样
 */
function export2excel($table, $file = '', $fields = '', $field_titles = '', $tag = '')
{
    //处理传递的参数
    if (stripos($table, C('DB_PREFIX')) == 0) {
        //含前缀的表,去除表前缀
        $table = substr($table, strlen(C('DB_PREFIX')));
    }
    $file = empty($file) ? C('DB_PREFIX') . $table : $file;
    $fieldsall = M($table)->getDbFields();
    $field_titles = empty($field_titles) ? array() : explode(",", $field_titles);
    if (empty($fields)) {
        $fields = $fieldsall;
        //成员数不一致,则取字段名为标题
        if (count($fields) != count($field_titles)) {
            $field_titles = $fields;
        }
    } else {
        $fields = explode(",", $fields);
        $rst = array();
        $rsttitle = array();
        $title_y_n = (count($fields) == count($field_titles)) ? true : false;
        foreach ($fields as $k => $v) {
            if (in_array($v, $fieldsall)) {
                $rst[] = $v;
                //一一对应则取指定标题,否则取字段名
                $rsttitle[] = $title_y_n ? $field_titles[$k] : $v;
            }
        }
        $fields = $rst;
        $field_titles = $rsttitle;
    }
    //处理tag标签
    $tag = param2array($tag);
    $limit = !empty($tag['limit']) ? $tag['limit'] : '';
    $order = !empty($tag['order']) ? $tag['order'] : '';
    $where = array();
    if (!empty($tag['where'])) {
        $where['_string'] = $tag['where'];
    }
    //处理数据
    $data = M($table)->field(join(",", $fields))->where($where)->order($order)->limit($limit)->select();
    import("Org.Util.PHPExcel");
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/London');
    $objPHPExcel = new \PHPExcel();
    import("Org.Util.PHPExcel.Reader.Excel5");
    /*设置excel的属性*/
    $objPHPExcel->getProperties()->setCreator("rainfer")//创建人
    ->setLastModifiedBy("rainfer")//最后修改人
    ->setKeywords("excel")//关键字
    ->setCategory("result file");//种类

    //第一行数据
    $objPHPExcel->setActiveSheetIndex(0);
    $active = $objPHPExcel->getActiveSheet();
    foreach ($field_titles as $i => $name) {
        $ck = num2alpha($i++) . '1';
        $active->setCellValue($ck, $name);
    }
    //填充数据
    foreach ($data as $k => $v) {
        $k = $k + 1;
        $num = $k + 1;//数据从第二行开始录入
        $objPHPExcel->setActiveSheetIndex(0);
        foreach ($fields as $i => $name) {
            $ck = num2alpha($i++) . $num;
            $active->setCellValue($ck, $v[$name]);
        }
    }
    $objPHPExcel->getActiveSheet()->setTitle($table);
    $objPHPExcel->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $file . '.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}

/**
 * 生成参数列表,以数组形式返回
 * @author xiaofeng<1034023036@qq.com>
 */
function param2array($tag = '')
{
    $param = array();
    $array = explode(';', $tag);
    foreach ($array as $v) {
        $v = trim($v);
        if (!empty($v)) {
            list($key, $val) = explode(':', $v);
            $param[trim($key)] = trim($val);
        }
    }
    return $param;
}

/**
 * 数字到字母列
 * @author xiaofeng<1034023036@qq.com>
 */
function num2alpha($intNum, $isLower = false)
{
    $num26 = base_convert($intNum, 10, 26);
    $addcode = $isLower ? 49 : 17;
    $result = '';
    for ($i = 0; $i < strlen($num26); $i++) {
        $code = ord($num26{$i});
        if ($code < 58) {
            $result .= chr($code + $addcode);
        } else {
            $result .= chr($code + $addcode - 39);
        }
    }
    return $result;
}
/**
 * 获取人民币折算 -单个
 * @param $currency_id
 * @return mixed|null
 */
function cursell_cny($money,$user_id=''){
    if(!$user_id){
        $user_id = $_SESSION['user']['member_list_userinfoid'];
    }
    $curoffer_list = M('curoffer')->where(array('user_id' => $user_id))->select();
    if ($curoffer_list) {
        foreach ($curoffer_list as $v) {

            if ($v['currency_code']=='HKD') {
                $cny = $money * $v['curbuy'];
            }
        }
        return number_format($cny,2,'.',',');

    }else{
        //当天时间
        $time = strtotime(date('Y-m-d'));
        //查看当天的港币和美元的汇率是否存在活动的
        $where['status'] = 1;
        $where['currency_code'] = array('in', 'HKD,USD');
        $where['update_at'] = array('gt',$time);
        $curoffer_list_1 = M('curoffer')->where($where)->select();
        //汇率是否开启
        foreach ($curoffer_list_1 as $v) {

//            if ($v['currency_code']=='USD') {
//                $usd = 1 / $v['cursell'];
//            }
            if ($v['currency_code']=='HKD') {
                $cny = $money * $v['curbuy'];
            }
        }
        return number_format($cny,2,'.',',');

    }
}
/**
 * 获取港币折算 -单个
 * @param $currency_id
 * @return mixed|null
 */
function cursell_hkd($money,$user_id='')
{
    if(!$user_id){
        $user_id = $_SESSION['user']['member_list_userinfoid'];
    }

    $curoffer_list = M('curoffer')->where(array('user_id' => $user_id))->select();
    if ($curoffer_list) {
        foreach ($curoffer_list as $v) {

//            if ($v['currency_code']=='USD') {
//                $usd = $v['cursell'];
//            }
            if ($v['currency_code']=='HKD') {
                $hkd = $v['cursell'];
            }
        }
        $res_curoffer = array(
//            'usd'=>number_format($usd,8,'.',','),
            'hkd'=>$hkd,
        );
        return round($money/$res_curoffer['hkd'],2);

    }else{
        //当天时间
        $time = strtotime(date('Y-m-d'));
        //查看当天的港币和美元的汇率是否存在活动的
        $where['status'] = 1;
        $where['currency_code'] = array('in', 'HKD,USD');
        $where['update_at'] = array('gt',$time);
        $curoffer_list_1 = M('curoffer')->where($where)->select();
        //汇率是否开启
        foreach ($curoffer_list_1 as $v) {

//            if ($v['currency_code']=='USD') {
//                $usd = 1 / $v['cursell'];
//            }
            if ($v['currency_code']=='HKD') {
                $hkd = $v['cursell'];
            }
        }

        $res_curoffer = array(
//            'usd'=>number_format($usd,8,'.',','),
            'hkd'=>$hkd,
        );
        return round($money/$res_curoffer['hkd'],2);

    }


}
/**
 * 返回不含前缀的数据库表数组
 *
 * @author xiaofeng<1034023036@qq.com>
 *
 * @return array
 */
function db_get_tables()
{
    static $tables = null;
    if (null === $tables) {
        $db_prefix = C('DB_PREFIX');
        $db = Db::getInstance();
        $tables = array();
        foreach ($db->getTables() as $t) {
            if (strpos($t, $db_prefix) === 0) {
                $t = substr($t, strlen($db_prefix));
                $tables [] = strtolower($t);
            }
        }
    }
    return $tables;
}

/**
 * 返回数据表的sql
 *
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param $table : 不含前缀的表名
 * @return string
 */
function db_get_insert_sqls($table)
{
    static $db = null;
    if (null === $db) {
        $db = Db::getInstance();
    }
    $db_prefix = C('DB_PREFIX');
    $db_prefix_re = preg_quote($db_prefix);
    $db_prefix_holder = db_get_db_prefix_holder();
    $export_sqls = array();
    $export_sqls [] = "DROP TABLE IF EXISTS $db_prefix_holder$table";

    switch (C('DB_TYPE')) {
        case 'mysql' :
            if (!($d = $db->query("SHOW CREATE TABLE $db_prefix$table"))) {
                $this->error("'SHOW CREATE TABLE $table' Error!");
            }
            $table_create_sql = $d [0] ['create table'];
            $table_create_sql = preg_replace('/' . $db_prefix_re . '/', $db_prefix_holder, $table_create_sql);
            $export_sqls [] = $table_create_sql;
            $data_rows = $db->query("SELECT * FROM $db_prefix$table");
            $data_values = array();
            foreach ($data_rows as &$v) {
                foreach ($v as &$vv) {
                    $vv = "'" . mysql_escape_string($vv) . "'";
                }
                $data_values [] = '(' . join(',', $v) . ')';
            }
            if (count($data_values) > 0) {
                $export_sqls [] = "INSERT INTO `$db_prefix_holder$table` VALUES \n" . join(",\n", $data_values);
            }
            break;
    }

    return join(";\n", $export_sqls) . ";";
}

/**
 * 检测当前数据库中是否含指定表
 *
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param $table : 不含前缀的数据表名
 * @return bool
 */
function db_is_valid_table_name($table)
{
    return in_array($table, db_get_tables());
}

/**
 * 不检测表前缀,恢复数据库
 *
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param $file
 */
function db_restore_file($file)
{
    static $db = null;
    static $db_prefix = null;
    if (null === $db) {
        $db = Db::getInstance();
        $db_prefix = C('DB_PREFIX');
    }
    $sqls = file_get_contents($file);
    $sqls = str_replace(db_get_db_prefix_holder(), $db_prefix, $sqls);
    $sqlarr = explode(";\n", $sqls);
    foreach ($sqlarr as &$sql) {
        $db->execute($sql);
    }
}

/**
 * 返回表前缀替代符
 * @author xiaofeng<1034023036@qq.com>
 *
 * @return string
 */
function db_get_db_prefix_holder()
{
    return '<--db-prefix-->';
}

/**
 * 强制下载
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param string $filename
 */
function force_download_content($filename, $content)
{
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Transfer-Encoding: binary");
    header("Content-Disposition: attachment; filename=$filename");
    echo $content;
    exit ();
}

/**
 * 所有用到密码的不可逆加密方式
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param string $password
 * @param string $password_salt
 * @return string
 */
function encrypt_password($password, $password_salt)
{
    return md5(md5($password) . md5($password_salt));
}

/**
 * 列出本地目录的文件
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param string $filename
 * @param string $pattern
 * @return Array
 */
function list_file($filename, $pattern = '*')
{
    if (strpos($pattern, '|') !== false) {
        $patterns = explode('|', $pattern);
    } else {
        $patterns [0] = $pattern;
    }
    $i = 0;
    $dir = array();
    if (is_dir($filename)) {
        $filename = rtrim($filename, '/') . '/';
    }
    foreach ($patterns as $pattern) {
        $list = glob($filename . $pattern);
        if ($list !== false) {
            foreach ($list as $file) {
                $dir [$i] ['filename'] = basename($file);
                $dir [$i] ['path'] = dirname($file);
                $dir [$i] ['pathname'] = realpath($file);
                $dir [$i] ['owner'] = fileowner($file);
                $dir [$i] ['perms'] = substr(base_convert(fileperms($file), 10, 8), -4);
                $dir [$i] ['atime'] = fileatime($file);
                $dir [$i] ['ctime'] = filectime($file);
                $dir [$i] ['mtime'] = filemtime($file);
                $dir [$i] ['size'] = filesize($file);
                $dir [$i] ['type'] = filetype($file);
                $dir [$i] ['ext'] = is_file($file) ? strtolower(substr(strrchr(basename($file), '.'), 1)) : '';
                $dir [$i] ['isDir'] = is_dir($file);
                $dir [$i] ['isFile'] = is_file($file);
                $dir [$i] ['isLink'] = is_link($file);
                $dir [$i] ['isReadable'] = is_readable($file);
                $dir [$i] ['isWritable'] = is_writable($file);
                $i++;
            }
        }
    }
    $cmp_func = create_function('$a,$b', '
		if( ($a["isDir"] && $b["isDir"]) || (!$a["isDir"] && !$b["isDir"]) ){
			return  $a["filename"]>$b["filename"]?1:-1;
		}else{
			if($a["isDir"]){
				return -1;
			}else if($b["isDir"]){
				return 1;
			}
			if($a["filename"]  ==  $b["filename"])  return  0;
			return  $a["filename"]>$b["filename"]?-1:1;
		}
		');
    usort($dir, $cmp_func);
    return $dir;
}

/**
 * 删除文件夹
 * @author xiaofeng<1034023036@qq.com>
 *
 */
function remove_dir($dir, $time_thres = -1)
{
    foreach (list_file($dir) as $f) {
        if ($f ['isDir']) {
            remove_dir($f ['pathname'] . '/');
        } else if ($f ['isFile'] && $f ['filename'] != C('DIR_SECURE_FILENAME')) {
            if ($time_thres == -1 || $f ['mtime'] < $time_thres) {
                @unlink($f ['pathname']);
            }
        }
    }
}

/**
 * 将内容存到Storage中，返回转存后的文件路径
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param string $dir
 * @param string $ext
 * @param string $content
 * @return string
 */
function save_storage_content($ext = null, $content = null, $filename = '')
{
    $newfile = '';
    $path = C('UPLOAD_DIR');
    $path = substr($path, 0, 2) == './' ? substr($path, 2) : $path;
    $path = substr($path, 0, 1) == '/' ? substr($path, 1) : $path;
    if ($ext && $content) {
        do {
            $newfile = $path . date('Y-m-d/') . uniqid() . '.' . $ext;
        } while (Storage::has($newfile));
        Storage::put($newfile, $content);
    }
    return $newfile;
}

/**
 * 返回带协议的域名
 * @author xiaofeng<1034023036@qq.com>
 */
function get_host()
{
    $host = $_SERVER["HTTP_HOST"];
    $protocol = is_ssl() ? "https://" : "http://";
    return $protocol . $host;
}

/**
 * 获取后台管理设置的网站信息，此类信息一般用于前台
 * @author xiaofeng<1034023036@qq.com>
 */
function get_site_options()
{
    $site_options = F("site_options");
    if (empty($site_options)) {
        $options_obj = M("Options");
        $option = $options_obj->where("option_name='site_options'")->find();
        if ($option) {
            $site_options = json_decode($option['option_value'], true);
            $site_options['site_copyright'] = htmlspecialchars_decode($site_options['site_copyright']);
        } else {
            $site_options = array();
        }
        F("site_options", $site_options);
    }
    $site_options['site_tongji'] = htmlspecialchars_decode($site_options['site_tongji']);
    return $site_options;
}

/**
 * 获取后台管理设置的邮件连接
 * @author xiaofeng<1034023036@qq.com>
 */
function get_email_options()
{
    $email_options = F("email_options");
    if (empty($email_options)) {
        $options_obj = M("Options");
        $option = $options_obj->where("option_name='email_options'")->find();
        if ($option) {
            $email_options = json_decode($option['option_value'], true);
        } else {
            $email_options = array();
        }
        F("email_options", $email_options);
    }
    return $email_options;
}

/**
 * 获取后台管理设置的邮件激活连接
 * @author xiaofeng<1034023036@qq.com>
 */
function get_active_options()
{
    $active_options = F("active_options");
    if (empty($active_options)) {
        $options_obj = M("Options");
        $option = $options_obj->where("option_name='active_options'")->find();
        if ($option) {
            $active_options = json_decode($option['option_value'], true);
        } else {
            $active_options = array();
        }
        F("active_options", $active_options);
    }
    return $active_options;
}

/**
 * 获取所有友情连接
 * @author xiaofeng<1034023036@qq.com>
 *
 * @return array
 */
function get_links($type = 1)
{
    $links_obj = M("plug_link");
    return $links_obj->where(array('plug_link_typeid' => $type, 'plug_link_open' => 1))->order("plug_link_order ASC")->select();
}

/**
 * 返回指定id的菜单
 * @author xiaofeng<1034023036@qq.com>
 *
 * 同上一类方法，jquery treeview 风格，可伸缩样式
 * @param $myid 表示获得这个ID下的所有子级
 * @param $effected_id 需要生成treeview目录数的id
 * @param $str 末级样式
 * @param $str2 目录级别样式
 * @param $showlevel 直接显示层级数，其余为异步显示，0为全部限制
 * @param $ul_class 内部ul样式 默认空  可增加其他样式如'sub-menu'
 * @param $li_class 内部li样式 默认空  可增加其他样式如'menu-item'
 * @param $style 目录样式 默认 filetree 可增加其他样式如'filetree treeview-famfamfam'
 * @param $dropdown 有子元素时li的class
 * $id="main";
 * $effected_id="mainmenu";
 * $filetpl="<a href='\$href'><span class='file'>\$label</span></a>";
 * $foldertpl="<span class='folder'>\$label</span>";
 * $ul_class="" ;
 * $li_class="" ;
 * $style="filetree";
 * $showlevel=6;
 * get_menu($id,$effected_id,$filetpl,$foldertpl,$ul_class,$li_class,$style,$showlevel);
 * such as
 * <ul id="example" class="filetree ">
 * <li class="hasChildren" id='1'>
 * <span class='folder'>test</span>
 * <ul>
 * <li class="hasChildren" id='4'>
 * <span class='folder'>caidan2</span>
 * <ul>
 * <li class="hasChildren" id='5'>
 * <span class='folder'>sss</span>
 * <ul>
 * <li id='3'><span class='folder'>test2</span></li>
 * </ul>
 * </li>
 * </ul>
 * </li>
 * </ul>
 * </li>
 * <li class="hasChildren" id='6'><span class='file'>ss</span></li>
 * </ul>
 */

function get_menu($id = "main", $effected_id = "mainmenu", $childtpl = "<span class='file'>\$label</span>", $parenttpl = "<span class='folder'>\$label</span>", $ul_class = "", $li_class = "", $style = "filetree", $showlevel = 6, $dropdown = 'hasChild')
{
    $navs = F("site_nav_" . $id);
    if (empty($navs)) {
        $navs = get_menu_datas($id);
    }
    import("Org.Util.Tree");
    $tree = new \Tree();
    $tree->init($navs);
    return $tree->get_treeview_menu(0, $effected_id, $childtpl, $parenttpl, $showlevel, $ul_class, $li_class, $style, 1, FALSE, $dropdown);
}


function get_menu_datas($id)
{
    $nav_obj = M("menu");
    $navs = $nav_obj->where(array('menu_open' => 1))->order(array("listorder" => "ASC"))->select();
    foreach ($navs as $key => $nav) {
        if ($nav['menu_type'] == 2) {
            $nav['href'] = $nav['menu_address'];
        } else {
            $nav['href'] = UU('list/index', array('id' => $nav['id']));
            if (strtolower($nav['menu_enname']) == 'home' && $nav['parentid'] == 0) {
                $nav['href'] = UU('index/index');
            }
        }
        $navs[$key] = $nav;
    }
    F("site_nav_" . $id, $navs);
    return $navs;
}

/**
 * 获取树形数组
 * @author xiaofeng<1034023036@qq.com>
 *
 * @return array
 */
function get_menu_tree($id = "main")
{
    $navs = F("site_nav_" . $id);
    if (empty($navs)) {
        $navs = get_menu_datas($id);
    }
    import("Org.Util.Tree");
    $tree = new \Tree();
    $tree->init($navs);
    return $tree->get_tree_array(0, "");
}

function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
{
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    return ($suffix && $slice != $str) ? $slice . '...' : $slice;
}

/**
 * 查询文章列表，支持分页或不分页
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param string $type 查询类型,可以为'cid',可以为'keyword',可以为'tag'
 * @param string $v 当查询类型为'cid'或'keyword'时,待搜索的值
 * @param string $tag 查询标签，以字符串方式传入,例："cid:1,2;field:news_title,news_content;limit:0,8;order:news_time desc,news_hits desc;where:n_id>5;"<br>
 *  ids:调用指定id的一个或多个数据,如 1,2,3<br>
 *    cid:数据所在分类,可调出一个或多个分类数据,如 1,2,3 默认值为全部,在当前分类为:'.$cid.'<br>
 *    field:调用post指定字段,如(n_id,news_title...) 默认全部<br>
 *    limit:数据条数,默认值为10,可以指定从第几条开始,如3,8(表示共调用8条,从第3条开始),使用分页时无效
 *    order:排序方式，如：news_hits desc<br>
 *    where:查询条件，字符串形式，和sql语句一样
 * @param array $where 查询条件，（暂只支持数组），格式和thinkphp where方法一样；
 * @param bool $ispage 是否分页
 */
function get_news($tag, $ispage = false, $pagesize = 10, $type = null, $v = null, $where = array())
{
    $where = is_array($where) ? $where : array();
    $tag = param2array($tag);
    $field = !empty($tag['field']) ? $tag['field'] : '*';
    $limit = !empty($tag['limit']) ? $tag['limit'] : '';
    $order = !empty($tag['order']) ? $tag['order'] : 'news_time';
    switch ($type) {
        case 'keyword':
            $where['news_title|news_key'] = array('like', '%' . $v . '%');//关键字
            break;
        case 'tag':
            $where['news_tag'] = array('like', '%,' . $v . ',%');//标签
            break;
        case 'cid':
            $cid = intval($v);
            $catids = get_menu_byid($cid, 1);
            if (!empty($catids)) {
                $catids = implode(",", $catids);
                //$catids="cid:$catids;";
            } else {
                $catids = "";
            }
            $tag['cid'] = $catids;//重新生成条件
            break;
        default:
    }
    //根据参数生成查询条件
    $where['news_open'] = array('eq', 1);
    $where['news_back'] = array('eq', 0);
    if (!empty($tag['cid'])) {
        $where['news_columnid'] = array('in', $tag['cid']);
    }
    if (!empty($tag['ids'])) {
        $where['n_id'] = array('in', $tag['ids']);
    }
    if (!empty($tag['where'])) {
        $where['_string'] = $tag['where'];
    }
    $join = "" . C('DB_PREFIX') . 'admin as b on a.news_auto =b.admin_id';
    $rs = M("news");
    if ($ispage) {
        //使用分页
        $count = $rs->alias("a")->join($join)->field($field)->where($where)->count();
        $pagesize = $pagesize ? $pagesize : C('DB_PAGENUM');
        $Page = new \Think\Page($count, $pagesize);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->setConfig('theme', ' %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%');
        $show = $Page->show();// 分页显示输出
        $content['page'] = $show;
        $news = $rs->alias("a")->join($join)->field($field)->where($where)->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $content['news'] = $news;
        $content['count'] = $count;
        return $content;
    } else {
        //不使用分页
        $news = $rs->alias("a")->join($join)->field($field)->where($where)->order($order)->limit($limit)->select();
        return $news;
    }
}

/**
 * 获取评论
 * @param string $tag
 * @param array $where //按照thinkphp where array格式
 */
function get_comments($tag = "field:*;limit:0,5;order:createtime desc;", $where = array())
{
    $where = is_array($where) ? $where : array();
    $tag = param2array($tag);
    $field = !empty($tag['field']) ? $tag['field'] : '*';
    $limit = !empty($tag['limit']) ? $tag['limit'] : '5';
    $order = !empty($tag['order']) ? $tag['order'] : 'createtime desc';

    //根据参数生成查询条件
    $mwhere['c_status'] = array('eq', 1);

    if (is_array($where)) {
        $where = array_merge($mwhere, $where);
    } else {
        $where = $mwhere;
    }
    $join = "" . C('DB_PREFIX') . 'member_list as b on a.uid =b.member_list_id';
    $comments_model = M("comments");
    $comments = $comments_model->alias("a")->join($join)->field($field)->where($where)->order($order)->limit($limit)->select();
    return $comments;
}

/**
 * 获取新闻分类ids
 * @author xiaofeng<1034023036@qq.com>
 *
 * $id 待获取的id
 * $self 是否返回自身，默认false
 * @return array
 */
function get_menu_byid($id = 0, $self = false)
{
    $arr = M('menu')->where(array('menu_open' => 1, 'id' => $id))->select();
    if ($arr) {
        $rst = $self ? array($id) : array();
        $menu = M('menu')->where(array('menu_open' => 1, 'parentid' => $id))->field('id')->select();
        foreach ($menu as $v) {
            $rst[] = intval($v['id']);
            $arr = M('menu')->where(array('menu_open' => 1, 'parentid' => $v['id']))->field('id')->select();
            if ($arr) {
                $rst = array_merge($rst, get_menu_byid($v['id'], false));
            }
        }
        return $rst;
    } else {
        return array();
    }
}

/**
 * 根据广告位获取所有广告
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param int $plug_ad_adtypeid 广告位id
 * @return array;
 */
function get_ads($plug_ad_adtypeid, $limit = 5, $order = "plug_ad_order ASC")
{
    $ad_obj = M("plug_ad");
    if ($order == '') {
        $order = "plug_ad_order ASC";
    }
    if ($limit == 0) {
        $limit = 5;
    }
    return $ad_obj->where(array('plug_ad_open' => 1, 'plug_ad_adtypeid' => $plug_ad_adtypeid))->order($order)->limit('0,' . $limit)->select();
}

/**
 * 截取待html的文本
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param int $plug_ad_adtypeid 广告位id
 * @return array;
 */
function html_trim($html, $max, $suffix = '...')
{
    $non_paired_tags = array('br', 'hr', 'img', 'input', 'param'); // 非成对标签
    $html = trim($html);
    $html = preg_replace('/<img([^>]+)>/i', '', $html);
    $count = 0; // 有效字符计数(一个HTML实体字符算一个有效字符)
    $tag_status = 0; // (0:非标签, 1:标签开始, 2:标签名开始, 3:标签名结束)
    $nodes = array(); // 存放解析出的节点(文本节点:array(0, '文本内容', 'text', 0), 标签节点:array(1, 'tag', 'tag_name', '标签性质:0:非成对标签,1:成对标签的开始标签,2:闭合标签'))
    $segment = ''; // 文本片段
    $tag_name = ''; // 标签名
    for ($i = 0; $i < strlen($html); $i++) {
        $char = $html[$i]; // 当前字符
        $segment .= $char; // 保存文本片段
        if ($tag_status == 4) {
            $tag_status = 0;
        }
        if ($tag_status == 0 && $char == '<') {
            // 没有开启标签状态,设置标签开启状态
            $tag_status = 1;
        }
        if ($tag_status == 1 && $char != '<') {
            // 标签状态设置为开启后,用下一个字符来确定是一个标签的开始
            $tag_status = 2; //标签名开始
            $tag_name = ''; // 清空标签名
            // 确认标签开启,将标签之前保存的字符版本存为文本节点
            $nodes[] = array(0, substr($segment, 0, strlen($segment) - 2), 'text', 0);
            $segment = '<' . $char; // 重置片段,以标签开头
        }
        if ($tag_status == 2) {
            // 提取标签名
            if ($char == ' ' || $char == '>' || $char == "\t") {
                $tag_status = 3; // 标签名结束
            } else {
                $tag_name .= $char; // 增加标签名字符
            }
        }
        if ($tag_status == 3 && $char == '>') {
            $tag_status = 4; // 重置标签状态
            $tag_name = strtolower($tag_name);
            // 跳过成对标签的闭合标签
            $tag_type = 1;
            if (in_array($tag_name, $non_paired_tags)) {
                // 非成对标签
                $tag_type = 0;
            } elseif ($tag_name[0] == '/') {
                $tag_type = 2;
            }
            // 标签结束,保存标签节点
            $nodes[] = array(1, $segment, $tag_name, $tag_type);
            $segment = ''; // 清空片段
        }
        if ($tag_status == 0) {
            //echo $char.')'.$count."\n";
            if ($char == '&') {
                // 处理HTML实体,10个字符以内碰到';',则认为是一个HTML实体
                for ($e = 1; $e <= 10; $e++) {
                    if ($html[$i + $e] == ';') {
                        $segment .= substr($html, $i + 1, $e); // 保存实体
                        $i += $e; // 跳过实体字符所占长度
                        break;
                    }
                }
            } else {
                // 非标签情况下检查有效文本
                $char_code = ord($char); // 字符编码
                if ($char_code >= 224) // 三字节字符
                {
                    $segment .= $html[$i + 1] . $html[$i + 2]; // 保存字符
                    $i += 2; // 跳过下2个字符的长度
                } elseif ($char_code >= 129) // 双字节字符
                {
                    $segment .= $html[$i + 1];
                    $i += 1; // 跳过下一个字符的长度
                }
            }
            $count++;
            if ($count == $max) {
                $nodes[] = array(0, $segment . $suffix, 'text', 0);
                break;
            }
        }
    }
    $html = '';
    $tag_open_stack = array(); // 成对标签的开始标签栈
    for ($i = 0; $i < count($nodes); $i++) {
        $node = $nodes[$i];
        if ($node[3] == 1) {
            array_push($tag_open_stack, $node[2]); // 开始标签入栈
        } elseif ($node[3] == 2) {
            array_pop($tag_open_stack); // 碰到一个结束标签,出栈一个开始标签
        }
        $html .= $node[1];
    }
    while ($tag_name = array_pop($tag_open_stack)) // 用剩下的未出栈的开始标签补齐未闭合的成对标签
    {
        $html .= '</' . $tag_name . '>';
    }
    return $html;
}

/**
 * 获取单页面菜单
 * @author xiaofeng<1034023036@qq.com>
 *
 * @param int $id 菜单id
 * @return array;
 */
function get_menu_one($id)
{
    $rst = array();
    if ($id) {
        $rst = M('menu')->where(array('menu_type' => 4, 'id' => $id))->find();
    }
    return $rst;
}

/**
 * 设置全局配置到文件
 *
 * @param $key
 * @param $value
 */
function sys_config_setbykey($key, $value)
{
    $file = './data/conf/config.php';
    $cfg = array();
    if (file_exists($file)) {
        $cfg = (include $file);
    }
    $item = explode('.', $key);
    switch (count($item)) {
        case 1:
            $cfg[$item[0]] = $value;
            break;
        case 2:
            $cfg[$item[0]][$item[1]] = $value;
            break;
    }
    return file_put_contents($file, "<?php\nreturn " . var_export($cfg, true) . ";");
}

/**
 * 设置全局配置到文件
 *
 * @param array
 */
function sys_config_setbyarr($data)
{
    $file = './data/conf/config.php';
    if (file_exists($file)) {
        $configs = include $file;
    } else {
        $configs = array();
    }
    $configs = array_merge($configs, $data);
    return file_put_contents($file, "<?php\treturn " . var_export($configs, true) . ";");
}

/**
 * 获取全局配置
 *
 * @param $key
 * @return null
 */
function sys_config_get($key)
{
    $file = './data/conf/config.php';
    $cfg = array();
    if (file_exists($file)) {
        $cfg = (include $file);
    }
    return isset($cfg[$key]) ? $cfg[$key] : null;
}

/**
 * 检查用户对某个url,内容的可访问性，用于记录如是否赞过，是否访问过等等;开发者可以自由控制，对于没有必要做的检查可以不做，以减少服务器压力
 * @param number $object 访问对象的id,格式：不带前缀的表名+id;如news1表示xx_news表里id为1的记录;如果object为空，表示只检查对某个url访问的合法性
 * @param number $count_limit 访问次数限制,如1，表示只能访问一次,0表示不限制
 * @param boolean $ip_limit ip限制,false为不限制，true为限制
 * @param number $expire 距离上次访问的最小时间单位s，0表示不限制，大于0表示最后访问$expire秒后才可以访问
 * @return true 可访问，false不可访问
 */
function check_user_action($object = "", $count_limit = 1, $ip_limit = false, $expire = 0)
{
    $action_log_model = M("action_log");
    $action = MODULE_NAME . "-" . CONTROLLER_NAME . "-" . ACTION_NAME;
    $userid = session('hid') ? session('hid') : 0;
    $ip = get_client_ip(0, true);
    $where = array("uid" => $userid, "action" => $action, "object" => $object);
    if ($ip_limit) {
        $where['ip'] = $ip;
    }
    $find_log = $action_log_model->where($where)->find();
    $time = time();
    if ($find_log) {
        //次数限制
        if ($count_limit > 0 && $find_log['count'] >= $count_limit) {
            return false;
        }
        //时间限制
        if ($expire > 0 && ($time - $find_log['last_time']) < $expire) {
            return false;
        }
        $action_log_model->where($where)->save(array("count" => array("exp", "count+1"), "last_time" => $time, "ip" => $ip));
    } else {
        $action_log_model->add(array("uid" => $userid, "action" => $action, "object" => $object, "count" => array("exp", "count+1"), "last_time" => $time, "ip" => $ip));
    }
    return true;
}

/**
 * 用于生成收藏内容用的key
 * @param string $table 收藏内容所在表
 * @param int $object_id 收藏内容的id
 */
function get_favorite_key($table, $object_id)
{
    $key = encrypt_password($table . '-' . $object_id, $table);
    return $key;
}

/**
 * URL组装 支持不同URL模式
 * @param string $url URL表达式，格式：'[模块/控制器/操作#锚点@域名]?参数1=值1&参数2=值2...'
 * @param string|array $vars 传入的参数，支持数组和字符串
 * @param string $suffix 伪静态后缀，默认为true表示获取配置值
 * @param boolean $domain 是否显示域名
 * @return string
 */
function UU($url = '', $vars = '', $suffix = true, $domain = false)
{
    $routes = get_routes();
    //dump($routes);
    if (empty($routes)) {
        //不存在路由,则直接以U方法生成
        return U($url, $vars, $suffix, $domain);
    } else {
        // 解析URL
        $info = parse_url($url);
        //如果path为空,则path为方法,否则为path
        $url = !empty($info['path']) ? $info['path'] : ACTION_NAME;
        if (isset($info['fragment'])) { // 解析锚点
            $anchor = $info['fragment'];
            //瞄点含?,则第1部分为真瞄点,第2部分为参数查询部分
            if (false !== strpos($anchor, '?')) { // 解析参数
                list($anchor, $info['query']) = explode('?', $anchor, 2);
            }
            //瞄点含@,则第1部分为真瞄点,第2部分为域名host
            if (false !== strpos($anchor, '@')) { // 解析域名
                list($anchor, $host) = explode('@', $anchor, 2);
            }
        } elseif (false !== strpos($url, '@')) { // 解析域名
            //path中含@,则第1部分为真正的path,赋值给url,第2为域名
            list($url, $host) = explode('@', $info['path'], 2);
        }


        // 解析参数
        if (is_string($vars)) { // aaa=1&bbb=2 转换成数组
            parse_str($vars, $vars);
        } elseif (!is_array($vars)) {
            $vars = array();//既不是字符串,也不是数组,则为空数组
        }
        //合并参数
        if (isset($info['query'])) { // 解析地址里面参数 合并到vars
            parse_str($info['query'], $params);
            $vars = array_merge($params, $vars);
        }
        $vars_src = $vars;
        ksort($vars);
        // URL组装
        $depr = C('URL_PATHINFO_DEPR');
        $urlCase = C('URL_CASE_INSENSITIVE');
        if ('/' != $depr) { // 安全替换
            $url = str_replace('/', $depr, $url);
        }
        // 解析模块、控制器和操作
        $url = trim($url, $depr);
        $path = explode($depr, $url);
        $var = array();
        $varModule = C('VAR_MODULE');
        $varController = C('VAR_CONTROLLER');
        $varAction = C('VAR_ACTION');
        $var[$varAction] = !empty($path) ? array_pop($path) : ACTION_NAME;
        $var[$varController] = !empty($path) ? array_pop($path) : CONTROLLER_NAME;
        //处理方法映射
        if ($maps = C('URL_ACTION_MAP')) {
            if (isset($maps[strtolower($var[$varController])])) {
                $maps = $maps[strtolower($var[$varController])];
                if ($action = array_search(strtolower($var[$varAction]), $maps)) {
                    $var[$varAction] = $action;
                }
            }
        }
        //处理控制器映射
        if ($maps = C('URL_CONTROLLER_MAP')) {
            if ($controller = array_search(strtolower($var[$varController]), $maps)) {
                $var[$varController] = $controller;
            }
        }
        if ($urlCase) {
            $var[$varController] = parse_name($var[$varController]);
        }
        $module = '';

        if (!empty($path)) {
            $var[$varModule] = array_pop($path);
        } else {
            if (C('MULTI_MODULE')) {
                //多模块
                if (MODULE_NAME != C('DEFAULT_MODULE') || !C('MODULE_ALLOW_LIST')) {
                    $var[$varModule] = MODULE_NAME;
                }
            }
        }
        //处理模块映射
        if ($maps = C('URL_MODULE_MAP')) {
            if ($_module = array_search(strtolower($var[$varModule]), $maps)) {
                $var[$varModule] = $_module;
            }
        }
        if (isset($var[$varModule])) {
            $module = $var[$varModule];
        }
        //开始拼装
        if (C('URL_MODEL') == 0) { // 普通模式URL转换
            $url = __APP__ . '?' . http_build_query(array_reverse($var));
            if ($urlCase) {
                $url = strtolower($url);
            }
            if (!empty($vars)) {
                $vars = http_build_query($vars);
                $url .= '&' . $vars;
            }
        } else { // PATHINFO模式或者兼容URL模式
            if (empty($var[$varModule])) {
                $var[$varModule] = MODULE_NAME;//模块为空,则以当前模块
            }
            $module_controller_action = strtolower(implode($depr, array_reverse($var)));//拼装成"模块/控制器/方法"
            //匹配路由规则
            $has_route = false;
            //拼装成原始url,形式"模块/控制器/方法?参数1=值1&参数2=值2"
            $original_url = $module_controller_action . (empty($vars) ? "" : "?") . http_build_query($vars);
            if (isset($routes['static'][$original_url])) {
                //存在静态路由
                $has_route = true;
                //返回静态后的url
                $url = __APP__ . "/" . $routes['static'][$original_url];
            } else {
                //不存在静态路由,则开始查找动态路由
                if (isset($routes['dynamic'][$module_controller_action])) {
                    //存在
                    $urlrules = $routes['dynamic'][$module_controller_action];//所有"模块/控制器/方法"的规则
                    $empty_query_urlrule = array();
                    foreach ($urlrules as $ur) {
                        $intersect = array_intersect_assoc($ur['query'], $vars);//返回键名 键值都一样的
                        if ($intersect) {
                            $vars = array_diff_key($vars, $ur['query']);//所有$vars参数数组不在规则参数的数组
                            $url = $ur['url'];
                            $has_route = true;
                            break;//退出循环
                        }
                        //不存在参数
                        if (empty($empty_query_urlrule) && empty($ur['query'])) {
                            $empty_query_urlrule = $ur;
                        }
                    }
                    if (!empty($empty_query_urlrule)) {
                        //不含参数
                        $has_route = true;
                        $url = $empty_query_urlrule['url'];
                    }
                    $new_vars = array_reverse($vars);
                    foreach ($new_vars as $key => $value) {
                        if (strpos($url, ":$key") !== false) {
                            $url = str_replace(":$key", $value, $url);
                            unset($vars[$key]);
                        }
                    }
                    $url = str_replace(array("\d", "$"), "", $url);
                    if ($has_route) {
                        if (!empty($vars)) { // 添加参数
                            foreach ($vars as $var => $val) {
                                if ('' !== trim($val)) $url .= $depr . $var . $depr . urlencode($val);
                            }
                        }
                        $url = __APP__ . "/" . $url;
                    }
                }//存在动态路由
            }
            $url = str_replace(array("^", "$"), "", $url);
            //不存在路由
            if (!$has_route) {
                $module = defined('BIND_MODULE') ? '' : $module;
                $url = __APP__ . '/' . implode($depr, array_reverse($var));
                if ($urlCase) {
                    $url = strtolower($url);
                }
                if (!empty($vars)) { // 添加参数
                    foreach ($vars as $var => $val) {
                        if ('' !== trim($val)) $url .= $depr . $var . $depr . urlencode($val);
                    }
                }
            }
            //添加静态后缀
            if ($suffix) {
                $suffix = $suffix === true ? C('URL_HTML_SUFFIX') : $suffix;
                if ($pos = strpos($suffix, '|')) {
                    $suffix = substr($suffix, 0, $pos);
                }
                if ($suffix && '/' != substr($url, -1)) {
                    $url .= '.' . ltrim($suffix, '.');
                }
            }
        }//pathinfo或兼容模式结束
        //添加瞄点
        if (isset($anchor)) {
            $url .= '#' . $anchor;
        }
        //添加域名
        if ($domain) {
            $url = (is_ssl() ? 'https://' : 'http://') . $domain . $url;
        }
        return $url;
    }
}

/**
 * 获取URL路由规则
 * @param boolean $refresh 是否刷新
 * @return array
 */
function get_routes($refresh = false)
{
    $routes = F("routes");
    if ((!empty($routes) || is_array($routes)) && !$refresh) {
        return $routes;
    }
    $routes = M("route")->where("status=1")->order("listorder asc")->select();
    $all_routes_s = array();
    $all_routes_d = array();
    $cache_routes = array();
    foreach ($routes as $er) {
        $full_url = htmlspecialchars_decode($er['full_url']);
        // 解析URL
        $info = parse_url($full_url);
        $path = explode("/", $info['path']);
        if (count($path) != 3) {//必须是完整 url
            continue;
        }
        $module = strtolower($path[0]);
        // 解析参数
        $vars = array();
        if (isset($info['query'])) { // 解析地址里面参数 合并到vars
            parse_str($info['query'], $params);
            $vars = array_merge($params, $vars);
        }
        $vars_src = $vars;
        ksort($vars);
        $path = $info['path'];
        $full_url = $path . (empty($vars) ? "" : "?") . http_build_query($vars);
        //显示的url
        $url = $er['url'];
        if (strpos($url, ':') === false) {
            //静态,不含动态参数
            $cache_routes['static'][$full_url] = $url;
            $all_routes_s[$url] = $full_url;
        } else {
            //动态
            $cache_routes['dynamic'][$path][] = array("query" => $vars, "url" => $url);
            $all_routes_d[$url] = $full_url;
        }
    }
    F("routes", $cache_routes);
    $data = array('URL_MAP_RULES' => $all_routes_s);
    sys_config_setbyarr($data);
    $data = array('URL_ROUTE_RULES' => $all_routes_d);
    sys_config_setbyarr($data);
    return $cache_routes;
}

function go_curl($url, $type, $data = false, &$err_msg = null, $timeout = 20, $cert_info = array(),$headers=[])
{
    $type = strtoupper($type);
    if ($type == 'GET' && is_array($data)) {
        $data = http_build_query($data);
    }
    $option = array();
    if ($type == 'POST') {
        $option[CURLOPT_POST] = 1;
    }
    if ($data) {
        if ($type == 'POST') {
            $option[CURLOPT_POSTFIELDS] = $data;
        } elseif ($type == 'GET') {
            $url = strpos($url, '?') !== false ? $url . '&' . $data : $url . '?' . $data;
        }
    }
    $option[CURLOPT_URL] = $url;
    $option[CURLOPT_FOLLOWLOCATION] = TRUE;
    $option[CURLOPT_MAXREDIRS] = 4;
    $option[CURLOPT_RETURNTRANSFER] = TRUE;
    $option[CURLOPT_TIMEOUT] = $timeout;
    //设置证书信息
    if (!empty($cert_info) && !empty($cert_info['cert_file'])) {
        $option[CURLOPT_SSLCERT] = $cert_info['cert_file'];
        $option[CURLOPT_SSLCERTPASSWD] = $cert_info['cert_pass'];
        $option[CURLOPT_SSLCERTTYPE] = $cert_info['cert_type'];
    }
    //设置CA
    if (!empty($cert_info['ca_file'])) {
        // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
        $option[CURLOPT_SSL_VERIFYPEER] = 1;
        $option[CURLOPT_CAINFO] = $cert_info['ca_file'];
    } else {
        // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
        $option[CURLOPT_SSL_VERIFYPEER] = 0;
    }
    $ch = curl_init();
    if(!empty($headers)){
        $option[CURLOPT_HTTPHEADER] = $headers;
    }
    curl_setopt_array($ch, $option);
    $response = curl_exec($ch);
    $curl_no = curl_errno($ch);
    $curl_err = curl_error($ch);
    curl_close($ch);
    // error_log
    if ($curl_no > 0) {
        if ($err_msg !== null) {
            $err_msg = '(' . $curl_no . ')' . $curl_err;
            $fp = @fopen("/data/wwwroot/hkeasypay/log/notifyerror/error.txt", "a+");
            fwrite($fp, json_encode($err_msg)."\n");
            fclose($fp);
        }
    }
    return $response;
}

function httpPost($url,$params){ // 模拟提交数据函数
    $ch = curl_init();
    $this_header = array("content-type: application/x-www-form-urlencoded;charset=UTF-8");

    curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//如果不加验证,就设false,商户自行处理
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $output = curl_exec($ch);
    return $output;
}

function checkVersion()
{
    if (extension_loaded('curl')) {
        $url = 'http://www.yfcmf.net/index.php?m=home&c=upgrade&a=check';
        $params = array(
            'version' => C('YFCMF_VERSION'),
            'domain' => $_SERVER['HTTP_HOST'],
        );
        $vars = http_build_query($params);
        //获取版本数据
        $data = go_curl($url, 'post', $vars);
        if (!empty($data) && strlen($data) < 400) {
            return $data;
        } else {
            return '';
        }
    } else {
        return '';
    }
}
/**
 * TODO 基础分页的相同代码封装，使前台的代码更少
 * @param $count 要分页的总记录数
 * @param int $pagesize 每页查询条数
 * @return \Think\Page
 */
function getpage($count, $pagesize = 10) {
    $p = new Think\Page($count, $pagesize);
    $p->setConfig('header', "条记录");
    $p->setConfig('prev', '<');
    $p->setConfig('next', '>');
    $p->setConfig('last', '末页');
    $p->setConfig('first', '首页');
    $p->setConfig('theme','<div class=ace-page><ul><li>  %upPage% %first%  %prePage%  %linkPage% %downPage%</li>  %totalRow%%header% %nowPage%/%totalPage%页</ul></div>');
    return $p;
}
/**
 * 实时显示提示信息
 * @param  string $msg 提示信息
 * @param  string $class 输出样式（success:成功，error:失败）
 * @author huajie <banhuajie@163.com>
 */
function showMsg($msg, $class = '')
{
    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\",\"{$class}\")</script>";
    flush();
    ob_flush();
}

/**
 * 在线更新
 * @author huajie <banhuajie@163.com>
 */
function update($version, $backup = 0)
{
    //检查是否有正在执行的任务
    $lock = './data/backup/update.lock';
    if (is_file($lock)) {
        showMsg('检测到有一个升级任务正在执行，请稍后再试！', 'error');
        exit;
    } else {
        //创建锁文件
        @touch($lock);
    }
    //PclZip类库不支持命名空间
    import('OT/PclZip');
    $date = date('YmdHis');
    sleep(1);
    //初始化信息
    showMsg('系统原始版本:' . C('YFCMF_VERSION'));
    showMsg('YFCMF在线更新日志：');
    showMsg('更新开始时间:' . date('Y-m-d H:i:s'));
    sleep(1);
    G('start1');
    if ($backup) {
        //备份重要文件
        showMsg('开始备份重要程序文件...');
        $backupallPath = 'data/backup/backupall_' . $date . '.zip';
        $zip = new \PclZip($backupallPath);
        $zip->create('app,public,ThinkPHP,.htaccess,admin.php,index.php');
        showMsg('成功完成重要程序备份,备份文件路径:<a href=\'' . __ROOT__ . '/' . $backupallPath . '\'>/' . $backupallPath . '</a>, 耗时:' . G('start1', 'stop1') . 's', 'success');
    }
    /* 获取更新包 */
    $updatedUrl = 'http://www.yfcmf.net/index.php?m=home&c=upgrade&a=get_updates';
    $params = array('version' => $version);
    $updates = go_curl($updatedUrl, 'post', http_build_query($params));
    if (empty($updates)) {
        $this->showMsg('未获取到更新包的下载地址', 'error');
        exit;
    }
    $updates = json_decode($updates, true);
    foreach ($updates as $v) {
        if (!empty($v['ver_downurl'])) {
            showMsg('开始获取' . $v['ver_curr'] . '->' . $v['ver_nextname'] . '远程更新包...');
            sleep(1);
            $zipPath = 'data/backup/update.zip';
            $downZip = go_curl($v['ver_downurl']);
            if (empty($downZip)) {
                showMsg('下载更新包出错，请重试或手动下载更新！', 'error');
                exit;
            }
            File::write_file($zipPath, $downZip);
            showMsg('获取' . $v['ver_curr'] . '->' . $v['ver_nextname'] . '远程更新包成功,更新包路径：<a href=\'' . __ROOT__ . '/' . ltrim($zipPath, '.') . '\'>/' . $zipPath . '</a>', 'success');
            sleep(1);
            showMsg($v['ver_curr'] . '->' . $v['ver_nextname'] . '更新包解压缩...');
            sleep(1);
            $zip = new \PclZip($zipPath);
            $res = $zip->extract(PCLZIP_OPT_PATH, './');
            if ($res === 0) {
                showMsg('解压缩失败：' . $zip->errorInfo(true) . '------更新终止', 'error');
                exit;
            }
            showMsg($v['ver_curr'] . '->' . $v['ver_nextname'] . '更新包解压缩成功', 'success');
            sleep(1);
            /* 更新数据库 */
            $updatesql = './update.sql';
            if (is_file($updatesql)) {
                showMsg('更新数据库开始...');
                if (file_exists($updatesql)) {
                    $Model = M();
                    $sql = File::read_file($updatesql);
                    $sql = str_replace("\r\n", "\n", $sql);
                    //替换表前缀
                    $default_tablepre = "yf_";
                    $tablepre = C('DB_PREFIX');
                    $sql = str_replace(" `{$default_tablepre}", " `{$tablepre}", $sql);
                    foreach (explode(";\n", trim($sql)) as $query) {
                        $Model->execute(trim($query));
                    }
                }
                @unlink($updatesql);
                showMsg('更新数据库完毕', 'success');
            }
            /* 系统版本号更新 */ //TODO
            $data = array('YFCMF_VERSION' => $v['ver_nextname']);
            $res = sys_config_setbyarr($data);
            if ($res === false) {
                showMsg($v['ver_curr'] . '->' . $v['ver_nextname'] . '更新系统版本号失败', 'error');
            } else {
                showMsg($v['ver_curr'] . '->' . $v['ver_nextname'] . '更新系统版本号成功', 'success');
            }
            sleep(1);
            showMsg($v['ver_curr'] . '->' . $v['ver_nextname'] . '更新完成');
        }
    }
    sleep(1);
    @unlink($lock);
    @unlink('./data/backup/update.zip');
    //清理缓存
    clear_cache();
    showMsg('##################################################################');
    showMsg('在线更新全部完成，如有备份，请及时将备份文件移动至非web目录下！', 'success');
}

/**
 * 清除缓存
 * @author xiaofeng<1034023036@qq.com>
 */
function clear_cache()
{
    remove_dir(TEMP_PATH);
    remove_dir(CACHE_PATH);
    remove_dir(DATA_PATH);
    file_exists($file = RUNTIME_PATH . 'common~runtime.php') && @unlink($file);
}

/**
 * 倒推后台菜单数组
 * $str String '方法名'或'控制器名/方法名'，为空则为'当前控制器/当前方法'
 * $status int 获取的menu是否含全部状态，还是仅status=1。不为0和1时,不限制
 * $arr boolean 是否返回全部数据数组，默认假，仅返回ids
 * @author xiaofeng<1034023036@qq.com>
 */
function get_menus_admin($str = '', $status = 1, $arr = false)
{
    $str = empty($str) ? CONTROLLER_NAME . '/' . ACTION_NAME : $str;
    if (strpos($str, '/') === false) {
        $str .= CONTROLLER_NAME;
    }
    $status = empty($status) ? 1 : $status;
    $arr = empty($arr) ? false : true;
    $where['name'] = $str;
    if ($status == 0 || $status == 1) {
        $where['status'] = $status;
    }
    $arr_rst = array();
    $rst = M('auth_rule')->where($where)->order('level desc,sort')->limit(1)->select();
    if ($rst) {
        $rst = $rst[0];
        if ($arr) {
            $arr_rst[] = $rst;
        } else {
            $arr_rst[] = $rst['id'];
        }
        $pid = $rst['pid'];
        while (intval($pid) != 0) {
            //非顶级
            $rst = M('auth_rule')->where(array('id' => $pid))->find();
            if ($arr) {
                $arr_rst[] = $rst;
            } else {
                $arr_rst[] = $rst['id'];
            }
            $pid = $rst['pid'];
        }
    }
    return array_reverse($arr_rst);
}

/**
 * 模拟post进行url请求
 * @param string $url
 * @param string $param
 */
function request_post($url = '', $param = '')
{
    if (empty($url) || empty($param)) {
        return false;
    }

    $postUrl = $url;
    $curlPost = $param;
    $ch = curl_init(); //初始化curl
    curl_setopt($ch, CURLOPT_URL, $postUrl); //抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1); //post提交方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    $data = curl_exec($ch); //运行curl
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        var_dump(curl_error($ch));
        die();
    }
    curl_close($ch);

    return $data;
}


/**
 * 获取入金费率
 * @param $id  入金表ID
 * @return mixed 入金费率
 */
function getPayinRate($id)
{
    $product = M('product')->where(array('product_id' => $id))->getField('payin_rate_id');
    if ($product) {
        $rate = M('payin_rate')->where(array('payin_rate_id' => $product))->find();
        return $rate['inrate'];
    } else {
        return null;
    }


}

/**
 * 获取出金费率清单
 * @param $id 出金表ID
 * @return bool|mixed
 */
function getPayoutRate($id)
{
    $rate = M('payout_rate')->where(array('payout_rate_id' => $id))->find();
    if ($rate) {
        return $rate;
    } else {
        return false;
    }

}


function getExcel($fileName, $headArr, $data)
{
    //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
    import("Org.Util.PHPExcel");
    import("Org.Util.PHPExcel.Writer.Excel2007");
    import("Org.Util.PHPExcel.IOFactory.php");
    $date = date("Y_m_d", time());
    $fileName .= "_{$date}.xls";
    //创建PHPExcel对象，注意，不能少了\
    $objPHPExcel = new \PHPExcel();

    $objPHPExcel->getProperties()->setCreator("Da")
        ->setLastModifiedBy("Da")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $objProps = $objPHPExcel->getProperties();

    //设置表头
    $key = ord("A");
    //print_r($headArr);exit;
    foreach ($headArr as $v) {
        $colum = chr($key);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($colum . '1', $v);
        $key += 1;
    }

    $column = 2;
    $objActSheet = $objPHPExcel->getActiveSheet();
    //Set column widths 设置列宽度
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
    //E 列为文本
    //print_r($data);exit;
    foreach ($data as $key => $rows) { //行写入
        $span = ord("A");
        foreach ($rows as $keyName => $value) {// 列写入
            $j = chr($span);
            $objActSheet->setCellValue($j . $column, $value);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit($j.$column,$value,\PHPExcel_Cell_DataType::TYPE_STRING);
            $span++;
        }
        $column++;
    }

    $fileName = iconv("utf-8", "gb2312", $fileName);

    //重命名表
    //$objPHPExcel->getActiveSheet()->setTitle('test');
    //设置活动单指数到第一个表,所以Excel打开这是第一个表
    $objPHPExcel->setActiveSheetIndex(0);
    ob_end_clean();//清除缓冲区,避免乱码
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename=\"$fileName\"");
    header('Cache-Control: max-age=0');

    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output'); //文件通过浏览器下载
    exit;
}


/**
 * 格式化金额
 * @param int $money
 * @param int $len
 * @param string $sign
 * @return string
 */
function format_money($money, $len = 2, $sign = '￥')
{
    $negative = $money > 0 ? '' : '-';
    $int_money = intval(abs($money));
    $len = intval(abs($len));
    $decimal = '';//小数
    if ($len > 0) {
        $decimal = '.' . substr(sprintf('%01.' . $len . 'f', $money), -$len);
    }
    $format_money = "";
    $tmp_money = strrev($int_money);
    $strlen = strlen($tmp_money);
    for ($i = 3; $i < $strlen; $i += 3) {
        $format_money .= substr($tmp_money, 0, 3) . ',';
        $tmp_money = substr($tmp_money, 3);
    }
    $format_money .= $tmp_money;
    $format_money = strrev($format_money);
    return $sign . $negative . $format_money . $decimal;
}

//翻譯銀行名稱
function getBankName($bankCode)
{
    $bankName = C('bank');
    if (empty($bankName[$bankCode])) {
        return null;
    }
    return $bankName[$bankCode];
}

function getBankCode($bankName)
{
    $codeBank = C('bankcode');
    if (empty($codeBank[$bankName])) {
        return null;
    }
    return $codeBank[$bankName];
}

//翻譯訂單狀態名稱
function getPayinStatus($status)
{
    switch ($status) {
        case -1:
            return "失败";
            break;
        case 0:
            return "待支付";
            break;
        case 1:
            return "成功";
            break;
        case 2:
            return "退款中";
            break;
        case 3:
            return "退款成功";
            break;
        case 4:
            return "退款成功";
            break;
    }

}

//翻譯訂單狀態名稱
function getPayoutStatusName($status)
{
    if ($status == 0) {
        return "待審核";
    }
    if ($status == 1) {
        return "審核通過";
    }
    if ($status == 2) {
        return "審核失敗";
    }
    if ($status == 3) {
        return "處理中";
    }
    if ($status == 4) {
        return "轉賬成功";
    }
    if ($status == 5) {
        return "轉賬失敗";
    }
    if ($status == 6) {
        return "同步成功";
    }

}

/*
 * 检测出金订单重复
 */
function checkPayoutOrderId($payout_orderid)
{
    if (M('payout')->where(array('payout_orderid' => $payout_orderid))->find()) {
        return false;  //有结果返回错误
    } else {
        return true;
    }

}

//根据商户号创建ID
function createOrder($userinfoId)
{
    $orderNum = $userinfoId . date('YmdHis') . Stringnew::randString(5);
    return $orderNum;
}


/**
 * 将一个数值切成N份
 * @param  int $number 切的数值
 * @param  int $maxNumber 最大值
 * @return array
 */
function getOrderNumber($number, $maxNumber)
{
    if ($number == 0) {
        return false;
    } else {
        $num = ceil($number / $maxNumber);//获取数量
        $array = array();
        $tempNumber = $number;
        for ($i = 0; $i < $num; $i++) {
            if ($tempNumber > $maxNumber) {
                array_push($array, $maxNumber);
            } else {
                array_push($array, $tempNumber);
            }
            $tempNumber = $tempNumber - $maxNumber;
        }
    }
    return $array;
}

/**
 * API入金訂單成功
 * 補單成功
 * @param $id  補單訂單ID
 * @param $orderId 平台訂單ID
 * @param $payOrderId 上游返回訂單ID
 * @return bool 成功返回 true 失敗返回 false
 */
function payinOrderRepairSuccess($id, $orderId, $payOrderId)
{
    if (empty($payOrderId)) {
        $payOrderId = 'Repair' . date('YmdHis');
    }
    $end_time = time();
    if ($id or $orderId) {
        //補單操作
        if ($id) {
            //获取用户的基础信息
            $info = M('payin')->field('payin_id,uid,transid,orderid,payment_id,payment_mid,currency_id,paybank,product_id,ordermoney,free,notifyurl,returnurl,begin_time,end_time,remark,status')->where(array('payin_id' => $id, 'status' => '0', 'notice_status' => 0))->find();
            if ($info) {
                $balance = M('user_balance')->field('sumcount,availablecount')->where(array('user_id' => $info['uid'], 'currency_id' => $info['currency_id']))->find();
                $fee = number_format($info['ordermoney'] * getPayinRate($info['product_id']), 4, '.', '');
                $data = array('factmoney' => $info['ordermoney'], 'free' => $fee, 'pay_orderid' => $payOrderId, 'end_time' => $end_time, 'status' => '1');
                //订单状态修改
                $orderState = M('payin')->where(array('payin_id' => $info['payin_id']))->save($data);
                if ($orderState) {
                    $sumcount = $balance['sumcount'] + $info['ordermoney'] - $fee;
                    $availablecount = $balance['availablecount'] + $info['ordermoney'] - $fee;
                    //支付成功记录
                    $userInfoResult = M('user_balance')->where(array('user_id' => $info['uid'], 'currency_id' => $info['currency_id']))->save(array('sumcount' => $sumcount, 'availablecount' => $availablecount));
                    if ($userInfoResult && PayinSubUserBalanceUpdate($info['uid'], $info['payment_mid'], $info['currency_id'], $info['paybank'], $info['ordermoney'] - $fee)) {
                        //寫入日誌
                        $orderLog = addOrderLog($info['orderid'], $info['uid'], 1, $info['ordermoney'], $sumcount + $fee, $info['begin_time'], $end_time, $info['remark']);
                        if ($orderLog) {
                            $freeLog = addOrderLog($info['orderid'], $info['uid'], 3, $fee, $sumcount, $info['begin_time'], time(), '');
                            if ($freeLog) {
                                //發送客戶消息
                                $chatId_case = getChatId($info['uid'],0);
                                if ($chatId_case) {
                                    $message_case = "<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";
                                    //發送到客戶
                                    telegramSendMessage($chatId_case, $message_case);
                                    //入金發送給自己組
//                                    $chatId_master = "-129211480";
//                                    $message_master = "<code>供應商: " . getPaymentName($info['payment_id']) . "-" . getSubUserBalanceAttributeName($info['paybank']) . "</code>%0A<code>MID: " . getMidName($info['payment_mid']) . "</code>%0A<code>入金客戶: " . getUserinfoName($info['uid']) . "</code>%0A<code>可用餘額: CNY " . number_format($availablecount, 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";
//
//                                    telegramSendMessage($chatId_master, $message_master);
                                }
                                $chatId_master = "-238443852";
                                $message_master = "<code>供應商: " . getPaymentName($info['payment_id']) ."-".getSubUserBalanceAttributeName($info['paybank']). "</code>%0A<code>MID: " . getMidName($info['payment_mid']) . "</code>%0A<code>入金客戶: " . getUserinfoName($info['uid']) . "</code>%0A<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') .  "</code>%0A<code>可用餘額: CNY " . number_format($availablecount, 2, '.', ',').
                                    "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";

                                telegramSendMessage($chatId_master, $message_master);
                                return true;
                            } else {
                                $content = $info['orderid'] . '###' . $fee . '手續費日誌添加失敗';
                                addLog($info['uid'], 2, 'payin', 'repair', $content);
                                return false;
                            }
                        } else {
                            $content = $info['orderid'] . '###' . $info['ordermoney'] . '入金訂單日誌添加失敗';
                            addLog($info['uid'], 2, 'payin', 'repair', $content);
                            return false;
                        }

                    } else {
                        //寫入錯誤日誌
                        $content = $info['orderid'] . '###' . $info['ordermoney'] . '入金訂單用戶餘額日誌修改失敗';
                        addLog($info['uid'], 2, 'payin', 'repair', $content);
                        return false;
                    }

                } else {
                    //寫入錯誤日誌
                    $content = $info['orderid'] . '###' . $info['ordermoney'] . '入金訂單狀態修改失敗';
                    addLog($info['uid'], 2, 'payin', 'repair', $content);
                    return false;
                }

            }
        } else {
            return false;
        }
        //訂單入金成功
        if ($orderId) {
            //获取用户的基础信息
            $info = M('payin')->field('payin_id,uid,transid,orderid,payment_id,payment_mid,currency_id,paybank,product_id,ordermoney,free,notifyurl,returnurl,begin_time,end_time,remark,status')->where(array('orderid' => $orderId, 'status' => '0', 'notice_status' => 0))->find();
            if ($info) {
                $balance = M('user_balance')->field('sumcount,availablecount')->where(array('user_id' => $info['uid'], 'currency_id' => $info['currency_id']))->find();
                $fee = number_format($info['ordermoney'] * getPayinRate($info['product_id']), 4, '.', '');
                $data = array('factmoney' => $info['ordermoney'], 'free' => $fee, 'pay_orderid' => $payOrderId, 'end_time' => $end_time, 'status' => '1');
                //订单状态修改
                $orderState = M('payin')->where(array('payin_id' => $info['payin_id']))->save($data);
                if ($orderState) {
                    $sumcount = $balance['sumcount'] + $info['ordermoney'] - $fee;
                    $availablecount = $balance['availablecount'] + $info['ordermoney'] - $fee;
                    //支付成功记录
                    $userInfoResult = M('user_balance')->where(array('user_id' => $info['uid'], 'currency_id' => $info['currency_id']))->save(array('sumcount' => $sumcount, 'availablecount' => $availablecount));
                    if ($userInfoResult && PayinSubUserBalanceUpdate($info['uid'], $info['payment_mid'], $info['currency_id'], $info['paybank'], $info['ordermoney'] - $fee)) {
                        //寫入日誌
                        $orderLog = addOrderLog($info['orderid'], $info['uid'], 1, $info['ordermoney'], $sumcount + $fee, $info['begin_time'], $end_time, $info['remark']);
                        //發送客戶消息
                        $chatId_case = getChatId($info['uid'],0);
                        if ($chatId_case) {
                            $message_case = "<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";
                            //發送到客戶
                            telegramSendMessage($chatId_case, $message_case);
                            //入金發送給自己組
//                            $chatId_master = "-129211480";
//                            $message_master = "<code>供應商: " . getPaymentName($info['payment_id']) . "-" . getSubUserBalanceAttributeName($info['paybank']) . "</code>%0A<code>MID: " . getMidName($info['payment_mid']) . "</code>%0A<code>入金客戶: " . getUserinfoName($info['uid']) . "</code>%0A<code>可用餘額: CNY " . number_format($availablecount, 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";
//
//                            telegramSendMessage($chatId_master, $message_master);
                        }
                        if ($orderLog) {
                            $freeLog = addOrderLog($info['orderid'], $info['uid'], 3, $fee, $sumcount, $info['begin_time'], $end_time, '');
                            if ($freeLog) {
                                $chatId_master = "-238443852";
                                $message_master = "<code>供應商: " . getPaymentName($info['payment_id']) ."-".getSubUserBalanceAttributeName($info['paybank']). "</code>%0A<code>MID: " . getMidName($info['payment_mid']) . "</code>%0A<code>入金客戶: " . getUserinfoName($info['uid']) . "</code>%0A<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') .  "</code>%0A<code>可用餘額: CNY " . number_format($availablecount, 2, '.', ',').
                                    "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";

                                telegramSendMessage($chatId_master, $message_master);
                                return true;
                            } else {
                                $content = $info['orderid'] . '###' . $fee . '手續費日誌添加失敗';
                                addLog($info['uid'], 2, 'payin', 'Api/Payin', $content);
                                return false;
                            }
                        } else {
                            $content = $info['orderid'] . '###' . $info['ordermoney'] . '入金訂單日誌添加失敗';
                            addLog($info['uid'], 2, 'payin', 'Api/Payin', $content);
                            return false;
                        }

                    } else {
                        //寫入錯誤日誌
                        $content = $info['orderid'] . '###' . $info['ordermoney'] . '入金訂單用戶餘額日誌修改失敗';
                        addLog($info['uid'], 2, 'payin', 'Api/Payin', $content);
                        return false;
                    }

                } else {
                    //寫入錯誤日誌
                    $content = $info['orderid'] . '###' . $info['ordermoney'] . '入金訂單狀態修改失敗';
                    addLog($info['uid'], 2, 'payin', 'Api/Payin', $content);
                    return false;
                }

            }
        } else {
            return false;
        }
    } else {
        return false;
    }


}

/**
 * 成功訂單補發Notify 異步通知 五遍！
 * @param $id 訂單ID
 * @return bool
 */
function payinOrderNoticeState($id)
{
    //获取用户的基础信息
    $info = M('payin')->field('payin_id,uid,transid,orderid,ordermoney,free,notifyurl,returnurl,begin_time,end_time,remark,status')->where(array('payin_id' => $id, 'status' => '1', 'notice_status' => 0))->find();
    if ($info) {
        $Signkeyi = M('userinfo')->field('md5key')->where(array('user_id' => $info['uid']))->find();
        $Md5key = $Signkeyi['md5key'];
        $mMark = "&";
        $company_code = $info['uid'];
        $order_number = $info['transid'];
        $order_amount = $info['ordermoney'];
        $remark = $info['remark'];
        $order_status = '1';
        $system_order_number = $info['orderid'];
        $sett_date = date('d-m-Y H:i:s', $info['end_time']);
        $order_fee = $info['free'];
        $timestamp = time();
        $sign_type = 'SHA256';
        $version = '1.0';
        $string = $company_code . $mMark . $order_number . $mMark . $order_amount . $mMark . $order_status . $mMark . $system_order_number . $mMark . $sett_date . $mMark . $order_fee . $mMark . $timestamp . $mMark . $sign_type . $mMark . $version . $mMark . $Md5key;
        $sign = hash('sha256', $string);
        $post_data = array(
            'company_code' => $company_code,
            'order_number' => $order_number,
            'order_amount' => $order_amount,
            'remark' => $remark,
            'order_status' => $order_status,
            'system_order_number' => $system_order_number,
            'sett_date' => $sett_date,
            'order_fee' => $order_fee,
            'timestamp' => $timestamp,
            'sign_type' => $sign_type,
            'version' => $version,
            'sign' => $sign
        );

        $url = $info['notifyurl'];
        $o = "";
        //格式化数组成为字符串
        foreach ($post_data as $k => $v) {
            $o .= "$k=" . urlencode($v) . "&";
        }
        $post_data = substr($o, 0, -1);
        //通知五次到客户
        for ($i = 0; $i < 5; $i++) {
            $res = go_curl($url,'post', $post_data);

            $LOG_FILE = "./log/" . $company_code . '###--' . date("Ymd") . ".txt";
            $fp2 = @fopen($LOG_FILE, "a+");
            fwrite($fp2, $res .var_export($post_data,true). "\n");
            fclose($fp2);

            if (strpos($res, "success") !== false) {
                //更新系统通知，并中断循环
                $rs = M('payin')->where(array('payin_id' => $id))->save(array('notice_status' => 1));
                if ($rs) {
                    return true;
                } else {
                    return false;
                }
                break;
            }
        }
    } else {
        return false;
    }

}

/**
 * 添加訂單日誌
 * 訂單ID AND 訂單類型 不可以重複
 * @param $orderId  訂單ID
 * @param $uid 用戶ID
 * @param $t_type 訂單類型
 * @param $ordermoney 訂單金額
 * @param $balance 用戶餘額
 * @param $begin_time 訂單開始時間
 * @param $end_time 訂單結束時間
 * @param $remark 備註
 * @return bool
 */
function addOrderLog($orderId, $uid, $t_type, $ordermoney, $balance, $begin_time, $end_time, $remark)
{
    $orderLogResult = M('order_log')->where(array('orderid' => $orderId, 't_type' => $t_type))->find();
    if ($orderLogResult) {
        return false;
    } else {
        if ($t_type == 1) {
            $datalog = array(
                'uid' => $uid,
                't_type' => $t_type,
                'orderid' => $orderId,
                'income' => $ordermoney,
                'balance' => $balance,
                'begin_time' => $begin_time,
                'end_time' => $end_time,
                'remark' => $remark
            );
        } else {
            $datalog = array(
                'uid' => $uid,
                't_type' => $t_type,
                'orderid' => $orderId,
                'outlay' => $ordermoney,
                'balance' => $balance,
                'begin_time' => $begin_time,
                'end_time' => $end_time,
                'remark' => $remark
            );
        }

        $rs = M('order_log')->add($datalog);
        if ($rs) {
            return true;
        } else {
            return false;
        }

    }
}

/**
 * 增加操作日誌
 * @param $uid 商戶MID
 * @param $log_type 日誌類型 1:成功 2：失败
 * @param $model 操作模型
 * @param $action 操作方法
 * @param $content 內容
 * @return bool
 */
function addLog($uid, $log_type, $model, $action, $content)
{
    $log_data = array(
        'uid' => $uid,
        'log_type' => $log_type,
        'model' => $model,
        'action' => $action,
        'content' => $content,
        'last_time' => date('Y-m-d H:i:s'),
        'ip' => get_client_ip(0, true)
    );
    $rs = M('log')->add($log_data);
    if ($rs) {
        return true;
    } else {
        return false;
    }
}
/**
 * 增加充值sms操作日誌
 * @param $uid 商戶MID
 * @param $log_type 日誌類型 1:成功 2：失败
 * @param $model 操作模型
 * @param $action 操作方法
 * @param $content 內容
 * @return bool
 */
function sms_addLog($uid,$check_id, $log_type, $model, $action, $content)
{
    $log_data = array(
        'uid' => $uid,
        'checkid' =>$check_id,
        'log_type' => $log_type,
        'model' => $model,
        'action' => $action,
        'content' => $content,
        'last_time' => time(),
        'ip' => get_client_ip(0, true),
    );
    $rs = M('sms_recharge')->add($log_data);
    if ($rs) {
        return true;
    } else {
        return false;
    }
}

/**
 * 增加充值钱包操作日誌
 * @param $uid 商戶MID
 * @param $log_type 日誌類型 1:成功 2：失败
 * @param $model 操作模型
 * @param $action 操作方法
 * @param $content 內容
 * @return bool
 */
function wallet_addLog($uid,$check_id, $log_type, $model, $action, $content)
{
    $log_data = array(
        'uid' => $uid,
        'checkid' =>$check_id,
        'log_type' => $log_type,
        'model' => $model,
        'action' => $action,
        'content' => $content,
        'last_time' => time(),
        'ip' => get_client_ip(0, true),
    );
    $rs = M('wallet_payin_log')->add($log_data);
    if ($rs) {
        return true;
    } else {
        return false;
    }
}
/**
 * 增加充值鉴权操作日誌
 * @param $uid 商戶MID
 * @param $log_type 日誌類型 1:成功 2：失败
 * @param $model 操作模型
 * @param $action 操作方法
 * @param $content 內容
 * @return bool
 */
function recharge_addLog($uid,$check_id, $log_type, $model, $action, $content)
{
    $log_data = array(
        'uid' => $uid,
        'checkid' =>$check_id,
        'log_type' => $log_type,
        'model' => $model,
        'action' => $action,
        'content' => $content,
        'last_time' => time(),
        'ip' => get_client_ip(0, true)
    );
    $rs = M('check_recharge')->add($log_data);
    if ($rs) {
        return true;
    } else {
        return false;
    }
}

//出金订单三个状态，1、出金提交申请，增加未结算金额
//2、出金订单成功   3、出金订单失败处理
/**
 * 出金修改商戶總額
 * @param $uid 商戶ID
 * @param $ordermoney 訂單金額
 * @param $free 訂單手續費
 * @return bool
 */
function payoutOrderApply($uid, $currency_id, $ordermoney, $free)
{
    //获取商户信息
    $userinfo = M('user_balance')->where(array('user_id' => $uid, 'currency_id' => $currency_id))->find();
    $availablecount = $userinfo['availablecount'] - $ordermoney - $free; //可用余额
    $unsettlement = $userinfo['unsettlement'] + $ordermoney + $free; //未结算金额
    $userinfo_data = array(
        'availablecount' => $availablecount,
        'unsettlement' => $unsettlement,
    );
    $u_userinfo = M('user_balance')->where(array('user_id' => $uid, 'currency_id' => $currency_id))->save($userinfo_data);
    if ($u_userinfo) {
        return true;
    } else {
        return false;
    }

}

/**
 * 根据名字获取ID -导入报表用
 * @param $vName 区域名称
 * @return bool
 */
function getRegionId($vName)
{
    $map['name'] = array('like', "%" . $vName . "%");
    $res = M('region')->where($map)->find();
    if ($res) {
        return $res['id'];
    } else {
        return false;
    }

}

/**
 * 根据ID获取名字 - 显示列表用
 * @param $vId
 * @return bool
 */
function getRegionName($vId)
{
    $map['id'] = array('like', "%" . $vId . "%");
    $res = M('region')->where($map)->find();
    if ($res) {
        return $res['name'];
    } else {
        return false;
    }
}

/**
 * 传入一个JSON数组，返回一个JSON中文值
 * @param $jsonDate
 * @return string
 */
function getProductName($jsonDate)
{
    $product_list_id = json_decode($jsonDate, true);
    $product_name = array();
    foreach ($product_list_id as $v) {
        $name = M('product')->where(array('product_id' => $v))->getField('product_title');
        array_push($product_name, $name);
    }
    return json_encode($product_name, JSON_UNESCAPED_UNICODE);

}

/**
 * 根据JSON获取货币名称
 * @param $jsonDate
 * @return string
 */
function getCurrencyCode($jsonDate)
{
    $currency_list_id = json_decode($jsonDate, true);
    $currency_code = array();
    foreach ($currency_list_id as $v) {
        $name = M('currency')->where(array('ccy_id' => $v))->getField('ccy_code');
        array_push($currency_code, $name);
    }
    return json_encode($currency_code, JSON_UNESCAPED_UNICODE);

}

/**
 * 获取货币名称 -单个
 * @param $currency_id
 * @return mixed|null
 */
function getCurrencyName($currency_id)
{
    $name = M('currency')->where(array('ccy_id' => $currency_id))->getField('ccy_code');
    if ($name) {
        return $name;
    } else {
        return null;
    }

}

/**
 * 根据用户ID 和 货币ID 获取用户的余额值
 * @param $userId
 * @param $currencyId
 * @return mixed
 */
function getUserBalance($userId, $currencyId)
{
    if (empty($currencyId)) {
        $currencyId = 1;
    }
    $balance = M('user_balance')->where(array('user_id' => $userId, 'currency_id' => $currencyId))->find();
    if ($balance) {
        return $balance;
    } else {
        $balance['info'] = 'error';
        return $balance;
    }
}

/**
 * 获取支付公司中文名称
 * @param $p_id
 * @return mixed|null
 */
function getPaymentName($p_id)
{
    $paymentName = M('payment_name')->where(array('api_id' => $p_id))->getField('api_china_name');
    if ($paymentName) {
        return $paymentName;
    } else {
        return null;
    }
}

/**
 * 獲取MID中文名字
 * @param $p_id
 * @return mixed|null
 */
function getMidName($m_id)
{
    $midName = M('payment_mid')->where(array('m_id' => $m_id))->getField('title');
    if ($midName) {
        return $midName;
    } else {
        return null;
    }
}

/**
 * 獲取商戶名稱
 * @param $p_id
 * @return mixed|null
 */
function getUserinfoName($uid)
{
    $userinfoName = M('userinfo')->where(array('user_id' => $uid))->getField('member_name');
    if ($userinfoName) {
        return $userinfoName;
    } else {
        return null;
    }
}

/**
 * 获取今年的开始时间时间戳
 * @param $year 年份 如2014
 * @return int
 */
function getYearTime($year = 0)
{
    if ($year != 0) {
        return strtotime("1 January $year");
    }
    $y = date("y", time());
    return strtotime("1 January $y");
}

function getProductAttribute($attribute)
{
    if ($attribute == '0') {
        return '网银';
    }
    if ($attribute == 'weixin') {
        return '微信';
    }
    if ($attribute == 'alipay') {
        return '支付宝';
    }

}

/**
 * @param $chatId 發送消息ID
 * @param $text   發送消息
 * @return bool
 */
function telegramSendMessage($chatId, $text)
{
    //Easypay Payin -238443852
    //Easypay Payout -233190543

        $botToken = "424731176:AAGA88peU1Dzn2ktnuTMynfBweEURc73fyk";

//    dump($chatId);die;
    $website = "https://api.telegram.org/bot" . $botToken;
    $text .= "%0A<code>支付平台: paypaypro</code>";
    $resualt = go_curl($website . "/sendmessage?parse_mode=HTML&chat_id=" . $chatId . "&text=" . $text,'1');

    $resualtArray = json_decode($resualt, true);

    if ($resualtArray['ok'] == 1) {

        $fps = @fopen("telegram_message.txt", "a+");
        fwrite($fps, var_export($resualtArray, true));
        fclose($fps);
        return true;
    } else {
        $fps = @fopen("telegram_message.txt", "a+");
        fwrite($fps, var_export($resualtArray, true));
        fclose($fps);
        return false;
    }

}

/**
 * 獲取telegram_group_id
 * @param $user_id
 * @return mixed|null
 */
function getChatId($user_id,$type)
{
    $chatId = M('telegram_user')->where(array('user_id' => $user_id,'telegram_type'=>$type, 'status' => 1))->getField('telegram_user_id');
    if ($chatId) {
        return $chatId;
    } else {
        return false;
    }

}


/**
 * 除去数组中的空值和签名参数
 * @param $para 签名参数组
 * return 去掉空值与签名参数后的新签名参数组
 */
function paraFilter($para)
{
    $para_filter = array();
    while (list ($key, $val) = each($para)) {
        if ($key == "sign" || $key == "signType" || $val == "") continue;
        else    $para_filter[$key] = $para[$key];
    }
    return $para_filter;
}

/**
 * 对数组排序
 * @param $para 排序前的数组
 * return 排序后的数组
 */
function argSort($para)
{
    ksort($para);
    reset($para);
    return $para;
}

/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstring($para)
{
    $arg = "";
    while (list ($key, $val) = each($para)) {
        $arg .= $key . "=" . $val . "&";
    }
    //去掉最后一个&字符
    $arg = substr($arg, 0, count($arg) - 2);

    //如果存在转义字符，那么去掉转义
    if (get_magic_quotes_gpc()) {
        $arg = stripslashes($arg);
    }


    return $arg;
}

/**
 * @param $user_id  用戶ID
 * @param $m_id  支付MID
 * @param $currency_id 支付貨幣
 * @param $attribute 支付屬性（支付寶，微信）前期使用
 * @param $orderMoney 訂單金額
 */
function PayinSubUserBalanceUpdate($user_id, $m_id, $currency_id, $attribute, $orderMoney)
{
    if ($attribute == 'alipay') {
        $sub_user_balance = M('sub_user_balance')->where(array('user_id' => $user_id, 'currency_id' => $currency_id, 'attribute' => 'alipay'))->find();
        if ($sub_user_balance) {
            $user_data = array(
                'm_id' => $m_id,
                'sub_user_balance' => $sub_user_balance['sub_user_balance'] + $orderMoney,
                'update_at' => time(),
            );
            $sub_user_resualt = M('sub_user_balance')->where(array('user_id' => $user_id, 'currency_id' => $currency_id, 'attribute' => 'alipay'))->save($user_data);
            if ($sub_user_resualt) {
                return true;
            } else {
                return false;
            }
        } else {
            $user_data = array(
                'user_id' => $user_id,
                'm_id' => $m_id,
                'currency_id' => $currency_id,
                'attribute' => 'alipay',
                'sub_user_balance' => $orderMoney,
                'created_at' => date('Y-m-d H:i:s'),
                'update_at' => time(),
            );
            $sub_user_resualt = M('sub_user_balance')->add($user_data);
            if ($sub_user_resualt) {
                return true;
            } else {
                return false;
            }
        }
    } elseif ($attribute == 'weixin') {
        $sub_user_balance = M('sub_user_balance')->where(array('user_id' => $user_id, 'currency_id' => $currency_id, 'attribute' => 'weixin'))->find();
        if ($sub_user_balance) {
            $user_data = array(
                'm_id' => $m_id,
                'sub_user_balance' => $sub_user_balance['sub_user_balance'] + $orderMoney,
                'update_at' => time(),
            );
            $sub_user_resualt = M('sub_user_balance')->where(array('user_id' => $user_id, 'currency_id' => $currency_id, 'attribute' => 'weixin'))->save($user_data);
            if ($sub_user_resualt) {
                return true;
            } else {
                return false;
            }
        } else {
            $user_data = array(
                'user_id' => $user_id,
                'm_id' => $m_id,
                'currency_id' => $currency_id,
                'attribute' => 'weixin',
                'sub_user_balance' => $orderMoney,
                'created_at' => date('Y-m-d H:i:s'),
                'update_at' => time(),
            );
            $sub_user_resualt = M('sub_user_balance')->add($user_data);
            if ($sub_user_resualt) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        $sub_user_balance = M('sub_user_balance')->where(array('user_id' => $user_id, 'currency_id' => $currency_id, 'attribute' => '0'))->find();
        if ($sub_user_balance) {
            $user_data = array(
                'm_id' => $m_id,
                'sub_user_balance' => $sub_user_balance['sub_user_balance'] + $orderMoney,
                'update_at' => time(),
            );
            $sub_user_resualt = M('sub_user_balance')->where(array('user_id' => $user_id, 'currency_id' => $currency_id, 'attribute' => '0'))->save($user_data);

            if ($sub_user_resualt) {
                return true;
            } else {
                return false;
            }
        } else {
            $user_data = array(
                'user_id' => $user_id,
                'm_id' => $m_id,
                'currency_id' => $currency_id,
                'attribute' => '0',
                'sub_user_balance' => $orderMoney,
                'created_at' => date('Y-m-d H:i:s'),
                'update_at' => time(),
            );
            $sub_user_resualt = M('sub_user_balance')->add($user_data);
            if ($sub_user_resualt) {
                return true;
            } else {
                return false;
            }
        }
    }

}

function getSubUserBalanceAttributeName($attribute)
{
    switch ($attribute) {
        case 'weixin':
            return '微信';
            break;
        case  'alipay':
            return '支付寶';
            break;
        default;
            return '網關';
    }

}

/**
 * @param $id 子賬戶ID
 * @param $orderMoney  訂單金額
 * @return bool
 */
function payoutSubUserBalanceUpdate($id, $orderMoney)
{
    $payout_sub_balance_list = M('sub_user_balance')->where(array('sub_balance_id' => $id))->find();
    if ($payout_sub_balance_list) {
        if ($payout_sub_balance_list['sub_user_balance'] < $orderMoney) {
            return false;
        } else {
            $sub_sunconut = $payout_sub_balance_list['sub_user_balance'] - $orderMoney;
            $rst = M('sub_user_balance')->where(array('sub_balance_id' => $id))->save(array('sub_user_balance' => $sub_sunconut));
            if ($rst) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}
/**
 * POST data
 */
function curl_post($url, $data)
{
    $this_header = array("content-type: application/x-www-form-urlencoded;charset=UTF-8");

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HTTPHEADER, $this_header);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36');
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $tmpInfo = curl_exec($curl);
    if (curl_errno($curl)) {
        echo 'Errno' . curl_error($curl);
    }
    curl_close($curl);
    return $tmpInfo;
}


function curl_post2($url, $data)
{//file_get_content
    $postdata = http_build_query(
        $data
    );
    $opts = array('http' =>
        array(
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        )
    );
    $context = stream_context_create($opts);
    $result = file_get_contents($url, false, $context);
    return $result;
}


/**
 * @param $uname 日志文件名
 * @param $text
 * 记录自己的日志
 */
function RecordLog($uname, $text)
{
    $date_time = date("Y年m月d H:i:s");
    $LOG_FILE = "./log/" . date("Ymd") . $uname . ".txt";
    $text = "$date_time  " . $text;

    if (!file_exists($LOG_FILE)) {
        touch($LOG_FILE);
        //chmod($LOG_FILE,"744");
    }

    $fd = @fopen($LOG_FILE, "a");
    @fwrite($fd, $text . "\r\n");
    @fclose($fd);
}


function get_parent_id($cid)
{
    $pids = '';
    $parent_id = M('agent_list')->where(array('agent_list_id' => $cid))->getField('agent_list_pid');
    if ($parent_id != '') {
        $pids .= $parent_id;
        $npids = get_parent_id($parent_id);
        if (isset($npids)) {
            $pids .= ',' . $npids;
        }
    }
    return $pids;
}

function getAgentSub($agentId)
{
    //獲取子集
    $nav_ag_sub = new \Org\Util\Leftnav;
    $menus_ag_sub = M('agent_list')->field('agent_list_id,agent_list_pid,agent_list_payin_rate,agent_list_weixin_rate,agent_list_alipay_rate')->order('agent_list_id')->select();
    //所有的代理ID
    $arr_ag_sub = $nav_ag_sub::menu_j($menus_ag_sub, '', $agentId);

    return $arr_ag_sub;

}
//整合鉴权数据
function build_post_str(array $post_data)
{
    $post_str = '';
    foreach ($post_data as $k => $v) {
        $post_str .= '&'.$k.'='.$v;
    }

    return substr($post_str, 1);
}

function getAgentSubRate($agentId)
{

    $arr_ag_sub = getAgentSub($agentId);

    $agentSubRate = array();
    $agentSubRate[$agentId] = getAgentRateCost($agentId);

    if ($arr_ag_sub) {

        foreach ($arr_ag_sub as $ka => $va) {
            if ($va['lvl'] == '1') {

                if (($va['agent_list_payin_rate'] - $agentSubRate[$agentId]['agent_list_payin_rate']) > 0) {
                    $agentSubRate[$va['agent_list_id']]['agent_list_payin_rate'] = $va['agent_list_payin_rate'] - $agentSubRate[$agentId]['agent_list_payin_rate'];
                } else {
                    $agentSubRate[$va['agent_list_id']]['agent_list_payin_rate'] = '0';
                }

                if (($va['agent_list_weixin_rate'] - $agentSubRate[$agentId]['agent_list_weixin_rate']) > 0) {
                    $agentSubRate[$va['agent_list_id']]['agent_list_weixin_rate'] = $va['agent_list_weixin_rate'] - $agentSubRate[$agentId]['agent_list_weixin_rate'];
                } else {
                    $agentSubRate[$va['agent_list_id']]['agent_list_weixin_rate'] = '0';
                }

                if (($va['agent_list_alipay_rate'] - $agentSubRate[$agentId]['agent_list_alipay_rate']) > 0) {
                    $agentSubRate[$va['agent_list_id']]['agent_list_alipay_rate'] = $va['agent_list_alipay_rate'] - $agentSubRate[$agentId]['agent_list_alipay_rate'];
                } else {
                    $agentSubRate[$va['agent_list_id']]['agent_list_alipay_rate'] = '0';
                }

            }
        }

        return $agentSubRate;
    } else {
        return false;
    }

}

function getAgentUpRate($agentId,$pid)
{
    //agentId 已经是顶级的情况
    $agentIdlist = M('agent_list')->where(array('agent_list_id' => $agentId))->field('agent_list_payin_rate,agent_list_weixin_rate,agent_list_alipay_rate')->find();

    $agentPidlist = M('agent_list')->where(array('agent_list_id' => $pid))->field('agent_list_payin_rate,agent_list_weixin_rate,agent_list_alipay_rate')->find();

    if ($agentIdlist) {
        $pidRateList = array();
        $pidRateList['agent_id'] = $pid;

        if (($agentIdlist['agent_list_payin_rate']-$agentPidlist['agent_list_payin_rate'])>0) {

            $pidRateList['netgate'] = $agentIdlist['agent_list_payin_rate']-$agentPidlist['agent_list_payin_rate'];
        }else{
            $pidRateList['netgate'] = '';
        }

        if (($agentIdlist['agent_list_weixin_rate']-$agentPidlist['agent_list_weixin_rate'])>0) {

            $pidRateList['weixin'] = $agentIdlist['agent_list_weixin_rate']-$agentPidlist['agent_list_weixin_rate'];
        }else{
            $pidRateList['weixin'] = '';
        }

        if (($agentIdlist['agent_list_alipay_rate']-$agentPidlist['agent_list_alipay_rate'])>0) {

            $pidRateList['alipay'] = $agentIdlist['agent_list_alipay_rate']-$agentPidlist['agent_list_alipay_rate'];
        }else{
            $pidRateList['alipay'] = '';
        }

        return $pidRateList;
    } else {
        return false;
    }

}

function getDownAgentRate($pid,$agentId)
{
    //agentId 已经是顶级的情况
    $agentIdlist = M('agent_list')->where(array('agent_list_id' => $agentId))->field('agent_list_payin_rate,agent_list_weixin_rate,agent_list_alipay_rate')->find();

    $agentPidlist = M('agent_list')->where(array('agent_list_id' => $pid))->field('agent_list_payin_rate,agent_list_weixin_rate,agent_list_alipay_rate')->find();

    if ($agentIdlist) {
        $pidRateList = array();
        $pidRateList['agent_id'] = $pid;
        $pidRateList['lvl'] = getAgentlvl($pid);

        if (($agentIdlist['agent_list_payin_rate']-$agentPidlist['agent_list_payin_rate'])>0) {

            $pidRateList['netgate'] = $agentIdlist['agent_list_payin_rate']-$agentPidlist['agent_list_payin_rate'];
        }else{
            $pidRateList['netgate'] = '';
        }

        if (($agentIdlist['agent_list_weixin_rate']-$agentPidlist['agent_list_weixin_rate'])>0) {

            $pidRateList['weixin'] = $agentIdlist['agent_list_weixin_rate']-$agentPidlist['agent_list_weixin_rate'];
        }else{
            $pidRateList['weixin'] = '';
        }

        if (($agentIdlist['agent_list_alipay_rate']-$agentPidlist['agent_list_alipay_rate'])>0) {

            $pidRateList['alipay'] = $agentIdlist['agent_list_alipay_rate']-$agentPidlist['agent_list_alipay_rate'];
        }else{
            $pidRateList['alipay'] = '';
        }

        return $pidRateList;
    } else {
        return false;
    }

}

function getAgentRateCost($agentId)
{
    $agent_list = M('agent_list')->where(array('agent_list_id' => $agentId))->field('agent_list_payin_rate,agent_list_weixin_rate,agent_list_alipay_rate')->find();
    if ($agent_list) {
        return $agent_list;
    } else {
        return false;
    }

}

function getUpAgentRate($agentId, $agentIdPid, $paybank)
{

    $agentRate = M('agent_list')->where(array('agent_list_id' => $agentId))->getField($paybank);
    if ($agentRate) {
        $agentPidRate = M('agent_list')->where(array('agent_list_id' => $agentIdPid))->getField($paybank);
        if ($agentPidRate) {
            if (($agentRate - $agentPidRate) > 0) {
                $upAgentRate = $agentRate - $agentPidRate;
                return $upAgentRate;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }

}

function getUserAgentRateList($userId)
{
    $userAgentRateList = array();
    $agentId = M('userinfo')->where(array('user_id' => $userId))->getField('agent_id');
    if ($agentId) {
        //校验是不是第一级
        $agentIdPid = M('agent_list')->where(array('agent_list_id' => $agentId))->getField('agent_list_pid');
        if ($agentIdPid>0) {
            //多个层级  获取子集
            $userAgentRateList[$userId][$agentId] = getUserAgentRateNoProductId($userId,$agentId);
            // 自己循环
            $agentSubList = get_parent_id($agentId);

            $agentSub = explode(",", $agentSubList);
            //
            foreach ($agentSub as $vs) {
                if ($vs >0) {
                    $userAgentRateList[$userId][$vs] = getDownAgentRate($vs,getDownAgentId($vs));
                }
            }

        } else {
            $userAgentRateList[$userId][$agentId] = getUserAgentRateNoProductId($userId,$agentId);
            return $userAgentRateList;
        }

        return $userAgentRateList;
    } else {
        //没有代理，属于系统平台客户
        return 0;
    }
}

function getUpAgentId($agentId)
{
    $pid = M('agent_list')->where(array('agent_list_id' => $agentId))->getField('agent_list_pid');
    if ($pid) {
        return $pid;
    } else {
        return $agentId;
    }

}

function getDownAgentId($agentId)
{
    $downId = M('agent_list')->where(array('agent_list_pid' => $agentId))->getField('agent_list_id');

    if ($downId) {
        return $downId;
    } else {
        return $agentId;
    }

}


function getUserAgentRateNoProductId($userId, $agentId)
{
    $productId = M('userinfo')->where(array('user_id' => $userId))->getField('product_id');

    if ($productId) {
        $productList = json_decode($productId, true);
        foreach ($productList as $vp) {
            //根据产品ID获取支付宝 微信以及网银的费率ID
            $weixin_rate_id = M('product')->where(array('product_id' => $vp, 'product_attribute' => 'weixin'))->getField('payin_rate_id');
            if ($weixin_rate_id) {
                $userWeixinRate =  M('payin_rate')->where(array('payin_rate_id' => $weixin_rate_id))->getField('inrate');
                if ($userWeixinRate) {
                    $rate_array['weixin'] = $userWeixinRate;
                } else {
                    $rate_array['weixin'] = 0;
                }
            }
            $alipay_rate_id = M('product')->where(array('product_id' => $vp, 'product_attribute' => 'alipay'))->getField('payin_rate_id');
            if ($alipay_rate_id) {
                $userAlipayRate =  M('payin_rate')->where(array('payin_rate_id' => $alipay_rate_id))->getField('inrate');
                if ($userAlipayRate) {
                    $rate_array['alipay'] = $userAlipayRate;
                } else {
                    $rate_array['alipay'] = 0;
                }
            }
            $netgate_rate_id = M('product')->where(array('product_id' => $vp, 'product_attribute' => '0'))->getField('payin_rate_id');
            if ($netgate_rate_id) {
                $userNetgateRate =  M('payin_rate')->where(array('payin_rate_id' => $netgate_rate_id))->getField('inrate');
                if ($userNetgateRate) {
                    $rate_array['netgate'] = $userNetgateRate;
                } else {
                    $rate_array['netgate'] = 0;
                }
            }
        }
    }else{
        return false;
    }
    //用户费率获取完毕
    $agetRate_list = M('agent_list')->where(array('agent_list_id' => $agentId))->field('agent_list_payin_rate,agent_list_weixin_rate,agent_list_alipay_rate')->find();
    if ($agetRate_list) {
        //计算代理和该客户的佣金
        if (($rate_array['netgate'] - $agetRate_list['agent_list_payin_rate']) > 0) {
            $userAgentRate['netgate'] = $rate_array['netgate'] - $agetRate_list['agent_list_payin_rate'];
        } else {
            $userAgentRate['netgate'] = '';
        }
        if (($rate_array['weixin'] - $agetRate_list['agent_list_weixin_rate']) > 0) {
            $userAgentRate['weixin'] = $rate_array['weixin'] - $agetRate_list['agent_list_weixin_rate'];
        } else {
            $userAgentRate['weixin'] = '';
        }
        if (($rate_array['alipay'] - $agetRate_list['agent_list_alipay_rate']) > 0) {
            $userAgentRate['alipay'] = $rate_array['alipay'] - $agetRate_list['agent_list_alipay_rate'];
        } else {
            $userAgentRate['alipay'] = '';

        }
        $userAgentRate['agent_id'] = $agentId;
        $userAgentRate['lvl'] = getAgentlvl($agentId);
        return $userAgentRate;
    } else {
        return false;
    }

}


function getUserAgentRate($userId, $agentId, $productId)
{

    $rateList = M('product')->where(array('product_id' => $productId))->field('payin_rate_id,product_attribute')->find();

    $userRate = M('payin_rate')->where(array('payin_rate_id' => $rateList['payin_rate_id']))->getField('inrate');
    if ($userRate) {
        $rate_array = $userRate;
    } else {
        $rate_array = '';
    }
    //用户费率获取完毕
    if ($rateList['product_attribute'] == 'weixin') {
        $field = 'agent_list_weixin_rate';
    } elseif ($rateList['product_attribute'] == 'alipay') {
        $field = 'agent_list_alipay_rate';
    } else {
        $field = 'agent_list_payin_rate';
    }

    $agentId = M('userinfo')->where(array('user_Id' => $userId))->getField('agent_id');
    $agetRate_list = M('agent_list')->where(array('agent_list_id' => $agentId))->field($field)->find();
    if ($agetRate_list) {
        //计算代理和该客户的佣金
        if (($rate_array - $agetRate_list[$field]) > 0) {
            $userAgentRate = $rate_array - $agetRate_list[$field];
        } else {
            $userAgentRate = '';
        }
        return $userAgentRate;
    } else {
        return false;
    }

}


/**
 * @param $uid 用户ID
 * @param $orderid 订单ID
 * @param $time 订单完成时间
 * @param $ordermoney 订单金额
 * @param $paybank 订单支付类型
 */
function orderAgentCash($userId, $orderid, $time, $ordermoney, $paybank,$productId)
{

    if ($paybank == 'weixin') {
        $field = 'agent_list_weixin_rate';
        $attribute = 'weixin';
    } elseif ($paybank == 'alipay') {
        $field = 'agent_list_alipay_rate';
        $attribute = 'alipay';
    } else {
        $field = 'agent_list_payin_rate';
        $attribute = '0';
    }
    //1写入用户直接关联的代理
    $agentId = M('userinfo')->where(array('user_id' => $userId))->getField('agent_id');
    if ($agentId) {
        //根据代理id写入佣金总额
        $agentOrderId = createOrder($agentId);
        $userAgentRate = getUserAgentRate($userId, $agentId, $productId);
        $userAgentFree = $userAgentRate * $ordermoney;
        if (checkAgentOrderId($agentOrderId, $agentId, $orderid)) {
            //检查重复
            $dataUserAgent = array(
                'user_id' => $userId,
                'agent_id' => $userId,
                'agent_pid' => $agentId,
                'agentpayin_order_id' => $agentOrderId,
                'payin_order_id' => $orderid,
                'order_money' => $ordermoney,
                'agentfree' => $userAgentFree,
                'agent_rate' => $userAgentRate,
                'paybank' => $paybank,
                'attribute' => $attribute,
                'update_time' => $time,
            );
            $userAgentResult = M('agentpayin')->add($dataUserAgent);
            //留个写日志的位置 addAgentpayin log
            RecordLog('AgentRate_success_log' . $agentId, '--' . $orderid . '--' . $ordermoney . '--Agent Client Rate Write success');
            if ($userAgentResult) {
                //更新代理余额
                $userAgentList = M('agent_list')->where(array('agent_list_id' => $agentId))->field('agent_list_sumcount,agent_list_availablecount')->find();
                $dataArray = array(
                    'agent_list_sumcount' => $userAgentList['agent_list_sumcount'] + $userAgentFree,
                    'agent_list_availablecount' => $userAgentList['agent_list_availablecount'] + $userAgentFree,
                );

                $userAgentListResult = M('agent_list')->where(array('agent_list_id' => $agentId))->save($dataArray);
                RecordLog('updateAgentSumcount_success_log' . $agentId, '--' . $orderid . '--' . $ordermoney . '--Agent Client Rate Write success');
                //执行日志updateAgentSumcount

                if ($userAgentListResult) {
                    //执行代理和代理之间的记录
                    $agentResult = agentPayinSettlement($userId,$agentId, $orderid, $ordermoney, $paybank, $time);

                    if ($agentResult) {

                        RecordLog('AgentCashRecord', '--' . $orderid . '--AgentCashRecord Write success');

                    } else {
                        //错误结果排查
                    }

                } else {
                    //错误结果排查
                }
            } else {
                //用户代理入金日志写入
            }

        } else {
            //重复订单，重复执行
        }

    } else {
        RecordLog('AgentRate_order_error_log', '--' . $orderid . '--' . $ordermoney . '--Agent Client Rate Write error');
        return null;
    }


}

function agentPayinSettlement($userId,$agent_id, $orderid, $ordermoney, $paybank, $time)
{
    if ($paybank == 'weixin') {
        $field = 'agent_list_weixin_rate';
        $attribute = 'weixin';
    } elseif ($paybank == 'alipay') {
        $field = 'agent_list_alipay_rate';
        $attribute = 'alipay';
    } else {
        $field = 'agent_list_payin_rate';
        $attribute = '0';
    }
    $agentList = M('agent_list')->select();

    foreach ($agentList as $v) {
        if ($v['agent_list_id'] == $agent_id) {
            //结算上级代理佣金 PID>0 表示ID存在，否则中断退出了
            if ($v['agent_list_pid'] > 0) {
                //写入记录
                $agentPidRate = getUpAgentRate($agent_id, $v['agent_list_pid'], $field);
                $agentOrderId = createOrder($v['agent_list_pid']);
                $AgentFree = $agentPidRate * $ordermoney;
                if (checkAgentOrderId($agentOrderId, $agent_id, $orderid)) {
                    $dataAgentPid = array(
                        'user_id' => $userId,
                        'agent_id' => $agent_id,
                        'agent_pid' => $v['agent_list_pid'],
                        'agentpayin_order_id' => $agentOrderId,
                        'payin_order_id' => $orderid,
                        'order_money' => $ordermoney,
                        'agentfree' => $AgentFree,
                        'agent_rate' => $agentPidRate,
                        'paybank' => $paybank,
                        'attribute' => $attribute,
                        'update_time' => $time,

                    );
                    $AgentResult = M('agentpayin')->add($dataAgentPid);
                    //留个写日志的位置 addAgentpayin log
                    RecordLog('AgentRate_success_log' . $v['agent_list_pid'], '--' . $orderid . '--' . $ordermoney . '--Agent Client Rate Write success');

                    if ($AgentResult) {

                        $AgentList = M('agent_list')->where(array('agent_list_id' => $v['agent_list_pid']))->field('agent_list_sumcount,agent_list_availablecount')->find();
                        $dataArray = array(
                            'agent_list_sumcount' => $AgentList['agent_list_sumcount'] + $AgentFree,
                            'agent_list_availablecount' => $AgentList['agent_list_availablecount'] + $AgentFree,
                        );
                        $AgentListResult = M('agent_list')->where(array('agent_list_id' => $v['agent_list_pid']))->save($dataArray);
                        RecordLog('updateAgentSumcount_success_log' . $v['agent_list_pid'], '--' . $orderid . '--' . $ordermoney . '--Agent Client Rate Write success');

                    }


                } else {
                    //订单号重复，需要重新执行一遍
                    RecordLog('订单号重复' . $v['agent_list_pid'], '--' . $orderid . '--' . $ordermoney . '--Agent Client Rate Write success');
                }

                agentPayinSettlement($userId,$v['agent_list_pid'], $orderid, $ordermoney, $paybank, $time);
                //递归点

            } else {
                break;
            }


        }
    }

    return true;

}

function getUserAgentList($user_id)
{
    $agentId = M('userinfo')->where(array('user_id' => $user_id))->getField('agent_id');
    if ($agentId) {
        $agentList = get_parent_id($agentId);
        return $agentList;
    } else {
        return 0;
    }

}


function getAgentTotal($userId,$agentId,$begin_time,$end_time)
{
    $sqll = "SELECT COUNT(*) as inum,sum(order_money) as agordermoney,sum(agentfree) as agfree, agent_id as gap,attribute as agattribute from  __PREFIX__agentpayin ";
    $sqll .= " where update_time>$begin_time and update_time<$end_time ";
    $sqll .= " and agent_pid=$agentId";
    $sqll .= " and user_id=$userId";
    $sqll .= " group by gap,agattribute";

    $resl = M()->query($sqll);//订单数,交易额

//    $res_id = new \Org\Util\ArrayGroupBy();
//    $list_l = $res_id->array_group_by($resl, 'gap');

    return $resl;

}

function getAgentName($agentId)
{
    $name = M('agent_list')->where(array('agent_list_id' => $agentId))->getField('agent_list_nickname');
    if ($name) {
        return $name;
    } else {
        return Null;
    }

}

function checkAgentOrderId($agentOrderId, $agentId, $orderid)
{
    if ($agentOrderId) {
        $AgorderId = M('agentpayin')->where(array('agentpayin_order_id' => $agentOrderId, 'agent_id' => $agentId, 'payin_order_id' => $orderid))->getField('agentpayin_id');
        if ($AgorderId) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }

}

function getAgentUserId($agentId)
{
    //獲取子集
    $agentIdArray = array();
    $agentIdArray[] = session('hid');
    $arr_ag_sub = getAgentSub(session('hid'));
//        dump(getUserAgentRate('8813','90005'));

    $agentIdArray = array_merge($agentIdArray,$arr_ag_sub);

    foreach ($arr_ag_sub as $k => $v) {
        array_push($agentIdArray, $v['agent_list_id']);
    }
    //获取代理名下用户ID
    $mapAgentId['agent_id'] = array('in',$agentIdArray);
    $userArray = M('userinfo')->where($mapAgentId)->field('user_id')->order('user_id')->select();

    $userIdArray = array();
    foreach ($userArray as $ku=>$vu) {
        array_push($userIdArray, $vu['user_id']);
    }
    return $userIdArray = $userIdArray;

}


function getAgentlvl($agentId)
{
    $lvl = '';
    $pid = M('agent_list')->where(array('agent_list_id' => $agentId))->getField('agent_list_pid');
    if ($pid>0) {
        $lvl = getParentlvl($pid);
        return $lvl;
    } else {
        $lvl = 0;
        return $lvl;
    }

}

function getParentlvl($agentId,$lvl=1){
    //循环，直到pid = 0;
    $pid = M('agent_list')->where(array('agent_list_id' => $agentId))->getField('agent_list_pid');
    if ($pid>0) {
        $lvl = $lvl +1;
        $agentid = get_parent_id($pid);
    }
    return $lvl;
}
//身份证和银行卡四要素
function getJianQuan($bankdata,$api){
    $app_key = [
        'idcard' => 'e7a6f1111b4b6178028d387118ee77ed',//身份证实名认证
        'verifybankcard4' => 'afd7f6ce42f3e4dc5cb80c67fcf97159'// 银行卡四元素校验

    ];

    $urls = [
        'idcard' => 'http://op.juhe.cn/idcard/query',
        'verifybankcard4' => 'http://v.juhe.cn/verifybankcard4/query',

    ];

    $data = [];
    $data['key'] = $app_key[$api];
    switch ($api) {
        case 'idcard':
            $data['realname'] = $bankdata['realname'] ;
            $data['idcard'] = $bankdata['idcard'] ;
            break;

        case 'verifybankcard4':
            $data['realname'] = $bankdata['realname'] ;
            $data['idcard'] = $bankdata['idcard'] ;
            $data['bankcard'] = $bankdata['bankcard'] ;
            $data['mobile'] = $bankdata['mobile'] ;
            break;

        default:
            break;
    }

    $post_str = build_post_str($data);
    $url = $urls[$api];
    $resp = go_curl($url,'post',$post_str);
    return json_decode($resp,true);
}
//反欺诈和多头贷款
function cheat($bankdata,$api){
    $headers = [
        'token' => ['content-type:application/x-www-form-urlencoded'],
    ];
    $url['multi_url'] = 'https://zx-api.juhe.cn/multiple/v1/tasks';     //多头借贷
    $url['anti_url'] = 'https://zx-api.juhe.cn/antifraud/v1/tasks';     //反欺诈

    $cnf = [
        'grant_type' => 'client_credentials',
        'client_id' => 'da7cecb20d0947f7a1e8c23830e1bdad',
        'client_secret' => '19bbbde9c2284ecfa5c8204df81a3062',
        'scopes' => 'carrier',
        'expires_in' => '7200',
    ];
//获取秘钥
    $token_url = 'https://zx-api.juhe.cn/oauth2/token';
    $post_str = build_post_str($cnf);
    $null = '';
    $data = go_curl($token_url,'post',$post_str,$null,20,array(),$headers['token']);
    if(!$data){
        return false;
    }

    $token = json_decode($data,true)["access_token"];

    $header_app = [
        "accept: application/json",
        "authorization: Bearer {$token}",
        "content-type: application/json"
    ];
    $post_data2 = [];
    switch ($api) {

        case 'multi_url':
            $post_data2["mobile"] =  $bankdata['mobile'];
            $post_data2["user_id"] = $cnf['client_id'];
            $post_data2["origin"] = 2;
            break;

        case 'anti_url':
            $post_data2["mobile"] =  $bankdata['mobile'];
            $post_data2["id_card"] = $bankdata['idcard'];
            $post_data2["bank"] = '';
            $post_data2["ip"] = $bankdata['ip'];
            $post_data2["name"] = $bankdata['realname'];

            $post_data2["user_id"] = $cnf['client_id'];
            $post_data2["origin"] = 0;
            break;

        default:
            break;

    }

    $json = json_encode($post_data2);
    $res = curlSendJson($json,$url[$api],$header_app);

    return json_decode($res,true);
}

function getToken($cnf)
{
    $token_url = 'https://zx-api.juhe.cn/oauth2/token';
    $post_str = build_post_str($cnf);
    $null = '';
    $data = go_curl($token_url,'post',$post_str,$null,20,array(),$this->headers['token']);
    if(!$data){
        return false;
    }

    return json_decode($data,true)["access_token"];
}
function curlSendJson($json,$url,$header)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS,$json);
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($ch);
    return $result;
}
//实名身份证导入数据库
function idcard_log($user_id,$idcard,$id){
    $data = array(
        'user_id' => $user_id,
        'index_id' => $id,
        'realname' =>$idcard['realname'],
        'idcard' =>$idcard['idcard'],
        'reason' =>$idcard['reason'],
        'state' =>$idcard['res'],
        'datetime' => time()
    );
    $res = M('idcard')->add($data);
    if($res){
        return true;
    }else{
        return false;
    }
}
//银行卡四要素导入
function bankcard_log($user_id,$bankcard,$id){
    $data = array(
        'user_id' => $user_id,
        'index_id' => $id,
        'jobid' => $bankcard['jobid'],
        'realname' =>$bankcard['realname'],
        'idcard' =>$bankcard['idcard'],
        'bankcard' =>$bankcard['bankcard'],
        'mobile' =>$bankcard['mobile'],
        'reason' =>$bankcard['message'],
        'states' =>$bankcard['res'],
        'datetime' => time()
    );
    $res = M('bankcard')->add($data);
    if($res){
        return true;
    }else{
        return false;
    }
}
//多头借贷数据导入
function jiedai_log($user_id,$jiedai,$id,$mobile){
    $data = array(
        'user_id' => $user_id,
        'index_id' => $id,
        'mobile' => $mobile,
        'registered_time' =>$jiedai['registered_logs'][0]['time'],
        'registered_type' =>$jiedai['registered_logs'][0]['type'],
        'apply_amount' =>$jiedai['apply_logs'][0]['amount'],
        'apply_time' =>$jiedai['apply_logs'][0]['time'],
        'apply_type' =>$jiedai['apply_logs'][0]['type'],
        'loan_amount' =>$jiedai['loan_logs'][0]['amount'],
        'loan_time' =>$jiedai['loan_logs'][0]['time'],
        'loan_type' =>$jiedai['loan_logs'][0]['type'],
        'rejected_time' =>$jiedai['rejected_logs'][0]['time'],
        'rejected_type' =>$jiedai['rejected_logs'][0]['type'],
        'overdue_amount' =>$jiedai['rejected_logs'][0]['amount'],
        'overdue_time' =>$jiedai['overdue_logs'][0]['time'],
        'overdue_count' =>$jiedai['overdue_logs'][0]['count'],
        'datetime' => time()
    );
    $res = M('jiedai')->add($data);
    if($res){
        return true;
    }else{
        return false;
    }
}
//反欺诈数据导入
function fanqizha_log($user_id,$mobileinfo,$id){
    $data = array(
        'user_id' => $user_id,
        'index_id' => $id,
        'task_id' => $mobileinfo['account'],
        'realname' => $mobileinfo['account']['name'],
        'mobile' => $mobileinfo['account']['mobile'],
        'idcard' => $mobileinfo['account']['id_card'],
        'bankcard' => $mobileinfo['account']['bank'],
        'mobile_info_province' =>$mobileinfo['mobile_info']['province'],
        'mobile_info_city' =>$mobileinfo['mobile_info']['city'],
        'carrier' =>$mobileinfo['mobile_info']['carrier'],
        'card' =>$mobileinfo['mobile_info']['card'],
        'id_card_area' =>$mobileinfo['id_card_info']['area'],
        'sex' =>$mobileinfo['id_card_info']['sex'],
        'birthday' =>$mobileinfo['id_card_info']['birthday'],
        'age' =>$mobileinfo['id_card_info']['age'],
        'bank' =>$mobileinfo['bank_info']['bank'],
        'type' =>$mobileinfo['bank_info']['type'],
        'mobile_status_code' =>$mobileinfo['mobile_status']['code'],
        'mobile_status_description' =>$mobileinfo['mobile_status']['description'],
        'mobile_time_code' =>$mobileinfo['mobile_time']['code'],
        'found' =>$mobileinfo['risk']['found'] == true ? 1 : 2,
        'ip_info_area' =>$mobileinfo['ip_info']['area'],
        'ip_info_location' =>$mobileinfo['ip_info']['location'],
        'risk_code' =>$mobileinfo['risk']['risks']['code'],
        'risk_value' =>$mobileinfo['risk']['risks']['value'],
        'risk_description' =>$mobileinfo['risk']['risks']['description'],
        'risk_score' =>$mobileinfo['risk']['score'],
        'datetime' => time()
    );
    $res = M('fanqizha')->add($data);
    if($res){
        return true;
    }else{
        return false;
    }
}

function check_verify($params,$url,$merchantId,$signKeyPath,$public_key){

    $data = encryption($params,$merchantId,$signKeyPath);

    $o = "";

    foreach ( $data as $k => $v )
    {
        if ($v != ''){
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
    }

    $str = substr($o,0,-1);
    $curl_data = request_post($url,$str,$merchantId);

    $curl_data = json_decode($curl_data,true);

    $info = base64_decode(urldecode($curl_data['data']));

    $p = json_decode($info,true);

    ksort($p);

    $return_pvs = '';

    foreach ($p as $key => $value){
        $return_pvs .= $value;
    }

    $ms = md5($return_pvs);

    $t = $curl_data['enc'];

    $ms_t = $ms.'|'.$t;

    $signature = base64_decode(urldecode($curl_data['sign']));

    $certificateCAcerContent = file_get_contents($public_key);

    $pubkeyid = openssl_get_publickey($certificateCAcerContent);
    // 验签
    $verify = openssl_verify($ms_t, $signature, $pubkeyid);

    openssl_free_key($pubkeyid);

    if ($verify == 1){
        list($t1, $t2) = explode(' ', microtime());

        $ct = (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);

        $pt = (int)$ct - (int)$data['enc'];

        if($pt < 60000){
            $rs['data'] = $data;
            $rs['curl_data'] = $curl_data;
            $rs['p'] = $p;
            $rs['status'] = "TURE";
            return $rs;

        }
    }

}
/**
 * rsa加密
 * @param array $p
 */
function encryption($p,$merchantId,$signKeyPath){
    ksort($p);//对数组进行ASCII排序

    $pvs = '';

    //将所有报文参数的非空参数值拼接为字符串 PVS
    foreach ($p as $key => $value){
        $pvs .= $value;
    }

    $jp = json_encode($p);

    $bjp = base64_encode($jp);

    list($t1, $t2) = explode(' ', microtime());

    $t = (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);

    $ms = md5($pvs);//对 PVS 计算 MD5 值 MS

    $s = $ms."|".$t;


    $bs = signfrompfx($s,$signKeyPath,'770880123');
    return array(
        'data' => $bjp,
        'enc' => $t,
        'sign' => $bs,
        'merchantId' => $merchantId,
    );
}

/**
 * RSA私钥签名
 * @param string $private_key 私钥
 * @param string $data 要加密的字符串
 * @return string $sign 返回加密后的字符串
 */
function signfrompfx($strData,$filePath,$keyPass)
{

    if(!file_exists($filePath)) {
        return false;
    }

    $pkcs12 = file_get_contents($filePath);

    if (openssl_pkcs12_read($pkcs12, $certs, $keyPass)) {

        $privateKey = $certs['pkey'];

        if (openssl_sign($strData, $signedMsg, $privateKey)) {

            $signedMsg = base64_encode($signedMsg);//这个看情况。有些不需要转换成16进制，有些需要base64编码。看各个接口
            return $signedMsg;

        } else {

            return '';

        }

    } else {

        return '0';

    }
}
