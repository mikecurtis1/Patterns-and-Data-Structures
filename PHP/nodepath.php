<?php 

class Member
{
    private $name = '';
    private $value = '';
    
    private function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
    
    public static function build($name='', $value='')
    {
        if (is_string($name) && is_string($value)) {
            return new Member($name, $value);
        } else {
            return false;
        }
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getValue()
    {
        return $this->value;
    }
}

class Node
{
    private $name = '';
    private $arr = array();
    
    private function __construct($name)
    {
        $this->name = $name;
    }
    
    public static function build($name='')
    {
        if (is_string($name)) {
            return new Node($name);
        } else {
            return false;
        }
    }
    
    private function insert($arg)
    {
        if ($this->insertable($arg) && $this->nodeIsSet($arg) === false) {
            $this->arr[] = $arg;
        }
    }
    
    private function insertable($arg)
    {
        if ($arg instanceof Node || $arg instanceof Member || $arg === null) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Recursively inserts a set of nested nodes
     * 
     * @param Node $curr_node
     * @param string $path a slash delimited path of node names
     * @param Node|Member|null $arg the final node added at the end of the node path
     */
    public function insertByPath(&$curr_node, $path='', $arg=null)
    {
        if (is_string($path) && $this->insertable($arg)) {
            $p = explode('/', $path);
            $n = array_shift($p);
            if ($n !== '') {
                $remaining_path = implode('/', $p);
                $new_node = self::build($n);
                if (count($p) === 0 && $arg !== null) {
                    $new_node->insert($arg);
                }
                $curr_node->insert($new_node);
                while (count($p) > 0) {
                    return $this->insertByPath($new_node, $remaining_path, $arg);
                }
            }
        }
    }
    
    private function nodeIsSet($arg)
    {
        foreach ($this->arr as $n) {
            if ($this->insertable($arg) && $n->getName() === $arg->getName()) {
                return true;
                break;
            }
        }
        
        return false;
    }
    
    public function getNode($name='')
    {
        foreach ($this->arr as $n) {
            if ($n instanceof Node && $n->getName() === $name) {
                return $n;
                break;
            }
        }
    }
    
    public function getArray()
    {
        return $this->arr;
    }
    
    public function getName()
    {
        return $this->name;
    }
}
?>
<pre>
<?php 
echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
$z = Node::build('Z'); // create root node
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
$z->insertByPath($z, 'A');
$z->insertByPath($z, 'B'); // will not insert node with duplicate name
$z->insertByPath($z, 'B');
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
$z->insertByPath($z, 'C', Node::build('D'));
#$z->insertByPath($z, 'C/D'); // syntactic difference only
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
$z->insertByPath($z, 'E/F', Node::build('G'));
$z->insertByPath($z, 'O/P/Q');
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
$z->insertByPath($z, 'H/I', Member::build('j', 'bar'));
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
$z->insertByPath($z, 'K/I', 1); // will not insert node for non-insertable
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
$z->insertByPath($z, 'L/M', Member::build('n', 'baz'));
echo var_dump($z);
?>
</pre>
