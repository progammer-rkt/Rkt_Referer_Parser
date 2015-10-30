<?php
namespace Rkt;

use Snowplow\RefererParser as SP;

class Referer
{
	protected $_parser = null;
	protected $_referer = null;
	protected $_requestUri = null;
	protected $_targetUri = null;

	public function __construct($requestUri = null, $targetUri = null)
	{
		$this->_initiateUris($requestUri, $targetUri);
		return $this;
	}

	public function currentUri()
	{
		$url = (isset($_SERVER['HTTPS']) ? "https" : "http")
		. "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		return $url;
	}

	public function referUri()
	{
		if (isset($_SERVER['HTTP_REFERER'])) {
			return $_SERVER['HTTP_REFERER'];
		} else {
			return null;
		}
	}

	public function getParser()
	{
		if ($this->_parser === null) {
			$this->_parser = new SP\Parser();
		}
		return $this->_parser;
	}

	public function getReferer($requestUri = null, $targetUri = null)
	{
		if ($this->_referer === null) {
			$parser = $this->getParser();
			$this->_referer = $parser->parse($requestUri, $targetUri);
		}
		return $this->_referer;
	}

	public function getRequestUri()
	{
		return $this->_requestUri;
	}

	public function getTargetUri()
	{
		return $this->_targetUri;
	}

	public function setRequestUri($uri)
	{
		$this->_requestUri = $uri;
		return $this;
	}

	public function setTargetUri($uri)
	{
		$this->_targetUri = $uri;
		return $this;
	}

	public function exists()
	{
		$refer = $this->getReferer();
		if ($refer->isValid() && $refer->isKnown()) {
			return true;
		}
		return false;
	}

	public function getMedium()
	{
		return $this->getReferer()->getMedium();
	}

	public function getSource()
	{
		return $this->getReferer()->getSource();
	}

	public function getSearchTerm()
	{
		return $this->getReferer()->getSearchTerm();
	}

	protected function _initiateUris($requestUri, $targetUri)
	{
		$this->_requestUri = $requestUri;
		$this->_targetUri = $targetUri;
		if ($requestUri === null) {
			$this->_requestUri = $this->referUri();
		}
		if ($targetUri === null) {
			$this->_targetUri = $this->currentUri();
		}
		return $this;
	}
}