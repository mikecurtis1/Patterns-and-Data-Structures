<?php 

class Point
{
    private $x = 0;
    private $y = 0;
    
    public function __construct($x=0, $y=0)
    {
        $this->x = $x;
        $this->y = $y;
    }
    
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
    
    public function checkPoint($x=null, $y=null)
    {
        if ($x === $this->x && $y === $this->y) {
            return true;
        }
        
        return false;
    }
}

class Grid
{
    private $limit_x = 100;
    private $limit_y = 100;
    private $grid = '';
    
    public function displayGrid()
    {
        $this->buildGrid();
    }
    
    public function mapPoint($points)
    {
        $this->buildGrid($points);
    }
    
    private function buildGrid($points=null)
    {
        $this->grid = '';
        for ($x = 0; $x < $this->limit_x; $x++) {
            for ($y = 0; $y < $this->limit_y; $y++) {
                if (is_array($points)) {
                    if ($this->inArray($points, $x, $y)) {
                        $this->grid .= $this->buildGridElement($x, $y);
                    } else {
                        $this->grid .= '[     ]';
                    }
                } else {
                    $this->grid .= $this->buildGridElement($x, $y);
                }
            }
            $this->grid .= "\n";
        }
    }
    
    private function inArray($points, $x, $y)
    {
        foreach ($points as $point) {
            if ($point->checkPoint($x, $y)) {
                return true;
                break;
            }
        }
        
        return false;
    }
    
    private function buildGridElement($x=0, $y=0)
    {
        return '[' . sprintf("%'.02d", $x) . ':' . sprintf("%'.02d", $y) . ']';
    }
    
    public function cmpPoints(Point $p1, Point $p2)
    {
        if ($p1->getX() === $p2->getX() && $p1->getY() === $p2->getY()) {
            return true;
        }
        
        return false;
    }
    
    public function distance(Point $p1, Point $p2)
    {
        $p1x = $p1->getX();
        $p2x = $p2->getX();
        $p1y = $p1->getY();
        $p2y = $p2->getY();
        $v1 = ( $p1x - $p2x ) * -1;
        $v2 = ( $p1y - $p2y ) * -1;
        $steps = $v1 + $v2;
        $distance = sqrt(($v1 * $v1) + ($v2 * $v2));
        
        return $distance;
    }
    
    public function getGrid()
    {
        return $this->grid;
    }
}
?>
<pre>
<?php 
$grid = new Grid();

$p1 = new Point(3,3);
$p2 = new Point(1,2);
echo $grid->distance($p1, $p2) . "\n";

$p1 = new Point(30,312);
$p2 = new Point(1131,272);
echo $grid->distance($p1, $p2) . "\n";

$p1 = new Point(10,10);
$p2 = new Point(20,20);
echo $grid->distance($p1, $p2) . "\n";
echo var_dump($grid->cmpPoints($p1, $p2));

$p1 = new Point(10,10);
$p2 = new Point(10,10);
echo var_dump($grid->cmpPoints($p1, $p2));

echo "\n\n";
$grid->displayGrid();
echo $grid->getGrid();
echo '-----------------------------------------------------------------------' . "\n";

$points = array();
$points[] = new Point(1,3);
$points[] = new Point(7,14);
$points[] = new Point(13,8);
$points[] = new Point(8,10);

echo $grid->mapPoint($points);
echo $grid->getGrid();
echo '-----------------------------------------------------------------------' . "\n";
echo var_dump($points);
echo '-----------------------------------------------------------------------' . "\n";

$arr = Array(1,2,3);

echo '-----------------------------------------------------------------------' . "\n";
//NOTE: function from http://stackoverflow.com/a/10223120/4223423
function permuteArray($items, $perms=array(), &$p=array())
{
    if (empty($items)) { 
        $p[] = $perms;
    } else {
        for ($i = count($items) - 1; $i >= 0; --$i) {
             $newitems = $items;
             $newperms = $perms;
             list($foo) = array_splice($newitems, $i, 1);
             array_unshift($newperms, $foo);
             permuteArray($newitems, $newperms, $p);
         }
    }
    
    return $p;
}

$p = permuteArray($arr);
print_r($p);
?>
</pre>
