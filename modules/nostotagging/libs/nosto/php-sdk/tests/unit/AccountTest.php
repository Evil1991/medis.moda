<?php

require_once(dirname(__FILE__) . '/../_support/NostoAccountMetaDataIframe.php');

class AccountTest extends \Codeception\TestCase\Test
{
	use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

	/**
	 * Tests the "isConnectedToNosto" method for the NostoAccount class.
	 */
	public function testAccountIsConnected()
	{
		$account = new NostoAccount();

		$this->specify('account is not connected', function() use ($account) {
			$this->assertFalse($account->isConnectedToNosto());
		});

		$token = new NostoApiToken();
		$token->name = 'sso';
		$token->value = '123';
		$account->tokens[] = $token;

		$token = new NostoApiToken();
		$token->name = 'products';
		$token->value = '123';
		$account->tokens[] = $token;

		$this->specify('account is connected', function() use ($account) {
			$this->assertTrue($account->isConnectedToNosto());
		});
	}

	/**
	 * Tests the "getApiToken" method for the NostoAccount class.
	 */
	public function testAccountApiToken()
	{
		$account = new NostoAccount();

		$this->specify('account does not have sso token', function() use ($account) {
			$this->assertNull($account->getApiToken('sso'));
		});

		$token = new NostoApiToken();
		$token->name = 'sso';
		$token->value = '123';
		$account->tokens[] = $token;

		$this->specify('account has sso token', function() use ($account) {
			$this->assertEquals('123', $account->getApiToken('sso')->value);
		});
	}

	/**
	 * Tests the "ssoLogin" method for the NostoAccount class.
	 */
	public function testAccountSingleSignOn()
	{
		$account = new NostoAccount();
		$meta = new NostoAccountMetaDataIframe();

		$this->specify('account sso without api token', function() use ($account, $meta) {
			$this->assertFalse($account->ssoLogin($meta));
		});
	}
}
