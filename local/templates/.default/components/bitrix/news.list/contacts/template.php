<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
use Bitrix\Main\Config\Option;
$phoneVolgograd = Option::get("grain.customsettings", "phoneVolgograd");
$phone2 = Option::get("grain.customsettings", "phone2");
?>
<!-- Подключенные в шаблоне библиотеки не работают -->
<script src="https://api-maps.yandex.ru/2.1/?apikey=e8b8a634-1cae-457a-a8fc-934c2a8ff7c5&lang=ru_RU&id=yamap" type="text/javascript"></script>
<div class="inner-page__wrap contacts">
 <div class="container">
        <div class="contacts__top">
        <? foreach ($arResult['ITEMS'] as $arItem){
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
            <div class="contacts__column" id="<? echo $this->GetEditAreaId($arItem['ID']); ?>">
                <div class="contacts__name">
                    <div class="contacts__icon">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/contacts__top.png" class="icon-top" alt="">
                        <img src="<?= SITE_TEMPLATE_PATH ?>/template/img/contacts__bottom.png" alt="">
                    </div>
                    <div class="contacts__wrapper">
                        <div class="contacts__props">
                            <div class="contacts__prop">
                                Адрес
                            </div>
                            <div class="contacts__value">
								Россия, <?= $arItem['PROPERTIES']['FILIALS_NAME']['VALUE'] ?><br>
                                <span><?= $arItem['PROPERTIES']['FILIALS_ADRES']['VALUE'] ?></span>
                            </div>
                            <div class="contacts__prop">
                                Email:
                            </div>
                            <div class="contacts__value">
                                <a href="mailto:help@fineroof.ru">help@fineroof.ru</a>
                            </div>
                        </div>
                        <div class="contacts__props">
                            <div class="contacts__prop">Режим работы</div>
                            <div class="contacts__value">
                                <span><?= str_replace(['<br>', '<br/>', '</br>'], '</span> <span>', $arItem['PROPERTIES']['FILIALS_WORK']['~VALUE']) ?></span>
                            </div>
                            <div class="contacts__prop">
                                Телефоны:
                            </div>
                            <div class="contacts__value">
                                <a href="tel:<?= clearPhone($phoneVolgograd); ?>"><?= $phoneVolgograd; ?></a><br>
                                <a href="tel:<?= clearPhone($phone2); ?>"><?= $phone2; ?></a>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        <? } ?>
    </div>
 </div>
    <? foreach ($arResult['ITEMS'] as $key => $arItem) {
        $prop = explode(',', $arItem['PROPERTIES']['COORDINATES']['VALUE']);
        $propsMap['X'][] = $prop[0];
        $propsMap['Y'][] = $prop[1];
        $propsMapKey[] = $key;
    } ?>
    <div class="contacts__map" id="ymap">
        <script>
            maps(<?= CUtil::PhpToJSObject($propsMap)?>, <?= CUtil::PhpToJSObject($propsMapKey)?>);
        </script>
    </div>
    <!-- <div class="contacts__info">
        <a href="tel:<?= clearPhone($phoneVolgograd); ?>" class="contacts__phone callibri_phone"><?= $phoneVolgograd; ?></a>
        <a href="tel:<?= clearPhone($phone2); ?>" class="contacts__phone callibri_phone"><?= $phone2; ?></a>
        <a href="mailto:help@fineroof.ru" class="contacts__mail">help@fineroof.ru</a>
    </div> -->
</div>