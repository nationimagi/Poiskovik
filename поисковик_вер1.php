<?php

$str = $_POST["poisk"];
$str1 = "";
$str_copy = "";

$eech = 0;

//------------------- слово найдено или нет
$f = fopen("библиотека.txt","r"); 
$t = fopen("временно.txt","r+"); 
$e = fopen("вывод.txt","a+");  

$ff = "библиотека.txt"; 
$tt = "временно.txt"; 
$ee = "вывод.txt";

file_put_contents("временно.txt", null); //очистка содержимого
file_put_contents("вывод.txt", null);

//------------------- еще одна поп ытка
while(!feof($f)){ 

//------------------- копируем содержимое библиотеки во временный файл, где можно будет удалять содержимое

file_put_contents("временно.txt", null); //очистка содержимого
fwrite($t, fgets($f));
$str_copy = file_get_contents($tt); //копируем содержимое файла в строчку

//------------------- проверка на полное совпадение
$count = 0;	

if ( strpos (file_get_contents("временно.txt"), $str) ){
		
 
	$eech++;
	fwrite($e, $str_copy);  //копируем правильные строчки из временного файла в вывод
	
} else {
	$count++;
}
 

 
switch(true) {
	//------------------- делаем все маленькими буквами
	case $count == 1:
		$str = mb_convert_case($str, MB_CASE_LOWER);
		
		
		if ( strpos (file_get_contents("временно.txt"), $str) ){

			$eech++;
			fwrite($e, $str_copy);

	break;	   		//		

		} else {
			
			//--------- проверяем окончание
			$str1 = substr($str, 0, -4); //убираем 2 буквы: -2 для латиницы, для русского алфавита -4
			
			if ( strpos (file_get_contents("временно.txt"), $str1) ){

				$eech++;
				fwrite($e, $str_copy);

	break;	   		//		

			} else 
			
				$count++;
			
		}
	
	//------------------- делаем буквы заглавными
	case $count == 2:
		$str = mb_convert_case($str, MB_CASE_TITLE);
		
		if ( strpos (file_get_contents("временно.txt"), $str) ){

			$eech++;
			fwrite($e, $str_copy);

	break;			//
			
		} else {
			
			//--------- проверяем окончание
			$str1 = substr($str, 0, -4); 
			
			if ( strpos (file_get_contents("временно.txt"), $str1) ){

				$eech++;
				fwrite($e, $str_copy);

	break;	   		//		

			} else 
			
			$count++;
		
		}	
	
	//------------------- не найдено или непредвиденная ошибка
	case $count == 3:
		//echo "Не найдено" . "<br>";
		$k=2+2;
		
	break;				//

} //------------------- конец switch

} //------------------- конец while

fclose($t);  //------------------- файл временно.txt закрыт
fclose($e);  //------------------- файл вывод.txt закрыт
fclose($f);  //------------------- файл библиотека.txt закрыт

echo "Найдено совпадений: " . $eech . "<br><br>";  //check
//------------------- 



//------------------- вывод текста из файла вывод.txt
$e = fopen("вывод.txt","r");  
while(!feof($e)){ 
	echo fgets($e)."<br>"; 
}

fclose($e);
//------------------- 

 

?>
