<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------

	public $tambahTugas = [
		'tugas_name' => [
			'rules' => 'required'
		]
	];

	public $tambahTugas_errors = [
		'tugas_name' => [
			'required' => 'Nama Tugas wajib diberikan'
		]
	];

	public $register = [
		'username' => [
			'rules' => 'required'
		],
		'user_fullname' => [
			'rules' => 'required'
		]
	];

	public $register_errors = [
		'username' => [
			'required' => 'Username wajib diisi'
		],
		'user_fullname' => [
			'required' => 'Nama Lengkap wajib diisi'
		]
	];
}
