SQLite format 3   @    �   �   �   �   V                                                � -�
   �    ����                                                                                                                                                                                                                                                       i	}W indexsqlite_autoindex_sqlitebrowser_rename_column_new_table_1sqlitebrowser_rename_column_new_table       P++Ytablesqlite_sequencesqlite_sequenceCREATE TABLE sqlite_sequence(name,seq)�\�tableuseruserCREATE TABLE `user` (
	`uid`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`username`	TEXT,
	`groupid`	INTEGER DEFAULT 2,
	`name`	TEXT,
	`avatar`	TEXT,
	`avatar_small`	TEXT,
	`email`	TEXT,
	`password`	TEXT,
	`cookie_token`	BLOB,
	`cookie_token_expire`	TEXT DEFAULT 0,
	`reg_time`	INTEGER DEFAULT 0,
	`last_login_time`	INTEGER DEFAULT 0
)k�1table<?php <?php CREATE TABLE "<?php " (
	`防止sqlite的数据库文件被直   	/   1   ,   (                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              � � ������d                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              )Wsqlitebrowser_rename_column_new_table� page_historyusercatpagpage	%page_historyWusercatalog   	iteitem   � ��                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <     M 87816719282be340d6bbcf31871363ff6ac1b97e90X���;     M laozhang31ff5f64670e1791d746badfe8b0552b0X�� � ������                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   = M'38e68a9ec624c99d2fd22c8c3714603fY"|�116.20.114.27X���   �M'968fe09c0f0db05450de54054e4e6a47X���116.20.113.62X-Q�   �M)b13a270d735824c682f47f9276284977X���116.20.113.187X�   �M)432e737ea0dbd11c832e03304ceda09cX���116.20.115.212X۲   {M)e1996b797ef6cf772a404587f96796dfX��e116.20.115.212= M'6bcfca6e26f2bd267ee07becffb6ebf3Y"}�116.20.114.27X���      �??           Q��  � �     (�*                    ��xsqli��*                    V �renam��*    �A?    �A?    6 Lrowse�A?           Q��  h ��   0�*    �A?    �A?    �W in                        tebrowser_rename_column_n   �]1!!�tableuser_tokenuser_tokenCREATE TABLE `user_token` (
        `id`  INTEGER PRIMARY KEY ,
        `uid` int(10) NOT NULL DEFAULT '0',
        `token` CHAR(200) NOT NULL DEFAULT '',
        `token_expire` int(11) NOT NULL DEFAULT '0' ,
        `ip` CHAR(200) NOT NULL DEFAULT '',
        `addtime` int(11) NOT NULL DEFAULT '0'
        )'.; indexsqlite_autoindex_page_1page�>/%%�?tablepa�f2�tabletemplatetemplateCREATE TABLE `template` (
        `id`  INTEGER PRIMARY KEY ,
        `uid` int(10) NOT NULL DEFAULT '0',
        `username` CHAR(200) NOT NULL DEFAULT '',
        `template_title` CHAR(200) NOT NULL DEFAULT '' ,
        `template_content` text NOT NULL DEFAULT '',
        `addtime` int(11) NOT NULL DEFAULT '0'
        )    � �A �
�                                                                                                                                                                                                                 � ##�Etableitem_memberitem_member
CREATE TABLE "item_member" (
	`item_member_id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`item_id`	INTEGER,
	`uid`	INTEGER,
	`username`	TEXT,
	`addtime`	INTEGER DEFAULT 0
, member_group_id INT( 1 ) NOT NULL DEFAULT '1')�"(�'tableitemitemCREATE TABLE "item" (
	`item_id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`item_name`	TEXT,
	`item_description`	TEXT,
	`uid`	INTEGER,
	`username`	TEXT,
	`password`	TEXT,
	`addtime`	INTEGER,
	`last_update_time`	INTEGER DEFAULT 0
, item_domain text NOT NULL DEFAULT '')5!I# indexsqlite_autoindex_item_member_1item_memberP++Ytablesqlite_sequencesqlite_sequenceCREATE TABLE sqlite_sequence(name,seq)k�1table<?php <?php CREATE TABLE "<?php " (
	`防止sqlite的数据库文件被直接下载`	INTEGER
)   & &O��J                     � +�\*�tableuseruserCREATE TABLE "user" (
	`uid`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`username`	TEXT,
	`groupid`	INTEGER DEFAULT 2,
	`name`	TEXT,
	`avatar`	TEXT,
	`avatar_small`	TEXT,
	`email`	TEXT,
	`password`	TEXT,
	`cookie_token`	BLOB,
	`cook'); indexsqlite_autoindex_item_1item�\*�tableuseruserCREATE TABLE "user" (
	`uid`	INTEGER PRIMARY KEY AUTOINCREMENT,
	`username`	TEXT,
	`groupid`	INTEGER DEFAULT 2,
	`name`	TEXT,
	`avatar`	TEXT,
	`avatar_small`	TEXT,
	`email`	TEXT,
	`password`	TEXT,
	`cookie_token`	BLOB,
	`cookie_token_expire`	TEXT DEFAULT 0,
	`reg_time`	INTEGER DEFAULT 0,
	`last_login_time`	INTEGER DEFAULT 0
)� +�tablecatalogcatalogCREATE TABLE "catalog" (
	`cat_id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`cat_name`	TEXT,
	`item_id`	INTEGER,
	`s_number`	INTEGER DEFAULT 99,
	`addtime`	INTEGER DEFAULT 0
, parent_cat_id INT( 10 ) NOT NULL DEFAULT '0', level INT( 10 ) NOT NULL DEFAULT '2')-,A indexsqlite_autoindex_catalog_1catalog   $ ��$                                                                                                                                                                                                                                                                                      �f/%%�tablepage_historypage_historyCREATE TABLE "page_history" (
	`page_history_id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`page_id`	INTEGER,
	`author_uid`	INTEGER,
	`author_username`	TEXT,
	`item_id`	INTEGER,
	`cat_id`	INTEGER,
	`page_title`	TEXT,
	`page_content`	TEXT,
	`s_number`	INTEGER,
	`addtime`	INTEGER
, page_comments text NOT NULL DEFAULT '')'.; indexsqlite_autoindex_page_1page�G-�qtablepagepageCREATE TABLE "page" (
	`page_id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
	`author_uid`	INTEGER,
	`author_username`	TEXT,
	`item_id`	INTEGER,
	`cat_id`	INTEGER,
	`page_title`	TEXT,
	`page_content`	TEXT,
	`s_number`	INTEGER DEFAULT 99,
	`addtime`	INTEGER DEFAULT 0
, page_comments text NOT NULL DEFAULT '')                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
         
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       %G    k�������������������������~ytoje`[VQLG  �S 1�Ulaozhang入金銀行列表eNpTUFBQ4NJVUHjauvRl+8SXXQ0vFvY87Zj+YuEKkCiUP6H3+YqNGulJmpwoAlUZaAKpeTCBJ7sXP1+0h/Nlw6yXjZM1XJ0DNGFsdwTTD8EMctLk4uKqQbevBt2+GnT7apDtq0GyrwZhXw3CvhqEfTVcNVa6KAAYFApoYmhCCjVIEshsEJerpjQzhRPIyMwr0TA00ISIPp2wjLOGUwGIEKAGCICqi1OL8hJzUxVqyhKLkjMSizSMgJogGsCqOBWeT1nxrGM70LecQPUFicXF5flFKQj1plD1IMVQHU/Xtz1f0MjJCXIO2HCwOEyDoSlQw7MZ6+EaQMSzGVufL98A80NRanp8SSbIVWBvGCK8AVZvANH0bPOKp209z6Zvezl9C0gbMLE8XdIOFH2/Z9az6QuAcQkAwhH0UA==cX�4�O 1�Mlaozhang入金銀行列表eNpdUstKw0AUXc98xSyTRaARunGpiDsRf0CiDW0WRkmqgtxFu7AtUqGikNJV6zO7Kr4W9nOcmWblL3gnDyfmkglnDufk3JsZyrCoxRg/f0j6V8lFZzkb8kG0nMWKzfejSxm/GM09k/wjzloVwvUL4vvrTt4uSNKZJN1rY2N92yzwpoZbGu6smZRSqOZBNQ+qeVDOg1Ie6DzQeaDzgMKqhaX+QIbKGwa4LNAs8hSOvQZB   �V   �T   �R   {Q   zP   �O   �N   �L   �K   �J   �I   �H   �G   �F   �E   uB   U@   V?   W>   f=   c<   �;   �:   �9   �8   �3   q0   %   �-      )!   �(   �*    D   %"   �6   �#   g g�                    �=.    @�*                                         �=.    ��*                                         �=.    p�*                                        �=.                                                   �=.    8C?    I                                    �=.                                                   �=.            f                    S               �=.                                                   �=.    �:?                                           �=.    �D?                           �      �;�    0d�            �f�   70K% indexsqlite_autoindex_page_history_1page_history�]1!!�tableuser_tokenuser_tokenCREATE TABLE `user_token` (
        `id`  INTEGER PRIMARY KEY ,
        `uid` int(10) NOT NULL DEFAULT '0',
        `token` CHAR(200) NOT NULL DEFAULT '',
        `token_expire` int(11) NOT NULL DEFAULT '0' ,
        `ip` CHAR(200) NOT NULL DEFAULT '',
        `addtime` int(11) NOT NULL DEFAULT '0'
        )    � �� � @                                                �k 1�laozhang入金銀行列表eNp1lFtPE0EUx5/bTzGP9IEv4BtUophoiCVBHoeydgdhlnR3Ecg+eO�s A�laozhang入金- 銀行支援列表eNp1lltPE0EUgJ/bXzGP8MAf8A0qEUw0REiUx6Gs3UGYJd1dBLIPXqEoiAQMyk3BojWRIjepBeG/mJ2lfeIveGYvs7OzBRJyzpmd75w5t4AQQtkOhNjr3ebsUgdqvnnW2J73Vva9xWNWWm1sV/hpYGXvF64qB22FofZMwjCtKwaNRgb37OvVznmm+Wyt+Xy5bbC/P   b�  C�]laozhang出金 - 銀行支援列表eNq1WklXG0kSPtu/oo7dB/cPmJssNoEQIKBtuJWhGlUPrvJIKo/t5wM7CBACgw2YzRgBsnuM0AIIieXPqErSyX9hIiuzKrNKKdFzGL/n94jMiNxi+SKiJAiC8PiJIOjzxdr8mvBEqC1OVA+XjY20kcjrC5vVw9Tjx+8f4VF9NV5JZX7eLIy9+HkTe1Q3/C7EHZYUc/jx+388gX+woYD/YgnhPfx/8p6OwjjsWy780Hdua+uXsN4jTO4u4eWBf   �� %�]laozhang默认页面eNq1WklXG0kSPptfUcfug/sHzE0Wm0AIENA23MpQjaoHV/VIKo/t5wM7CBACgw2YzRgBcvcYoQUQEsufUZWkk//CRFZmVWaVUqLnMH7P7xGZEbnF8kVEqUWAfy1PBUFfKNYW1oWnQm1psnq0YmymjUReX9yqHqVaWt4/waP6WrySyvy4XRx/+eM29qRu+F2IOywp5nDL+388hX9oR/wXSwjv4f/T93QUxmHfcuG7vntX27iC9Z5gcm8ZLw/kM      � �                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      .
 bank_listbank_list878167192X�X���   � ��� � �E   7                             i#}W indexsqlite_autoindex_sqlitebrowser_rename_column_new_table_1sqlitebrowser_rename_column_new_table�     5!I# indexsqlite_i0}W indexsqlite_autoindex_sqlitebrowser_rename_column_n   �]1!!�tableuser_tokenuser_tokenCREATE TABLE `user_token` (
        `id`  INTEGER PRIMARY KEY ,
        `uid` int(10) NOT NULL DEFAULT '0',
        `token` CHAR(200) NOT NULL DEFAULT '',
        `token_expire` int(11) NOT NULL DEFAULT '0' ,
        `ip` CHAR(200) NOT NULL DEFAULT '',
        `addtime` int(11) NOT NULL DEFAULT '0'
        )'.; indexsqlite_autoindex_page_1page�>/%%�?tablepa�f2�tabletemplatetemplateCREATE TABLE `template` (
        `id`  INTEGER PRIMARY KEY ,
        `uid` int(10) NOT NULL DEFAULT '0',
        `username` CHAR(200) NOT NULL DEFAULT '',
        `template_title` CHAR(200) NOT NULL DEFAULT '' ,
        `template_content` text NOT NULL DEFAULT '',
        `addtime` int(11) NOT NULL DEFAULT '0'
        )   �    ���                            �] [�Claozhang微信支付入金限制（借记卡）    
-  微信支付入金- 銀行支援�   m�F C��+laozhang出金 - 銀行支援列表    
-  出金 - 銀行支援列表

|	銀行名稱（gb）	|	銀行名稱（zh）	|	銀行名稱（en）	|
|:----    |:-------    |:--- |-- -|------      |
|	中国银行	|	中國銀行	|   ��b A�glaozhang入金- 銀行支援列表    
-  入金- 銀行支援列表



|銀行名稱(gb)|銀行名稱(zh)|銀行名稱(en)|銀行代碼|YS|GO|SYX|CBA|
|:--------------    |:-------------    |:--------- |--------   |--------    
|	中国银行	|	中國銀行	|	Bank of China	|	zhonghang	|	√	|	√	|	√	|	√	|
|	农业银行	|	農業銀行	|	Agricultural Bank of China	|	nonghang	|	√	|	√	|	√	|	√	|
|	工商银行	|	工商銀行	|	Industrial and Commercial Bank of China	|	gonghang	|	√	|	√	|	√	|	√	|
|	建设银行	|	建設銀行	|	China Constuction Bank	|	jianhang	|	√	|	√	|	   *   (
   � ����                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        		                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
   � �                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   � ��                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          +	API接口文档cX�G %	数据字典cX�9
   � ��                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          		
   <� ��v��p�jd^�����X���R����LF��|@:4.("
��������������������                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        WWVVUUTTSSRRQQPPOONNMMLLKKJJIIHHGGFFEEBBAA@@??>>==<<;;::995544//++%%$$##!!8833221100..--,,**))((''&&""  DDCC7766                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   1H5p6D+JnhDsiKiDZ7o83vlwmebv3qfNU6+2/ye8bA8qk1EtbA4IXCEr0/0j/O2MCEtYZ8ypkWiYRlERWVM8KqvXknhUZm/UqlYPb+nKwGZoscw+WABJRLVRqOyqpgrmILlYrI2Sc9PyLr7wt6aIo+KSDhiChrLu+zZCencsQfOGxKVaITuZ1ysVzYPqRgmXWKyEglJyrgpJSvj+IZzecdDLy6yD828Fd3q8lRPrNOtLk8rO7e2xAAcbDwkykKfNqbCXq3Sa2lC/eOVpETpEvrNA7uEXjpml+jQYInGwmA75Ycj1pQQ6dKJb9DnZfabi+nJM7ofJhkRURHaXkvhl2F5PMRsVZs+NzYf9OlUdWPWlq7NXKLB2SwatNboUyNReKQB8TU8bIRnSTc5/TyGF/nJuM7oezl4Aj3zEQ/9/MRmMZckLPAsiMUcQix9sLrgYexMX9kqF/9Db4ZJt509k+TfbYWbLOBfDhcxB8HLWGMjUkLQdDOXnxBVLBmX14wqTNK9u2USjAhsb+yvw2as7eEp5OrmFGuHtlU1O8teuUgXM/Yz5eKBvcBgSLKV0iZGooInIhPFxFf1ZII6QCKNSEuuUxPfyCJj/IUke2NC1r23al1Xjzv1E+fqJyAqVD/nU0buK5VInyGyTgLYX6pYIPnNyJ9QAUy6BQZlZg9j/7t+fcC8lUm6RTrhzd+FVA27wuE3+3kBCnA8JyhxuGE/NZnaW8ZTnZ6AR3jmCXQLP3k7fQHPz4K3t6fPExgW/L4e32BbK177bq2WnaIOdrdU+562j9Mv+zXGJbf3jE8XlBeT7qO3ay9kBV81mwPjplfFZN1VJTB2/JprMeOA8hPSzd8l+8n6evKTEf/KfRc0ldjlvku3GpZEoe0NCuPjEmNet2l0wsK0yzXYcdYvrPP4NbVTwu8zO61fbOrJz8anNH2l2enK4j0ZtGR7w2MqiyC5C4g+nK2ZcXbrQRFFTRqIEsv64jf6bpi0mJ/39gZ9TkNwGMBCXC/OG4V9rCq9e   AYhoPZxgV5gIW7MXRGGpUnCsHrOxHDAi3+haDWsvZRkYVhW3mkqCRcMdO0YmcNyIVbbSnH3oQyfJrn7jISk3+He4xDpFYClBvvUDuJ6JlP/luw4T40eAGjRsquz6sMB49VntcnjOoFW0S9bAvfXte0cFQBy565eQBoWrUBzf80GAUJaAq0Scn1Gv+kVo7TAhCWTtLjbh1p9noCpYJO7cpqAXAkF+hxFamaQHqxd60J21CnKLxxxFsPfaaKyecHXFMvA09QApDrv4D/EgijaoYFFHE2z7k5ImokgP2ft5xoieGVvCuMX5B2VzVQleV+d2tTXFuGPJwwPBjKGJ23zwG0VONJLmmekazMFjr3A+Gy2sb1AhB4j6gezrS5TGEPk9gI3pA9oRCCmJ46ZCPMVkTbuiUq3Q/0bixBWjFKKWsDGIsQU4yHDyIRfsq/1PyLrzScHJmGy7gKajUjG5SpgJRV4OASs5ETqgI162/PlEpN15tf1/E6dQLem+DWFCReQS6MY6IqKzilWORAiuswQAfl2FFIWXrICCTDkK8hOskk2DYasxRy8dCbDrSgZhiRhWGOw4u8nCs9womBsnVTmaBZMSLdAUB4JiSqbXB4VyzcxrhMShi/zlftvXCe0UsiBkKa8bRSVwW5ZzYPd8jQ/oI1Ymi/frEC+YOylIHGod5rKTALSB3N2qbHrDAWHevp9+JqpKeS0dQux4+wSzyW5E+lVjr7lK3f1FOOLpdZFjCaYhDCHgMPmrswc6gma0FTmdhBpcUO0RjZEuRNfzACzalydUhlzEPzLuEtSREQwKwTbBnqHgt62AQy+ve3CSOdQp8cHedgvgn8Qw2914c9q/qj+AdB49mv9A4z4OnoDHSiV62kLen0ePw38tY8PdpmDAtjHa7ukMVEajJktX4zYAwIq2yQxWd8WgKq1Fec31ctjh7Hkd3nG0iEqtrWAr1VPHlDiMJMybthi/tger0wdOz3uhYyKpmea0KFN/MaYav4SQJbzUtk8oG1jawMgo   bhLfH8VSm+X74MKoQDn+D4EyxcyqdwJeN856jdMWoIhTY6gCGQDTHX9r+rSqZ7dpSeGke15PXfFCbF+rZVEAAQjJw/2m3NgGDNYWqiPAGYofCMjjZgJBT8E6Nsxx2tsx9h3oLHcfAVsaJunrB3UVk55dtAlM3YQ3zK2V9hSDJH2OTV8Tnqk20n9YoqDyZ+W7XFW1S5vQK7W7fG1twU6cMy6nbJXcdUJMGUv5KoTXP0XE5/M0uEns7MAWbT8So5KY6TLceGMo9yqzs+4hnGYc2AuJuskZBp6jfwum2UikpNlQjlCzT2+5chLgeRIIHATaQXM5g0AbGzewALbC1LD1/Y/sLaNSI5h94PEGDFsYGHreELyJDpJJY+whvE4BC6Mx/XLZouCiWxQlR5+4+rbnNrg6nsAgnYnSaTtQolEaZJy5C5qn+f52Yg1xc1GoF6bQKGEi1gJh+UQsq6FIMrUmf5206HLKsTv4vr+EpOuXSDSLQHY2m7ZgVH45rDO4l+8Uz2XGBdfy8M7cJtL+loOxSpec+n5UBcULx1CcCgIzstFtemvLEYT0n0SFJsGibVU107Y7LqycMhm15YEBMPxbuvsK3POjtycoxcnqhHbwBxeb2TPHK9UmuW9ktfRy/n4YGR3WJBGZD3qomIhJDLlhV4oVOb574sLDszAfWVzuUhIa9LCw2ZcSX2BG3At3J7iWrgX7odMoVF7sLrKtrwyiKwrj8FDEOraIqDG+o7Ifgbpsw4BkPBbB0obUx/KBWo3xtR8NbNGKyDABoQPGC+86i/+KFHpzrJ+uErFdmKIpIiqeO02PhsZdtK4HmrU1kAMZoXUpK0Bi48rZhuFXy7DydivE3AyxkhB2BUFq6sZlr+65giaftEdNfXSEhskCGlrieCqH7y13WMBayHv2GIh5dhCViLOLSolfgpXuXrgpnA9MoamJvn+/Fz1A2TtTCU3d0ZG3AbmUxQpLPSApagTBLyMXMzhwJisgyKNTWnR0bc5FQsz7mifd6L41u8b4    ka3cmGpdnLFtuFrJx/4Xfwwgc9KKW7na+Aj6AwzKfSI+Rs7cQMfQWcwx5lFVDuFA6t0GBMmnR9ywDBd+kPNyPs7Vw+mOrWJOyv2LNt9qU6l8axHgcxY+F1+0+BDAqL/EJW3jgCLm5OuViQnWoJO+62r4WjDD5Rm5OGGyFaoqjqGAP4bIxHuoTXvQNk8TTpQ7SbmWRsF21p9g8JQwNcbsL/PsflA6ZhbZKGU2V1mHZ8bWwkoHI1sSV8pNjklKb+O05Q/PtnkxERhYWlMjgpDCvraap0B1DkSQn8IHi2qKuorVYsIQWkceOzW0spjbTuLp1nbzmwtOw7iVdU/pLAYlV9LEeb7QfO9bJ4me3X5/L6A0Bfs/dUX8LY5FWVbA0blRy5mAvMjm6HHizSD5to9QhDqBPdxRNpRFmwfYzBFis1J42C/usTpgrumWA/oQ0FOhmq3cbQl7ljaxOdp9K2AMDT/VtBvfhQTG8KdnsmAJz+izEwGJQRN37eRyVhxFX3sZtJqEjfWFst3e64Um8QNPGV/igFX7vLRsNHb1xb0DPp+bWNifHH90c51bTf7aOd6WFNQ5/oRH8CdydkDlKxx74J7lSYD90ZIHY7PD7WZdUe5P8utbUdQXkRrVZwzPtKtJzxN7mwnR31h9bWsjEqPXJ+04iHJhlqElyWjhNucYk3f9J8BDafdJKHlJRvW53tOiWN9xK9Hlsc/5WO34q6LHapBUm+5UuOVMZjwT2wCC3dlM7CbNsCuLI86stHtefQ5jbtyfh2muCt3DwVQPtQEZMt3uyBcOyqib2LcXypghi/zwNDg9wqaMiY9+suJ/8PPIMhPS7iZhznVYGHysazxY+vJP8ulDf5jJ//UJ2PchaEeHhWbmwfu9pRm0Qdu7uq4/1OaAQbuHsPSxIT6byEIDhhuttHtF/38CspwTt58e8lO8Tq4I8Qt7XLdXM0opPlnNheEWe6B+blnL9kEYs04boG0tDwV9OSCkUv9uP1sbH2Bgf8CfRmICQ==cXq�    � � �                                                                                                                                                                      �% A�Ulaozhang入金- 銀行支援列表eNp1lt1SE0kUx6/DU/QlXPACe4fRUrbKLUqocr3shDHTLPRQmRkEKhcIokFlIwWuKx8qmmiskmCASDaJ8C7W9CS54hX29Hz09PSESVXqnDPTv/n3OX1ODUIIDY0ixNYr/Wdbo6j/fKV3+NLdOXZLZ6z4pndYHYKr4IfZq81utT6cy4yk4pFlXY1oVESc9qfux06hv7Lbf7w9/GByJDTTvwtz8sGfI4Whwm+jsQu0ISWmh   �%$ M�]laozhang入金- 銀行單筆限額列表eNqtk8tOwkAUhtf0KeYBqCkmLOrWnYkrFoZ36QItYLkFCLcAolapdCEgEEDbBl6mZzpd9RUcqKEVq+3CyTSZ859v/jMznUEIIYZFCHKKfVtnkV3MELkM7Yk1ztvdmi1XQOoQWWUYIfaVq1UsdRajYaZnXzccQ0qnHKPgF84vjoSrVPpyLzHCGUsbLYrckT9AAv1YwVOp/l9lY+b7GO5Krhdlklyc47gTjkM02PcDQzZzrIwPZIL7HYW1Aq18NFTXiOq5JoNAbbhb+t9uuNSPWhK/1a3mQwhKJMm/29N4IsCtiJdrvHzBg5nVNWDWCvEE/TkqSldqbuUwv1wBhqNIe7bFJW5uITsnjWyY68cCJoUwqNwxtVcP4uM8zx8zlW+MPzMd4cVTUMY9091VG9Tp/wy/cPRATe0+yIpUpzCs/szQxiK46RJVd4wefcP40QAxZ276UBVJRnQM752DtDJ1xfWwpDnW2nT2J1NIw0g=cX @�    FBBuiHbaKiQcppHbO9nf/sHiEj57v4LXxO4NzD9CxkPUVonFIO/rBs0p2OaA/tXcRf+4QcU9nTfae4KSu/ixK0cCcpYLk+y9qxl5/EsUpH0GuJ5hb1+KoiBGxLH6bRtWnkCPEynUdqYm9PyWTIAn7sG3271ahcRHtxqJNhbDFRqWnbWIgb1sHBjhmA6gOa0yrxGIom+m0giqLQpyWJONH2aMYDmvtiTtx64cW13Ybuw1DJDZcv6YNb3re7O+4jluwqLUFPXaM5DEQ8xF4TUrK2fxcpcLMpllooSiFoE2pKmSmp8ZqWtSFLjc/dtR0Am+SZ0TNCEPQ2lQze1BW3WmJ/TqBVS5+2HWBX236XMZNBNEvO2DczraDl+0wNG5WweOZeHck9wVzkc41Pj6Sj5AIfNJtK1wcpfIlW+K3EwRbcWtHwmT3J6XNC0usP+as3duWSr1d72E0HsrzV48MkJD4bcCcO0oASTeAGybyYaIqvbi3YifaestuFjrzpF97zO9k8hoaz+OgxupMRj3ouG/YcgzfwhLzTCXw7vRGOiX/ghShbr5Run9S1Ki++q3XJDIzP+YcwIK0mBwRMbE14Qxo/cMQEJ3fPmjzIrOH+GzyAz6B7pFDx3G+fSKfBcVWZ4Xr3NClOBgEr3YAs0yd3j3+Kj0rsld5Joguskm7osOTaKmvtOK3qJe1B3Wu8EeErXxIG4hU0LjZmEl4c3x1KiTpt/s3Ip6vbSMXdD1B0bLxIcCtI9T+30ZlnOYOAmCm34OcsYSu7YZvycbA48J39gGpwOKqzYLmqP3dOPEeX4C3cTFFiYMTgkNCJA+at7VokAvqsCpoh4u+WbMsM9OGLn76SqeK7KuAPlhFHCu1OPzEjIRQ3mEHx2OO1/Uwn3vpbWsYUm8BKfbhB4pJFFRYX3LKsdiEVB5PiHiIzNknm8BAYOjWA5XKOIrb7tVdtXnV345nE/dNjaunOxx0prvZW1q07wRRR+0FS6p+1uo94tnritf2D1/y1kPb4=cX @F    SFUkG7INhoqpJzmEdv73d/+CSpSvrv/0hcF7g1M/0TGY5TWCcXgL+sGzemY5sD+r7gL//ADCnu+7zR3BaV3ceJWjgRlLJcnWXvWsvN4FqlIeg3xvMLePhfEwA2J43TaNq08AR6m0yhtzM1p+SwZgM9dg2+3erWLCA9uNRLsLQYqNS07axGDeli4MUMwHUBzWmVeJJFE300kEVTalGQxJ5o+zRhAc1/uyVsP3Li2e7BdWGqZobJlfTDrx1Z355+I5bsKi1BT12jOQxEPMReE1Kytn8XKXCzKZZaKEohaBNqSpkpqfGGlrUhS40v3Q0dAJvkmdEzQhD0NpUM3tQVt1pif06gVUuftx1gV9utSZjJoJ4l52wbmdbQcv+kBo3I2j5zLQ7knuKscjvGp8XSUfIDDZhPp2mDlr5Eq35U4mKJbC1o+kyc5PS5oWt1hf7Xm7lyy1Wpv+5kg9tcaPPjshAdD7oRhWlCCSbwA2TcTDZHV7UU7kb5TVtvwsVedonteZ/unkFBWfxsGN1LiMe9Fw/5DkGb+kBca4S+Hd6Ix0S/8ECWL9eqd0/oepcV31W65oZEZ/zBmhJWkwOCJjQkvCONH7piAhB5480eZFZw/w2eQGXSPdApeuI1z6RR4riozPK/eZoWpQECle7AFmuTu8W/xUendkjtJNMF1kk1dlhwbRc19pxW9xD2oO62PAjyla+JA3MKmhcZMwsvDm2MpUafN16xcirq9dMzdEHXHxosEh4J0z1M7vVmWMxi4iUIbfs4yhpI7thk/J5sDz8l9TIPTQYUV20XtqXv6KaIcf+VuggILMwaHhEYEKH9zzyoRwHdVwBQRb7d8U2a4B0fs/KNUFc9VGXegnDBKeHfqkRkJuajBHILvDqf9PpVwH2ppHVtoAi/x6QaBJxpZVFR4z7LagVgURI5/isjYLJnHS2Dg0AiWwzWK2OqHXrV91dmFjx733w5bW3cu9lhprbeydtUJPonCL5pK97TdbdS7xRO39Tes/h8PHj4KcX @�   � ��                                                                                                                                                                                                                                                                                                                                                                                                                           �0D C�}laozhang出金 - 銀行支援列表eNq1WktX20gWXie/QsvuRfoHzM4xL4MxYKAT2CmgxuohUsa2MklOFrzBgDEEEiC8Qng56QnGxoCxefwZS5ZX+QtzS1VSleSy6VlMzsk53Kp763Uf371XFgRBePxEEPTZYnV2RXgiVOfHzP1FYy1jpPL63Lq5n378+P0jPKovJyvp7M+buZEXP28Sj2qG30W4w5JiDT9+/48n8A82FPBfLCG8h/9P3tNRGId9y4Uf+tZtdfUS1nuEye0FvDyQT0Xln4L6h+CPyIqIN   ��C A�-laozhang入金- 銀行支援列表eNqNVltT00AUfoZfsY/ywB/wrVQHeFAZYUZ5XEpsgrBlmgSByQNys1y0w4gXbipIFWekyKWCbYX/4mTT9om/4NndZJMmtCUPnXPOJt+5f12EEGrvRIgu5Gqv1jpRbXmmurvqrB852TOa+VDdPWiHxxLmO8mhDk+cVqWoEE+0S18re2VrsN/qfmT1Dz614l0xq92621n3gEsUsoVMyAocBGXUb   s    SFUkG7INhoqpJzmEdv73d/+CSpSvrv/0hcF7g1M/0TGY5TWCcXgL+sGzemY5sD+r7gL//ADCnu+7zR3BaV3ceJWjgRlLJcnWXvWsvN4FqlIeg3xvMLePhfEwA2J43TaNq08AR6m0yhtzM1p+SwZgM9dg2+3erWLCA9uNRLsLQYqNS07axGDeli4MUMwHUBzWmVeJJFE300kEVTalGQxJ5o+zRhAc1/uyVsP3Li2e7BdWGqZobJlfTDrx1Z355+I5bsKi1BT12jOQxEPMReE1Kytn8XKXCzKZZaKEohaBNqSpkpqfGGlrUhS40v3Q0dAJvkmdEzQhD0NpUM3tQVt1pif06gVUuftx1gV9utSZjJoJ4l52wbmdbQcv+kBo3I2j5zLQ7knuKscjvGp8XSUfIDDZhPp2mDlr5Eq35U4mKJbC1o+kyc5PS5oWt1hf7Xm7lyy1Wpv+5kg9tcaPPjshAdD7oRhWlCCSbwA2TcTDZHV7UU7kb5TVtvwsVedonteZ/unkFBWfxsGN1LiMe9Fw/5DkGb+kBca4S+Hd6Ix0S/8ECWL9eqd0/oepcV31W65oZEZ/zBmhJWkwOCJjQkvCONH7piAhB5480eZFZw/w2eQGXSPdApeuI1z6RR4riozPK/eZoWpQECle7AFmuTu8W/xUendkjtJNMF1kk1dlhwbRc19pxW9xD2oO62PAjyla+JA3MKmhcZMwsvDm2MpUafN16xcirq9dMzdEHXHxosEh4J0z1M7vVmWMxi4iUIbfs4yhpI7thk/J5sDz8l9TIPTQYUV20XtqXv6KaIcf+VuggILMwaHhEYEKH9zzyoRwHdVwBQRb7d8U2a4B0fs/KNUFc9VGXegnDBKeHfqkRkJuajBHILvDqf9PpVwH2ppHVtoAi/x6QaBJxpZVFR4z7LagVgURI5/isjYLJnHS2Dg0AiWwzWK2OqHXrV91dmFjx733w5bW3cu9lhprbeydtUJPonCL5pK97TdbdS7xRO39Tes/h8PHj4KcX Au   #p://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)   $     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备�    ��：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


W:��                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              �}" M�laozhang入金- 銀行單筆限額列表eNqtk89OwkAQxs/0KfoA1CwmHOrVm4knDoZ36QEUteVPkFCCoqhokR6sFRoClkZeprNdTn0FB5rQitX24KRNOt/88s3udpbjMTiB5z1Vp/KMDXTfqcOpDsZ1oLjLAS2bHCdlVtUSG9ThquHp4wympd6q3PYduVjwHSUqHB7tCCeF4vFG4qQDAWPdM/iKJryEryCFKur/1Tbjzg24qwVeyORJlhCyRwiPyebZMuxzQofGlsyR31GYDaFzkQ5d2EwPXfNxoK2tl/63G63dpm1J31ue+pCAMlmO7nY/m4txq9LpjE5faH/s3Tgw7iR4wuI5LYorxQFL8jtXQBul2vPqbErVJVQmrF1Jcv2w4E1Jgupd134NITEriuIu0/jGRCvmiFpPcZXgTNej1m/h/0weODxQ176Ps2JNE7TmzwqGwIN2SS280j3afUThC3TXpCk=cX @(    DpZ55uxxAOpQIpOUSFH2pDXKOtk3NYpO/x3sPcVgsgE4tGrICYQ72H6EzKeoJxOKAZ5TTdoQce0AOv/SgfwDz+gsBdHbutAUPrX5171VFDGC0WStxcsu4gXkIqkdxCvquztC0EMxYg4Qeds0yoS4GE6h3LG4qJWzJMh+MId+E67X7+O8SDW4oB9Y6BS07LzFjGoj4WNeYLpEJrbrvA7EkkMxFQSIUqbkjzmRDOgGUNo3qtD+eihmIztIRwXTC0zimxNH876e7e3/3vMCkSFRaipa7Tgo4iPWAxVata2LhPXXCrJ1yxdShjUCtBWNTWk5mdW3o1Dan7uve8KyBQ/hI4JmrTn4OrQt9qytmAsLWrUiqhL9hOsBvbPjcxk0E0S8zsbmHfRCnzTB8bX2Tp1b07knuCiUhwT0xO5OPkAh8Om0rXNKl/iqAJR4mCK7i9rxdkiKejJgObUEw426t7+Dduo9feeC+Jgs8mVz8+5MuJOGqYFVzCFlyH7Zqoh8rq9YqfSd8Hq2wH2tlvyrhrs6AISyhpvI+V2RrzmOxoJXoI085d81Sh3Dj7RuOgXXkTpy3r9zm3/FaclENVuuaeR+aAYZ8UqTYHBkxgTvhLGj9wxIQk98uePMis4f57PIDPsHqkKXnrNK6kKfFENM6pX/7BiqUAgSu94F2KSuyfY4qPS35I7STTBXSGbuhxyYhS1jtx27MQ7brjtDwI8rWuiIO5j00LjJglLP5HbnTesUo77vHzGxQjywMYrBEeh6L6k9nirIucuFFNXbIhsSa6TxbEztDh+wDQsCSpWiQPUn3kXH2PK2RcupihgOGuoAVT+9C6rsWkgqqbTRPiVjb3jU3b1Qcq+L6rGD+DaYGTYqufrOswZ+IpxO79lUuJjLadjC03iVT69QPFUI8HIib3777L6sTAKNWdfhWZ8gSzhVVjgaBGawzOG2Mb7fq1z2z2ATyjvjy7b3HKvD1l5s7++edsNP7CiD5Zq76LTazZ6pXOv/StY/w9tc2occXsq    BAqSTdkG42VUk77lB1+He59AREp3z166WsCdxLTX5DxGGV1QjH4a7pBCzqmBbC/lQ/gH35AYc+OnPaBoAyuz93aqaBkCkWStxcsu4gXkIqkdxCvauz1M0EM3JA4Reds0yoS4GE6h7LG4qJWzJMR+MId+G5n0LiO8ODWI8HeYqBS07LzFjGoh4Ub8wTTETSnU+U1Ekn03UQSQaVNSR5zounTjBE09+WhvPXAjWv7AbYLSy0zVLamj2Z93u3v/xWxfFdhEWrqGi14KOIhFoOQmrWty1iZy2W5zFJRAlErQFvVVEmtj6yyG0lqfey/7QnIDN+EjgmatuegdOietqwtGEuLGrVC6pL9GKvC/ruRmQy6SWI+sIF5F63Ab3rAqJztU+fmRO4J7iqHY2p2KhslH+Cw2US6tln1U6TKdyUOpuj+slbMFUlBjwuaU3c43Gi4+zdsoz7YeyqIw80WDz4958GQO22YFpRgBi9D9s1EQ+R1e8VOpO+CNbZ97G2v7F412dEFJJQ1X4fB7ZR4zHvRuP8QpJk/5IXS/OXwTpQR/cIPUbJYr944nX+jtPiu2i2TGpn3D2NOWEkKDJ7YmPCCMH7kjglI6JE3f5RZwfnzfAaZQfdIp+CF27qSToHnqjLD8+ptVpgKBFS6x7ugSe4e/xYfld4tuZNEE9wl2dRlybFR1D5yOtFL3OOm03knwLO6Jg7EfWxaKGMSXh7eHKuJOu38xqqVqNsrZ9wNUQ9tvEJwKEj3PLXT21U5g4GbKLTh5yxnKLljO/FzsjPynPyIaXA6qLBiu2g8cS/eR5SzT9xNUGBhzuCQ0IgA1X/cy1oE8F0VMEvE2y3flBnu8Sm7eidVxXNVxkMoJ4wS3p16ZEZCrhswh+Cjw+n+mUq4P2lZHVtoGq/y6QaBXzWyoqjwnmWNY7EoiJx9EZHMAlnCq2Dg0AiWwzWB2MbbQb172zuALx737x7b3HKuD1llc7C+edsLvofCD5pa/6LbbzX75XO38wes/h8q/T1ucX A�   � � � ,                              �] [�Claozhang微信支付入金限制（借记卡）    
-  微信支付入金- 銀行支援�   m�F C��+laozhang出金 - 銀行支援列表    
-  出金 - 銀行支援列表

|	銀行名稱（gb）	|	銀行名稱（zh）	|	銀行名稱（en）	|
|:----    |:-------    |:--- |-- -|------      |
|	中国银行	|	中國銀行	|   �c A�g878167192入金- 銀行支援列表    
-  入金- 銀行支援列表



|銀行名稱(gb)|銀行名稱(zh)|銀行名稱(en)|銀行代碼|YS|GO|SYX|CBA|
|:--------------    |:-------------    |:--------- |--------   |--------    
|	中国银行	|	中國銀行	|	Bank of China	|	zhonghang	|	√	|	√	|	√	|	√	|
|	农业银行	|	農業銀行	|	Agricultural Bank of China	|	nonghang	|	√	|	√	|	√	|	√	|
|	工商银行	|	工商銀行	|	Industrial and Commercial Bank of China	|	gonghang	|	√	|	√	|	√	|	√	|
|	建设银行	|	建設銀行	|	China Constuction Bank	|	jianhang	|	√	|	√	|	√	|	   ��  �  ��l            �W 1�]laozhang入金銀行列表eNp1lEtP20AQx8/Jp9gjHPgCvYUUFSpRoYLUclyCiZeGNYptCsgHoLwfpQgQLa8WGiCVSijvNFD4Lp�+ A�ulaozhang入金- 銀行支援列表eNp1ll9PG0cQwJ/tT7GP8MAX6Btxo4ZKqVBASnlczMW3FPaQ744AugcCITVJiIsgTcOftCR24krF1ICDa7vwXarbs/3EV+js/dnb2zNnydqZvfnN7OzM6BBCKDuGENuqDn7eHUODl+v9k9fe/plXvmSld/2TGt8NtOyXnV6tMVKYHc0kFGu6otBopHA7n3ofu5nB+sHg2d7IzNRotMx9L5ZTMz+K9czD0Ww266T8OSmHTsqjI7t0YpdO7NKRX   &   � A�laozhang入金- 銀行支援列表eNp1lltPE0EUgJ/bXzGP8MAf8A0qEUw0REiUx6Gs3UGYJd1dBLIPXqEoiAQMyk3BojWRIjepBeG/mJ2lfeIveGYvs7OzBRJyzpmd75w5t4AQ�?! A�laozhang入金- 銀行支援列表eNp1ll9PG0cQwJ/tT7GP8MAX6Btxo4ZKqVBBanlcm4tvKewh3x0FdA8EQmqSEBdBmoY/aUntxJWKqQEH13bhu1S3Z/uJr9DZ+7O3t2fOkjUze/ub2Zmd0SGEUHYCIbZdG/60N4GGLzYGp6+8g3OvcsXKbwendb4aWNnPu/16c6yYH88kDOu6YtBoZHC7f/Q/9DLDjcPh0/2xuZnxSMx9LcSZue+FPPd4PJvNOil/Tsqhk/LoyC6d2KUTu3Qkl07W+WIi8UAqkGJTTMiRF   �H  M%laozhang入金- 銀行單筆限額列表eNoDAAAAAAE=cX =m: D D.                                                                                                                                  �o	 %�laozhang默认页面-  支付寶入金- 銀行支援列表�	 �	 7�Ylaozhang支付寶入金限制-  支付寶入金- 銀行支援列表（借记卡）

�G C��+878167192出金 - 銀行支援列表    
-  出金 - 銀行支援列表

|	銀行名稱（gb）	|	銀行名稱（zh）	|	銀行名稱（en）	|
|:----    |:-------    |:--- |-- -|------      |
|	中国银行	|	中國銀行	|   r   �                                                                                                                                                                                                                �                               �? =�#878167192微信支付入金限制    
-  微信支付入金- 銀行支援列表（借记卡）



|銀行名稱（gb）|虚拟商品交易（單笔/單天）|实物商品交易（單笔/單   �                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    BMz/Y7kEwRVb/IyRBYbLqEeaFVdIAybIFKOGKm+ihTQ186pn+nXrvZEkSfL6JAnmmrlQWKFnTssQb/OrnE/i1xFbyeAck18gWbKV7nKWhEjL1vqQVZazlBef8AYFt1mrO8D1H99xIWxXqizdgrsE5C9NQ2XlPC6xnmw9Ffz4AfVxhQKtaaUeKZQ3/M336cEjS3tz6ylv2AOTNobj+Vc8kifsuTg7O/OvXjgOhPzBkGcNmhq2NheBAh+gRN3UqwTI1J+h9k5FiqdA/X0QdB7yn3+A3hYg5w6CLkL+iw2IpWui7HYgJJJHDh88+I8CHtUg2j0MWo2D6/EmQ+wLIhrr56xCi8ow/uJC6LY0byPQUtR2446Iqx0IsjegykRp+FUWjB2hASdoTcNHrExcxPsuP1O/ZuMJdfTGM0yaR/COx2evHdGW22i6KtxyL1qJl0eskeN3V1Qabw02oGrJkrc89k6AuGLAfIL/EXLnXqmSNVSp1p8MoD4SBXN0WT4J/QKbdqkMBi07LVMtq+tWokVvarcXoq510PF+y4eXFGheEbHvIEy7ZKMH6uzZkmk8USyM+ryaILqMN37BsEY1diWNUiFuxW1+P6NYHlCrrNgjIpp63b5pEgnYL2NsbCrLQoQ1G/b1AMsokiBHJsW+VUys5H+huIhZX/Qf7ysC3T5WR0ZL2uxIlT7zqaoB5Na/frHSvUPZTnJ0RFmF7tbR/xs/DzoE+ihjdHH0PbU85n7gYv2Ocold/eT7gdAYP4uknIPBHcWEqxXvEvwi53fxa0eCYlFzjN3N2CkeQjPGLbHX+UMDjM6qPesR/qccDGFnnujQWFsR8ERvO8aLvlo5jxWnI+5Rq8cnQbRid6fLWRVVhd3PIBY35zWQY3YktpxloNfh1dpGjbiCt66OOW1bo6k1HljJITOKXu9fFyIYzg==cX���                                                                                   t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<   6               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   X码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**     t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<   0----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in   3               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   4员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   5码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    1

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   7员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   8码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    F

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<   ;               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   <员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   >码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**     �  �|
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &q� : !#�{ertgtd4fv4data-副本    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----               2   ?

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   9----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<   @----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in   A

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   B码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    C员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   D               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   G----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<    �  �    |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
-� 9 !#�{ertgtd4fv4data-副本    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----               :    �  �| 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &qu� ; !#�{ertgtd4fv4data-副本    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----               .    �  �|:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码� 8 !#�{ertgtd4fv4data-副本    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----               (    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<   K----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in   L

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   O               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   P员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   M码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**     t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<
    �	|	500000	|	500000	|	无限额	|
|	上海银行	|	50000	|	50000	|	10万	|

-  支付寶入金- 銀行支援列表（信用卡）

|	銀行名稱（gb）	|	單筆	|	單日	|	單月	|
|:--------------    |:-------------    |
|	工商银行	|	10000	|	10000	|	100000	|
|	农业银行	|	20000	|	20000	|	200000	|
|	建设银行	|	50000	|	50000	|	100000	|
|	中国银行	|	卡额度	|	卡额度	|	卡额度	|
|	平安银行	|	50000	|	50000	|	无限额	|
|	交通银行	|	20000	|	20000	|	50000	|
|	招商银行	|	30000	|	无限额	|	无限额	|
|	浦发银行	|	100000	|	100000	|	无限额	|
|	邮储银行	|	20000	|	20000	|	50000	|
|	兴业银行	|	50000	|	100000	|	无限额	|
|	广发银行	|	30000	|	30000	|	无限额	|
|	华夏银行	|	20000	|	无限额	|	无限额	|
|	民生银行	|	卡额度	|	卡额度	|	卡额度	|
|	光大银行	|	50000	|	50000	|	无限额	|
|	中信银行	|	卡额度	|	卡额度	|	卡额度	|

- 備註：表格僅供參考，其他各城市商業銀行，實際支付額度以系統爲準

cX���                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   � �                                                                                                                                                                                                                                                                                                                                                                                                                              �U@ M�=laozhang入金- 銀行單筆限額列表eNqdVMtugkAUXctXzAdIghIXdNd2162b+i8sbFGLr6jxFbWmJZWWRbXVxtoC0Z9hhmHFL3QUBYqotJOQnLncc8/hMncAAICiAYB52bpr0MAqZbFUgZ2JOS5YvbolVaHYxZJCUXxs+65eNZVpjGyzfeumaetiJm3rRX/g8ioQSGeugykX55sIxZ/RZBEXwEH+DeDJQ/NelMSJD+NrDO/LjhtSM8XEGYYBBLE74IVc5PLwcobksctOMG5uONyvABcybBeiVQgvoKlY8Syk/mBAHa1bGCLNBplBKioPDrh2qUlmD7me0XvDbD38r21YFP0tT8YTW5Ud8OGNYAnNF2j+jIZTs6fDaTuibFAXak9HS5zsGfl0YyWdUA+K5otw9BLGOXEqLGGOWiuYm+FmLpLboPD3B5wUjzLZUF6la6ivHo+LcxwXdR7Wf2o9UcMGOVwH5or1NcA5D7U3OKq5qf4RSP3O3S0awNseVjRb75PLCD3qUMgbywGsCTgr2Lp3YUHx09Bkp7QpzpDaIewfy7u+0w==cXJa�   � �                                                                                                                                                                                                                                                                                                                                                                                                                                  �Q? M�5laozhang入金- 銀行單筆限額列表eNqdVMtugkAUXctXzAdIghIXdNd2162b+i8sbFGLr6jxFbWmJZWWRbXVxtoq0Z/hDrDiFzqKAkWs2ElIzlzuPedwuTMIIUTRCEFWNu9qNDILaUMqQWukD3Nmp2pKZRDbhqRQFB/ZvquWdWUcIdt017ypW6qYSlpq3hu4vPIFkqlrf8rF+SZC8Wc0WcQFspF3g3jy0LwbJXHiQ/sawn3RdkM4E0yUYRhEELsDbshBTp2xnGB56FTHGCc3GO4zwEyGZi4cQzDBYm4oroXECQbmg3ULA6TZw00gdbjYO2B5vy6+5xe/1/TGw/9aZoiit93xaGyrsgMevBEs4OkMT59xf6x3VBg3Q8r6dWHx9CcFe4yAfLq2ko6o+0WzeRi8BNUcmQhTmOLGCjITo54J5dYv/P0Bo/zpcwGltjZ/deu4KMdxYc/C+k+tT1O/RmbrwJliPQ2w56HyBoOKk+od/8Tv3N2iEdx2DGVhqV1yEeFHFYSstuxBRTDSgqW6lxWIn9pCtql1cYLnLVL9A/rKviY=cXJac   � �                                                                                                                                                                                                                                                                                                                                                                                                                                  �Q> M�5laozhang入金- 銀行單筆限額列表eNqdVMtugkAUXctXzAdIghIXdNd2162b+i8sbFGLr6jxFbWmNZWWRbXVxtoC0Z/hDrDiFzqKAkWs2klIzlzuuedwuTMIIUTRCEFWsu5qNLIKaXNQgtbYGOWsTtUalEFsmwOZovjI5l21bMiTCNmmu9ZN3dbEVNLW8v7A5VUgkExdB1MuztcRij+jySIukIP8G8STh+a9KIkTH/rXCO6LjhtSM8FEGYZBBLFb4IVc5PLMxRRLI5cdY9zccLhbAeYSNHPHVQgvoCqm7FlInGBAGa5aGCLN7m8C4eFib4/lXV58xy9+rxmNh/+1zBRFf7vj0dhGZQt8eC1YwLM5nj3j/sToaDBpHpAN/VxQn/7ks8FCIT9aXw4OSAdFs3kYvoRxDoyDJcxwYwmZqVnPHOU2KPz9AeP86UMBpbauvHo8Lspx3LEHYfWbVkepXyODtedAsb4GOMNQeYNhxU31z37id+520QhuO6as2lqX3EL4UQMhqy96UBHMtGBr3k0F4qeuSk5pQ5xipUXYP/rjvag=cXJa6                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          $   #   "   #   $��方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	    ^://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     銀行)	|	Ping An Bank	|	shenfa	|	√	|	|	|	|
|	北京银行	|	北京銀行	|	Bank of Beijing	|	beijing	|	√	|	|	|	|
|	北京农商银行	|	北京農商銀行	|	Beijing Rural Commercial Bank	|	bjnongshang	|		|	|	|	|
|	上海银行	|	上海銀行	|	Bank of Shanghai	|	shanghai	|		|	|	|	|
|	上海农村商业银行	|	上海農村商業銀行	|	Shanghai Rural Commercial Bank	|	shnongshang	|	√	|	|	|	|
|	东亚银行	|	東亞銀行	|	The Bank of East Asia	|		|	√	|	|	|	|
|	华夏银行	|	華夏銀行	|	Huaxia Bank	|	huaxia	|	√	|	|	|	|
|	渤海银行	|	渤海銀行	|	Bank of Bohai	|		|		|	|	|	|
|	南京银行	|	南京銀行	|	Bank of Nanjing	|	nanjing	|	√	|	|	|	|
|	宁波银行	|	寧波銀行	|	Bank of Ningbo	|		|		|	|	|	|
|	天津银行	|	天津銀行	|	Bank of Tianjing	|		|		|	|	|	|
|	杭州银行	|	杭州銀行	|	Bank of Hangzhou	|		|		|	|	|	|
|	微信支付	|	微信支付	|	WeChat Payment	|	weixin	|		|	|	|	|
|	支付宝支付	|	支付寶支付	|	Alipay	|	alipay	|		|	|	|	|	|




- 备注：无


cXrV    RJzd4XYP/hIyIP32rPZrJPy56QcOimPjuzSiV06sUtHculknVsdiR9IBVJsigk50oEso6yTcWt7bP1vc/k3BJEJ1I23QUygdmH6BBmPUU4nFIM+rRu0oGNaAPlfaQ3+wi9Q2MyGW1sTlMbFobe7JyidhSLJ26OWXcSjSEXSG4inu+zDjCCGakTspcO2aRUJ8DAdRjljbEwr5kkLfOEG/Fm9Ub2I8aBW4oD9y0ClpmXnLWJQHwsHIwTTFjS3XuY1EkkM1FQSIUqbkjzmRDOgGS1o3tt1+emhmoztHjwXrlpmFNm03pr1a+lq5XPMClSFRaipa7Tgo4iPGAtNatZeHyfKXCrJZZaKEgY1CbQpTQ3p5BtbXIpDOvl29elcQPr5I3RMUJ89DKVDt7UJbdQYH9OoFVHH7cdYDezPpcxkME0S844NzJtoBX7oA+Ny1vbcy215JriqNEfvQG8uTj7A4bGpdM2x8vc4qkCVOJii7gmtOFQkBT0Z0LD6wuaLqrdyyV5UGsuvBLH58oQbXx1yY8TtM0wLStCPJyD7Zmog8ro9aafSd8SqcwH2+rzknR6wjSNIKDv4EBnnMuIz31Fb8BGkmX/km9q5c/CJOsW88CZKF2t+1a3/jNMSqOq0dGlkJGjGISGlKbB4EmvCN8L6kScmJKEH/v5RdgXnj/AdZIbTI3XBG+/kVOoCX1XDjPrVf6wQFQhE6W0uQUzy9ARHfFX6R/IkiSG4KWRTl0NOrKLahluPnXibB259S4AHdE00RDc2LdRpkrD1E7ldeMfKi/GcL+5zNYL02HiS4CgU3dfUGa+V5dyFaqrEhsiW5DrZHAstm+M+pmFLUCElHlB97h3txJT971xNUeDikKEGUP7hHe/GVwNVvTpAhF/5sre5x063pOz7qnq5B8oGK8NWPV9UYc/AfzHu2cdMSn2o5XRsoT48xbcXGJ5qJFg5sXf/W1bdFJdCy/5vYekcJeN4CgQcCeF1+OlArDzrHVWuz9e81S9g+A8yjknycXr�   � �                                                                                                                                                                                                                                                                                                                                                                                                                              �U< M�=laozhang入金- 銀行單筆限額列表eNqdVM1ugkAQPstT7ANIghoP9Nb21quX+i4cbFGLf1HjX9SallRaDtVWG2urRF+GWeDEK3TxB1DAn26yybfDfDPfDLOLEEIUjRBkJOOhSiMjn9LFIjSH2iBrtCuGWAKhpYsyRXGhzbdKSZNHIXJMdYy7mqkIyYSp5NyG65s9QyJ5u+9ydbmyUNwFTRZRgdbIfUAc2TTnWImd6FB/BvBYWKshMeNMmGEYRFBsCxyTjWyevhhjaWCzI4zt6w+9EWAqQSN7WgT/APOZLjsS4mcImPWtFvqkjgU3gfBwoRsg2cuLevTiz6pWf/pfy3RBcLc7Go5ssmyBC68S5vFkiievuDfS2gqMGkfS+pYL85eD/MPNIkWrS/FI3v2MmRz03/w4Xt/N/PITXF9CeqzX0gc1BjQWfr9gmDu/Oii21Nm7w2PDLMueOv7Wz7EuUK9KxingGsV2KrdGoPwB/bLt6p74+K7vdtEI7tu6PDeVDnl78LMCfEZddKHM6yneVJz3CYRvdS6tQ2vCGM+ahP0Hp4C73Q==cXJY    �：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<� 
  {
    &quot;error_code&quot;: 0,
    &quot;dat   d    |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备�   � �                                                                                                                                                                                                                                                                                                                                                                                                                                  �Q= M�5laozhang入金- 銀行單筆限額列表eNqdVMtugkAUXZevmA+QBDUu6K7trls39V9Y2KIWX1HjK2pNSyoti2qrjbUFoj/DHWDFL3QUBargoyQkZy733HvmcGcQQoiiEYKsZN3XaGQV0qZYgtbIGOasTtUSyyC0TVGmKO5s/a1aNuTxGVmmu9Zt3daEVNLW8v7A1fVWIJm62U65vFhFKO6cJg9RgRzkXyCOvDTnRUmc6NC/h/BQdNSQmgkmwjAMIii+AV7IRS7PnE+wNHTZUcbNDYa7FWAmQTN3XIXgAqpiyp6ExAkClMHSwoDW8XATCA8XeyGSd3mxHb34o2Y0Hv9nmSkIfrtjkei6ywb48KphAU9nePqC+2Ojo8G4eaBt4HZBfd7L328W2bS+EA/03e6YzcPgNYhzYBYsfoobC8hMzHpmr9QQf+HnE0b50zcJpbauvHk8NsKy7LGnYPmPlueoXyNTFXKa4j4DnEmovMOg4qb6Bz/xN3fz0AjuOqas2lqXXEH4SQM+q897UOHNNG9r3jUFwpeuSk5pQ5hgpUXYv9wAvSo=cXJ`O    |	广州农村商业银行	|	廣州農村商業銀行	|	Guangzhou Rural Commerical Bank	|
|	昆山农村商业银行	|	崑山農村商業銀行	|	KUNSHAN RURAL COMMERCIAL BANK	|
|	佛山顺德农村商业银行	|	佛山順德農村商業銀行	|	Shunde Rural Commercial Bank	|
|	上海农村商业银行	|	上海農村商業銀行	|	Shanghai Rural Commercial Bank	|
|	深圳农村商业银行	|	深圳農村商業銀行	|	Shenzhen Rural Commerical Bank	|
|	太仓农村商业银行	|	太倉農村商業銀行	|	Taicang Rural Commercial Bank	|
|	宁夏黄河农村商业银行	|	寧夏黃河農村商業銀行	|	Yellow River Rural Commercial Bank	|
|	张家口市商业银行	|	張家口市商業銀行	|	Bank of ZhangJiaKou	|
|	张家港农村商业银行	|	張家港農村商業銀行	|	Rural Commercial Bank Of Zhangjiagang	|


- 備註：表格僅供參考，系統出金下拉列表中無法顯示的銀行，請選擇“其他銀行”，並在“開戶網點”中填寫正確的詳細銀行開戶名稱。


cXtkA   g商业银行	|	攀枝花市商業銀行	|	PanZhiHua City Commercial Bank	|
|	重庆黔江银座村镇银行	|	重慶黔江銀座村鎮銀行	|	Chongqing Qianjiang Yinzuo Rural Bank	|
|	山东省农村信用社联合社	|	山東省農村信用社聯合社	|	Rural Credit Cooperative of Shandong	|
|	天津农村合作银行	|	天津農村合作銀行	|	TIANJIN RURAL COOPERATIVE BANK	|
|	云南省农村信用社联合社	|	雲南省農村信用社聯合社	|	Yunnan Rural Credit Cooperatives	|
|	宁波鄞州农村合作银行	|	寧波鄞州農村合作銀行	|	Yinzhou Bank	|
|	郑州银行	|	鄭州銀行	|	Bank of ZhengZhou	|
|	浙江省农村信用社联合社	|	浙江省農村信用社聯合社	|	Zhejiang Province Rural Credit Cooperatives	|
|	江苏长江商业银行	|	江蘇長江商業銀行	|	JiangSu ChangJiang Commercial Bank	|
|	北京农村商业银行	|	北京農村商業銀行	|	Beijing Rural Commercial Bank	|
|	重庆农村商业银行	|	重慶農村商業銀行	|	Chongqing Rural Commercial Bank	|
   hnk of ShaoXing	|
|	浙商银行	|	浙商銀行	|	China Zheshang Bank	|
|	安徽省农村信用联社	|	安徽省農村信用聯社	|	Anhui jixi Rural Commercial Bank Company Limited	|
|	重庆银行	|	重慶銀行	|	Bank of ChongQing	|
|	东莞农村商业银行	|	東莞農村商業銀行	|	DONGGUAN RURAL COMMERCIAL BANK	|
|	福建省农村信用社联合社	|	福建省農村信用社聯合社	|	FUJIAN RURAL CREDIT UNION	|
|	广州银行	|	廣州銀行	|	Bank of GuangZhou	|
|	广西壮族自治区农村信用社联合社	|	廣西壯族自治區農村信用社聯合社	|	Rural Credit Union of Guangxi Zhuang Autonomous Region	|
|	湖北省农村信用社联合社	|	湖北省農村信用社聯合社	|	Hubei Rural Credit Cooperatives	|
|	吉林省农村信用社联合社	|	吉林省農村信用社聯合社	|	JILIN PROVINCE RURAL CREDIT BANK	|
|	江苏省农村信用社联合社	|	江蘇省農村信用社聯合社	|	Juangsu Rural Commercial Bank	|
|	龙江银行	|	龍江銀行	|	LongJiang Bank	|
|	攀枝花市   ingshu Rural Commercial Bank	|
|	浙江稠州商业银行	|	浙江稠州商業銀行	|	ZheJiang ChouZhou Commercial Bank	|
|	东莞银行	|	東莞銀行	|	Bank of DongGuan	|
|	东营市商业银行	|	東營市商業銀行	|	Dongying Bank	|
|	恒丰银行	|	恆豐銀行	|	HENGFENG BANK Co.Ltd	|
|	晋城银行	|	晉城銀行	|	JinCheng Bank	|
|	浙江景宁银座村镇银行	|	浙江景寧銀座村鎮銀行	|	Zhejiang Jingning Yinzuo Rural Bank	|
|	晋商银行	|	晉商銀行	|	JinShang Bank	|
|	莱商银行	|	萊商銀行	|	LaiShang Bank	|
|	廊坊银行	|	廊坊銀行	|	BANK OF LANGFANG	|
|	临商银行	|	臨商銀行	|	Linshang Bank	|
|	绵阳市商业银行	|	綿陽市商業銀行	|	MianYang City Commercial Bank	|
|	内蒙古银行	|	內蒙古銀行	|	Bank of Inner Mongolia	|
|	泉州银行	|	泉州銀行	|	Bank of QuanZhou	|
|	商丘市商业银行	|	商丘市商業銀行	|	SHANG QIU COMMERCIAL BANK	|
|	上饶银行	|	上饒銀行	|	Bank of Shangrao	|
|	绍兴银行营业部	|	紹興銀行營業部	|	Ba   _ _                                                                                                                                                                                                                                                                                                                                                     �W 7�e	laozhang支付寶入金限制eNq1VElygkAUXcMpvABVRItNjpNNLuHC0jjGsWI0DiklJcaNaOIYIXqZ/g294grphEigAcVFetO/vs/HH95rIRbDzRnSnmC2hqxC8g0hRkopUy7TNK4todA25YmlFyA1MNU5VGRLL/J8krNB9IfbG5rhkhy0VGOaswPcVn6DfoFL8slrwXNi9DC5nxSlRdsp9D7Jw5qSU4orkR7XjdtD0qmTl+dvVg5yfbTthoITItrmbeBGgcdcMNAOjki0G5FUOGXcYdR2prr34SQfIXwsQC06QMnfCNMUnQA6yL4/SMETyBZh9BoRjFdjqDUccEJ05hQMv++5h3amkI+Dj9t1e8EkrUJ64mH+u5gi5g2jOYg8jeUpPTDgShVGNS+z6A7YtZTwahNayHHhvBDVUHTJRnPy74Y6JX2XBfxuih8l777FIPH7Z+EgGTvTbuk8YTcOj8MtE7xzxrBs1ZJTCiPnxFkjMnZxPRZRRB1eCKNS6TTtRcZiNB0/36PXXhH3c8mjwzxnUb5APQTpjjnRLL1LvYKHOmSyaN+DWsZMZSy9DNk10lpQv4NBFbZpulasTI/+KcNsTLo924RErlBOpCnGQjNWb0bhHe9aPP8F5PEt7g==cX���   j南陽銀行	|	Bank of NanYang	|
|	宁夏银行	|	寧夏銀行	|	Bank of NingXia	|
|	青岛银行	|	青島銀行	|	Bank of Qingdao	|
|	青海银行	|	青海銀行	|	Bank of QingHai	|
|	齐商银行	|	齊商銀行	|	QiShang Bank	|
|	新韩银行（中国）	|	新韓銀行（中國）	|	SHINHAN BANK(CHINA) LTD	|
|	浙江泰隆商业银行	|	浙江泰隆商業銀行	|	ZheJiang Tailong Commercial Bank	|
|	台州银行	|	台州銀行	|	Bank of TaiZhou	|
|	天津银行	|	天津銀行	|	Bank of TianJin	|
|	潍坊银行	|	濰坊銀行	|	Bank of WeiFang	|
|	温州银行	|	溫州銀行	|	Bank of WenZhou	|
|	吴江农村商业银行	|	吳江農村商業銀行	|	WUJIANG RURAL COMMERCIAL BANK	|
|	邢台银行	|	邢台銀行	|	Bank of XingTai	|
|	营口银行	|	營口銀行	|	Bank of YingKou	|
|	包商银行	|	包商銀行	|	Baoshang Bank Limited	|
|	沧州银行	|	滄州銀行	|	Bank of Cangzhou	|
|	长沙银行	|	長沙銀行	|	Bank of ChangSha	|
|	江苏常熟农村商业银行	|	江蘇常熟農村商業銀行	|	Cha   l Bank	|
|	承德银行	|	承德銀行	|	Bank of ChengDe	|
|	赣州银行	|	贛州銀行	|	Bank of GanZhou	|
|	广西北部湾银行	|	廣西北部灣銀行	|	GuangXi BeiBu Gulf Bank	|
|	贵阳市商业银行	|	貴陽市商業銀行	|	Bank of GuiYang	|
|	广东华兴银行	|	廣東華興銀行	|	GuangDong HuaXing Bank	|
|	徽商银行	|	徽商銀行	|	huisang bank	|
|	葫芦岛银行	|	葫蘆島銀行	|	Bank of HuLuDao	|
|	江西赣州银座村镇银行	|	江西贛州銀座村鎮銀行	|	Jiangxi Ganzhou Yinzuo Rural Bank	|
|	嘉兴银行	|	嘉興銀行	|	Bank of JiaXing	|
|	锦州银行	|	錦州銀行	|	Bank of JinZhou	|
|	南昌银行	|	南昌銀行	|	Juangxi Bank	|
|	开封市商业银行	|	開封市商業銀行	|	COMMERCIAL BANK OF KAIFENG	|
|	企业银行（中国）	|	企業銀行（中國）	|	Industrial Bank of Korea (China) Limited	|
|	兰州银行	|	蘭州銀行	|	Bank of LanZhou	|
|	柳州银行	|	柳州銀行	|	Bank of LiuZhou	|
|	洛阳银行	|	洛陽銀行	|	Bank of LuoYang	|
|	南阳银行	|	   m	Huaxia Bank	|
|	湖州银行	|	湖州銀行	|	Bank of Huzhou	|
|	济宁银行	|	濟寧銀行	|	Bank of JiNing	|
|	昆仑银行	|	崑崙銀行	|	Bank of KunLun	|
|	浙江民泰商业银行	|	浙江民泰商業銀行	|	ZheJiang Mintai Commercial Bank	|
|	广东南粤银行	|	廣東南粵銀行	|	GuangDong NanYue Bank	|
|	宁波银行	|	寧波銀行	|	Bank of NingBo	|
|	日照银行	|	日照銀行	|	Bank of RiZhao	|
|	北京顺义银座村镇银行	|	北京順義銀座村鎮銀行	|	Beijing Shunyi Yinzuo Rural Bank	|
|	苏州银行	|	蘇州銀行	|	Bank of SuZhou	|
|	乌鲁木齐市商业银行	|	烏魯木齊市商業銀行	|	Bank of URUMQI	|
|	威海市商业银行	|	威海市商業銀行	|	WeiHai City Commercial Bank	|
|	厦门银行	|	廈門銀行	|	Xiamen Bank	|
|	烟台银行	|	煙台銀行	|	Yantai Bank	|
|	珠海华润银行	|	珠海華潤銀行	|	CHINA RESOURCES BANK OF ZHUHAI CO. LTD	|
|	自贡市商业银行	|	自貢市商業銀行	|	ZIGONG COMMERCIAL BANK	|
|	长安银行	|	長安銀行	|	ChangAn   nITED	|
|	重庆渝北银座村镇银行	|	重慶渝北銀座村鎮銀行	|	Chongqing Yubei Yinzuo Rural Bank	|
|	浙江三门银座村镇银行	|	浙江三門銀座村鎮銀行	|	Zhejiang Sanmen Yinzuo Rural Bank	|
|	鞍山市商业银行	|	鞍山市商業銀行	|	Bank of Anshan	|
|	大连银行	|	大連銀行	|	Bank of DaLian	|
|	德阳银行	|	德陽銀行	|	Bank of DeYang	|
|	德州银行	|	德州銀行	|	Dezhou Bank	|
|	富滇银行	|	富滇銀行	|	FUDIAN BANK	|
|	福建海峡银行	|	福建海峽銀行	|	FuJian HaiXia Bank	|
|	深圳福田银座村镇银行	|	深圳福田銀座村鎮銀行	|	Shenzhen Futian Yinzuo Rural Bank	|
|	桂林银行	|	桂林銀行	|	GuiLin Bank	|
|	海南省农村信用社联合社	|	海南省農村信用社聯合社	|	Hainan bank	|
|	邯郸市商业银行	|	邯鄲市商業銀行	|	Bank of Handan	|
|	江苏银行	|	江蘇銀行	|	Bank of HangSu	|
|	汉口银行	|	漢口銀行	|	HanKou Bank	|
|	哈尔滨银行	|	哈爾濱銀行	|	Harbin Bank	|
|	华夏银行	|	華夏銀行	|   o��银行	|	上海農村商業銀行	|	Shanghai Rural Commercial Bank	|
|	东亚银行	|	東亞銀行	|	The Bank of East Asia	|
|	华夏银行	|	華夏銀行	|	Huaxia Bank	|
|	渤海银行	|	渤海銀行	|	Bank of Bohai	|
|	南京银行	|	南京銀行	|	Bank of Nanjing	|
|	宁波银行	|	寧波銀行	|	Bank of Ningbo	|
|	天津银行	|	天津銀行	|	Bank of Tianjing	|
|	杭州银行	|	杭州銀行	|	Bank of Hangzhou	|
|	韩亚银行（中国）	|	韓亞銀行（中國）	|	HANA BANK (CHINA) COMPANY LIMITED	|
|	齐鲁银行	|	齊魯銀行	|	QiLu Bank	|
|	阜新银行	|	阜新銀行	|	Bank of FuXin	|
|	河北银行	|	河北銀行	|	Bank of HeBei	|
|	吉林银行	|	吉林銀行	|	Bank of JiLin	|
|	外换银行（中国）	|	外換銀行（中國）	|	Korea Exchange Bank	|
|	漯河市商业银行	|	漯河市商業銀行	|	Bank of LuoHe	|
|	鄂尔多斯银行	|	鄂爾多斯銀行	|	Ordos Bank	|
|	泰安市商业银行	|	泰安市商業銀行	|	Taian Bank	|
|	友利银行	|	友利銀行	|	WOORI BANK (CHINA) LIM    � �2 �                                                                                                                  �'0 A�mlaozhang入金- 銀行支援列表eNqFls9T2kAUx8/wV+xRDvwDvSF1WjvTGac60+lxhUhiITgkseJwsCIWf7TUUWtFbGsrlkPFoqIUKP4vnWyAk/9CXxKy2QSjOTD73iaf/ea9/S5BCCF/ECGSK   ��#/ A�elaozhang入金- 銀行支援列表eNp9ls9T2kAUx8/wV+xRDvwDvSF1WjvTGac60+lxxUhiITgkseJwsKIWf7SUUWtFbGsrlkPFoqIWKP4vnWyAk/9C3yZks4RgDsy+t9nPfve9fS8ghJA/i   ��. M�Mlaozhang入金- 銀行單筆限額列表eNqNk8tOwkAUhtf0KeYBqBlMWNSdunPrynfpAi1guQUItwCiVql0ISAQRNsGXqZnOl31FRyooRWr7WSa9Pzn63/mTGcQQojjEYKc6tzWeeQUM1QpQ3tij/NOt+YoFZA7VNE4Tkx852oVW5slWJjpOdcN15SvLl2zEBTOLw6Fs9OdwoknPBusJvLeggES2cOLvsp0VtX6GMNdyavNPNM4iTE+whixYDf3DF3PiTrekyn8NworFVr5eKihU813TYeB+nDb6v9upNSPW5K81e3mQwRKZTnY7XEyFeJWJMsVWb6QwczumjBrRXiC8RwXZSu1NkqUX64Aw1Gsnh1pSZobyM5pIxvl+rmASSEKKncs/dWHhKQgCIdM5QcTzExHZPEUlvH2dHvUBnX2P6MPHNtQS78Ps6LVKQyrvzNs8AhuulQzXLPHLh95NEHKWes+VCWakVzTv6Agv1uG6nnY8pzobfb1FwUEm/g=cX A�   p	Bank of China	|
|	农业银行	|	農業銀行	|	Agricultural Bank of China	|
|	工商银行	|	工商銀行	|	Industrial and Commercial Bank of China	|
|	建设银行	|	建設銀行	|	China Constuction Bank	|
|	交通银行	|	交通銀行	|	Bank of Communications	|
|	招商银行	|	招商銀行	|	China Merchants Bank	|
|	民生银行	|	民生銀行	|	China Minsheng Banking	|
|	兴业银行	|	興業銀行	|	Industrial Bank	|
|	浦发银行	|	浦發銀行	|	Shanghai Pudong Development Bank	|
|	广发银行	|	廣發銀行	|	Guangdong Development Bank	|
|	中信银行	|	中信銀行	|	China CITIC Bank	|
|	光大银行	|	光大銀行	|	Chian Everbright Bank	|
|	邮政储蓄银行	|	郵政儲蓄銀行	|	Postal Savings Bank of China	|
|	平安银行(深圳发展银行)	|	平安銀行(深圳發展銀行)	|	Ping An Bank	|
|	北京银行	|	北京銀行	|	Bank of Beijing	|
|	北京农商银行	|	北京農商銀行	|	Beijing Rural Commercial Bank	|
|	上海银行	|	上海銀行	|	Bank of Shanghai	|
|	上海农村商�    rXZF4d062/t7W9w2CbU7RXhH9QuTJ6j1DMUVzWCQZ9WUySpYpIE+V9m86ZfwKSL2/bFpsSsXp44uUOJGUumtYQ5aphpPIrCDsit8M9z9N2ixHdVD7+XDJu6kdYAHZNhFE+NjSnphHaDs+StnJWK1fyl7wzUAz8ZDgU+iG6YCUNLEe4EDkY0TFpi28X92oxfKFeNFB8yMImWwAxfF9ipltjOylawSK5aH/cDKAwAGboX9bR6G+Rfa5X1zz6yUEPIGtFVhSQ5sMYBx1xT82ovnNWNTiYTHJ1Aa92AJwF7SmkebuEbza754Ra+VTbKErKfpatiDfWZwzAO6J4yoYymxscUYng+xs1nuHnQf66CHijsbcBDtwkeGmEn2WELeNhJ+2o3uKJMDU1g70Bv3O8ieIPKtKj0Et3/7gct1AAqJuj+hJIeSmtJtT7e4ebx1mbzzvoVnT2ovp2X+LW5AjPOnzCj56UvpRvQy348AW3UI/uZUM1Js0XlT2l+STi5Lmec82O6fQq9oMfvPONSm3xNEKx4CTrEXuKmDhYKRIBicn3ZpLbq+us3dD/rj2r2iKleaj0mntSwB6dyDYRGWKsf7OJPvxlCDRNBl6KNiF0aklKT+DgIcHEdV3IjMHKQDFxc9JhTcogwmbcRRsu6SwyRLPiILjuF88CIcjUcv7drvL5SlGARPIjd2VmDSIOUII7Yfwo/CtKD3OVGiehqMBHpNUgWO4f0/JNPFkINJ9IDALBkbDZVX6zPhU9IfVdf39jVh5i4vSRSinZVAO7/cM5yPqBQw4ADGscBiyGl+nR5hbft4mYg0WO7GE30PtYNFNP56DIKm8Khuomw8i+d0z0/rKPvTI3kCakNpViantAoy8s8EBzcmuzSx7aI+kSJq9hAfXiK8SgYXijapJdjlPz5ZzS/I793LUe/pSU2qo3jKRCwJ4TGQjydiM5uVA9K1+VNuMg5X8p0bsG+3KLZuerM3HXZveZ5V7dc5bRUKRxXMidO8T18/R+usJajcXpy    5ru2f31f7unm0UIIX8QIZotdT8Ugqi7Mt85WNM2T7T8Oc1tdw7KfrjSppt+Wm+Xq0P8eKDXMSd4HByxHWrjR/t7M92dL3bfbwyNRQL2MvzcWUbG3rju4VAg7U8/CvZcIBJ5fB4XSjMb7Br50z716pju/u1uXIAgn2nurZr6wBzG5C1KTqCwIBIM9pyQJLyACQ/rf7liv//ApEt76lXRYXZap1rp2GGG+JQYVeKyksJx5A1AHsS/LNGtJYdvmTZ/hMQUSU6JQMckhsLJRIJLRcU+wfgHBWvUO5WWGwzMsvsyBgpiEElWorKYJEYQ2JgUMRnIVuuHem2d5JvmreTDGyhEjGKdL5ns5EC2trrLJskye3W/gMQASJZs1XPCQ8i/C+3Nry7ZND1kkUgCR3gDLBrAhOW6P9vZ856jk8uxR4cprSV4BtiznAfGaq0d0XzB1Vo7au80HV5Ef1cBi2hUicFZQI+5aS6enEpwRLYDTCkT+H7Ff67ZCBSamonwVIEId7F5fXMAHhpSvT5g+1M3Pcdv5NVI2C0hRIO03J0Tml2mhz9dxabJIDFBT6a51HhK5IVesTHMAhlmd6GibV7ThXJnY9EhdzM13bl4qjtt/mhSkqF+ETwNpZNu9WRUUGaUAQk/o5VlM8hNM6ddVuneGZSAVrds57LPuc0IO2TeBIXRbzJcAV0KKEAhp2X10zmo2Osf6WHePZ75E920X+2ZgmdEbOMEw+qLM1lr22r9l1sG0/Q2/zAnTpr9M+6s7tFnQGD+9sxHwwlTmB0AFhe9NMawZ0jq0Sb1USxZw4D5M87kila7ZM6kYXqV281lZNZZ9iOBXm2/AOrY1je39N8OY4sdA07b3iVeEljxnjYwE9WqQB/Bb7na+OK7Zb7mwgKW0Sie1dsVHO84kW0pz4wxHqOVfed5y3Ny4XhCcXEKz8IC2wsPxr6CiC7sdMqNm2YRPjC0b02ayaqtXZrPdOYzN03r88P+gCi1zxrtWrWdO9Xqn+Hp//lU+qM=cX<y    �                                                                                                                                                                                                                                                                      �B A�=laozhang入金- 銀行支援列表eNqNls1SGkEQx8/wFHOUAy+QG5JUYqpSZYVUJR5HWHfXwGCxu0YtDkbE4FcIpcaIWomJGA4Rg4oaIPguqZ0FTr5Cer+HFcUty   t�QA M�5laozhang入金- 銀行單筆限額列表eNqdVM1SglAUXsdT3AeQGdRxQbtq19ZNvgsLCzX8G3X8GzWnmKRYpKWNWcDoy3AusOIVuooCIYZ1Z5j57uF85/s43HMRQoiiEYK8ZN02aGSVsqZYgc7EGBesXt0SqyB0TVGmKO5k+65eNeTpCdlm+9Z109aETNrWiv7AxWUgkM5cBVPOzzYRijulySIukIP8G8SRh+a8KIkTH/rnGO7KjhtSM8XEGIZBBCV3wAu5yOWZyxmWxi47zri54XC/AiwkaBeOqxBeQFVM2bOQ+oMBZbRuYYh0MsgMUnF5cMC1S00we8j1jN8aRuv+f20zBcHf8kQsvlXZAR/eCJbwfIHnT3g4NXoaTNtHygZ1QX38tURkz8in6ysxQj0omi/C6DmME3EqLH6OWyvIzcxm7ii3QeGvd5gUI5ihxEpXV148IhtjWfbYgVj/qvVIDRvkdB0YrKSvA86BqL3CqOam+mcg9TN3t2gENz1TVm2tT24j/KABn9eXA6jxZpa3Ne/GAuFDVyWntCHMsNIh7G9UV78BcXJb    �：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<�                     code        x�                IrSDdlGI8WU0zphB/8Odr+DiJTvHr7wNYE7genvyHiEMjqhGPxV3aB5HdM82P+V9uEffkBhzw6d1r6g9K/O3OqJoKTzBZKz5y27gOeRiqS3EC+r7M0zQQzckDhJZ23TKhDgYTqLMsbCglbIkSH4/C34Trtfv4rw4NYiwd5ioFLTsnMWMaiHhRtzBNMhNKdd4TUSSfTdRBJBpU1JDnOi6dOMITT3xYG89cCNa/sVtgtLLTNUtqoPZ33b6e39HbF8V2ERauoazXso4iEWgpCatc2LWJlLJbnMUlECUctAW9FUSc1PrLwTSWp+6r3rCsg034SOCZqyZ6F06I62pM0biwsatULqov0Iq8J+XMtMBt0kMX+2gXkbLc9vesConK0T5/pY7gnuKodjcmYyEyUf4LDZRLq2WOVzpMp3JQ6m6O6SVsgWSF6PC5pVdzhYr7t712y91t99KoiDjSYPPj3jwZA7ZZgWlGAaL0H2zURD5HR72U6k75zVt3zsTbfkXjbY4TkklDXehMGtlHjMe9Go/xCkmT/khcb4y+GdKC36hR+iZLFevnXaX6O0+K7aLRMamfMPY1ZYSQoMntiY8IIwfuSOCUjovjd/lFnB+XN8BplB90in4LnbvJROgeeqMsPz6m1WmAoEVLpHO6BJ7h7/Fh+V3i25k0QT3CbZ1GXJsVHUOnTa0Uvco4bTfi/AM7omDsRdbFoobRJeHt4cK4k6bb9ilXLU7eVT7oaoezZeJjgUpHue2umtipzBwE0U2vBzljWU3LHt+DnZHnpOfsM0OB1UWLFd1J+45x8iyuln7iYosDBrcEhoRIDKF/eiGgF8VwXMEPF2yzdlhnt0wi7fS1XxXJVxD8oJo4R3px6ZkZCrOswh+OxwOn+lEu4DLaNjC03hFT7dIPBYI8uKCu9ZVj8Si4LI6XcRSc+TRbwCBg6NYDlc44itv+vXOjfdffjmcf/pso1N5+qAlTf6axs33eCLKPygqfbOO71mo1c6c9t/wur/AQ9JPYA=cX A�    u+2wmiwvtQ/2lR3ztTiJSns9Y+qQbiyRpp8fN+r1kfY6ZA7sch5EoxgJZT2j973TnawVBq83R55NRmyhtFnznA0EsoGs4/CrguEIU/Ok0JZaoIeo2A2oDRPycHfwfYViAgYYXnD0AThKBZeo9QMinK8gCFe5FICy2GBhfG/Qsn9CzSyWlaaJZvW756rlVObFmHTfExOSHIaJ5AXLTxAvq6Q3VWbbIYWeVyIy6KU5oGLhTiKppJJJh3j71iGfWCZdqtf6zrLQFh1XkCHAF0QJTkm8SlBx8PELI+Fe6hK61jroV1kIxwqMqiWBT6GNbJoUFP3UNWNA7okZujW+hzKAAhJtJQucvczf2/1dr46TCP0MHlB5BiB1ZG8jkqaKb+q5i9d26JQoLcF1TxT5AJQM4wHZuhrnJDilqOvcdLb79ikSe3NOMyjCTkOfUaPmXkmkZpLMoJkoefkGeyn8s8NzSZgSYr9RAa2H5XVJn3BYCrl5oj2mBZ6NtX41HjUaRKsA0W4qwIkv0aOfzoqjZCCYQGNzTPp6TTPcm6BcUyhDNpguabu3JDlan97xWYOcg0tuXKuJS3yREqUoEOTeB6aIw75KsbJC7JvYS9Ibc3A33YK6nWdlC+g1KS+ayXXAvZt+oIjxk3QAO0mPRXSRMDaKGLbTttz/u18/4EcF51NVzzTQut1nsp4gccWiNMjP9DmntL65VTcCL3uHWX4WcMM0/bInwYHpes405NwXNIONonohX5ees40bZ1Z7cwUTTdTTVWa62rjmtpveugVbJlFr6M9HMKAUvVwC3TRDjamtONdn6LdbHvQT7bI0bKH9rfSLCstZyX1sK60vtj0KY6xt94YFiUUEfW+acbMYLd+0q2Bz+A/Wml/DgyFL5kohyU0gTOakSHxhuFpy9knjv4AqR3aT5qZsys7E0nwczgDA2wNaCXGFUZkeb9fbd92SvC1oH7rkFxe6R6QYq6/lLvtmN8S1tdApXfR7jXqvcK52voET/8HEB/meA==cX1e�    f6+VBQbY+45t/2cb8+551CEEAqGEaLZUvdDIYy6K/OdgzV980TPn9PcduegHIQrbbnpp/V2uTrEj4d6HXOCz8ERx6E1frS/N9Pd+WL3/cbQm7GQs4w+95bDkVA6mH4U7rlAGPL5fC6UZjbYNQqmA9rVMd392924ABEBy9xbtTSBOYzJWyRNoKggEgz2nCARXsCEh/W/XLHff2DSpT3tqugyO61TvXTsMiN8SoypCUVN4QTyByAP4l+W6NaSy7dNhz9C4qqspESgYxJHUSmZ5FIxsU8w/kHBGvVOpeUFA7PsvYyJghhEVtSYIkrEDAIbkyImA9la/dCorZt8y7yVfHgDlYgxbPBliy0NZOuru2ySbLNX9wtIDIAU2VE9JzyE/LvQ3vzqkS3TRxaJLHCEN8GiCUzarvuznT3vOTq5HHt0mNLagmeAPcv5YKzW2hHNFzyttaP2TtPljRnvKmARjapxOAvoMTfNJaSpJEcUJ8CUOoHvV/znmo1AoZGZCE9ViHAXmzc2B+ChIbXrA7Y/DdN3/EZejUS9EkI0SMvdOaHZZXr401NsmQwSE/RkmkuNp0Re6BUbxyyQYXYXKvrmNV0odzYWXXI3UzOci6eG0+GPSrIC9RvD01A6+VZPxgR1Rh2Q8DNaWbaC3DRz+mWV7p1BCWh1y3EuB9zbzLBD1k1QGOMm0xUypIACFHFb1jidg4q9/pEe5r3jmT8xTOfVnql4RsQOTjCtvjiLtbat1X95ZbBMf/MPc+Kk1T/j7uoefSYE5m/PfDSdMIXZAWBz0UtzDPuGpBFt0hjFsj0MmD/zTK7otUvmTJqmX7nTXGZm3WU/EujV9wugjm19a8v47TC32DHgtu1d4mWBFe9rAytRrQr0Efx+a40vgVvmay4qYAWN4lmjXcHxjhPZlmJA1jO0su8+bHtOLlxPJCFO4VlYYGfBMuwrjOjCTqfcuGkW4WtC/9akmazW2qX5TGc+c9O0vzWcr4VS+6zRrlXbuVO9/hme/g9K/PDAcX<   x x                                                                                                                                                                                                                                                                                                                                                                              �P %�E	laozhang默认页面eNq1VEtygkAQXcMpvABVRItNzubC0qBoNGrFaPyklJQYF/GT+Beil5kemJVXyBgigQEUF5lNd3U9Hj3d740Qi+HaBOnPMFmCrJFcVYiRQspSi7SMy3NQGpY6PBgKpLrWeAol9WDkeT7JkcclBXFJDkpP5nvNTnBD+006Cpfkk7eC58ToYWo/JUqH1iNofzmkNyI9rogbPdKskNeXIysH2Q5at0LBCRGtczZwpcFTNhhoJyck2vZJKpwy7jDqW2u88+EkHyFsZjDOO0DJfxHmUnQCaK/6PpCCJyDnof8WEYwXAyhXHXBCdOYUDL9vu4d2oZHN3sftil4wSY8hPfQw/wWmiWnVrHUjT2N+Tg8MuPQA/bKXWXQn7FoKeLEKbeS0cF6IaiS6ZLM2/DcjnZO8S/p+F8VPUndHMUj0/hk4SMbG9JZ0jrAdhOfhVgneNWNUtmvJaYWRceKiARmbuB6JKGIOb4RRp3Se9ipDMVqOX76j11YR93PNY8M8Y1H+QL0D6aY11A9Gi3oE9wzIyGjXhnLGSmUORhHkJdLrULmjC8XayLbVsT4ZkFbbth1RS5QN6Zo5083Fh6l84m2d578BAqgfKQ==cX��Y   x x                                                                                                                                                                                                                                                                                                                                                                              �Q %�E	laozhang默认页面eNq1VElygkAUXcMpuIBVRItNzsbC0jjGseIQh5SSEuMiDomzEL1M/4ZeeYW0IRJoQHGR3vxf7fPxh/c6Igi4NkXaM0xXkFJJphoRSD5uKgV6jcsLyDZNZXTUsxDvmZMZFJWjnuN5mSNPKwriZA6KdeO9ZiW4qf4m3Swn8/J9xHUEepi7nytKhzZj6HzZpHciPY6Im33SqpDXlxMrB+ku2rQDwTERbTIWcK1CPe0PtJIzEu0GJB5MGbUZtZ052XtwkocQtnOY5Gyg5G2EaYpOAB0Uzx8k/wmkcjB4CwnGyyGUqzY4Jtpz8oc/dpxDu1LI9uDhdkQ3mCQmkBi5mP8CU8SsatR6oaexuKQHBlwswaDsZhadCbuWPF6uAws5L5yPhDUSXbJRG/2bkS5J3iF9r4uiZ6k7o+gneu8MbCRjY9olnSPshsF5sFX8d80Yla1askthZBy7akDGJo5HIoyYgwth1Cldpr3JUIyWo9d7dNsq5H5ueWyYZyzMF6h3INEyR9pRb1OP4L4OyRTad6CcNOPJo16A1AppDag8QK8EmwRdK1bHlrlOv06HpN2xzEeUIuVEmmrMNWP5YWQ/8a7B89/NWiNacX��r   v    |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备�   x://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     �：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<x|
|:-----  |:-----|-----                             ~    |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备�   ://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)    �://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)    � �                                                                                                                                                                                                                                                                                                                                                                                                                                                          �9K %�-laozhang默认页面eNqNU0tygkAQXcMpuICFn3KTi7DPJpdgoaloREViidH4LSw0WokoMUajRi9DD7DyCmmkjDEFTmYxdHW/evO6+8FxHMdGOA62hrXTiDqx1nXI9N37coRz8ylHK2KOKO+QqznacL/JIcpWhyBr+43E4hF9FDzI9tDE+s01FkTnqUEKXahmoZK2VjqpV7BEJor9qvL4AX3kocDo2NKIhmLFq8jZQcncn9whxYoMLPpI51Y+UBIjMoloNMp7F8ZJL04KjAcjhWYYLCHwCR8E2Za1bFzgOsQecL1yjG0gMCbwMZ/NWo6h+RXMJhx1wecOlDKFCTIS6M+BoLjAx49MMzAkSodkYeJzYFZpk8i8h03irEH0BqVBMi3bapeincwHYVP41aCRJrNesPBT7AGLmVBL/OiylnkyX4Q9iW53e21YDTx7tlLuSz0poDN9se0xLDr/cQnuNgx4MoBcs9902trMrlNQKPNx725hqoLeII8TavMtp9Sh8PkTwn8Ch3lxL3IJdOWiV74BfgfTiw==cX��    �  �                                                                                                                                                                                        �3	 7�878167192支付寶入金限制-  支付寶入金- 銀行支援列表（借记卡）

|	銀行名稱（gb）	|	單筆	|	單日	|	單月	|
|:--------------    |:-------------    |
|	中国银行	|	10000	|	10000	|	无限额	|
|	农业银行	|	10000	|	10000	|	30万	|
|	工商银行	|	10000	|	100000	|	10万	|
|	交通银行	|	10000	|	10000	|	2万	|
|	建设银行	|	10000	|	50000	|	10万	|
|	平安银行	|	50000	|	无限额	|	无限额	|
|	中信银行	|	50000	|	50000	|	无限额	|
|	光大银行	|	50000	|	50000	|	无限额	|
|	浦发银行	|	300000	|	300000	|	无限额	|
|	招商银行	|	50000	|	50000	|	无限额	|
|	广发银行	|	30000	|	30000	|	无限额	|
|	邮储银行	|	5000	|	5000	|	无限额	|
|	民生银行	|	50000	|	50000	|	无限额	|
|	兴业银行	|	10000	|	10000	|	无限额	|
|	华夏银�   R   � �                                                                                                                                                                                                                                                                                                                                                                                                                               �TL [�-laozhang微信支付入金限制（信用卡）eNqNU0tygkAQXcMpuICFn3KTi7DPJpdgoaloREViidH4LSw0WokoMUajRi9DD7DyCmmkjDEFTmYxdHW/evO6+8FxHMdGOA62hrXTiDqx1nXI9N37coRz8ylHK2KOKO+QqznacL/JIcpWhyBr+43E4hF9FDzI9tDE+s01FkTnqUEKXahmoZK2VjqpV7BEJor9qvL4AX3kocDo2NKIhmLFq8jZQcncn9whxYoMLPpI51Y+UBIjMoloNMp7F8ZJL04KjAcjhWYYLCHwCR8E2Za1bFzgOsQecL1yjG0gMCbwMZ/NWo6h+RXMJhx1wecOlDKFCTIS6M+BoLjAx49MMzAkSodkYeJzYFZpk8i8h03irEH0BqVBMi3bapeincwHYVP41aCRJrNesPBT7AGLmVBL/OiylnkyX4Q9iW53e21YDTx7tlLuSz0poDN9se0xLDr/cQnuNgx4MoBcs9902trMrlNQKPNx725hqoLeII8TavMtp9Sh8PkTwn8Ch3lxL3IJdOWiV74BfgfTiw==cX��(   �    |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备�    �：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<w                                                     �    |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备�    RBYbLqEeaFVdIAybIFKOGKm+ihTQ186pn+nXrvZEkSfL6JAnmmrlQWKFnTssQb/OrnE/i1xFbyeAck18gWbKV7nKWhEjL1vqQVZazlBef8AYFt1mrO8D1H99xIWxXqizdgrsE5C9NQ2XlPC6xnmw9Ffz4AfVxhQKtaaUeKZQ3/M336cEjS3tz6ylv2AOTNobj+Vc8kifsuTg7O/OvXjgOhPzBkGcNmhq2NheBAh+gRN3UqwTI1J+h9k5FiqdA/X0QdB7yn3+A3hYg5w6CLkL+iw2IpWui7HYgJJJHDh88+I8CHtUg2j0MWo2D6/EmQ+wLIhrr56xCi8ow/uJC6LY0byPQUtR2446Iqx0IsjegykRp+FUWjB2hASdoTcNHrExcxPsuP1O/ZuMJdfTGM0yaR/COx2evHdGW22i6KtxyL1qJl0eskeN3V1Qabw02oGrJkrc89k6AuGLAfIL/EXLnXqmSNVSp1p8MoD4SBXN0WT4J/QKbdqkMBi07LVMtq+tWokVvarcXoq510PF+y4eXFGheEbHvIEy7ZKMH6uzZkmk8USyM+ryaILqMN37BsEY1diWNUiFuxW1+P6NYHlCrrNgjIpp63b5pEgnYL2NsbCrLQoQ1G/b1AMsokiBHJsW+VUys5H+huIhZX/Qf7ysC3T5WR0ZL2uxIlT7zqaoB5Na/frHSvUPZTnJ0RFmF7tbR/xs/DzoE+ihjdHH0PbU85n7gYv2Ocold/eT7gdAYP4uknIPBHcWEqxXvEvwi53fxa0eCYlFzjN3N2CkeQjPGLbHX+UMDjM6qPesR/qccDGFnnujQWFsR8ERvO8aLvlo5jxWnI+5Rq8cnQbRid6fLWRVVhd3PIBY35zWQY3YktpxloNfh1dpGjbiCt66OOW1bo6k1HljJITOKXu9fFyIYzg==cX��                                                                                                  �：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<u��用户  |

 **备注** 

- 更多返回错误代   �    |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备�   �://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     � � �                                                                                                                                                                          �!* M�Ulaozhang入金- 銀行單筆限額列表eNqNk8tugkAUhtfyFPMA0mATF3TbXZOuXDS+Cwtb1OItarxFrW1ppbKoWjHWFoi+DGcYVrxCR2mEWlqYDAnnPx//mTPMIIQQwyIEBcW5bbLIKeeIXIXuzJ4WnX7DkWsg9YisMoyQ+M41ara6SNAwN3CuW64pZTOuWQoK5xdHwlUme7mXGOGMpYMWRd5bMEACfVjBV6lOy1ofU7ireMWpaZpLchx3wnGIBvt5YMhGw8r0QKa4v1FYK9ApxkMNnai+azoM1Me7Xv93w5Vh3JL4rWm3HyJQIknBbk+TqRC3Ml6t8eoFjxZ234RFJ8ITjOe4KF2ptZWj/AolGE9i9eyIK9zeQl4jrXyU6+cSZqUoqNqz9Fcf4pM8zx8ztR9MMDOf4OVTWMbb091RGzXp/4w+cHRDLf0+zIrU5zCu/87QwSK46RPVcM0BvX340QSxYG2GUBdJTnRN/4aC9G4ZiudhSxrWu/TrLxflnII=cX @��) A�Ulaozhang入金- 銀行支援列表eNp1lt1OG0cUx6/NU8wlvuAFemecKKFSKxSQql6OzcY7FGaRd5cC8gWBkJgk1EWQpuEjLYmduFIxMeDg2g68S7Sztq94hZ7Zj9nZWbOWrHPO7vz2P+fMOVqEEBqbQIht1YbPdyfQ8MX64OSVu3/mVi5Z+c3gpD4GV8kPs993+vXmeCGXjgfWdCWg0XQqiDjdD/33vdJw/WD4ZG/855l0aGa/j8zJTLo0VvpuInaBMqTEl   '   �业银行	|	農業銀行	|	Agricultural Bank of China	|	nonghang	|	√	|	|	|	|
|	工商银行	|	工商銀行	|	Industrial and Commercial Bank of China	|	gonghang	|	√	|	|	|	|
|	建设银行	|	建設銀行	|	China Constuction Bank	|	jianhang	|	√	|	|	|	|
|	交通银行	|	交通銀行	|	Bank of Communications	|	jiaohang	|	√	|	|	|	|
|	招商银行	|	招商銀行	|	China Merchants Bank	|	zhaohang	|	√	|	|	|	|
|	民生银行	|	民生銀行	|	China Minsheng Banking	|	minsheng	|	√	|	|	|	|
|	兴业银行	|	興業銀行	|	Industrial Bank	|	xingye	|	√	|	|	|	|
|	浦发银行	|	浦發銀行	|	Shanghai Pudong Development Bank	|	pufa	|	√	|	|	|	|
|	广发银行	|	廣發銀行	|	Guangdong Development Bank	|	guangfa	|		|	|	|	|
|	中信银行	|	中信銀行	|	China CITIC Bank	|	zhongxin	|	√	|	|	|	|
|	光大银行	|	光大銀行	|	Chian Everbright Bank	|	guangda	|	√	|	|	|	|
|	邮政储蓄银行	|	郵政儲蓄銀行	|	Postal Savings Bank of China	|	chuxu	|	√	|	|	|	|
|	平安银行	|	平安銀行(深圳發展   ��名稱（zh）	|	銀行名稱（en）	|
|:----    |:-------    |:--- |-- -|------      |
|	中国银行	|	中國銀行	|	Bank of China	|
|	农业银行	|	農業銀行	|	Agricultural Bank of China	|
|	工商银行	|	工商銀行	|	Industrial and Commercial Bank of China	|
|	建设银行	|	建設銀行	|	China Constuction Bank	|
|	交通银行	|	交通銀行	|	Bank of Communications	|
|	招商银行	|	招商銀行	|	China Merchants Bank	|
|	民生银行	|	民生銀行	|	China Minsheng Banking	|
|	兴业银行	|	興業銀行	|	Industrial Bank	|
|	浦发银行	|	浦發銀行	|	Shanghai Pudong Development Bank	|
|	广发银行	|	廣發銀行	|	Guangdong Development Bank	|
|	中信银行	|	中信銀行	|	China CITIC Bank	|
|	光大银行	|	光大銀行	|	Chian Everbright Bank	|
|	邮政储蓄银行	|	郵政儲蓄銀行	|	Postal Savings Bank of China	|
|	平安银行(深圳发展银行)	|	平安銀行(深圳發展銀行)	|	Ping An Bank	|
|	北京银行	|	北京銀行	|	Bank of Beijing	|
|	北京农商银行	|	�   � �0�                                                                                                                                                                                                                                                                                                                                                                                    �#- A�elaozhang入金- 銀行支援列表eNp9lk1T2kAYx8/wKfYoB75Ab0id1s50xqnOdHpcMZJYCA5JrDgcrKjFl5Yyaq2IbW3FcqhYVNQCxe/SyQY4+RX6bEI2SwjmwOzzbPLbf563gBBC/iBCZ   ��#, A�elaozhang入金- 銀行支援列表eNp9lk1T2kAYx8/wKfYoB75Ab0id1s50xqnOdHpcMZJYCA5JrDgcrKjFl5Yyaq2IbW3FcqhYVNQCxe/SyQY4+RX6bF42SwBzYPZ5NvntP89bQAghfxAhs   �+ A�Mlaozhang入金- 銀行支援列表eNp1lt1O20gUx6/hKeYSLniBvQtp1bJSK1SQVr2cBDceFsYotllAuaBQ2tCWpgj6xUd3aZM2Ky2hAVLSJIV3qTxOcsUr7Bl/jMfj4EjROceen/9zzpwjI4TQ8BhCbKPSf7Y9hvrPV3tHL93dE7d0zorvekfVYbgKfpi93upW6yO5zGg8sKIrAY2GAaf9ufupU+iv7vUf74w8nBoNzfTvkTmeGi0MF34bi10gDCkxJ   �    De6lQuLteNLtg1fO/7A7+KHCXxWSnE7XwMfQWeYTqFHzF/biRv4CDqDOc4sotopHFilw5gw6fyQA4bp0h9qRt7dunow1ckN3FmxZ9nuS3UyjWc9CmTGwp/ymwYfEhD9SlTeOgIsbk66WpGcaAk67bOuhqMNP1CakYcbIlugqmofBPhvjES4h9a8A2XzNOlAtZmYZ20UbG3xDQiDAV9PwP4+x+YDpSNukYVSZneZdXRmbCagcDSyJX252OSUpPw6SlP++ESTExOFhaVROSoMKuhrq3UGUOdwCP0heLSoqqgvVS0iBKUx4LFbS8sPte0snmZtO7O17DiIV1VfSWExKr+WIsz3g+Z72TxN9ur0+X0BoTfY87sv4G11Ksq2BozKD1zMBOYHNkOPF2kGzbU7hCDUCe7iiLSjLNg+xmCKFBsTxv5edZHTBXdNsR7Qi4KcDNVu42hL3LG0gc/T6FsBYWj+raDP/CgmNoQ7PZMBT35AmZkMSgiavm8jk7HiKvrYzaTVJG6sLpRvd10pNokbeMr+FAOu3OmjYaOntzXoGfD93srE+OLag53r2k72wc71kKagzvUDPoA7kzP7KFnj3gX3Kk0G7o2QOhyfH2rTa45yf4Zb2w6jvIjWqjhnfKBbT3ia3NlOjnrD6mtZGZEeuD5pxUOSDbUIL0tGCbc5xZq+6T/9Gk67SULLSzasz/ecEsf6iF+PLA9/ysduxV0XO1SDpN5ypcYrYzDhn9gEFu7KZmA3bYBdWR5xZKNbc+hzGnfl/BpMcVfuGgygfKgJyJZvd0C4dlhE38S4v1TADF/mgKHB7xU0ZVR68JcT/4efQZCflnAzD3OqwcLkY1njx9aT38uldf5jJ7/rEzHuwlAPj4jNzQN3e0oz6AM3d3Xc/ylNAwN3jyFpfFz9txAEBww32+jmi352CWU4J2++uWCneB3cYeKWdrlurmYU0vwzmwvCLPfA/Nyzh2wCsWYMt0AeP34i6Ml5I5f6efPZ2PwCA/8F7eqH/w==cXr   �cVd4vsrUHq7fB9UCAU4x/chWD6XSeVOwPvWUb9h0hIMaXIERSAbYKprf1UXT/TsDj0xjGzN6blLToj1ay0kAiAYOb6335wDw5jB0kJ9BDBD4RsZacRMKPghQN+KOV5jK8a+A43l5itgQ9s4Ye2gtnzCs4NOmbGD+KaxtcyWYoi0z6nhc9Ij3Uzo55McTP60ZI+zqnZ5A3K1Lo+vrTXQjmPWzaS9iqtOgCl7IVed4Oq/mPhklg6/mJ0FyKLll3JUGiVdjnNnHOVWdX7GNYyDnANzMVknIdPQa+R32CwTkZwsE8oRau7xTUdeCiRHAoGbSCtgNm8AYGPzBhbYnpMavrb3gbVtRHIMuw8kRolhAwtbxxOSJ9FBKnmENYzHIXBhPK5PNlsUTGSDqvTgG1ff5tQ6V9/9ELQ7SCJtF0okSpOUI3de+zzHz0asKW42AvXaOAolXMRKOCyHkHUtBFGmzvS3mw6dViF+G9f3Fpl07RyRbgnA1jbLDozCN4d1Fv/ineqZxLj4ah7egdtc0ldzKFbxmkvPBjuheGkXgoNBcF4uqk19ZTGakO6ToNg0QKylunrMZteV+QM2u7YkIBiOdVlnX551duRmHb04UY3YBubweiN76nil0gzvlbyOXs7HeyO7zYI0IutRFxULIZEpL/RCoTLHf19ccGAG7iuby0VCWpMWHjbjSuoL3IBr4fYU18K9cD9kCo3ag9UVtuWVQWRdeQweglDXFgE11ndE9jJIn3UIgITfOlDamPxQLlC7MSbnqplVWgEBNiB8wHjhVX/zR4lKt5f0gxUqth1DJEVUxWu38dnIsJ3G9VCjtgZiMCukJm0NWHxMMdso/HIZTsZ+nYCTMUYKwq4oWF3JsPzVVUfQ9IvuqKmXFtkgQUhbSwRX/eCtbR4LWAt5xxbzKccWshJxblEp8VO4yuU9N4XrljE0Ncn352arHyBrZyq52VMy4jYwn6JIYaEbLEUdJ+Bl5GIOB8ZkHRRpbEqLjr7FqViYcUf7vAPFtz7fI    � �� �                                                                                                                                �( A�Ulaozhang入金- 銀行支援列表eNp1lt1O20gUx6/DU8wlXPACexfSastKu0IFqerlJLjxsDBGsU0B5YJC6Ya2NEXQ7ZaP7tImbSqV0AApaZKFd1l5nOSKV9gz/hiPx8GRonOOPT//55w5R0YIoZFxhNhmdfDHzjgaPF/rH790907d8gUrve0f10bgKvph9nq7V2uM5rNjqXhkVVcjGhURp/Ox96FbHKztD57sjj6cHgvNzC+ROZEeK44UfxqPXaANKTElh   w�' A�Ulaozhang入金- 銀行支援列表eNp1lt9PE0sUx5/LXzGP8MA/cN+wGsVEQ4TE+Dgta3e4MEu6uwikDwjiLSpWAl6VH96LtloTKRao1LbC/3Kzs22f+Bfumf0xOztbtklzztmdz37nnDknixBCQ6MIsfVK/6+tUdR/sdI7fOXuHLulM1Z81zusDsFV8MPszWa3Wh/OZUZS8ciyrkY0KiJO+3P3U6fQX9ntP90efjQ5Eprpu8J8OPno3khhqPDHaOwCcUiJK   !�& A�Ulaozhang入金- 銀行支援列表eNp1lt9PE0sUx5/LXzGP8MA/cN+wGsVEQ4TE+Dgta3e4MEu6uwikDwjiLSpWAl6VH96LtloTKRao1LbC/3Kzs22f+Bfumf0xOztbtklzztmdz37nnDknixBCQ6MIsfVK/6+tUdR/sdI7fOXuHLulM1Z81zusDsFV8MPszWa3Wh/OZUZS8ciyrkY0KiJO+3P3U6fQX9ntP90efjQ5Eprpu8J8OPno3khhqPDHaOwCcUiJK      � �                                                                                                                                                                                                                                                                                                                                                                                                                                                                      �-# M�mlaozhang入金- 銀行單筆限額列表eNqtk09OwkAUxtf0FHMAaooJi7p1Z+KKheEuXaAFLAgphH8BRK1S6UJAwAZtG7hM33S66hUcqIGK1XbhZJrM+95vvjcznUEIIYZFCAqqe11nkVvOEaUC7YkzLrrdmqtUQeoQRWMYIfGVq1UdbZagYa7nXjY8S8pmPKsUFE7PDoSLTPZ8KzHCCUsbLYr8UTBAAv1YYa9S/b/KJuz3Mdze+F6USXNJjuOOOA7RYNt3DFnNsTrekSnudxSWKrSK8VDTINreNR0GGsPN0v92wzf9uCXxa91p3kegRJKCuz1OpkLcylhfYv0ZD2ZO14JZK8ITzKe4KF2pvVai/AolGI5i7dkVddxcQ35OGvko148FTEpRUKVjGy97iE/yPH/IVL8xwcx0hBePYRn/TDdXbVCn/zP6wtEDtY27MCsiT2Eo/8zQxiK46hLN9KwefcP4wQKxYK/6IIskJ3pWBTenWH7zp9qm6ixMR5850hwbbTr7E1hcw8Q=cX @p   �6cQAmof5+kF5uPG7CVhWJwgDCtnTAwHvPgXilZD2gtJFoZk5Z2mknDBQNe2kTkoF2K1zRR3H8rwaYK7z3BI+hPuPQaRXgFYarBPbT+uZzL1b8mO89ToAYAWLbs6rd7vM159Wps4qhNoEf2yJXB3VdvKUQEgt2/rBaQh0Qo0d1dsECCkJdAiIddn9JteNkrzTFgySYu7bbDF5wmYCja5KycJyJVQoM9RpGYG6cHatE5kRx2i/NwRZzH8nSQqG+d8TbEMPE31Q6rzDv5DLIiiHRpYxOEU6+6EpJkI8nPWfq4ggld2JzF+Qd5R2UhVknfVyQ19dQH+eMTwYCBjeNI2D9xWgSO9oHlGujZd4NgLjM9kG9sLROhRon4w2+oShTFEbs1zQ3q/RgRieuKIiTBfEWnjnqh0OdS/vgBhxSilqAWsL0BMMe4zjEz4Bfta/yOyXn9yYBIm6y6g2YhkXKwAVlKB+wPASk6kDtiotzVXLjFZZ35Nz2/XCXRpil9TmHABuTSKga6o6JxilQMhotMMEZBvRyFl4SUrkABDvoLsJJtk02DIWszBC2cy3IKSYUgShjQGK/5+ovAUJwrG5nFllmbBhHQLBOXhkKiyyeVhsXwd4zohYfgyV7n7xnVCK4XsD2nK20ZRGeyW1TzYLU/z/dqwpfny9TLkC8ZuChKHeqepTCcgfTBnFxu7zmBwsLvPh6+ZmkROW7cQO84u8UySO5Be5ehbvnJXTjC+WGpdwGiCSQhzCDhs7sr0gZ6gCU1ldhuRFjdEa2RDlDvxxQwwK8blCZUxB8G/jNskRUQEs0Kwtb9nMOht7cfg29MmDHcMdnh8kIf9JvgHMPxW579X84f1D4DGs1/rH2DY194TaEepXHdr0Ovz+Gngr328t8scFMA+XtkljYnSYMxs+WLE7hFQ2SaJyfq2AFStLTi/qV4cOYwlv8MzlnZRsa0FfK16fI8Sh+mUcc0W80f2eGXyyOlxz2VUND3VhHZt/A/GVPMXALKcl8rmAW0bWxsAC   �Coq/xTUPwRvSFZEtMEjfW63XPhs81fvssbxD5vfMxaWR7TxqBYWxwWO8NWx/nHOFiakJexTRrVINCyDqKiMCl715UspPCLzVyoVq2d3dCUgU/QYJh8soESi2khUVhVzBVOwXEzWJuj5CVl3X9hbU+QREQlHTEFjaYc9OyGdO3bDeUOiEo3Q/YzztcrGARXDpEtMViIhSRkzpWRlDN9wNu946IUF9qGZt6JbXZzoiTW61cVJZfvGluiHg42FRFno1UZV2KtFei2Nq69eSkqULqFf37NL6KUjdol2DZZoLAy2U74/ZE0JkS6d+AZ8Xma/2ZiePKX7YZIRERWh9bUUfhGWx0LMVrWpM2PjXp9KVddnbOna9AUanMmiQWuNXjUShUfqF1/Dw0Z4lnSd089ieJFfjKuMvpuDJ9AzH/HQr49sFnNJwgLPgljMIcTSC6sLHsbO9OXNcvE/9GaYdNvZU0n+01a4yQL+5XARcxC8jDU2IiUETTdz+QlRxaJxccWowiTdu1smwYjA9sbeGmzG2h6eQq5uTrF2aFtVs7Pslot0MWMvUy7u2wsMhCRbKa1iJCp4IjJRTHxFTyaoAyTSiLTkOjTxjSwyxl9IsjcmZN17q9Z19bhTP3GufgKiQvVzNmnkvlKJ9Cki6ySA/YWKBZLfjPwxFcCkW2BAZvYw9n7oV/vMW5mkW6QD3vxdSNWwKxx8s58XoADHc4ISB+v2U5Op3SU81eEJeISnnkCX8Iu3wxfw/Cp4e7p7PYEhwe/r9g20tuC1b1dr2UnqYLeLtR9p+zh9sl9jXHJr1/h0Tnkx6T56m/ZcVvBVszkwbnpVTNZdVQJjx6+5GjP2KT8h3fydsp+sryc/GfGv3HdBU4kd7rt0qWFJFFrfoDA+JjHmdZNGJyxMuVyDHWf9wjqPX1M7JPw+M1P6+Yae/Gx8StNXmpmqLNyRQUu2JzyqsgiSO4fow9maGWe3HhBR1KSBKLGkL3yj74ZJi/lZT0/Q5zQEhwHMx/XinFHYw6rSi   �X1JGObHCMPSKRPDAS/+haLVgPZCkoUBWXmnqSRcMNC1aWT3yoVEdT3N3YcyfBrj7jMYkf6Ee49ApFcAlursU91N6tls7Vuy4zw1+gCgRduuTsz7XcarT6pjBzUCTWJQtgXurqob51QAyM3bWgFpQLQDzd0VGwQIaQs0Scj1Gf1mFo3SLBOWLNLmbulvCvhCloIt7spxCnIlFOjPKVIzg/RgLVo7sqM2UX7uirMY/o5TlbUzvqZYBp6meiHVeQf/IRbE0Q51LGJ/gnV3QtJMBPk5az9XEMEr2+MYvyDvqKylK4d35viavjwHfzxieDCQMTwZhwduq8CRXtA8I1OdLHDsBcancvXtBSL0MFE/mK25QGEMkRuz3JDeqxGBhJ46YCLMV0Q6uCcqHS71r85BWDFKaWoBq3MQU4z7LCMTfcG+1v+IrNefXJiEyZoLaA4iGRdLgJVU4H4PsJITqUMO6m3MlEtM1plf0fObNQIdmhLUFCZcQC6NYqAnKrqnWOVAiGi3QgTk23FIWXjJCiTAkK8gO8kdsmkwZC3W4IU7GW5CyTAkCQMagxV/P1F4ihMFY/2oMk2zYEJ6BcLyYERU2eRyv1i+TnCdkDB8mancfeM6oZ1C9kY05W29qAx2y2oe7Jan+V5t0NZ8+XoR8gVjOw2JQ63TVCZTkD5Ys/P1Xac/3N/ZE8DXTI8jp61ZiB1nl3gmyW1Ir3L8LV+5S8cYX2y1zmE0wSSEOQQcDndlck9P0YSmMr2JSJsbojWyIcqd+mIFmCXj8pjKWIPgX8btIUVEBLNCuLm3qz/sb+7F4NvVIgy29bf5ApCH/SYE+zD8mrPfzfx+7QOg8dzX2gcYDLR2hVpRKtfZHPYHfEEa+Ksf750yBwWwj1dOSWOhNBgzW74YiXsEVI5JYrK2LQBVaxPOb8yLA5ex5Ld4xtIqKo61gK+ZR/cocZhMG9dsMX/gjFfGD9we91xGRdNTTWjVRv9gTDV/ASDLealcHtC2vrUBkFDcJb6/BKW3x/dBh   �nikz2yXC58dfvMuZxz9cPh9I1F5SBuNa1FxVOAIXx3pH2ccYULawgFlWIvFozKIisqw4FdfvpSiQzJ/pVLRPL2jKwGZpsew+GABJRbXhuKyqlgrWILl4mF1jJ6fkDX3hb01RR4SkXDMEjQWttizE9K9YyecNyIq8RjdzzhbqaztUTFMesRkJRaRlBFLSlZG8A2n866HnptjH5p5K7rVxbGeWqFbXRxXNm8ciV442EhElIVubViFvZqk19Ko+uqlpMTpEvr1PbuEXjpgl2jVYIn6wmA75ft91pQQ6dFJoC/gZ/abTuiHJ3Q/TDIioiI0v5aiL6LySITZqjpxaqzd6xNpc3XKka5OXqDBqRwatNfoVmNxeKRe8TU8bIxnSdfn+mkCL/KLcZXVt8/hCfTsRzz06yOHxVqSsMCzIBZrCLF0w+qCj7EzfXG9XPwPvRkmvXb2VJL/dBRusYB/uVzEGgQvY42NSAlhy808fkJUMW9cXDGqsEjv7rZJMCKwvbGzApuxtoenkKtbU6wdOlbV6Czb5SJdzNjJlou7zgJ9EclRSrMYiwu+mEwUk1zSD1PUAVIZRNpybZr4RhYZ4y8csjcmZM17q/Z19aRbP0mufkKiQvVzOm6cf6USmRNE1kgA+wsVCxx+M/JHVACTXoE+mdnD2PmhX+0yb2WRXpE2ePN3EVXDrrD3zXlegAIczwlK7K06T02mthfwVJsv5BOe+kIdwi/+tkDI96vg7+rs9oUGhGCgM9DX3ITXvl2u5sapg93OV39knOP0yEGNccmNbePTGeXFpPfoLdpzWcFXzZ2DcdOrYrLmqhIYO37N5YSxS/kJ6eVvl4Nkff3wk5H8yn0XNJXa4r5LhxqVRKH5DQrjIxJjXjcZdMLChMc12HHWL+zzBDW1TcLvMzWhn63ph5+NTxn6SlMTlbk7MmjLdkWHVRZBzs8g+nC2ZsbZrftEFDVpIEot6HPf6Lth0mZ+1tUVDrgNwWUAs0m9OGMUdrCq9OIJhIDqx1l6gdmkM    K3UfZcPou7mcud429g9N3JXJLvfOS774UpbbvLxfbtcHYlOB/odS6LLIci2Q2/8aH9vprvLhe7bnZFXkwF7GX7mLEdDgbQ//SjYd4Ew5PK5XCjNbfBr5E/79Nszcvi3u3MNInyWWdyyNIE5iuXXKDGLwqIkY7CXxIQcFbEchfW/bIH9+kCXj6wX9dsCQ3VaF0bpjKFC0aQU0WKqlsQx5ObKD2FvSmRvnWF7po0dl2c0RU1KAMXyDAon4nEhGZE8zog+dEaj3qm0nDPALDvSTQKgZUXVIqqUkE02bMxJWB6G1OsnNG8ssJY5EFjQq8lSBFOsYiETw5DG1iEfiZ7Zr/I5vD08ryq2xiXxAeDvfHv3qwO0TBdQkhVRkKMmTzI58Z7LM5JrV31FkM3yRcBlqydvEZApwVNc7ZTk8o642mn7oMlIk/SdRCyhCW0GEoseCwtCLDEfF2TVRs9rs9hT4p87Hkyg9TjwEw3Aw5BRuulNhc7R7475RqKmq4TGp8bDTmLgEHh97yhukJOfjkTL5GBYRmMLQnI6KUXFfnUzmENZtO5Kxdi9Iyvlzs4qY3YzNepcvaBOmzyRUFTIzSRegLQoAy0UEbVFzTukl6SyYbHvm1njpkqKlxBkUt2znRs+dpt52oh1E4Se3mS6AlQBHIxCrMNonQ3J4va+Xv/lhMgy3f01KkhzVtFOs9UQFIyvvjljOmGI8T3Ww6EX5hRzDRt6yBydZEqv37gU6LebRu2Gqw7TdKu1i9p8cbYcwIBS4ygPuvhOs7bo0DW3+K5jvTJMtiLysj1Ku6jXnZOMo6pe/8LoU6LACmUMKyoKKRLNGO2hFO7XT95/ICc5Zzrkzqlpk55qeFHCtijRtDzz1apAb8HHV2989g2YL4WwiFU0gVO0c8HxRpD4NmPzxXyAVI7Ykz3P+TXzhGLSPE7BAtsLBjCvICIrB51y475ZgL8AxrcmyazprUOSy3SWM/fN3h8E+xNfal822rVqO3th1D/B0/8BroPLrA==cX-Rj   �VCAc3wfguVzmVTuBLxvXfUbJm3BiCbHUARyAMZc+cucP9ZzW/TEMLIxo59fckJsUGsiEQDByNG98+YcGMYMthZqI4AVCt/ISCNWQsEPAfpGwvUaGwn2HWgst14BG9raMWsH1cVjnh20y4wdJNeNjUW2FEOkc04Nn5Me6WZMPxvnYPKnBWecVbXHG5CrdfgCLc2hVhyzbsadVTx1Akw5C3nqBE//xcInq3T4xeosQBYtv5Tj0jDpcpy54yi3qgsyrmHsnbswF5M1EjINvUZ+i80yEcnJMqEcoeaeXHflpUByJBC4ibQCZvMGADY2b2CB7Tmp4as7H1jbRiTHsHtAYpgYNrCwdTwheRJtpJJHWMN4HAIXxuN6ZKtFwUQ2qEr3vnH1bU2tcvXdC0G7jSTSTqFEojRJOc7Pqp9n+NmIPcXNRqBeG0WhhItYKZflELKmhSDK1Jn+dtOh3S7Eb5P6zjyTrp0h0isB2Npi24FR+OayzuJfvFM9kxgXX87DO3CbS/ryOYpVvObSs/52KF5ahXB/GJyXi2oTX1mMJqT3JCg29RFrMZeP2Oy6MrvHZte2BATDkQ777IvT7o7ctKsXJ6oxx8BcXm/kTlyvVJrivZLf1cv5eG/kNlmQRmQt6qJiISIy5YVeKFRm+O+LCw7MwH1la7lYRGvQwsNmXEl/gRtwLdyZ4lq4H+6HTKFee9BcYlteWUTWlMfgIQh1HRFQY21HZCeL9FmDAEj4rQuljfEP5QK1G2N8xswu0woIsAHhA8YLv/pbME5Uurmg7y1Rsc0EIimiKn6njc9Ghs0MrofqtTUQg1UhNWhrwOIjitVG4ZfLcDL26wScjDFSEPZEQXMpy/Kby66gGRS9UVMvzbNBgpCOlgiuBsFbW3w2sBbyri1m064tZCXm3qJS4qdwlct7bgrXKWNoapDvz0ybHyBrZyq56RMy4jWwgKJIUaETLEUdJeBlnCdcDozJGijS2JQWHX2DU7Ew4672eRuKbz2Bfm50Kxfmq0eXbBu+e    vSB38WPEvislJJOvgY+gs4wmUaPmL92EjfwEXQGa5xZRHVSOLBKlzFh0v0hBwzToz/UjLy79fRgzPE13FlxZtnuizmewbM+BTJj4U/5TZ0PCYh+JSpvXQEWNyc9rUhOtASd9thXw9GGHyityMMNkU1QVbX2A/zXRyLcQ2vcgXJ4GnSgWizMszcKNzcF+oT+UKAr5HyfY/OB0gG3yEIps7fMOjg11lNQOBq5kr5YbHBKUn4dZCh/cqzBiYnCotKwHBf6FfS11T4DqHMwgv4QfFpcVdSXqhYTwtII8DitpcWH2nY2T6O2ndVadh3Er6qvpKgYl19LMeb7QeO9HJ4Ge7UHgoGQ0B3u+j0Q8je7FeVYA0blBy5mAfMDm6HHizWC5uodQhDqBHdJRDpRFmwfYzBFirUxY3fHnOd0wT1TrAd0oyAnQ7VbP9oSdyyt4fPU+1ZAGBp/K+ixPoqJdeFOz2bBkx9QZjaLEoKG71vPZOy4ij52M2k1iRvLc+XbbU+KTeIGnnI+xYArtwdo2Ojqbg77+gK/NzMxvrjyYOe6upV7sHM9oCmoc/2AD+DO5NQuSta4d8G9SouBeyOkDtfnh+rkiqvcn+LWtoMoL6K1Ks4ZH+jWE54Gd3aSo+6o+lpWhqQHrk9a8ZBkQy3Cy5JRwm1NsaZv+U+vhtNuktDykg378z2nxLE/4tciy8Of8rFbcdfFDlUnqbddqf7KGEz4J7aAhbuyFdgtG2BXlodc2ejGDPqcxl05vwJT3JU7+kMoH2oAsuXbLRCu7hfRNzHuLxUww5cZYKjzewVNGZYe/OXE/+FnEOSnJdzMw5qqszD5WFb/sfXD7+XSKv+xD7/rYwnuwlAPD4mNzQN3e0pT6AM3d3Xc/ylNAgN3jwFpdFT9txAGB4w22ujmi356CWU4J2++uWCneB3cQeKWTrlurWYUMvwzWwvCLPfA/Nyzi2wCsWYEt0AeP34i6BObZrr08+azuZ82vtzok9Pluy09NWmOTcL8fwFaG5JbcXs4   �://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)    �://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)    � �                                                                                                                                                                                                                                                                                                                                                                                                                                                                          �)O %�	laozhang默认页面eNq1VMtOwkAUXbdf0R9oUiHd+G1dEBKeWiuxBBEM1gCy0EIib1B+prd0VvyCo8g4vdMXC2dzbyanp/dxzqiK4ttjb3MP4zmUBqTSUBVSLwTONb32rSlUW4EzOmyrUOgF7gRM57CtybIhkbs5BUmGBGZz/2ofE781+E26VcmQjUs1dBR60N3PFaXzlm/Q+WCkFxo9XPRbT6R9S54fv1klKHe95UMsOK95y8oRuBhAsxwNPCYnpLfuk0I8ZY4xbtaB+yngdIEQVu/g1hhQFxtBTdEJeDtH+ECPnkCpBv2XjGB/NgSrwcB5jc0pGn7V4YeWUshqJ3BzMQwmRReKoxDzX0BFTBp7u5d5GtMkPSCweQN9K8ys8QleS92fLWILOS1cVrMaiS55b4/+zUhJkuekL7ood5I6H7Uo0YszYEhkY9olnSOsh/F5vFWid42MiqvWWSlIxvlUAyKbcI9EFjHHF4LUqSfTnmUopOVceo9hW2XczzmPDXrGsvxB/gL79OBdcX���    �：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<�                     code        �                �               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   �://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)       �                    �T [�-laozhang微信支付入金限制（借记卡）eNrVVkty2kAQXcMpdAEKYxebXIR9NrkECwwBgwHL   ,�pS [�elaozhang微信支付入金限制（借记卡）eNqNVUmS2kAQPKNX6AOEYAgu/gh3X/wJDixmhxEYhn0ZOQRmImbEIhiE2D6jaqlPfMHNZjQETVkHqaM7o6oyK1UtiqIoeEURtpq1U0hlZK3qkOjTVMkr0mzEUfJsj8gzSNccZbhfpyHSc7QxFJT9OiOwJ3xCQbFgDyfs/Md3dhB2Gk2S68FLEspRy1RJvcyOyEi23ysS+4D6dkCB1rUzbxhKCH/zfnlYyeLN3nFLCHtg0WfhaPmTleQJewI+n086vNjaH5KCIc8RtDIdbcsD+c+gZNsymgjIMj6gtcEiJTKg/rkLegpJT2fQcgdy6S4oEJICJxDJtXjsriAmJI3cLzz4TwIa0yA2vA86rIPH9Ykh8wUSjYxLdqWHMUzMHgh6ac1SBy2DpZsPeFpdQVB4BlVGWkNTBTCvgvrdoKMM51j5BE/3Kz/LyJL5Aiu98wGL7n/ozsonnwNeyks0Q+WmvIlWo3WddEr0JYXRWHbIBOslSRdpfIOAqGLCdsH+I6bd407V7KmKWX8xgbbOC+ZyWTkN4wpZDTEGk56TkzHLGoad7OFJnf6O51qXHJsinUYx0LbBU98lmBYl+m+s9kLNMt8xFfQxbSYRl9HOL5i2MGM3cmxU8K144fczxtoDapNUR0hEy2g7z12EgDObM2NjLCsR0u042QlrI28EuZhUx3Y1eRj/O+XBMBvz/uPbiYDbxx7I7Eo6ZcRan//SVT/TVjq+SO3VNdkEdqVDrOEMV/t1k93b5HUN8YS1bYEcdyLx/ToPowFttk73PVXYFBxYq76tr+z5xE5PiVkVhL/mWUW1cX���   i i                                                                                                                                                                                                                                                                                                                                                               �R C�E	laozhang支付寶支付入金限制eNq1VElygkAUXcMpuIBVRItNzsbC0jjGseIQh5SSEuMiDomzEL1M/4ZeeYW0IRJoQHGR3vxf7fPxh/c6Igi4NkXaM0xXkFJJphoRSD5uKgV6jcsLyDZNZXTUsxDvmZMZFJWjnuN5mSNPKwriZA6KdeO9ZiW4qf4m3Swn8/J9xHUEepi7nytKhzZj6HzZpHciPY6Im33SqpDXlxMrB+ku2rQDwTERbTIWcK1CPe0PtJIzEu0GJB5MGbUZtZ052XtwkocQtnOY5Gyg5G2EaYpOAB0Uzx8k/wmkcjB4CwnGyyGUqzY4Jtpz8oc/dpxDu1LI9uDhdkQ3mCQmkBi5mP8CU8SsatR6oaexuKQHBlwswaDsZhadCbuWPF6uAws5L5yPhDUSXbJRG/2bkS5J3iF9r4uiZ6k7o+gneu8MbCRjY9olnSPshsF5sFX8d80Yla1askthZBy7akDGJo5HIoyYgwth1Cldpr3JUIyWo9d7dNsq5H5ueWyYZyzMF6h3INEyR9pRb1OP4L4OyRTad6CcNOPJo16A1AppDag8QK8EmwRdK1bHlrlOv06HpN2xzEeUIuVEmmrMNWP5YWQ/8a7B89/NWiNacX���   |://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     f9uK4j660u9o01t50wrXJL8Xu+o4ocrY6TJx/fdSm0kNh0YTCzyrgQnWgm19aP7vZ3pLxX7b7dHXk0GrGH4mTMcDQUy/syj4MAFwpAr50qhDDPBjpE/41Mbp+Tgb3/7CkT4jLC0YWiCcBSLr1FyBoV5QcQQL/JJMcZjMQbjf/ni4H+gkdWS2ijatF7nXCuf2rRQLCVElLispHAcudHiA+TrMtldtclmaJHHxagiySkBuFiMonAykeBSEeGOZWIPLNNq9qodZxkIK84L6BCgi5KsRGQhKep4mJgVsHgPVW0e0x7aRTbCoSKDakUUIpiSJYOavIeqbRywJTHDQa3PoQyAkCVL6SJ/P/P3Vnfnq8M0QhdTECWeE2M6UtBRCTPlVdXc5cC2yOfZbcE0zxS5ANQ054IZ+uonpLDl6KufdPfbNmmSvhmPBTShRKHP6DE3z8WTcwlOlC30nDKDvVT+uWHZBCzJsJ8owPaixuikJxhMpd4csR6joWtTjU+Nh50mwTpQhLsqQHJr5Pino9IIGRgW0dg8l5pOCTF+UGAUMyiD1l+uajs3ZLnS216xmf1snSZXzmnSIk8kJRk6NInnoTnSkK8ivLKgeBb2glTXDPxtO69d10jpAkpNartWcs1n36YvOGLcBA2gN+mpABUBa6OQbTu657zb+f4DOS44m65wRkPrdZ4qeEHAFojXIy/Q5p7a/OVU3Ajd7h3lhFnDDNP2yJsGB+XAcaYn4bhkHWwS0Qv9vHSdaXSdWXpmSqabmaaqjXWtfs3sNz10C7bMotfRHg5hQKl2uAW6WAcbU/R416dYN9se9JIt8azsof2tNkpq01lJO6ypzS82fYrn7K03hiUZhSS9b9SYaTyon3Sq4DP4jVZbn31D4UsuzGMZTeA0NTIk3nACaznzj545+iOkemg/a2bOruxMKC7M4TQMsDVgEMYVRGR5v1dp3baL8LmgfWuTbE7tHJBCtreUvW2bHxPW50C5e9Hq1mvd/LnW/ARP/wd1qOYOcX1e�    /ffbQVRf32pd7Sp7ZxphUuS3+sdVfxwZcw0+fi+W6mNxKYDzsQi70pwopVQWz+639uZ/lKx/3Z75NVkwBqGn9nD0VAg4888CjouEIZcOVcKZZgJdoz8GZ/aOCUHf/vbVyDCZ4alDVMThKNYfI2SMyjMCyKGeJFPijEeizEY/8sXnb9AI6sltVGktF7nXCufUloolhIiSlxWUjiO3GjxAfJ1meyuUvIgtMjjYlSR5JQAXCxGUTiZSHCpiHDHMrEHlmk1e9WOvQyEFfsFDAjQRUlWIrKQFA08TMwKWLyHqjaP9R7SIpvhUJFBtSIKEayTJZOavIeqbRywJRmETq3PoQyAkCVL6SJ/P/P3Vnfnq800QxdTECWeE2MGUjBQiUHKq6q5S8e2yOfZbcE0byByAahpzgUz9dVPSGHL1lc/6e63KWlSfzMeC2hCiUKf0WNunosn5xKcKFvoOWUGe6n8c8OyCViSYT9RgO1FjemTnmAwlXpzxHpMD12banxqPGw3CdaBItxVAZJbI8c/bZVmyMCwiMbmudR0SojxToFRzKBMWn+5qu3ckOVKb3uFMvvZup5cOdeTFnkiKcnQoUk8D82RhnwV4ZUFxbOwF6S6ZuJv23ntukZKF1BqUtu1kms+epux4Ih5EzRAv8lIBXQRsDYKUdvpe867ne8/kOOCvekKZ3povc5TBS8I2ALxRuQF2txTm7/sipuh272jnDBrmmGajrxpcFA6jjMjCccl6+ABEb0wzkvXmaavM6ufmdLAzUxT1ca6Vr9m9psRugVbZjHqSIdDGFCqHW6BLtbB5pR+vBtTrJupB71kSzwre2h/q42S2rRX0g5ravMLpU/xHN16Y1iSUUgy+qYbM42d+kmnCj6D/2i19dk3FL7kwjyW0QRO60aGxBtOYC1HTxzjAVI9pE8OMmdXNBOKC3M4DQNsDSjAvIKILO/3Kq3bdhE+FbRvbZLNqZ0DUsj2lrK37cGHhPUpUO5etLr1Wjd/rjU/wdP/AbPv5eo=cX1e�   �码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    �

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   \----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in   � �                                                                                                                                                                                                                                                                                                                                                                                                                          �Y9 M�Elaozhang入金- 銀行單筆限額列表eNqlVM1ugkAQPstT7ANIgxoP9Nb21quX+i4cbFGLf1HjX9SallRaDtVWG2sLRF+GWeDEK3TRRpAIJboJycws8+2338wsQghRNEJQkKz7Jo2scs4Uq9CdGpOi1W9YYg2EninKFMXF/vYaNUOexYibG1i3LVsTshlbK3kDV9e+QCZ74//l8mITobhzmizCAm0tr4M48tGcGyVxwkP/nsBDZcuGYKaZOMMwZwyDiJPy2HsbXmeHYa7mWJrskBKMNyPMO4gGSwk6xUhogRCqYsouofSRdJSxI/RhIqkIahEMXBkGXyYII3noTvijabQfTxfZFARvsZLxhHuux953NyzKeLHEixc8mhl9DWadSFxCtAH1+T+siCoThfS1eGTLQKEE49eA5JAms/gFbq8hPzdb+Qj0Q4sCP58wLZ0mAlR7uvLmYrBxlmWPGUKnzs5Ij5qkdYMHO+WXyWmu+juM67sE3+yl9zKo7aIR3PVNWbW1AXkg8ZMGfEFfDaHOmzne1txHFIQvXZW22IYwx0qXZP8Cw3vaqA==cX<�    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<%   �               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   �员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   �码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    �

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   �----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in    �  �                                                                                                                                                                                       � > !#�{ertgtd4fv4data-副本    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----               �    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<'   �               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   �员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   �码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    �

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   �----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in    �  �                                                                                                                                                                                       � ? !#�{ertgtd4fv4data-副本    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----               �    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<(   �               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   �员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   �码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    �

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   �----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in    5ru2f31f7unm0UIIX8QIZotdT8Ugqi7Mt85WNM2T7T8Oc1tdw7KfrjSppt+Wm+Xq0P8eKDXMSd4HByxHWrjR/t7M92dL3bfbwyNRQL2MvzcWUbG3rju4VAg7U8/CvZcIBJ5fB4XSjMb7Br50z716pju/u1uXIAgn2nurZr6wBzG5C1KTqCwIBIM9pyQJLyACQ/rf7liv//ApEt76lXRYXZap1rp2GGG+JQYVeKyksJx5A1AHsS/LNGtJYdvmTZ/hMQUSU6JQMckhsLJRIJLRcU+wfgHBWvUO5WWGwzMsvsyBgpiEElWorKYJEYQ2JgUMRnIVuuHem2d5JvmreTDGyhEjGKdL5ns5EC2trrLJskye3W/gMQASJZs1XPCQ8i/C+3Nry7ZND1kkUgCR3gDLBrAhOW6P9vZ856jk8uxR4cprSV4BtiznAfGaq0d0XzB1Vo7au80HV5Ef1cBi2hUicFZQI+5aS6enEpwRLYDTCkT+H7Ff67ZCBSamonwVIEId7F5fXMAHhpSvT5g+1M3Pcdv5NVI2C0hRIO03J0Tml2mhz9dxabJIDFBT6a51HhK5IVesTHMAhlmd6GibV7ThXJnY9EhdzM13bl4qjtt/mhSkqF+ETwNpZNu9WRUUGaUAQk/o5VlM8hNM6ddVuneGZSAVrds57LPuc0IO2TeBIXRbzJcAV0KKEAhp2X10zmo2Osf6WHePZ75E920X+2ZgmdEbOMEw+qLM1lr22r9l1sG0/Q2/zAnTpr9M+6s7tFnQGD+9sxHwwlTmB0AFhe9NMawZ0jq0Sb1USxZw4D5M87kila7ZM6kYXqV281lZNZZ9iOBXm2/AOrY1je39N8OY4sdA07b3iVeEljxnjYwE9WqQB/Bb7na+OK7Zb7mwgKW0Sie1dsVHO84kW0pBmQ+Qyv7zsOW5+TC8YTi4hSehQW2FyzDuoKILux0yo2bZhG+LLRvTZrJqq1dms905jM3Teu7w/5yKLXPGu1atZ071eqf4en//+D2kQ==cX<C    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<*   �               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   �员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   �码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    �

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   �----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in    �  �                                                                                                                                                                                       � A !#�{ertgtd4fv4data-副本    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----               �    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<2   �               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   �员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   �码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    �

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---    	光大银行	|	光大銀行	|	Chian Everbright Bank	|	guangda	|	√	|		|		|
|	邮政储蓄银行	|	郵政儲蓄銀行	|	Postal Savings Bank of China	|	chuxu	|	√	|	√	|	√	|
|	平安银行（深圳发展银行）	|	平安銀行(深圳發展銀行)	|	Ping An Bank	|	shenfa	|	√	|	√	|	√	|
|	华夏银行	|	華夏銀行	|	Huaxia Bank	|	huaxia	|	√	|	√	|	√	|
|	北京银行	|	北京銀行	|	Bank of Beijing	|	beijing	|	√	|	√	|	√	|
|	北京农商银行	|	北京農商銀行	|	Beijing Rural Commercial Bank	|	bjnongshang	|		|		|		|
|	上海银行	|	上海銀行	|	Bank of Shanghai	|	shanghai	|		|		|		|
|	上海农村商业银行	|	上海農村商業銀行	|	Shanghai Rural Commercial Bank	|	shnongshang	|	√	|	√	|		|
|	东亚银行	|	東亞銀行	|	The Bank of East Asia	|	dongya	|		|		|		|
|	微信支付	|	微信支付	|	WeChat Payment	|	weixin	|	√	|		|		|
|	支付宝支付	|	支付寶支付	|	Alipay	|	alipay	|		|		|		|		|






- 備註：表格僅供參考，支援銀行以系統爲準


cX1e�   �√	|
|	交通银行	|	交通銀行	|	Bank of Communications	|	jiaohang	|	√	|	√	|	√	|	√	|
|	招商银行	|	招商銀行	|	China Merchants Bank	|	zhaohang	|	√	|	√	|	√	|	√	|
|	民生银行	|	民生銀行	|	China Minsheng Banking	|	minsheng	|	√	|	√	|	√	|	√	|
|	兴业银行	|	興業銀行	|	Industrial Bank	|	xingye	|	√	|	√	|	√	|	√	|
|	浦发银行	|	浦發銀行	|	Shanghai Pudong Development Bank	|	pufa	|	√	|	√	|	√	|	√	|
|	广发银行	|	廣發銀行	|	Guangdong Development Bank	|	guangfa	|	√	|	√	|	√	|	√	|
|	中信银行	|	中信銀行	|	China CITIC Bank	|	zhongxin	|	√	|	√	|	√	|	√	|
|	光大银行	|	光大銀行	|	Chian Everbright Bank	|	guangda	|	√	|	√	|	√	|	√	|
|	邮政储蓄银行	|	郵政儲蓄銀行	|	Postal Savings Bank of China	|	chuxu	|	√	|	√	|	√	|	√	|
|	平安银行（深圳发展银行）	|	平安銀行(深圳發展銀行)	|	Ping An Bank	|	shenfa	|	√	|	√	|	√	|	√	|
|	华夏银行	|	華夏銀行	|	Huaxia Bank	|	huaxia	|		|    	√	|	√	|	√	|
|	北京银行	|	北京銀行	|	Bank of Beijing	|	beijing	|	√	|	√	|	√	|	√	|
|	北京农商银行	|	北京農商銀行	|	Beijing Rural Commercial Bank	|	bjnongshang	|		|		|	√	|	√	|
|	上海银行	|	上海銀行	|	Bank of Shanghai	|	shanghai	|		|	√	|		|	√	|
|	上海农村商业银行	|	上海農村商業銀行	|	Shanghai Rural Commercial Bank	|	shnongshang	|	√	|		|		|	√	|
|	杭州银行	|	杭州銀行	|	Bank of Hangzhou	|	hangzhou	|		|		|	√	|		|
|	南京银行	|	南京銀行	|	Bank of Nanjing	|	nanjing	|	√	|	√	|	√	|		|
|	天津银行	|	天津銀行	|	Bank of Tianjin	|	tianjin	|		|	√	|		|		|
|	东亚银行	|	東亞銀行	|	Bank of East Asia	|	dongya	|	√	|		|		|		|
|	宁波银行	|	寧波銀行	|	Bank of Ningbo	|	ningbo	|	√	|	√	|	√	|		|
|	微信支付	|	微信支付	|	WeChat Payment	|	weixin	|		|		|	√	|	√	|
|	支付宝支付	|	支付寶支付	|	Alipay	|	alipay	|		|		|		|	√	|






- 備註：表格僅供參考，支援銀行以系統爲準


cXpy   �               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   �员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   �码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    �

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   �----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in    �  �                                                                                                                                                                                       � C !#�{ertgtd4fv4data-副本    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----               �    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<5   �               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理   �员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代   �码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


    
**简要描述：**    �

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:---   �----    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |int(11)     |否   | 0  |   注册时间  |

- 备注：无



    
-  用户表，储存用户信息

|字段|类型|空|默认|注释|
|:----    |:-------    |:--- |-- -|------      |
|uid	  |int(10)     |否	|	 |	           |
|username |varchar(20) |否	|    |	 用户名	|
|password |varchar(50) |否   |    |	 密码		 |
|name     |varchar(15) |是   |    |    昵称     |
|reg_time |in    d N� d                                                                                      �53 M�}laozhang入金- 銀行單筆限額列表eNqVVM1OwkAQPtOn2Aegpmg41Jt68+rJd+kBLWARCBD+AojaSLUHQYtBtG3gZTrb7amv4FYIXYRK2WSTmW/nm29ndlqEEOJ4hCCneTc1Hnm3GaKWoDVyh3mvU/XUMihtouocJyWWZ9WyqxsJ6ma63lXdt5XLC98usMDZ+V/g9OQX4aRjni6qiRYW6yCJbl4KUYpTVedrCHfFhTbNmRaSgiAcCAKizhFjJ8JgMhtjbbiipASWs+4xLJhq0MzvzbJMooda6R0ccxA0ZbvGRjW42Iu+UUTt+L3mNh7iV0EUhe3VYTK1OmftpcItnkzx5Bn3Dbdjg9GMrwPW0y7WtoqcubqHRq4Ag5eI+PU2efIEN+aQHZN6Nu514PsDRoXY0aW2Y76G0WJSFMX/pinobTC5/Rp99Oj53ZySvuGY96toplRSeYNBZetsptezBItHcN0huuXbXfrB40cb5Jwz60FFJhnZt8OfAiifjqUt0rrKGJstyv4Bc6qjsA==cX-R��'2 A�mlaozhang入金- 銀行支援列表eNqFlt1S2kAUx6/hKfZSLniB3iF1WjvTGac60+nlCpHEQnBIYsXhwopY/Gipo9aK2NZWLBcVi4pSoPgunWyAK1+hZ/O5BKMZx9lzNvntP+fsfwlCCPmDCJFcu   ��'1 A�mlaozhang入金- 銀行支援列表eNqFlt1S2kAUx6/hKfZSLniB3iF1WjvTGac60+nlCjGJheCQxIrDhRWx+NFSR60Vsa2tWC4qFhWlQPFdOtkAV75CT743wWjGcfacTX77zzn7X4IQQsEwQiRfG   �    t(11)     |否   | 0  |   注册时间  |

- 备注：无


    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述


cW<7   �               |
|groupid |int   |用户组id，1：超级管理员；2：普通用户  |

 **备注** 

- 更多返回错误代码请看首页的错误代码描述



    
**简要描述：** 

- 用户注册接口

**请求URL：** 
- ` http://xx.com/api/user/register `
  
**请求方式：**
- POST 

**参数：** 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|username |是  |string |用户名   |
|password |是  |string | 密码    |
|name     |否  |string | 昵称    |

 **返回示例**

``` 
  {
    &quot;error_code&quot;: 0,
    &quot;data&quot;: {
      &quot;uid&quot;: &quot;1&quot;,
      &quot;username&quot;: &quot;12154545&quot;,
      &quot;name&quot;: &quot;吴系挂&quot;,
      &quot;groupid&quot;: 2 ,
      &quot;reg_time&quot;: &quot;1436864169&quot;,
      &quot;last_login_time&quot;: &quot;0&quot;,
    }
  }
```

 **返回参数说明** 

|参数名|类型|说明|
|:-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理    	√	|	√	|	√	|
|	北京银行	|	北京銀行	|	Bank of Beijing	|	beijing	|	√	|	√	|	√	|	√	|
|	北京农商银行	|	北京農商銀行	|	Beijing Rural Commercial Bank	|	bjnongshang	|		|		|	√	|	√	|
|	上海银行	|	上海銀行	|	Bank of Shanghai	|	shanghai	|		|	√	|		|	√	|
|	上海农村商业银行	|	上海農村商業銀行	|	Shanghai Rural Commercial Bank	|	shnongshang	|	√	|		|		|	√	|
|	杭州银行	|	杭州銀行	|	Bank of Hangzhou	|	hangzhou	|		|		|	√	|		|
|	南京银行	|	南京銀行	|	Bank of Nanjing	|	nanjing	|	√	|	√	|	√	|		|
|	天津银行	|	天津銀行	|	Bank of Tianjin	|	tianjin	|		|	√	|		|		|
|	东亚银行	|	東亞銀行	|	Bank of East Asia	|	dongya	|	√	|		|		|		|
|	宁波银行	|	寧波銀行	|	Bank of Ningbo	|	ningbo	|	√	|	√	|	√	|		|
|	微信支付	|	微信支付	|	WeChat Payment	|	weixin	|		|		|	√	|	√	|
|	支付宝支付	|	支付寶支付	|	Alipay	|	alipay	|		|		|		|	√	|






- 備註：表格僅供參考，支援銀行以系統爲準


cXpyW   �√	|
|	交通银行	|	交通銀行	|	Bank of Communications	|	jiaohang	|	√	|	√	|	√	|	√	|
|	招商银行	|	招商銀行	|	China Merchants Bank	|	zhaohang	|	√	|	√	|	√	|	√	|
|	民生银行	|	民生銀行	|	China Minsheng Banking	|	minsheng	|	√	|	√	|	√	|	√	|
|	兴业银行	|	興業銀行	|	Industrial Bank	|	xingye	|	√	|	√	|	√	|	√	|
|	浦发银行	|	浦發銀行	|	Shanghai Pudong Development Bank	|	pufa	|	√	|	√	|	√	|	√	|
|	广发银行	|	廣發銀行	|	Guangdong Development Bank	|	guangfa	|	√	|	√	|	√	|	√	|
|	中信银行	|	中信銀行	|	China CITIC Bank	|	zhongxin	|	√	|	√	|	√	|	√	|
|	光大银行	|	光大銀行	|	Chian Everbright Bank	|	guangda	|	√	|	√	|	√	|	√	|
|	邮政储蓄银行	|	郵政儲蓄銀行	|	Postal Savings Bank of China	|	chuxu	|	√	|	√	|	√	|	√	|
|	平安银行（深圳发展银行）	|	平安銀行(深圳發展銀行)	|	Ping An Bank	|	shenfa	|	√	|	√	|	√	|	√	|
|	华夏银行	|	華夏銀行	|	Huaxia Bank	|	huaxia	|		|                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   �天）|
|:--------------    |:-------------    |
|	工商银行	|	3000/3000	|	1W/5W	|
|	建设银行	|	3000/3000	|	1W/1W	|
|	农业银行	|	3000/3000	|	1W/1W	|
|	中国银行	|	3000/3000	|	1W/1W	|
|	光大银行	|	3000/3000	|	2W/2W	|
|	广发银行	|	3000/3000	|	3W/3W	|
|	招商银行	|	3000/3000	|	3W/3W	|
|	交通银行	|	3000/3000	|	5W/5W	|
|	邮储银行	|	3000/3000	|	5000/5000	|
|	中信银行	|	3000/3000	|	5W/5W	|
|	民生银行	|	3000/3000	|	2W/2W	|
|	兴业银行	|	3000/3000	|	1W/5W	|
|	平安银行	|	3000/3000	|	5W/5W	|
|	浦发银行	|	3000/3000	|	5W/5W	|
|	华夏银行	|	3000/3000	|	1W/1W	|
|	重庆银行	|	1000/3000	|	1000/5W	|
|	包商银行	|	3000/3000	|	2W/2W	|
|	上海银行	|	3000/3000	|	5W/5W	|
|	杭州银行	|	3000/3000	|	5000/5000	|
|	华润银行	|	3000/3000	|	2W/5W	|
|	渤海银行	|	3000/3000	|	5000/5000	|
|	南阳村镇银行	|	3000/3000	|	2W/2W	|
|	九江银行	|	3000/3000	|	2W/2W	|
|	成都银行	|	3000/3000	|	2W/2W	|
|	顺德农商行	|	3000/3000	|	5W/5W	|
|	南粤银行	|	3000/3   �000	|	3W/3W	|
|	深圳农商行	|	3000/3000	|	2W/2W	|
|	哈尔滨银行	|	3000/3000	|	2W/2W	|
|	江苏银行	|	3000/3000	|	2W/2W	|
|	常熟农商行	|	3000/3000	|	2W/2W	|
|	西安银行	|	3000/3000	|	2W/2W	|
|	齐鲁银行	|	3000/3000	|	2W/2W	|
|	龙江银行	|	3000/3000	|	5W/5W	|
|	宁波银行	|	3000/3000	|	2W/2W	|
|	南京银行	|	3000/3000	|	2W/2W	|
|	泰隆银行	|	3000/3000	|	2W/5W	|
|	青岛银行	|	3000/3000	|	5W/5W	|
|	晋中银行	|	3000/3000	|	5000/2W	|
|	鄂尔多斯银行	|	3000/3000	|	5W/5W	|
|	东莞银行	|	3000/3000	|	2W/2W	|
|	贵阳银行	|	3000/3000	|	2W/2W	|
|	攀枝花商业银行	|	3000/3000	|	5W/5W	|
|	新疆农信	|	3000/3000	|	2W/2W	|
|	兰州银行	|	3000/3000	|	2W/2W	|
|	上海农商行	|	3000/3000	|	2W/2W	|
|	福建农信银行	|	3000/3000	|	5W/5W	|
|	北京银行	|	1500/1500/无	|	1W/1W	|

-  微信支付入金- 銀行支援列表（信用卡）

|銀行名稱（gb）|虚拟商品交易（單笔/單天）|实物商品交易（單笔/單天）|
|:--------------    |:----------    ---    |
|	工商银行	|	3000/3000	|	5000/5W	|
|	招商银行	|	3000/3000	|	3W/3W	|
|	农业银行	|	3000/3000	|	5000/5000	|
|	建设银行	|	3000/3000	|	1W/1W	|
|	中国银行	|	3000/3000	|	5W/5W	|
|	广发银行	|	3000/3000	|	1W/1W	|
|	光大银行	|	3000/3000	|	2W/2W	|
|	平安银行	|	3000/3000	|	3W/3W	|
|	深发展银行	|	3000/3000	|	3W/3W	|
|	兴业银行	|	3000/3000	|	1W/1W	|
|	中信银行	|	3000/3000	|	5W/5W	|
|	民生银行	|	3000/3000	|	2W/2W	|
|	浦发银行	|	3000/3000	|	2W/2W	|
|	宁波银行	|	3000/3000	|	3000/3000	|
|	包商银行	|	3000/3000	|	5W/5W	|
|	上海银行	|	3000/3000	|	2W/卡额度（最高5W）	|
|	杭州银行	|	3000/3000	|	5000/5000	|
|	广州银行	|	3000/3000	|	5W/5W	|
|	南粤银行	|	3000/3000	|	3W/3W	|
|	江苏银行	|	3000/3000	|	2W/2W	|
|	鄂尔多斯银行	|	3000/3000	|	5W/5W	|
|	东莞银行	|	3000/3000	|	2W/2W	|
|	上海农商行	|	3000/3000	|	2W/2W	|
|	华夏银行	|	3000/3000	|	1W/1W	|




- 備註：表格僅供參考，實際支付額度以系統爲準

cX���                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    bzbCqPB+lL/aFPdOVOLl6Sw1z+qBuHKGmny8X2vWh9hp0PuxCLnSTCClVDaP3rfO9nBUmnwdnvk1WTIGkafOcPRSCgbzD4Kuy4Qhjw5TwplqQl6jILZgNI8JQd/B9tXICJghOUNQxOEo1h4jVIzKMrxAoZ4kUsJLIcFFsb/CiX3f6CR1bLSLNm0fvdcrZzatAib5mNyQpLTOIG8aOEB8nWF7K7aZDO0yONCXBalNA9cLMRRNJVMMukYf8cy7APLtFv9WtdZBsKq8wI6BOiCKMkxiU8JOh4mZnks3ENVWsdaD+0iG+FQkUG1LPAxrJFFg5q6h6puHNAlMUO31udQBkBIoqV0kbuf+Xurt/PVYRqhh8kLIscIrI7kdVTSTPlVNX/p2haFAr0tqOaZIheAmmE8MENf44QUtxx9jZPefscmTWpvxmEeTchx6DN6zMwzidRckhEkCz0nz2A/lX9uaDYBS1LsJzKw/aisNukLBlMpN0e0x7TQs6nGp8ajTpNgHSjCXRUg+TVy/NNRaYQUDAtobJ5JT6d5lnMLjGMKZdAGyzV154YsV/vbKzZzkGtoyZVzLWmRJ1KiBB2axPPQHHHIVzFOXpB9C3tBamsG/rZTUK/rpHwBpSb1XSu5FrBv0xccMW6CBmg36amQJgLWRhHbdtqe82/n+w/kuOhsuuKZFlqv81TGCzy2QJwe+YE295TWL6fiRuh17yjDzxpmmLZH/jQ4KF3HmZ6E45J2sElEL/Tz0nOmaevMamemaLqZaqrSXFcb19R+00OvYMsseh3t4RAGlKqHW6CLdrAxpR3v+hTtZtuDfrJFjpY9tL+VZllpOSuph3Wl9cWmT3GMvfXGsCihiKj3TTNmBrv1k24NfAa/0Ur7c2AofMlEOSyhCZzRjAyJNwxPW84+cfQHSO3QftLMnF3ZmUiCn8MZGGBr4PwFjSuMyPJ+v9q+7ZTgY0H91iG5vNI9IMVcfyl32zE/JayPgUrvot1r1HuFc7X1CZ7+DzG65fw=cX1e�    lbqvssHUXdzuXO8beyeG7krkt3vHJf9cKUtN/n4vl2ujkSnA72OJdHjEGTHoTd+tL83093lQvftzsiryYCzDD9zl6OhQNqffhTsuUAY8vg8LpTmNvg18qd9+u0ZOfzb3bkGET7LLG5ZmsAcxfJrlJhFYVGSMdhLYkKOiliOwvpftsB+faDLR9aL+m2BoTqtC6N0xlChaFKKaDFVS+IY8nLlh7A3JbK3zrC26WDH5RlNUZMSQLE8g8KJeFxIRqQBZ0QfOqNR71Ra7hlgll3pJgHQsqJqEVVKyCYbNuYkLA9D6vUTmjcWWMvsCyzo1WQpgilWsZCJYUhj65CPhG32qnwObw/Pq4qjcUl8APg739796gIt0wOUZEUU5KjJk0xO3HYNjOTaVU8RZLN8EXDZsuUtAjIlDBRXOyW5vCuudto+aDLSJH0nEUtoQpuBxKLHwoIQS8zHBVl10PPaLB4o8c8dDybQehz4iQbgYcgo3RxMhc7R7475RqKmp4TGp8bDbmLgEHj9wVHcICc/XYmWycGwjMYWhOR0UoqKvepmMIeyaN2VirF7R1bKnZ1VxuxmatS5ekGdDnkioaiQm0m8AGlR+looImqL2uCQXpLKhsW+b2aNmyopXkKQSXXPcW742G3maSPWTRB6epPpClAFcDAKsQ6jdTYki9v7ev2XGyLL9PbXqCDNWUU7zVZDUDC+euaM6YQhxveYjUMvzCnmGTb0kDk6yRS737gU6LebRu2Gqw7T9Kp1itp8cbbsw4BS4ygPuvhOs7bo0DW3+K5jvTJMtiLysgeUdlGvuycZR1W9/oXRp0SBFcoYVlQUUiSaMdpDKdyrn7z/QE5y7nTInVPTIT3V8KKEHVGiaXn1UEirAq0F31698dnXZ74UwiJW0QRO0cYFxxtB4ruMjRfzAVI5Yk/anvNr5gnFpHmcggV2FgxAryAiKwedcuO+WYA/AMa3Jsms6a1Dkst0ljP3TfvvgfOBL7UvG+1atZ29MOqf4On/RQrLJg==cX-R:    H  H                                                              �5E %�%laozhang默认页面eNrVVcmO2kAQPTNfwZEoQnJAZCD3OURc5sIhH5CPiOSDyYRtgsegQFgGhmWYASXBEA2Lg1mk/Ep6sU/8QspuQ2x2KbmkZbnLTVX3e6+rijMeS+9Jvo8zIo8XMV1I8fS7iu8+8lpvQIo3/Bn/ygvDDcO02KfXzXutZfBw6Z9GWiPtWhlYbNC2CPvAChbz9FtOL2X0ZtWDY1fPYI30JFJ4sK39rBuxFUF7jBK1oY2eaPkDqTaQOjJ/wa0EeeoYhtwkFZFedelk4TIORkoX387w+AHn42sQWKhpch9AgB3gOHi/4MwJX9/RTJzmhribsZBK90htgauHFOoAAE8FXSjTWhctGprc0npRAy/uFvWEpFdLRIjiXpzWozTXIcmxgVJQ6aCnyQ3GBikTP8cBJYgKBQLBoInSZT4+BiJwFMtymt7G4bK2WW8XQEriz8S2s0PEpc5WDOjA3NcGi4vQ2/lymkSKgNT7X0IUTdJgLKcp5w4ABoj/Q2Gd6P5zgaxcVCeaPN+Xiw5+HQPKihPbCHLG77dzcIQwuvqXNNAFAtuMHd7kcwIKCFzRj8fnO09zhFpqWTMjSGdZYALcj/pHwhdvDhxiaROvIKXMtHGfMDb0s5LNmsKgAMn1kFr04MVXIo7ZbZBaRa82WXowQUMh5wUbwX42vb5g8rjhbm3ZldqRF066YXBlh+9WxsbAvU4llj1hLFf35J0tKMA5LmI76BRhjHA1Bp3p0ncJDRI61tapNjHIUNLaSaiKE1PGKGyz6W3Y4bfvnGjZ5ZN+luZqOwvDv4Jh9vo2mhZoKrkuiJfBvSmuDYZYnoOz8Q/WLTDgR3N1HQW3HgGoB/vcAWx/Ccu36jSnoMLiDW5JO9Wz2qZvu0cYn7MsUq7t5XB+fqiModY34ML4DSI6ug4=cX|?�    �                                                                                                                                                                                                                                                     �V 7�E	laozhang支付寶入金限制eNq1VElygkAUXcMpuIBVRItNzsbC0jjGseIQh5SSEuMiDomzEL1M/4ZeeYW0IRJoQHGR3vxf7fPxh/c6Igi4NkXaM0xXkFJJphoRSD5uKgV6jcsLyDZNZXTUsxDvmZMZFJWjnuN5mSNPKwriZA6KdeO9ZiW4qf4m3Swn8/J9xHUEepi7nytKhzZj6HzZpHciPY6Im33SqpDXlxMrB+ku2rQDwTERbTIWcK1CPe0PtJIzEu0GJB5MGbUZtZ052XtwkocQtnOY5Gyg5G2EaYpOAB0Uzx8k/wmkcjB4CwnGyyGUqzY4Jtpz8oc/dpxDu1LI9uDhdkQ3mCQmkBi5mP8CU8SsatR6oaexuKQHBlwswaDsZhadCbuWPF6uAws5L5yPhDUSXbJRG/2bkS5J3iF9r4uiZ6k7o+gneu8MbCRjY9olnSPshsF5sFX8d80Yla1askthZBy7akDGJo5HIoyYgwth1Cldpr3JUIyWo9d7dNsq5H5ueWyYZyzMF6h3INEyR9pRb1OP4L4OyRTad6CcNOPJo16A1AppDag8QK8EmwRdK1bHlrlOv06HpN2xzEeUIuVEmmrMNWP5YWQ/8a7B89/NWiNacX����U =�-laozhang微信支付入金限制eNrVVkty2kAQXcMpdAEKYxebXIR9NrkECwwBgwHLBMz/Y7kEwRVb/Iy   �    �  �                                                                                                                                                                                                                                              �H %�Elaozhang默认页面eNqNVUty2kAQXcMpdAFKYIpNLsI+m1xCCyBB/C0IGPEnSgmCq2zxEVgCDFxGPdKsfIUMvyBTDJ1ZjKZGr7r7vX5qCYIgBEOCAFvD2WmkNnbWDUgPaKYSEmg+4WlFdkeUOWRVTxsF2ZKO11AuuaPpx3v229eP95zkNVuk0IcnGapJZ6WTRpW9ImPFfamJ7AH68x4FRs/NPWOooPQl9GmxGoWru8NVUAqANWDhaPWNlRSQAtFwOCzuN3aOxMVYPHAArVeeseWBIieQ3HHsFgJy7Fdob7BI6Rzof26CHuLiwwm03IFSuQmKxsXoEUQKbR67C4gJSRO3C4/9k4CmDEiNboP259jhfGTIjIBEI5OKW+tjDNPzO4KeW7M0wchh6RZDnlYXEJQeQVeQ1tBMCVYXQSN+0EGGU6ximqf7hZ9j58nCwkrvvoLV+w/dWfnkbchLeY5m69yUV9FU2jBJt0KfMhiNZZdMsV6SbJl+3yAgqq1ga7HviGl3v1OqO9Mx61tT6Ji8YD6XVbMwqZH1CGMw7XsFBbOsbbtyH0/qDXY81/rk2JTpLImBtk2e+j7BjCQxf2O1l1Rn9YKpYE5oS0ZcRrs/YdbGjN0ssFHBt+KZ348Uaw/oLVIfIxEdu+M99hAC3nzBjI2xrCVIr+vlp6yNvBHkY1KfuHV5P/532p1hNuF9x9cTAbePO1TYL+mYEWt98VNXI0xb8bAR9Zdvsv0FqfMM5Q==cX���    �  �                                                                                                                                                                                                                                  �I %�]laozhang默认页面eNqNVUty2kAQXcMpdAFKYIpNLsI+m1yCBZDwBwsC5v+JUoLgKluInxFg4DLqkWblK6T5BZli6Ggxmpp51d3v9VNLkiTJ65Mk2OrWTmWVkbWuQ6LPUyWfxLNRR83jGVNmkK456vDjPQ3RnqMbUFA/3jNefCJHFBQL9nCM99++4kXEaTRZrgdPSSjHrJXG6mW8YiPFfqnI+ALteY8CvWtnnimUN/LF9+nBkqWrs8ORN+KBRR/D8fIbluSJeIJ+v1/eL7gPhOVQ2HMArVeOvhWBAidQsm2ZTQJkma/Q2lCREhnQ/twEPYTlhxNouQOldBMUDMvBI4jlWiJ2FxAKyaO3Cw/9k4DHdYgPb4P2+9Bhf2SIviCiMaNkV3oUw8TsjqDn1iynoGeodPOBSKsLCAqPoClEa3iqAKuLoAE36CDDKVY+IdL9ws8ys2y+oErvvMKi+x+6Y/nsbSBKeY5masKUV9FqvD5lnRJ/SlE0lh02pnrJ0kX+fUOAuLqC7QK/I9Tufqdq9kSjrL8YQ3sqCuZyWTkNRoWthxSDcc/JKZRlTdNO9uikTn8ncq1Ljk2RT2IUaNsQqe8STI+x6W+q9kLNWr1QKkwN3kwSLuOdnzBpUcZu5HBUiK145vcjju0BrcmqIyKiZbadxy5BwJnN0dgUy0qUdTtOdoxtFI0gF5OqYVeT+/G/U+8MM0P0HV9PBNo+9kDBX9IxI9X6/KeuBlBb+bCw2i/XZPsLZDYXqQ==cX��    l  l                                                                                                  �F %�]laozhang默认页面eNrVVctu2kAUXbtf4SVVheSC3ED3WVRssmHRD+hHVGJhlIZHhAuoUAKBEhOSoLY2VAngYh4f03nYK36h14xxbcxLajcdWZ7r4d6Zc87ce0lx1qeRqRS4lGNgWaEPMv1hwAqWq/R7xaqXrE4rhC/On8Ma6RdJ7c6zxtuhTcm8TxNDMUePtPGBtBRkjOwfcDdLHnu2oXVIU6bnKp0suNSz1OswDB7GymKfYT4VdpbBg0O6iq9neHyHqxkXJJbapjYAkGCLggDvl8JqwpdfaClDK0OslhwmxVtkdME1RGo3gBBPJUtq0LaKFoqpdc1+2uaD1SsrW7RadSKlcT9Db9K00iO5sU1DMuhT39QUxhbpk6ggAGWIiotiLGbz4LjVE2EgxINYltNCEAfnbONuJyI9+2di23kh4novEAM6MHfXYHFJej1fTnNIl5Bx+0tKo0kBjOU0798BwADxfyisH91/LpCTi8bE1Oa7ctHHr2dDWXNiG0HORKNeDr4QRtf6WgC6QCDI2OdNPmehwsAV/bx/sfU0X6ijljMzgnRWBibA/aB/MnH6ds8hjjaZJtIbTBv+iLGhn5NszpQABUilj4yrEF58I/KY3QZpN61Wh6UHEzQe91+wHRxl05tTJg8Pd+vJrvyWvPDTTYArO3y7Mh4GvJtKLHsSWGvtyDtPkCj4LiIYdIwwdrhxAZ3pLHIGDRI6VuBUjxhkWDQfclAVR6aMXdirprdhJ96996Nll08GZVppby2M6BrG6t/gAU1rNJ9zC+JVbGeKm09DrM3BmVQHWK0x4Adz1Y2CW08C1L19bg+2v4QVWXeaY1Bh+SPuFreq57TNSLBH2J+zMtIvveVwcrKvjKHWN+DC+A0dGKIUcX|?�    l  l                                                                                                  �G %�]laozhang默认页面eNrVVctu2kAUXbtf4SVVheSC3ED3WVRssmHRD+hHVGJhlIZHBAVUKIFAiQkJKK0NVQK4mMfHdB72il/otccQG/OS2k1Hlud6uHfmnDP3XhKc+WVkyDkuweG8TLt5+lO37Qr9UTZrRbPdDOCL85ewRvoFUr1zrfGwaDYk4z5JdNkYPdL6J9KUkT6yfsCdNHnsWYbaJo08PVfoZMElXiTeBmHwMGyLfQb5RNBZBg8OaQq+nuHxHa6knuFJLUMdAEiwRUGA92vBnvDlN1pM0fIQK0XmjQu3SO+Aa4BUbwAhnkqmVKctBS1kQ+0Y/aTFBytXZrpgNmtESuJ+it4kablHMmOLhqTTp76hyowt0iZhQQDKEBUVxUjE4sFx9hNiIMSDWJbTnB8H52yz3k5EWvp5Ytu5IeJazxcDOjD3tcHi4vR6vpxmkCYh/fa3lESTHBjLada7A4AB4v9QWC+6/1wgJxf1iaHOd+Wih1/PgrLixDaCnAmH3Rw8IYyu+ZADukDAz9jjTb6mocLAFf26f7X1NE+oo5YzM4J0VgImwP2gfzx2+n7PIY42qQbS6kwb/oixoZ+TbM4UAwVIuY/0qwBefCf5MbsN0mqYzTZLDyZoNOq9YCs4zKZ3p0weHu7WlV3ZLXnhpRsDV3b4dmVcDPh1KrHsiWG1uSPvXEGi4LkIf9Axwljh+gV0prPQGTRI6Fi+U11ikGHB6GagKo5MGauw7aa3Ycc+fPSiZZdPBiVabm0tjPAKhv1v0EXTKs1m1gXxJrIzxY2nIVbn4EwqA6xUGfCDubqOgluPA9S9fW4Ptr+EFVp1mmNQ4fxn3ClsVc9pmyF/j7A+ZyWkXbrL4eRkXxlDrW/AhfEH96adzQ==cX|@                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       �   +   /   �   ~   �   �   �   4   �   .   3   �   J   �   e   �   }   �      �   |   �   K   2   1   0   �   A   @   �   �   �   �   �   -   ?   >   <   ;   �   �   5   6   7   8   9   :   B   C   D   E   F   G   �   �   �   �   �   �   a   I   �   �   =   H   L   M   N   O   P   Q   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   d   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   S   `   �   �   v   T   ^   ]   \   [   Z   Y   X         �   r   �   �   m   l   ,   �   r   �   r   �   r   �   �   �   �   �   m   �   l   �   �   �   �   �   �   �   �   �   �      �      �      �      �   �      (   �   �   �   �   '   �   )   a   b   a   �   b   �   [   I      !   J   H   =   I   [   �   �   �         a      �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   �   a   a   a   a   �   �-----  |:-----|-----                           |
|groupid |int   |用户组id，1：超级管理    $ P $                        �)N %�	laozhang默认页面eNq1VMtOwkAUXbdf0R9oUiHd+G1dEBKeikgsQQSDNS2y0EIib1B+prd0VvyCo8g4vdOBsnA292Zy5uQ+zhld00J7GKzuYTiFgkdKDV0j1VzkXNPrsD6GcityBrt1GXK9yB9BzdmtK6pqKeRuSkGKpUCtuX2190nY8n6TblmxVOtSjx2NHnT3c0XpgvkbdD4Y6YVBDxfD1hNp35Lnx29WBYrdYP4gBWeNYF7aA2ceNIvJwH1yQAZLl+TklBnGuFpG/qeAMwVCWLyDX2FAU2wENUUnEGwc4YGZPIFCBdyXlOBw0od6g4GzBptTMvyqww/tRCGLjcDNxTiY5H3ID2LMfwEVMWps7V7qaYyP6QGBazfg1uPMBp/gtVTDyUxayGHhqp7WSHTJW3vwb0Y6JnlO+qKLMgep89FIEr04A4ZENqZd0jnCsi/P5VZJ3jUyKq7aZKUgGWdPGhDZhPsk0ohZXghSp3mc9ixDIS1nTvcYt5VsP+f/Mej3SrN49QtmstndcX����-M %�	laozhang默认页面eNqNks1Og0AQx8/wFLwACdpw8dk4kCZtoYpIpEFtTcWA9qC0if2gH9qX2dmyp76Cq9gVdkE7l5lMfvvPzH9WVRTsj9H6BsZzaMWk46kK6ZpZeEHb2J2CFWThaL+xwBxmyQSccL+xZdmQyPWcQpIhgdPbvfh5gYP4pxhYkiEbZ2opFBpc77tF5VD6Cv13Jnqi0ShkHDyQ2yvyeP+lKkF7gNK7WrihobSTg4sYeu1qMC8OJFpFxKyXPGWK61WWfAicLgjC8g0Sm4G6uAi3FHUAbUPhgV7tQMuG6PlIGM+ewPUY3NCYT9X4eb9o2j+DLLeCdiGXYdJMoDkqKf8mboiJt/OHR7sx/es/cLBzCZFbVtaKBX+WLp4tagc5HPwTJodp8A==cX���                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    f                                                                                                                                                                                                                                                                              �I8 M�%laozhang入金- 銀行單筆限額列表eNqdVM1OwkAQPtOn2Aegpkg44E29efXku3BAC1j+AoS/AKI2Uu1BUDCItg28TGe7PfUVXChpl4ZidZNNZmbnm292ZnYRQojjEYK8Yt82eGSXskSuQGdijQt2r27LVZC6RFY5LhPbntWrljqNUTXbt6+bjiFdXTpGkTWcXwQNZ6cbC5c54eminMiVWAVl6OYzvpXaKav5NYa7sstNY6aEuCAIR4KAqJJkZPbAg5HlDCtjD5wQWPQBzQsACwXahUgBWJSuEdWnTUUn1Ubrou2nS+6XKQyXB+FZhsPcZPF7w2o9/KtGRJLY8h7HE54rK2/JSni+wPNnPJxaPQOm7UiUuxmD/vQb/OB1zZUcvZeQL8LoJcR/t+G2OMetFeRmpJmLkFewjvD9AZPiny8Ela6pvfqwdDydTkcc7nUz1q9j2KCTE/5GksGikNobjGqed2C6U7tjOZya2j3r6xVus3gENz2i6o7Rp18MfjRAzJvLAdREkhUdw/+GQPo0dcUNZEkzrHUo+geg2LgPcX1l��7 A�=laozhang入金- 銀行支援列表eNqNls1SGkEQx8/wFHOUAy+QG5JUYqpSZYVUJR5HWHfXwGCxu0YtDkbE4FcIpcaIWomJGA4Rg4oaIPguqZ0FTr5Cer+HFcUty   �    �  �                                                                                                                                                                                         �:J w�]laozhang微信支付入金- 銀行支援列表（借记卡）eNqNVUty2kAQXcMpdAFKYIpNLsI+m1yCBZDwBwsC5v+JUoLgKluInxFg4DLqkWblK6T5BZli6Ggxmpp51d3v9VNLkiTJ65Mk2OrWTmWVkbWuQ6LPUyWfxLNRR83jGVNmkK456vDjPQ3RnqMbUFA/3jNefCJHFBQL9nCM99++4kXEaTRZrgdPSSjHrJXG6mW8YiPFfqnI+ALteY8CvWtnnimUN/LF9+nBkqWrs8ORN+KBRR/D8fIbluSJeIJ+v1/eL7gPhOVQ2HMArVeOvhWBAidQsm2ZTQJkma/Q2lCREhnQ/twEPYTlhxNouQOldBMUDMvBI4jlWiJ2FxAKyaO3Cw/9k4DHdYgPb4P2+9Bhf2SIviCiMaNkV3oUw8TsjqDn1iynoGeodPOBSKsLCAqPoClEa3iqAKuLoAE36CDDKVY+IdL9ws8ys2y+oErvvMKi+x+6Y/nsbSBKeY5masKUV9FqvD5lnRJ/SlE0lh02pnrJ0kX+fUOAuLqC7QK/I9Tufqdq9kSjrL8YQ3sqCuZyWTkNRoWthxSDcc/JKZRlTdNO9uikTn8ncq1Ljk2RT2IUaNsQqe8STI+x6W+q9kLNWr1QKkwN3kwSLuOdnzBpUcZu5HBUiK145vcjju0BrcmqIyKiZbadxy5BwJnN0dgUy0qUdTtOdoxtFI0gF5OqYVeT+/G/U+8MM0P0HV9PBNo+9kDBX9IxI9X6/KeuBlBb+bCw2i/XZPsLZDYXqQ==cX��'    YQK0g3ZRsOFIad5zPZ/9ne+g4gh3z144WsCdxzTP5HxCKV1QjH4K7pBczqmObB/FffgH35AYU8PnOaeoPQuT93KsaCkcnmStecsO4/nkIqkNxAvKuzNU0EM3JA4QWds08oT4GE6g9LG/LyWz5IB+NwN+HarV7uM8OBWI8HeYqBS07KzFjGoh4UbswTTATSnVeY1Ekn03UQSQaVNSRZzounTjAE098W+vPXAjWu7B9uFpZYZKlvRB7O+bXd3/45YvquwCDV1jeY8FPEQ80FIzdrGeazMxaJcZqkogagloC1rqqTGF1bajiQ1vnQ/dARkim9CxwRN2jNQOnRLW9TmjIV5jVohdcF+hFVhP65kJoNukph3bGDeRMvxmx4wKmfz2Lk6knuCu8rhmJieSEfJBzhsNpGuTVb+GqnyXYmDKbq9qOUzeZLT44Jm1B3212ru7hVbq/Z2nghif73Bg09OeTDkThqmBSWYwouQfTPREFndXrIT6TtjtU0fe90puhd1dnAGCWX1N2Fwc0g85r1oxH8I0swf8kKj/OXwTpQS/cIPUbJYL985rf+itPiu2i3jGpn1D2NGWEkKDJ7YmPCCMH7kjglI6IE3f5RZwfmzfAaZQfdIp+C527iQToHnqjLD8+ptVpgKBFS6h9ugSe4e/xYfld4tuZNEE9wk2dRlybFR1DxwWtFL3MO60/oowNO6Jg7EbWxaKGUSXh7eHMuJOm29YuVS1O2lE+6GqLs2XiI4FKR7ntrpzbKcwcBNFNrwc5YxlNyxrfg52Rp4Tu5jGpwOKqzYLmqP3bNPEeXkK3cTFFiYMTgkNCJA+V/3vBIBfFcFTBPxdss3ZYZ7eMwuPkpV8VyVcRfKCaOEd6cemZGQyxrMIfjmcNrvhxLuH1paxxaaxMt8ukHgL40sKSq8Z1ntUCwKIiffRSQ1RxbwMhg4NILlcI0htvahV21fd/bgg8f9p8PWN5zLfVZa762uX3eCz6Hwg6bSPWt3G/Vu8dRtvYXV/wOq3D1lcX A�    p � p                                                                                                  �6 A�-laozhang入金- 銀行支援列表eNqNlt9P2lAUx5/hr7iP8sA/sDdky+aSJWYuWfZ4hdrWwa2hrVPDgxNx+GuMqHOiZnMTx8PEoaIOGP4vS2+BJ/+Fn   y�'5 A�mlaozhang入金- 銀行支援列表eNqFls1S2lAUx9fwFHcpC16gO6ROa2c641RnOl1eISaxEBySWHFYWBGLHy111FoR29qKZVGxqCgFiu/SyQ2w8hV68n0TjGbB3HNu8rv/nHP/lyCEUDCMEMlXB   x�I4 M�%laozhang入金- 銀行單筆限額列表eNqdVM1OwkAQPtOn2Aegpkg41Jt68+rJd+kBLWD5CxD+AojaCNqDoGAQbRt4mc52e+oruFDSLoRidZNNZmbnm292ZnYRQojjEYLs0Lmt8cgppIlagtbYHuWcTtVRy6C0iapxnBTbnFXLtjaJUTXdda7rrqlcXbpmnjWcX+wazk7XFk464eminMiTWAVJdPNSYKV2ymp9jeCu6HHTmCkhLgjCkSAgqiQZmT3wYWQxxcORD04ILPqA5geA+RCauUgBWJShEy2gTUUn1Qerou2nS+6XKQwXe+FZhsO8ZPF7zW48/KtGRFHY8h7HE74rK2/ICng2x7Nn3J/YHRMmzUiU2xmD8fQb/OB1raUavZeQzcPgJcR/u+GOPMONJWSmpJ6JkNduHeH7A8b5P18ISm1Lfw1gYlwUxYjDvWrG6nX0a3Rywt9IcrcopPIGg4rvvTPdqe2x7E8s/Z719aKsF4/gpkM0wzW79H/BjybIWWvRg4pM0rJrBn8QKJ+WMfSi2MoU6y2K/gHO7reBcX1l�                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    BBZK3Xf5YOou7ncOd42ds+N3BXJ7neOy3540pabfHzfLldHotOBfseS6HIIsu3QGz/a35vp7nKh+3Zn5NVkwB6GnznD0VAg7U8/CvY9IAy5fC4XSnMT/Bj50z799owc/u3uXIMIn2UWtyxNYI5i+TVKzKKwKMkY7CUxIUdFLEdh/C9bYL8+0OUj60X9tsBQndaFUTpjqFA0KUW0mKolcQy5ufJD2JsS2Vtn2J5pY8flGU1RkxJAsTyDwol4XEhGJI89og/t0ah3Ki1nDzDLjnSTAGhZUbWIKiVkkw0TcxKWhyH1+gnNGwusZQ4EFvRqshTBFKtYyMQwpLF1yEeiZ/arfA6nh/WqYmtcEh8A/s63d786QMt0ASVZEQU5avIkkxPvuTwjuXbVdwmyWf4ScNnqyVsEZErwFFc7Jbm8I6522j5oMtIkPZOIJTShzUBi0WNhQYgl5uOCrNroeW0We0r8c8eDCZQeB36iAXgYMkonvalQOfrdMV9I1HRdofGp8bCTGNgEju8dxQ1y8tORaJkcDMtobEFITielqNivbgZzKIvWXakYu3dkpdzZWWXMbqZGnasX1GmTJxKKCrmZxAuQFmWghCKitqh5h/SSVDYs9n0za9xUSfESgkyqe7Zzw8deM3cbsV6C0NOXTFeAKoCNUYhVGL1nQ7K4va/Xfzkhskx3fY0K0px1aafZaAgK2ldfnzGd0MT4Guvh0Auzi7maDd1kjnYypVdvXAr0202jdsPdDtN0q7UvtXlwNhzAgFLjKA+6+EqzpmjTNaf4qmO1Mky2IvKyPa52Ua87OxlHVb3+hdGnRIFdlDGsqCikSDRjtIZSuF8/ef+BnOSc7pA7p6ZNeqrhRQnbokTT8sxXqwK1BR9fvfHZN2C+FMIiVtEETtHKBccbQeLLjPUXcwGpHLGVPc/5NfOEYtI8TsEA2wP+POYTRGTloFNu3DcL8C/A+NYkmTW9dUhymc5y5r7Z+49gf+VL7ctGu1ZtZy+M+idY/R+7esw6cX-R�                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   � �                                                                                                                                                                                                                                                                                                                                                                                                                          �Y: M�Elaozhang入金- 銀行單筆限額列表eNqlVM1OwkAQPtun2AegpkA41Jt688pF3qUHlB/LX4DwF0CijVR7EBQMom0DL9PZtqe+gltqaKm0NrBJk5nZzrfffjOzCCFE0QhBQTTvmjQyy1lDqEJ3qk+KZr9hCjXge4YgURR38rvXqOnS7IS42YF507JUPpO21JI3cHnlC6Qz1/5fLs43EYo7o8kiLJBjeR3EkY/m3CiJEx7a1wTuKw4bgpliYgzDnDIMIk7SY+9seJ0thrGaY3GyRYoz3owwby8aLEXoFCOhBUIosiG5hFIH0pHHttD7iSQjqEUwcGUYfJkgjMS+O+H3pt5+OF5kg+e9xUrE4u65HnvX3bAo48USL57xaKb3VZh1InEJ0QaUp/+wIqpMFNLWwoEtA4USjF8CkkOazMwtcHsN+bnRykegH1oU+P6Aaek4EaDa0+RXF4ONsSx7yBDadbZHetQkrRs82Em/THZz1d9gXN8m+GYv9SfDWTSC274hKZY6IG8kflQhV9BWQ6jnjGzOUt13FPhPTREdeJ2fY7lLsn8A/0rbNg==cX<�    mQZZZ2M2z5jR/8O9z9DEJlAPX4ZxATqA0x/QMYTlNMJxaCv6wYt6pgWQf6vfAj/8AMKe37stg8FZXBz4dXOBGWyWCIFe9GyS3gRqUh6D/G6xt48F8RQjYhTdN42rRIBHqbzKGcsLWmlAhmBL96D73YGjZsYD2o9DtjfDFRqWnbBIgb1sbCwQDAdQXM7VV4jkcRATSURorQpKWBONAOaMYLmvTySjx6qydgew3Fhq2VGka3ro1l/7/UPfotZgaqwCDV1jRZ9FPERS6FJzdr2VaLM5bJcZqkoYVCrQFvT1JBaH1llLw6p9bH/ricgM/wQOiZo2p6H0qEvtRVt0Vhe0qgVUZftJ1gN7J9bmcmgmyTmVzYw76MV+aIPjMvZPnNvT+We4KpyOaZmp3Jx8gEOh02la4dVP8VRBarEwRQ9XNFK+RIp6smA5tUTDjcb3sEt26wP9p8J4nCrxY3PLrgx4k4bpgUlmMErkH0z1RAF3V61U+m7ZI2dAHvXK3vXTXZ8CQllzTeRcScjXvMdjQUvQZr5S75pnDsHn2hS9Au/ROlivXrrdv6K0xKoarc80MhCcBnzQkpTYPAkxoRvhPEjd0xIQt/680eZFZy/wGeQGXaPdAteeK1r6Rb4qhpmdF/9wwpRgUCU3skexCR3T7DER6W/JHeSaIL7QjZ1OeTEKGofu53YiXfSdDvvBXhW18SFeIhNC02ahJeHN8daqk67r1m1End75ZyrEeqRjVcJjgLSfU3t9HZVzmCopgptBDnLG0ru2G7ynuyOvCffYBreDiqkxCkaT73LDzHl/BNXUxTYmDc4JBJiQPVP76oWAwJVBcwS4d0KRJnhnZyx6/dSVXxVZTyCcsIo4d2px2IcyE0D5hB85bjdXzMp9Tstp2MLTeM1Pt3A8KNGVpUo/HdZ40RsCi3nn4VlcpEs4zUQcCSE2+GZQGzz3aDevesdwieW93uPbW27N0essjXY2LrrhR9g0QdNrX/Z7bea/fKF1/kFdv8PWU53bw==cX 3�   � �                                                                                                                                                                                                                                                                                                                                                                                                                                      �M; M�-laozhang入金- 銀行單筆限額列表eNqdVMtOwkAUXduvmA+gSYGwqDt155aN/EsXaAHLK0B4BZBoI9UuBAWDaNvAz/RO21V/wSmPtkAL4iRNzpzec19zZxBCiKIRgqxk3ddoZBXSpliC1sgY5qxO1RLLILRNUaYo7mz9r1o25PEZ2aa71m3d1oRU0tbyfuLqeodIpm52TS4vlgzFndNkkSzQCvk3iCMfzXks4Uke+vcQHoqrbIjPBBNhGAYRFN8Aj3KRqzPnEywNXXWUcW2D4b4HmEnQzB3xEKxUFVP2YidOiKwMnN4FxIyHV090uNgLyXVfF9vLF3/UjMbj/3plCoK/z7FIdB1lA3x4GbCApzM8fcH9sdHRYNw8EjawXFCfD+oPN4sUrS/E0w4WsnkYvAZpwobA4qe4sYDMxKxnDuYY0lj4+YRR/vTqoNTWlTdPx0ZYlv3r3DuH49ycfo2MU8j9iW9V7oxA5R0GFdfUP/GJbdvNohHcdUxZtbUueXTwkwZ8Vp/3oMKbad7WvIcJhC9dlVauDWGClRZR/wJtGrqQcX<	3