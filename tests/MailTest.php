<?php
namespace Zhuzi\Mail\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery\Matcher\AnyArgs;
use Zhuzi\Mail\Exceptions\HttpException;
use Zhuzi\Mail\Exceptions\InvalidArgumentException;
use Zhuzi\Mail\Mail;
use PHPUnit\Framework\TestCase;

class MailTest extends TestCase
{

    protected $username = 'wangzhum@gmail.com';

	protected $password = 'assddfsdsdsf';
	

	// 检查 $type 参数
    public function testGetMailWithInvalidType()
    {
        $w = new Mail($this->username, $this->password);

        // 断言会抛出此异常类
        $this->expectException(InvalidArgumentException::class);

        // 断言异常消息为 'Invalid type value(base/all): foo'
        $this->expectExceptionMessage('Invalid type value(base/all): foo');

        $w->searchMailbox();

        $this->fail('Failed to assert getWeather throw exception with invalid argument.');
    }

    public function testGetMail()
    {
        $w = new Mail($this->username, $this->password);

        var_dump($w->searchMailbox());

    }

    public function testSendMail()
    {
        $w = new Mail($this->username, $this->password);

        var_dump($w->sendMail($this->username, '1076380746@qq.com', 'test', 'test'));

    }

    
}
