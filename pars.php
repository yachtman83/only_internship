<?php
function convertToId($pCode, $pKey, $IBLOCK_ID) 
{
    static $pCache = [];

    if (!isset($pCache[$pCode])) {
        $rsEnum = CIBlockPropertyEnum::GetList([], ["CODE" => $pCode, "IBLOCK_ID" => $IBLOCK_ID]);
        while ($arEnum = $rsEnum->Fetch()) {
            $pCache[$pCode][normalize($arEnum["VALUE"])] = $arEnum["ID"];
        }
    }

    if ($pCode === "LOCATION") {
        foreach ($pCache["LOCATION"] as $iblockValue => $id) {
            if (mb_stripos($iblockValue, $pKey) !== false) {
                return $id;
            }
        }
    }
    else {
        return $pCache[$pCode][$pKey] ?? null;
    }
}

function normalize(string $value)
{
    $value = str_replace("\xC2\xA0", ' ', $value);
    $value = str_replace(["\r\n", "\n", "\r"], ' ', $value);
    $value = preg_replace('/\s+/u', ' ', $value);

    return mb_strtolower(trim($value), 'UTF-8');
}

function dataChange($pValue, &$map) 
{
    if(isset($map[$pValue])) {
        return $map[$pValue];
    }
    return $pValue;
}

function parseCsv($data, $IBLOCK_ID, &$typeJ) 
{
    $elementArr = [
        "ACTIVITY" => convertToId("ACTIVITY", normalize(dataChange($data[9], $typeJ)), $IBLOCK_ID),
        "FIELD" => convertToId("FIELD", normalize($data[11]), $IBLOCK_ID),
        "OFFICE" => convertToId("OFFICE", normalize($data[1]), $IBLOCK_ID),
        "LOCATION" => convertToId("LOCATION", normalize($data[2]), $IBLOCK_ID),
        "REQUIRE" => $data[4],
        "DUTY" => $data[5],
        "CONDITIONS" => $data[6],
        "EMAIL" => $data[12],
        "DATE" => date("d.m.Y"),
        "TYPE" => convertToId("TYPE", normalize($data[8]), $IBLOCK_ID),
        "SALARY_TYPE" => "",
        "SALARY_VALUE" => normalize($data[7]),
        "SCHEDULE" => convertToId("SCHEDULE", normalize($data[10]), $IBLOCK_ID)
    ];
    
    foreach ($elementArr as $key => &$value) {
        $value = trim($value);
        $value = str_replace("\n", "", $value);
        
        if (stripos($value, "•") !== false) {
            $value = explode("•", $value);
            array_shift($value);
            $value = array_map("trim", $value);
        }
    }
    
    if (in_array($elementArr["SALARY_VALUE"], ["-", ""])) {
        $elementArr["SALARY_VALUE"] = "";
    } elseif ($elementArr["SALARY_VALUE"] === "по договоренности") {
        $elementArr["SALARY_VALUE"] = "";
        $elementArr["SALARY_TYPE"] = "договорная";
    } else {
        $arSalary = explode(" ", $elementArr["SALARY_VALUE"]);
        
        if (in_array($arSalary[0], ["от", "до"])) {
            $elementArr["SALARY_TYPE"] = $arSalary[0];
            array_shift($arSalary);
            $elementArr["SALARY_VALUE"] = implode(" ", $arSalary);
        } else {
            $elementArr["SALARY_TYPE"] = "=";
        }
    }
    
    $elementArr["SALARY_TYPE"] = convertToId("SALARY_TYPE", normalize($elementArr["SALARY_TYPE"]), $IBLOCK_ID);
    
    return $elementArr;
}

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule("iblock");


$typeJ = [
    "Проектная/Временная работа" => "Временная занятость"  
];

$isHeader = true;
$IBLOCK_ID = 5;
$element = new CIBlockElement;

if (($handle = fopen("vacancy.csv", "r")) !== false) {
    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        if ($isHeader) {
            $isHeader = false;
            continue;
        }
        
        $elementArr = parseCsv($data, $IBLOCK_ID, $typeJ);
        $arLoadProductArray  = [
            "MODIFIED_BY" => $USER->GetID(),
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $IBLOCK_ID,
            "PROPERTY_VALUES" => $elementArr,
            "NAME" => $data[3],
            "ACTIVE" => end($data) ? "Y" : "N",
        ];
        
        if ($PRODUCT_ID = $element->Add($arLoadProductArray)) {
            echo "Добавлен элемент с ID : " . $PRODUCT_ID . "<br>";
        } 
        else {
            echo "Ошибка: " . $element->LAST_ERROR . "<br>";
        }
    }
    fclose($handle);
}
?>