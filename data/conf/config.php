<?php	return array (
  'SHOW_PAGE_TRACE' => false,
  'URL_CASE_INSENSITIVE' => false,
  'DB_LIKE_FIELDS' => 'news_title|news_content|news_flag|news_open',
  'URL_MODEL' => 2,
  'URL_HTML_SUFFIX' => '',
  'URL_ROUTER_ON' => true,
  'URL_MAP_RULES' => 
  array (
    'about' => 'home/list/index?id=1',
    'contacts' => 'home/list/index?id=10',
    'index' => 'home/index/index',
    'Api/query_order_result' => 'Api/Query/orderResualt',
  ),
  'URL_ROUTE_RULES' => 
  array (
    'list/:id\\d' => 'home/list/index',
    'news/:id\\d' => 'home/news/index',
  ),
  'THINK_SDK_QQ' => 
  array (
    'APP_KEY' => '203564',
    'APP_SECRET' => 'bab1f3acc0c67b69a1f470ac5e8dc36a',
    'CALLBACK' => 'http://www.ebpays.com/index.php?m=Home&c=oauth&a=callback&type=qq',
  ),
  'THINK_SDK_SINA' => 
  array (
    'APP_KEY' => '602735229',
    'APP_SECRET' => '66781cbeab9fdb9b014a387ab6e943fe',
    'CALLBACK' => 'http://www.ebpays.com/index.php?m=Home&c=oauth&a=callback&type=sina',
  ),
  'COMMENT' => 
  array (
    'T_OPEN' => '1',
    'T_LIMIT' => 60,
  ),
);