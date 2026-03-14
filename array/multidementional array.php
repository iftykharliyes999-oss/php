<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    $marry = array( 
        array(3,6,4,2),
        array(3,6,4,2),
        array(3,6,4,2),
    );

    print_r($marry);

    echo"<br>";

    $arr = [ 
     ["A","T","R","P","W"],
     ["B","C","Q","F","N"],
     ["3","5","2","1","7"],
    ];
    

    print_r($arr);
    echo"<br>";
    echo $arr[1][4];

    $array = [
    ['A', 't', 'r'],
    ['B', 'C', 'y'],
    [3, 5, 2]
];

foreach ($array as $rowIndex => $row) {
    echo "<h3>Row number $rowIndex</h3>";
    
    echo "<ul>";
    foreach ($row as $value) {
        echo "<li>$value</li>";
    }
    echo "</ul>";
}
    ?>
</body>
</html>