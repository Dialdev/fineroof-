<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<div class="search-page">
    <div class="header__search search" style="margin: 0">
        <form action="" method="get">
            <label class="search__label">
                <input type="hidden" name="how" value="r"/>
                <input
                        id="<?= $INPUT_ID ?>"
                        type="text"
                        name="q"
                        autocomplete="off"
                        value="<?= $arResult["REQUEST"]["QUERY"] ?>"
                        placeholder="Введите поисковый запрос"
                        class="text-input search__input"
                        style="width: 100%;">
                <button class="search__submit common-button big-button" type="submit" name="s">Найти</button>
            </label>
        </form>
    </div>

    <noindex>
        <div class="search-advanced">
            <div class="search-advanced-result">
                <? if (is_object($arResult["NAV_RESULT"])): ?>
                    <div class="search-result">Найдено: <?= $arResult["NAV_RESULT"]->SelectedRowsCount() ?></div>
                <? endif; ?>
            </div>
        </div>
    </noindex>

    <div class="search-result">
        <? if (count($arResult["SEARCH"]) > 0): ?>
            <? foreach ($arResult["SEARCH"] as $arItem): ?>
                <div class="search-item">
                    <h4><a href="<?= $arItem["URL"] ?>"><?= $arItem["TITLE_FORMATED"] ?></a></h4>
                    <div class="search-preview"><?= $arItem["BODY_FORMATED"] ?></div>
                    <div class="search-preview __path"><?= $arItem["CHAIN_PATH"] ?></div>
                </div>
            <? endforeach; ?>
            <? if ($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"] ?>
        <? else: ?>
            <? ShowNote('К сожалению, на ваш поисковый запрос ничего не найдено.'); ?>
        <? endif; ?>
    </div>
</div>