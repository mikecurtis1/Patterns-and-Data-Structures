<?php 

class BinarySearch
{
    private $arr = null;
    private $middle = false;
    private $b = null; // bottom half start index
    private $t = null; // top half start index
    private $split = null;
    
    public function __construct($array)
    {
        $this->arr = $array;
        $this->setSteps();
    }

    private function setSteps()
    {
        if (count($this->arr) % 2 !== 0) {
            // array count is odd
            $this->split = (int) (count($this->arr) - 1) / 2;
            $this->middle = $this->split;
            $this->b = $this->split - 1;
            $this->t = $this->split + 1;
        } else {
            // array count is even
            $this->split = (int) count($this->arr) / 2;
            $this->b = (int) round($this->split, 0, PHP_ROUND_HALF_UP) - 1;
            $this->t = (int) round($this->split, 0, PHP_ROUND_HALF_UP);
        }
    }

    /**
     * @returns int|false numeric index value of the matched array item, false if no match
     */
    public function search($needle)
    {
        if ($found = $this->searchMiddle($needle)) {
            return $found;
        }
        if ($found = $this->binarySearch($needle)) {
            return $found;
        }
        
        return false;
    }
    
    private function searchMiddle($needle)
    {
        if ($this->middle !== null) {
            if ($this->arr[$this->middle] === $needle) {
                return $this->arr[$this->middle];
            }
        }
        
        return false;
    }
    
    private function binarySearch($needle)
    {
        for ($i = 0; $i < $this->split; $i++) {
            $temp_b = $this->b - $i;
            $temp_t = $this->t + $i;
            //NOTE: echo iterations only to demonstrate that the binary search exits early if match is found
            echo 'Iteration # ' . ($i + 1) . "\n";
            echo '' . $i . ', ' . $temp_b ."\n";
            echo '' . $i . ', ' . $temp_t ."\n";
            if ($this->arr[$temp_b] === $needle) {
                return $temp_b;
            }
            if ($this->arr[$temp_t] === $needle) {
                return $temp_t;
            }
        }
        
        return false;
    }
}
?>
<pre>
<?php 
echo '-----------------------------------------------------------------------' . "\n";
$array_even = array(0,1,2,3,4,5,6,7,8,9); // median is (4+5)/2, middle isn't
$array_odd = array(0,1,2,3,4,5,6,7,8); // median is 4, middle is 4
$b_search = new BinarySearch($array_even);
echo var_dump($b_search);
echo var_dump($b_search->search(23));
echo '-----------------------------------------------------------------------' . "\n";
$words_even = array('one','two','three','four','five','six','seven','eight','nine','ten');
$words_odd = array('one','two','three','four','five','six','seven','eight','nine');
$b_search = new BinarySearch($words_even);
echo var_dump($b_search);
echo var_dump($b_search->search('five'));
echo '-----------------------------------------------------------------------' . "\n";
$arr = range(0, rand(1, 999));
$needle = rand(1, 999);
$b_search = new BinarySearch($arr);
echo var_dump($arr);
echo var_dump($b_search->search($needle));
echo "\n";
echo 'Array count : ' . (count($arr)-1) . "\n";
echo 'Needle      : ' . $needle . "\n";
echo '-----------------------------------------------------------------------' . "\n";
?>
</pre>
