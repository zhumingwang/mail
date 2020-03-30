<?php
namespace Zhuzi\Mail;

use Zhuzi\Mail\Exceptions\InvalidArgumentException;
use Zhuzi\Mail\Exceptions\HttpException;
use PHPMailer\PHPMailer\PHPMailer;
use PhpImap\Mailbox;

class Mail extends PHPMailer
{

	protected $domain = '';

	protected $send_client = null;

	protected $fetch_client = null;

	public $attachments_path = '';

	public $char_set = 'utf-8';

	public function __construct($email, $password)
	{
		$this->initSendClint($email, $password);

		$this->initFetchClient($email, $password);
	}

	public function initSendClint($email, $password)
	{
		$this->send_client = new PHPMailer;

		$this->send_client->Username = $email;
		$this->send_client->Password = $password;

		$config = $this->getSmtpConfig($email);

		$this->send_client->Host = $config['host'] ?? '';
		$this->send_client->Port = $config['port'] ?? '';
		$this->send_client->SMTPAuth = true;
		$this->send_client->SMTPSecure = $config['secure'] ?? '';
		$this->send_client->CharSet  = $this->charSet;
		$this->send_client->isSMTP();
		$this->send_client->isHTML(true);

		return $this->send_client;
	}


	public function initFetchClient($email, $password)
	{
		$this->fetch_client = new Mailbox(
            $this->getImapPath($email), // IMAP server and mailbox folder
            $email, // Username for the before configured mailbox
            $password, // Password for the before configured username
            $this->attachments_path,
            $this->char_set
        );

        return $this->fetch_client;
	}

	public function setAttachementPath($path)
	{
		return $this->attachments_path = $path;
	}

	public function getAttachementPath()
	{
		return $this->attachments_path;
	}


	public function getSmtpConfig($email)
	{
		preg_match('/@(?P<domain>\w+)\.+/', $email, $matches);

		$domain = $matches['domain'] ?? '';

		if(empty($domain)){
			throw new \InvalidArgumentException("不符合邮箱规则");
		}

		$this->domain = $domain;

		$imapConfig = $this->getMailConfig('smtp');

		$imapPath = $imapConfig[$domain] ?? '';

		if(empty($imapPath)){
			throw new \InvalidArgumentException('没有设置对应邮箱smtp服务信息');
		}

		return $imapPath;
	}

	public function getImapPath($email)
	{
		preg_match('/@(?P<domain>\w+)\.+/', $email, $matches);

		$domain = $matches['domain'] ?? '';

		if(empty($domain)){
			throw new \InvalidArgumentException("不符合邮箱规则");
		}

		$this->domain = $domain;

		$imapConfig = $this->getMailConfig('imap');

		$imapPath = $imapConfig[$domain]['path'] ?? '';

		if(empty($imapPath)){
			throw new \InvalidArgumentException('没有设置对应邮箱服务信息');
		}

		return $imapPath;
	}

	public function getMailConfig($type)
	{
		$config = require('config.php');
		if(!isset($config[$type])){
			throw new InvalidArgumentException('not support type smtp/imap: '.$type);
		}

		return $config[$type];
	}

	/**
	 * 发送邮件
	 * @param    [type]     $from
	 * @param    [type]     $to
	 * @param    [type]     $subject
	 * @param    [type]     $body
	 * @param    boolean    $reply
	 * @param    array      $attachments
	 * @return   [type]
	 */
	public function sendMail($from, $to, $subject, $body, $reply = false, $attachments = [])
	{
		$body = "<pre>{$body}</pre>";
        $this->send_client->setFrom($from);
        $this->send_client->addAddress($to);
        $this->send_client->AltBody = $body;
        $this->send_client->Body    = $body;

        if($reply){
        	$this->send_client->addReplyTo($to);
        	$subject = 'Re: '.$subject;
        }

        $this->send_client->Subject = $subject;

        if(!empty($attachments)){
        	foreach ($attachments as $attathment) {
        		$fileName = basename($attathment);
	        	$this->send_client->addAttachment($attathment, $fileName);
        	}
        }

        return $this->send_client->send();
    }

    /**
     * 获取发送发件的id
     * @DateTime 2020-01-14
     * @return   [type]
     */
    public function getLastMessageID()
    {
    	return trim($this->send_client->lastMessageID, '<>');
    }

    /**
     * 根据条件搜索邮件id
     * @param    string     $criteria
     * @param    boolean    $disableServerEncoding
     * @return   [type]
     */
    public function searchMailbox($criteria = 'ALL', $disableServerEncoding = false)
	{
		return $mailIds = $this->fetch_client->searchMailbox($criteria, $disableServerEncoding);
	}

	/**
	 * 根据邮件id获取邮件详情
	 * @param    [type]     $mailId
	 * @param    boolean    $markAsSeen
	 * @return   [type]
	 */
	public function getMail($mailId, $markAsSeen = true)
	{
		return $this->fetch_client->getMail($mailId, $markAsSeen);
	}

	/**
	 * 判断邮箱是否授权成功
	 * @return   [type]
	 */
	public function checkAuth()
	{
		try {
			// return $this->fetch_client->getQuotaLimit();//163邮箱不支持该方法
			$countMail = $this->fetch_client->countMails();
			return true;
		} catch (\Exception $e) {
			throw new \Exception($e->getMessage(), $e->getCode());
			return false;
		}
	}

	public function __call($method, $args)
	{
        return $this->resolve($method, $args);        
	}

	public function resolve($method, $args)
	{
		if(method_exists($this->send_client, $method)){
			return $this->send_client->$method(...$args);
		}elseif (method_exists($this->fetch_client, $method)) {
			return $this->fetch_client->$method(...$args);
		}else{
			throw new InvalidArgumentException('不支持该方法的调用'.$method);
		}
	}
}