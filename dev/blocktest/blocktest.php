<?php
if (!defined('_PS_VERSION_'))
	exit;

class blocktest extends Module
{
	public function __construct()
	{
		$this->name = 'blocktest';
		$this->tab = 'other';
		$this->version = 0.1;
		$this->author = 'Ivan Yaroslavzev';
		$this->need_instance = 0;

		parent::__construct();
		
		$this->displayName = "%name%";
		$this->description = "%description%";
	}

	public function install()
	{
			return (parent::install() %hook%);
	}

	%functions%
}


