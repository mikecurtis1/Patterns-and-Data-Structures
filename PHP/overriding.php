<?php 
//NOTE: place OOP declarations in separate PHP tag to emulate PSR-1 2.3 declarations v. side-effects

interface FooInterface
{
    public function getName();
}

abstract class AbstractFoo 
{
	protected $name = '';
	
	protected function setName()
	{
		$this->name = get_class($this);
	}
	
	public function getName(){
		return $this->name;
	}
}

class Concrete1Foo extends AbstractFoo implements FooInterface
{
	public function __construct(){
		$this->setName();
	}
}

class Concrete2Foo extends AbstractFoo implements FooInterface
{
	public function __construct(){
		$this->setName();
	}
	
	//NOTE: override method inherited from AbstractFoo
	protected function setName()
	{
		$this->name = 'My name is: ' . get_class($this);
	}
}
?>
<pre>
<?php
// modify ini
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
// instantiate
$foo1 = new Concrete1Foo;
$foo2 = new Concrete2Foo;
echo '|' . $foo1->getName()  . "|\n"; //"Foo"
echo '|' . $foo2->getName()  . "|\n"; //"Bar"
?>
</pre>
