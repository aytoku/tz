<!--знания php: часть 1 Требуется убрать все ключи с пустыми значениями на PHP-->
<?php

function delete($del_emp) {
    return ($del_emp != NULL);
}

$example = [
    “name” => “Software”,
    “properties” => [
        “version” => “”,
        “size” => 195,
        “param” => 0
    ],
    “author” => [
        [
            “name” => “”,
            “email”=> “”
        ],
        [
            “name” => “Ivan”,
            “email”=> “mail@example.com”
        ]
    ]
];
$example = array_filter($example, "delete");

?>


<!--часть 2:Написать собственный класс для работы с MS Office документами
MS Word document-->
<?php
/*set_error_handler('err_handler');
function err_handler($errno, $errmsg, $filename, $linenum) {
$date = date('Y-m-d H:i:s (T)');
$f = fopen('errors.txt', 'a');
if (!empty($f)) {
$filename  =str_replace($_SERVER['DOCUMENT_ROOT'],'',$filename);
$err  = "$errmsg = $filename = $linenum\r\n";
fwrite($f, $err);
fclose($f);
}
}*/
//ini_set('log_errors', 'On');
//ini_set('error_log', '/var/log/php_errors.log');
//создаем новый объект используя библиотеку COM
$w = new COM("word.application");

//Скрываем приложение MS Word
$w->Visible = 0;

//Создаем новый документ
$w->Documents->Add();

$w->Selection->PageSetup->LeftMargin = '2"';
$w->Selection->PageSetup->RightMargin = '2"';

$w->Selection->Font->Name = 'Serif';
$w->Selection->Font->Size = 8;


$w->Selection->TypeText("Привет");

//Сохраняем документ
$w->Documents[1]->SaveAs("C:hello.doc");

//Завершение работы с MS Word и освобождение памяти
$w->quit();
$w->Release();
$w = null;


?>

<!--MS Excel document-->
<?php


$ex = new COM("excel.application");
$ex->Visible = 0;

//Создаем новую книгу
$wkb = $excel->Workbooks->Add();
$sheet = $wkb->Worksheets(1);

//Выбираем активный лист и устанавливаем курсов в область ячейки (1, 3)
$sheet->activate;
$cell = $sheet->Cells(1,3);
$cell->Activate;

//Записываем в ячейку текст
$cell->value = 'Привет';

$wkb->SaveAs("C:excel.xls");

$wkb->Close(false);
$ex->Workbooks->Close();
$ex->Quit();
unset($sheet);
unset($excel);

?>
<?php
if(isset($_FILES) && $_FILES['inputfile']['error'] == 0){ // Проверка щагрузился ли файл
$destiation_dir = dirname(__FILE__) .'/'.$_FILES['inputfile']['name']; // Директория для размещения файла
move_uploaded_file($_FILES['inputfile']['tmp_name'], $destiation_dir ); // Перемещаем файл в директорию которую хотим
echo 'File Uploaded'; // Файл загрежен
}
else{
echo 'No File Uploaded'; // Файл не загружен
}
?>
<?php
date("Y-m-d H:i:s", time());
$english_format_number = number_format($w);
echo sprintf($w);
?>
<!--$phpexcel = new PHPExcel();
//Знание SQL-->
<!--select temp.group_id as "group_id", COUNT(temp.id) as "count", MIN(temp.id) as "min_id" 
from temp 
group by temp.group_id;-->
SELECT min(id)  AS min_id 
       , group_id
     , count(*) AS row_count 
          
FROM  (
   SELECT id
        , group_id
        , id - row_number() OVER (PARTITION BY group_id ORDER BY id) AS res
   FROM   users
   ) sub
GROUP  BY group_id, res
ORDER  BY min_id;  
