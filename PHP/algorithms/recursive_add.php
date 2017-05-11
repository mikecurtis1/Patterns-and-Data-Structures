<?php 

class Addition
{
    private $number = 0;
    private $max = 1;
    private $i = 1;
    
    public function __construct($max=1)
    {
        $this->max = $max;
    }
    
    public function addSimple($addend=1)
    {
        while (($this->number + $addend) <= $this->max) {
            $this->number = $this->number + $addend;
            echo $this->i . ' : ' . number_format($this->number) . "\n";
            $this->i++;
            return $this->addSimple($addend);
        }
    }
    
    public function addGeometric($addend=1)
    {
        while (($this->number + $addend) <= $this->max) {
            $this->number = $this->number + $addend;
            echo $this->i . ' : ' . number_format($this->number) . "\n";
            $this->i++;
            return $this->addGeometric($this->number);
        }
    }
    
    //NOTE: http://www.maths.surrey.ac.uk/hosted-sites/R.Knott/Fibonacci/fibtable.html
    public function addFibonacci($addend1=0, $addend2=1)
    {
        while (($this->number + $addend1) <= $this->max) {
            echo $this->i . ' : ' . number_format($this->number) . "\n";
            $this->number = $addend1 + $addend2;
            $this->i++;
            return $this->addFibonacci($addend2, $this->number);
        }
    }
    
    public function getMax()
    {
        return $this->max;
    }
}
?>
<pre>
<?php 
echo '-----------------------------------------------------------------------' . "\n";
echo "addSimple()\n\n";
$recursive_addition = new Addition(50);
echo var_dump($recursive_addition);
$recursive_addition->addSimple();
echo number_format($recursive_addition->getMax()) . "\n";
echo '-----------------------------------------------------------------------' . "\n";
echo "addGeometric()\n\n";
$recursive_addition = new Addition(1000000000000000000000);
echo var_dump($recursive_addition);
$recursive_addition->addGeometric();
echo number_format($recursive_addition->getMax()) . "\n";
echo '-----------------------------------------------------------------------' . "\n";
echo "addFibonacci()\n\n";
$recursive_addition = new Addition(100000000000);
echo var_dump($recursive_addition);
$recursive_addition->addFibonacci();
echo number_format($recursive_addition->getMax()) . "\n";
echo '-----------------------------------------------------------------------' . "\n";
?>
</pre>
