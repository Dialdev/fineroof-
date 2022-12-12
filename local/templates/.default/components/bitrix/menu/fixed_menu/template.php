<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
    <ul class="fixed-menu__list">

        <li class="fixed-menu__item">
            <a href="<?= SITE_DIR ?>" class="fixed-menu__link">Главная</a>
        </li>

        <?
        foreach ($arResult as $arItem):
            if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?>
            <? if ($arItem["SELECTED"]): ?>
            <li class="fixed-menu__item selected">
                <a href="<?= $arItem["LINK"] ?>" class="fixed-menu__link"><?= $arItem["TEXT"] ?></a>
            </li>
        <? else: ?>
            <li class="fixed-menu__item">
                <a href="<?= $arItem["LINK"] ?>" class="fixed-menu__link"<?= $arItem['ITEM_TYPE'] == 'P' ? ' target="_blank"' : ''; ?>><?= $arItem["TEXT"] ?></a>
            </li>
        <? endif ?>

        <? endforeach ?>
    </ul>
<? endif ?>
