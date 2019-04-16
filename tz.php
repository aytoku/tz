//знания php: часть 1 Требуется убрать все ключи с пустыми значениями на PHP
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


//часть 2:Написать собственный класс для работы с MS Office документами
//MS Word document
<?php
//создаем новый объект используя библиотеку COM
$w = new COM("word.application");

//Скрываем приложение MS Word
$w->Visible = 0;

//Создаем новый документ
$w->Documents->Add();

//Отступы в документе
$w->Selection->PageSetup->LeftMargin = '2"';
$w->Selection->PageSetup->RightMargin = '2"';

//Шрифт
$w->Selection->Font->Name = 'Verdana';
$w->Selection->Font->Size = 8;


$w->Selection->TypeText("Привет");

//Сохраняем документ
$w->Documents[1]->SaveAs("C:hello.doc");

//Завершение работы с MS Word и освобождение памяти
$w->quit();
$w->Release();
$w = null;


?>

//MS Excel document
< ?php


$ex = new COM("excel.application");
$ex->Visible = 0;

//Создаем новую книгу
$wkb = $excel->Workbooks->Add();
$sheet = $wkb->Worksheets(1);

//Выбираем активный лист и устанавливаем курсов в область ячейки (2, 4)
$sheet->activate;
$cell = $sheet->Cells(2,4);
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
