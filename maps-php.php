<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Карта ЯНДЕКС</title>
</head>
<body>
<pre>
<?php
	//функция получения XML массива с наиденной информацией по заданному метоположению
    function get_XML($adress){
    	$xml = simplexml_load_file('https://geocode-maps.yandex.ru/1.x/?geocode='.$adress);
    	return $xml;
    }

    //задаем метоположение
	$adr = 'с. Барда, ул. Ленина, д. 52г ';
	$name_adr = 'Филиал';
	
	$urlXML = 'https://geocode-maps.yandex.ru/1.x/?geocode='.$adr;

	//получаем XML массив
	$array = get_XML($adr); 

	//Координаты центра объекта
	$pos = $array->GeoObjectCollection->featureMember['0']->GeoObject->Point->pos;
	echo "<b>pos</b>: $pos \n";

	//Верхняя граница области, внутри которой объект рекомендуется показать на карте
	$upperCorner = $array->GeoObjectCollection->featureMember['0']->GeoObject->boundedBy->Envelope->upperCorner;
	echo "<b>upperCorner</b>: $upperCorner \n";

	//Нижняя граница области, внутри которой объект рекомендуется показать на карте
	$lowerCorner = $array->GeoObjectCollection->featureMember['0']->GeoObject->boundedBy->Envelope->lowerCorner;
	echo "<b>lowerCorner</b>: $lowerCorner \n";

	// Разделение строки на массив функцией explode
	$posArr = explode(" ",$pos);
	$posLeft = explode(".",$posArr[0]);
	$posRight = explode(".",$posArr[1]);

	$upperCornerArr = explode(" ",$upperCorner);
	$upperCornerLeft = explode(".",$upperCornerArr[0]);
	$upperCornerRight = explode(".",$upperCornerArr[1]);

	$lowerCornerArr = explode(" ",$lowerCorner);
	$lowerCornerLeft = explode(".",$lowerCornerArr[0]);
	$lowerCornerRight = explode(".",$lowerCornerArr[1]);

	$urlMap = "https://maps.yandex.ru/?text=".$posRight[0].'.'.$posRight[1].$upperCornerRight[0].$upperCornerRight[1].' '.$posLeft[0].'.'.$posLeft[1].$upperCornerLeft[0].$upperCornerLeft[1];
?>
</pre>	

<p><a href="<?= $urlMap ?>">Проверить координаты на карте</a></p>
<p><a href="<?= $urlXML ?>">Просмотреть XML массив</a></p>
<?php 
	/*
	LAT - RIGHT
	LON - LEFT
	*/
	$yandex_lat = $posRight[0].'.'.$posRight[1].$upperCornerRight[0].$upperCornerRight[1];
	$yandex_lon = $posLeft[0].'.'.$posLeft[1].$upperCornerLeft[0].$upperCornerLeft[1];
	$LON = $posLeft[0].'.'.$posLeft[1].$lowerCornerLeft[0].$lowerCornerLeft[1];
	$LAT = $posRight[0].'.'.$posRight[1].$lowerCornerRight[0].$lowerCornerRight[1];
	$TEXT = $name_adr;
 ?>
<p>Данные для виджета Яндекс.Карты в Битрикс</p>

<pre>
"MAP_DATA" => "a:4:{s:10:
            \"yandex_lat\";d:<?= $yandex_lat ?>;s:10:
            \"yandex_lon\";d:<?= $yandex_lon ?>;s:12:
            \"yandex_scale\";i:16;s:10:
            \"PLACEMARKS\";a:1:{i:0;a:3:{s:3:
            \"LON\";d:<?= $LON ?>;s:3:
            \"LAT\";d:<?= $LAT?>;s:4:
            \"TEXT\";s:30:\"<?= $name_adr ?>\";}}}",
</pre>

</body>
</html>
