
<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule("iblock");

$isHeaderRow = true;
$IBLOCK_ID = 5;
$element = new CIBlockElement;

function readCSV($data, $IBLOCK_ID) {
    $elementData = [
        "REQUIRE" => $data[4],
        "DUTY" => $data[5],
        "CONDITIONS" => $data[6],
        "EMAIL" => $data[12],
        "DATE" => date("d.m.Y"),
    ];
    
    foreach ($elementData as $key => &$value) {
        $value = trim($value);
        $value = str_replace("\n", "", $value);
        
        if (stripos($value, "•") !== false) {
            $value = explode("•", $value);
            array_shift($value);
            $value = array_map("trim", $value);
        }
    }
    
    if (in_array($elementData["SALARY_VALUE"], ["-", ""])) {
        $elementData["SALARY_VALUE"] = "";
    } elseif ($elementData["SALARY_VALUE"] === "по договоренности") {
        $elementData["SALARY_VALUE"] = "";
        $elementData["SALARY_TYPE"] = "Договорная";
    } else {
        $arSalary = explode(" ", $elementData["SALARY_VALUE"]);
        
        if (in_array($arSalary[0], ["от", "до"])) {
            $elementData["SALARY_TYPE"] = strtoupper($arSalary[0]);
            array_shift($arSalary);
            $elementData["SALARY_VALUE"] = implode(" ", $arSalary);
        } else {
            $elementData["SALARY_TYPE"] = "=";
        }
    } 
    return $elementData;
}




if (($handle = fopen("vacancy.csv", "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        if ($isHeaderRow) {
            $isHeaderRow = false;
            continue;
        }
        
        $elementData = readCSV($data, $IBLOCK_ID);
        $arLoadProductArray = [
            "MODIFIED_BY" => $USER->GetID(),
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $IBLOCK_ID,
            "PROPERTY_VALUES" => $elementData,
            "NAME" => $data[3],
            "ACTIVE" => end($data) ? "Y" : "N",
        ];
        
        if ($PRODUCT_ID = $element->Add($arLoadProductArray)) {
            echo "Добавлен элемент с ID : " . $PRODUCT_ID . "<br>";
        } 
        else {
            echo "Error: " . $element->LAST_ERROR . "<br>";
        }
    }
    fclose($handle);
}
?>