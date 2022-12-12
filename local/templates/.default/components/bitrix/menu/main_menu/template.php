<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Config\Option;

$youtube = Option::get("grain.customsettings", "youtube"); ?>

<? if (!empty($arResult)): ?>
    <ul class="navigation__list">

        <li class="navigation__item">
            <a href="<?= SITE_DIR ?>" class="navigation__link">Главная</a>
            <span class="navigation__additional"></span>
        </li>

        <?
        foreach ($arResult as $arItem):
            if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) {
                continue;
            }
            ?>
            <? if ($arItem["SELECTED"]): ?>
            <li class="navigation__item selected">
                <a href="<?= $arItem["LINK"] ?>" class="navigation__link"><?= $arItem["TEXT"] ?></a>
               
            </li>
        <? else: ?>
            <li class="navigation__item">
                <??>
                <a href="<?= stripos($arItem["LINK"], 'http') !== false ? $youtube : $arItem["LINK"] ?>"
                   class="navigation__link"<?= $arItem['ITEM_TYPE'] == 'P' ? ' target="_blank"' : ''; ?>><?= $arItem["TEXT"] ?></a>
                
            </li>
        <? endif ?>

        <? endforeach ?>
    </ul>
<? endif ?>
