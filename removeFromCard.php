<?php
var_dump($_GET);
echo '<br/>';

$items=explode(",",substr($_GET['items'],0,-1));
var_dump($items);
echo '<br/>';
$collection="";
foreach( $items as $item){
    if($item != $_GET['item']){
        $collection.=$item.',';
    }
}
// $_POST['items']='jhgjgjhgj';
var_dump($collection);
echo '<br/>';
// $_POST['items']=$collection;
header("Location:./addCard.php?cardItems=".$collection);

?>




