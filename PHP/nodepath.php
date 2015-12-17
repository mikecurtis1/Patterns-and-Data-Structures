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
     * Recursively inserts a path of nodes
     * 
     * @param Node $curr_node
     * @param string $path a slash delimited path of node names
     * @param Node|Member|null $arg the final node added at the end of the node path
     */
    //TODO: simplify this method!
    public function insertByPath(&$curr_node, $path='', $arg=null)
    {
        if (is_string($path) && $this->insertable($arg)) {
            $p = explode('/', $path);
            $n = array_shift($p);
            if ($curr_node instanceof Node) {
                $curr_name = $curr_node->getName();
            }
            if ($curr_name === $n) {
                if (isset($p[0])) {
                    $n = $p[0];
                }
                if ($next_node = $curr_node->getNode($n)) {
                    $next_node = $next_node;
                } else {
                    $next_node = $curr_node;
                }
                
            } else {
                $new_node = self::build($n);
                $curr_node->insert($new_node);
                $next_node = $new_node;
            }
            if ($n !== '') {
                $remaining_path = implode('/', $p);
                while (count($p) > 0) {
                    return $this->insertByPath($next_node, $remaining_path, $arg);
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

//NOTE: https://en.wikipedia.org/wiki/Node_%28computer_science%29

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
// create root node
$z = Node::build('Z');
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
// add a child to root
$z->insertByPath($z, 'A');
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
// another child added... 
$z->insertByPath($z, 'B');
// ...but, will not insert node with duplicate name
$z->insertByPath($z, 'B');
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
// insert a node at end of path
$z->insertByPath($z, 'C', Node::build('D'));
// syntactically the same a above...
// ...but, insert fails because of duplicate path
$z->insertByPath($z, 'C/D');
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
// insert a deep node path
$z->insertByPath($z, 'E/F/G/H/I');
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
// child nodes (F/G/H/I) here and above can be duplicated, 
// because siblings (E,D) are different nodes 
// the two resulting paths are unique
$z->insertByPath($z, 'D/F/G/H/I');
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
// insert a Member at end of path
$z->insertByPath($z, 'K/L', Member::build('j', 'bar'));
echo var_dump($z);

echo '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n";
// will not insert non-insertable
$z->insertByPath($z, 'M/N', 1);
echo var_dump($z);
?>
</pre>
