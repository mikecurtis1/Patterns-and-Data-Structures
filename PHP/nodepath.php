<?php 

class Node
{
    private $name = '';
    private $data = array();
    private $children = array();
    
    
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
    
    public function setData($arg)
    {
        if (is_array($arg)) {
            $this->data = $arg;
        }
    }
    
    private function insert($arg)
    {
        if ($this->insertable($arg) && $this->nodeIsSet($arg) === false) {
            $this->children[] = $arg;
        }
    }
    
    private function insertable($arg)
    {
        if ($arg instanceof Node) {
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
     * @param array $array optional data array added to last node in the path
     */
    public function insertByPath(&$curr_node, $path='', $array=null)
    {
        if (is_string($path)) {
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
                $new_node->setData($array);
                $curr_node->insert($new_node);
                $next_node = $new_node;
            }
            if ($n !== '') {
                $remaining_path = implode('/', $p);
                while (count($p) > 0) {
                    return $this->insertByPath($next_node, $remaining_path, $array);
                }
            }
        }
    }
    
    private function nodeIsSet($arg)
    {
        foreach ($this->children as $n) {
            if ($this->insertable($arg) && $n->getName() === $arg->getName()) {
                return true;
                break;
            }
        }
        
        return false;
    }
    
    public function getNode($name='')
    {
        foreach ($this->children as $n) {
            if ($n->getName() === $name) {
                return $n;
                break;
            }
        }
        
        return false;
    }
    
    public function getChildren()
    {
        return $this->children;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function nestXML($obj=null, $depth = 1, &$markup) {
        if ($obj === null) {
            $obj = $this;
        }
        $array = $obj->getChildren();
        $indent_chr = "\t";
        $indent_str = str_repeat($indent_chr, $depth);
        foreach ($array as $key => $val) {
            $c=1;
            $node_data = $val->getData();
            $markup .= $indent_str . '<nodeSet level="' . $depth . '">' . "\n";
            $markup .= $indent_chr . $indent_str . '<node ord="' . $c . '">' . "\n";
            $markup .= $indent_chr . $indent_chr . $indent_str . '<name>' . htmlspecialchars($val->getName()) . '</name>' . "\n";
            if (! empty($val->getData())) {
                $markup .= $indent_chr . $indent_chr . $indent_str . '<data>' . "\n";
                foreach ($val->getData() as $key => $value) {
                    $markup .= $indent_chr . $indent_chr . $indent_chr . $indent_str . '<' . htmlspecialchars($key) . '>' . htmlspecialchars($value) . '</' . htmlspecialchars($key) . '>' . "\n";
                }
                $markup .= $indent_chr . $indent_chr . $indent_str . '</data>' . "\n";
            }
            $markup .= $indent_chr . $indent_str . '</node>' . "\n";
            if (is_array($val->getChildren())) {
                $this->nestXML($val, ($depth+1), $markup);
                $markup .= $indent_str . '</nodeSet>' . "\n";
            }
            $c++;
        }
        
        return;
    }
    
    public function nestDiv($obj=null, $depth = 1, &$markup) {
        if ($obj === null) {
            $obj = $this;
        }
        $array = $obj->getChildren();
        $indent_chr = "\t";
        $indent_str = str_repeat($indent_chr, $depth-1);
        foreach ($array as $key => $val) {
            $c=1;
            $markup .= $indent_str . '<div class="nodeSet level_' . $depth . '">' . "\n";
            $node_name = $val->getName();
            $node_data = $val->getData();
            $markup .= $indent_chr . $indent_str . '<div class="node node_' . $c . '">' . "\n";
            $markup .= $indent_chr . $indent_chr . $indent_str . '<div class="name">' . htmlspecialchars($node_name) . '</div>' . "\n";
            if (! empty($val->getData())) {
                $markup .= $indent_chr . $indent_chr . $indent_str . '<div class="data">' . "\n";
                foreach ($val->getData() as $key => $value) {
                    $markup .= $indent_chr . $indent_chr . $indent_chr . $indent_str . '<div class="datum ' . htmlspecialchars($key) . '">' . htmlspecialchars($value) . '</div>' . "\n";
                }
                $markup .= $indent_chr . $indent_chr . $indent_str . '</div>' . "\n";
            }
            $markup .= $indent_chr . $indent_str . '</div>' . "\n";
            if (is_array($val->getChildren())) {
                $c=1;
                $this->nestDiv($val, ($depth+1), $markup);
                $markup .= $indent_str . '</div>' . "\n";
            }
            $c++;
        }
        return;
    }
    
    public function nestList($obj=null, $depth = 1, &$markup) {
        if ($obj === null) {
            $obj = $this;
        }
        $array = $obj->getChildren();
        if (! empty($array)) {
            $indent_chr = "\t";
            $indent_str = str_repeat($indent_chr, $depth-1);
            $markup .= $indent_str . '<ol class="level_' . $depth . '">' . "\n";
            foreach ($array as $key => $val) {
                $markup .= $indent_chr . $indent_str . '<li>' . "\n";
                $markup .= $indent_chr . $indent_str . '<span class="name">' . trim($val->getName()) . '</span>' . "\n";
                if (! empty($val->getData())) {
                    $markup .= $indent_chr . $indent_str . '<ol class="data">' . "\n";
                    foreach ($val->getData() as $key => $value) {
                        $markup .= $indent_chr . $indent_chr . $indent_str . '<li>' . "\n";
                        $markup .= $indent_chr . $indent_chr . $indent_str . '<span class="datum ' . $key . '">' . $value . '</span>' . "\n";
                        $markup .= $indent_chr . $indent_chr . $indent_str . '</li>' . "\n";
                    }
                    $markup .= $indent_chr . $indent_str . '</ol>' . "\n";
                }
                if (is_array($val->getChildren())) {
                    $this->nestList($val, ($depth+1), $markup);
                }
                $markup .= $indent_chr . $indent_str . '</li>' . "\n";
            }
            $markup .= $indent_str . '</ol>' . "\n";
        }
        return;
    }
}
?>
<?php 

$nodeTree = Node::build('root');
$nodeTree->setData(array('123'=>'abc'));
$nodeTree->insertByPath($nodeTree, 'root/A');
$nodeTree->insertByPath($nodeTree, 'root/B');
$nodeTree->insertByPath($nodeTree, 'root/B/C');
$nodeTree->insertByPath($nodeTree, 'root/B/D', array('foo'=>'a','bar'=>'b','baz'=>'c'));
$nodeTree->insertByPath($nodeTree, 'root/B');
$nodeTree->insertByPath($nodeTree, 'root/D/F/G/H/I');
#echo var_dump($nodeTree);

#$markup = '';
#$markup .= '<!DOCTYPE html>' . "\n";
##$nodeTree->nestDiv(null, 1, $markup);
#$nodeTree->nestList(null, 1, $markup);

$markup = '';
$markup .= '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
$markup .= '<nodePath>' . "\n";
$nodeTree->nestXML(null, 1, $markup);
$markup .= '</nodePath>';
header('Content-Type: text/xml; charset=utf-8'); 
echo $markup;

?>
