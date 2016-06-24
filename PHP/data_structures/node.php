<?php 

class Node
{
    private $count = 0;
    private $last_index = 0;
    
    public function insert($arg=null)
    {
        if ($arg instanceof Node || is_string($arg)) {
            $this->last_index++;
            $this->{$this->last_index} = $arg;
            $this->count++;
        }
    }
    
    public function delete($index=null)
    {
        if (isset($this->{$index})) {
            unset($this->{$index});
            $this->count--;
        } else {
            return false;
        }
    }
    
    public function getMember($index=null)
    {
        if (isset($this->{$index})) {
            return $this->{$index};
        } else {
            return false;
        }
    }
    
    public function setMember($index=null, $str='')
    {
        if (isset($this->{$index}) && is_string($this->{$index}) && is_string($str)) {
            $this->{$index} = $str;
            return true;
        } else {
            return false;
        }
    }
    
    public function emitHTML($node=null, $layer=1, &$html='')
    {
        $html;
        $tab = "\t";
        $tab_whitespace = str_repeat($tab, $layer);
        if ($node ===  null) {
            $node = $this;
        }
        foreach ($node as $i => $property) {
            if (is_numeric($i) && is_string($property)) {
                $html .= $tab_whitespace . '<div class="layer">' . $layer . "\n";
                $html .= $tab_whitespace . $tab . '<div>' . "\n";
                $html .= $tab_whitespace . $tab . $tab . '<div class="index">' . $i . '</div>' . "\n";
                $html .= $tab_whitespace . $tab . $tab . '<div class="datum">' . htmlspecialchars($property) . '</div>' . "\n";
                $html .= $tab_whitespace . $tab . '</div>' . "\n";
                $html .= $tab_whitespace . '</div>' . $layer . "\n";
            } elseif (is_numeric($i) && $property instanceof Node) {
                $html .= $tab_whitespace . '<div class="layer">' . $layer . "\n";
                $html .= $tab_whitespace . $tab . '<div class="node" index="' . $i . '">Node</div>' . "\n";
                $layer++;
                $this->emitHTML($property, $layer, $html);
                $layer=1;
                $html .= $tab_whitespace . '</div>' . $layer . "\n";
            }
        }
        $layer=1;
        
        return $html;
    }
    
    //NOTE: public properties are already iterable
    
    //TODO: sort
}

?>
<pre>
<?php 
$node = new Node();

echo var_dump($node);

$node->insert('foo');
echo var_dump($node);

$node->insert('bar');
echo var_dump($node);
echo var_dump($node->getMember(2));
$node->delete(1);
echo var_dump($node);

$node->insert(new Node());
echo var_dump($node);

//NOTE: properties created dynamically are public by default
#$node->{3} = null;
#echo var_dump($node);

foreach ($node as $i => $property) {
    echo var_dump($property);
}

$node3 = new Node();
$node3->insert('dog');
$node->{3}->insert($node3);
#$node->setMember(3, 'baz'); // replaces the previously inserted node
$node->insert(new Node());
$node->setMember(2, 'baz');


$next_node = new Node();
$next_node->insert('bin');
echo var_dump($next_node);
$node->insert($next_node);

echo var_dump($node);
?>
</pre>
<?php 
$html = $node->emitHTML();
echo $html;
?>
