<?

class MTest extends CModel{
	protected static $_table = 'test';
	protected static $_scheme = array(
		'id' => array(
			'tipo' => 'int',
			'encode' => false,
			'default' => 0
			),
		'test' => array('tipo'=>'text','encode'=>false,'default'=>'NULL')
	);
}


?>