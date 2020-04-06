<?php
    $db = new mysqli('localhost', 'petcoffe_mobile', 'Ykpl.2412', 'petcoffe_vetvn');
    $db->set_charset("utf8");
    $sql = 'select * from pet_news_pet';
    // die($sql);
    $query = $db->query($sql);
    
    while ($row = $query->fetch_assoc()) {
        $sql = 'update pet_news_pet set microchip = "' . str_replace(' ', '', $row['microchip']) . '" where id = ' . $row['id'];
        echo $sql . '<br>';
    }
?>
