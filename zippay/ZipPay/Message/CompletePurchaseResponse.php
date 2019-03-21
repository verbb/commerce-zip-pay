<?php
namespace Omnipay\ZipPay\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
	public function isSuccessful()
	{
		return true;
	}

	public function getMessage()
	{
		return '';
	}

	public function getCode()
	{
		return '';
	}

	public function getTransactionReference()
	{
		return '';
	}

}