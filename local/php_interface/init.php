<?
define("IMAGE_QUALITY", '75');
define("PAGE_404", "/404.php");

function clearPhone($polophonchik)
{
    $rest = '';
    $polophonchik = preg_replace('/[^0-9+]/', '', $polophonchik);

    //если первый символ 8 заменяем на +7
    if ($polophonchik[0] == '8'){
        $rest .= '+7';
        $rest .= substr($polophonchik, 1);
        return $rest;
    }elseif ($polophonchik[0] == '7'){ //если первый символ 7 заменяем на +7
        $rest .= '+7';
        $rest .= substr($polophonchik, 1);
        return $rest;
    }else{
        return $polophonchik;
    }
}

//задаем окончание в цветовых решениях
function textEnd($nums, $pos)
{
    $num = intval(substr($nums, -1));

    if ($pos == 1 && $num == 1) {
        echo 'ое';
    }
    elseif ($pos == 2 && $num == 1) {
        echo 'ие';
    }
    elseif ($pos == 1 && $num >= 2 && $num < 5) {
        echo 'ых';
    }
    elseif ($pos == 2 && $num >= 2 && $num < 5) {
        echo 'ия';
    }
    elseif ($pos == 1) {
        echo 'ых';
    }
    elseif ($pos == 2) {
        echo 'ий';
    }
}


//ресайз картинок на лету))
function imgResize ($arImg, $w, $h) {
    $WH = $w/$h;//0.85
    $image = CFile::ResizeImageGet(
        $arImg,
        array("width" => $w, "height" => $h*$WH),
        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
        true,
        false,
        false,
        IMAGE_QUALITY
    );
    return $image['src'];
}

//Page 404
AddEventHandler("main", "OnAfterEpilog", "Check404Error");
function Check404Error()
{
    global $APPLICATION;
    if (!defined('ERROR_404') || ERROR_404 != 'Y') {
        return;
    }
    if ($APPLICATION->GetCurPage() != PAGE_404) {
        header('X-Accel-Redirect: ' . PAGE_404);
        header("HTTP/1.0 404 Not Found");
        exit();
    }
}

//Заменить весь тайтл
AddEventHandler('main', 'OnEpilog', ['CMainHandlers', 'OnEpilogHandler']);

class CMainHandlers
{
    public static function OnEpilogHandler()
    {
        $title = $GLOBALS['APPLICATION']->GetTitle();
        if ($GLOBALS['APPLICATION']->GetTitle() && $GLOBALS['APPLICATION']->GetCurPage(false) != '/') {
            //$GLOBALS['APPLICATION']->SetPageProperty('title', 'Официальный сайт Fine Roof  - ' . $title);
        }
    }
}

//добовляем символьный код и отправляем письмо
AddEventHandler("iblock", "OnAfterIBlockElementAdd", ["TranslateCode", "OnAfterIBlockElementAddHandler"]);

class TranslateCode
{
    function OnAfterIBlockElementAddHandler(&$arFields)
    {
        if ($arFields["IBLOCK_ID"] === 9 || $arFields["IBLOCK_ID"] === "9") {
	
	        $elem = CIBlockElement::GetList(
		        [],
		        ['IBLOCK_ID' => $arFields["IBLOCK_ID"], 'ID' => $arFields['ID']],
		        false,
		        false,
		        ['*', 'PROPERTY_FILE']
	        )->Fetch();

            $arEventFields = [
                "NAME"  => $arFields['NAME'],
                "PHONE" => strval($arFields['PROPERTY_VALUES'][22]),
                "CITY"  => strval($arFields['PROPERTY_VALUES'][23])
            ];
            CEvent::Send("FEEDBACK_FORM", 's1', $arEventFields, 'N', 7, [$elem['PROPERTY_FILE_VALUE']]);
        }
        //Bitrix\Main\Diag\Debug::writeToFile($elem, '', '/log.txt');
    }
}