<?php

return  [

	'smtp' => [
		'gmail' => [
			'host' => 'smtp.gmail.com',
			'port' => '465',
			'secure' => 'ssl',
		],
		'yahoo' => [
			'host' => 'smtp.mail.yahoo.com',
			'port' => '465',
			'secure' => 'ssl',
		],
		'qq' => [
			'host' => 'smtp.qq.com',
			'port' => '465',
			'secure' => 'ssl',
		],
		'126' => [
			'host' => 'smtp.126.com',
			'port' => '465',
			'secure' => 'ssl',
		],
		'163' => [
			'host' => 'smtp.163.com',
			'port' => '465',
			'secure' => 'ssl',
		],
		'yeah' => [
			'host' => 'smtp.yeah.net',
			'port' => '465',
			'secure' => 'ssl',
		],
		'sina' => [
			'host' => 'smtp.sina.com',
			'port' => '465',
			'secure' => 'ssl',
		],
		'outlook' => [
			'host' => 'smtp.office365.com',
			'port' => '587',
			'secure' => 'starttls',
		],
	],

	'imap' => [
		'gmail' => [
			'host' => 'imap.gmail.com',
			'port' => '993',
			'secure' => 'ssl',
			'path' => '{imap.gmail.com:993/imap/ssl}INBOX',
		],
		'126' => [
			'host' => 'imap.126.com',
			'port' => '993',
			'secure' => 'ssl',
			'path' => '{imap.126.com:993/imap/ssl}INBOX',
		],
		'163' => [
			'host' => 'imap.163.com',
			'port' => '993',
			'secure' => 'ssl',
			'path' => '{imap.163.com:993/imap/ssl}INBOX',
		],
		'yeah' => [
			'host' => 'imap.yeah.net',
			'port' => '993',
			'secure' => 'ssl',
			'path' => '{imap.yeah.net:993/imap/ssl}INBOX',
		],
		'qq' => [
			'host' => 'imap.qq.com',
			'port' => '993',
			'secure' => 'ssl',
			'path' => '{imap.qq.com:993/imap/ssl}INBOX',
		],
		'yahoo' => [
			'host' => 'imap.mail.yahoo.com',
			'port' => '993',
			'secure' => 'ssl',
			'path' => '{imap.mail.yahoo.com:993/imap/ssl}INBOX',
		],
		'sina' => [
			'host' => 'imap.sina.com',
			'port' => '993',
			'secure' => 'ssl',
			'path' => '{imap.sina.com:993/imap/ssl}INBOX',
		],
		'outlook' => [
			'host' => 'outlook.office365.com',
			'port' => '993',
			'secure' => 'tls',
			'path' => '{outlook.office365.com:993/imap/tls}INBOX',
		],
	],

	'pop3' => [
		'gmail' => [
			'host' => 'pop.gmail.com',
			'port' => '995',
			'secure' => 'ssl',
		],
	],
];