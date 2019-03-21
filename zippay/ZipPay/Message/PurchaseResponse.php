<?php
namespace Omnipay\ZipPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{

	private $redirect_url = '';

	public function setRedirectURL($redirectURL)
	{
		$this->redirect_url = $redirectURL;
		return $this;
	}

	public function getRedirectUrl()
	{
		return $this->redirect_url;
	}

	public function getRedirectMethod()
	{
		return 'GET';
	}

	public function isRedirect()
	{
		return true;
	}

	public function isSuccessful()
	{
		return false;
	}

	public function getRedirectData()
	{
		return null;
	}


}