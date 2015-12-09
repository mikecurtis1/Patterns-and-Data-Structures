<?php 

// receiver
interface Placeable
{
    public function locate();
    
    public function toPlace(Placement $placement);
}

// client
interface Placer
{
    public function place(Placeable $placeable, $x=0, $y=0);
}

// command
interface Placement
{
    public function setX($x=0);
    
    public function setY($y=0);
    
    public function getX();
    
    public function getY();
}

///////////////////////////////////////////////////////////////////////

// receiver
class Book implements Placeable
{
    private $x = 0;
    private $y = 0;
    
    public function locate()
    {
        return '(' . $this->x . ',' . $this->y . ')';
    }
    
    // invoker is inside the receiver, because the command changes private properties
    public function toPlace(Placement $placement)
    {
        $this->x = $placement->getX();
        $this->y = $placement->getY();
    }
}

// command
class PlacementCommand implements Placement
{
    private $x = 0;
    private $y = 0;
    
    public function setX($x=0)
    {
        $this->x = $x;
    }
    
    public function setY($y=0)
    {
        $this->y = $y;
    }
    
    public function getX()
    {
        return $this->x;
    }
    
    public function getY()
    {
        return $this->y;
    }
}

// client
class Person implements Placer
{
    public function place(Placeable $placeable, $x=0, $y=0)
    {
        $placement_command = new PlacementCommand();
        $placement_command->setX($x);
        $placement_command->setY($y);
        $placeable->toPlace($placement_command);
    }
}
?>
<pre>
<?php 
$book = new Book();
$person = new Person();
$person->place($book, 3, 4);
//
echo var_dump($book);
?>
</pre>
