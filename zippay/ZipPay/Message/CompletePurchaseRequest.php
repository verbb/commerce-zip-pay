<?php
namespace Omnipay\ZipPay\Message;

use Omnipay\Common\Message\AbstractRequest;

class CompletePurchaseRequest extends AbstractRequest
{

	public function getData()
	{
		$data = $this->httpRequest->query->all();
		return $data;
	}

	public function sendData($data)
	{
		return $this->response = new CompletePurchaseResponse($this, $data);
	}

}