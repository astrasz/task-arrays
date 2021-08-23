<?php

declare(strict_types=1);

// error_reporting(E_ALL);
// ini_set('dispaly_errors', '1');

// require_once('utiles/debug.php');

function convertMultiDimensionalArray(array $listArr): array
{
    $newListArr = [];
    foreach($listArr as $key=>$value)
    {
        $id = $listArr[$key]['translations']['pl_PL']['category_id'];
        $name = $listArr[$key]['translations']['pl_PL']['name'];
        $newListArr[$id]=$name;
    };
    return $newListArr;
}

function addNameToMainArray(array $iteratingArr, array &$mainArr): array
{
    foreach($iteratingArr as $key=>$value){
        foreach($mainArr as &$item){
            if($item['id']==$key){
                $item = array_merge(
                    array_slice($item, 0, 1, true),
                    ['name'=>$value], 
                    array_slice($item, 1, count($item)-1,true)
                    );
                if(!empty($item['children'])){
                    addNameToMainArray($iteratingArr, $item['children']);
                }
            }
        }
    }
    return $mainArr;
}


$listArr = json_decode(file_get_contents('utiles/list.json'), true);
$treeArr = json_decode(file_get_contents('utiles/tree.json'), true);

$newListArr = convertMultiDimensionalArray($listArr);

// $result = addNameToMainArray($newListArr, $treeArr);
// dump($result);

$result = json_encode(addNameToMainArray($newListArr, $treeArr), JSON_UNESCAPED_UNICODE);

echo($result);









