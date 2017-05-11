<?php 
// make a list of random numbers
$length = 1;
if (isset($_REQUEST['length'])) {
    $length = $_REQUEST['length'];
}
$arr = range(0,$length-1);
shuffle($arr);
#$arr = array(1,2,3); // ascending
#$arr = array(3,2,1); // descending
#$arr = array(9,4,3,5,13,6,8,7,7,1,3,50,128,207,2,0); // repeated numbers, with gaps
#$arr = array(1); // single number
?>
<h1>Bubble Sort</h1>
<form action="" method="post">
List length: <input name="length" value="<?php echo $length; ?>" />
<input type="submit" value="sort" />
</form>
<pre>
<?php 
// display initial list
print_r($arr);
echo "START... \n";
// start a processing timer
$iterations = 1;
$time_start = microtime(true);
// set a counter for iterations
$len = count($arr)-1;
// process from the backwards from the end of the array
for ($i=$len; $i > 0; $i--) {
    echo "<hr />\n";
    for ($c=$i-1; $c < $len; $c++) {
        $a = $c;
        $b = $c+1;
        echo "[{$a}][{$b}] ({$arr[$a]} > {$arr[$b]})\n";
        print_r($arr);
        // compare values, sort ascending. use less than to sort descending
        if ($arr[$a] > $arr[$b]) { 
            $tmp = $arr[$a];
            $arr[$a] = $arr[$b];
            $arr[$b] = $tmp;
        }
    }
}
// processing time
echo "<hr/>\n";
echo "...END\n";
print_r($arr);
$time_end = microtime(true);
$time = $time_end - $time_start;
echo "{$time_start} - {$time_end} = {$time} seconds\n";
echo "iterations = {$iterations}\n";
