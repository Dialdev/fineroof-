<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$classNum = 0;
?>

<div class="inner-page__wrap catalog-list" id="sectionChecked">
    <? for ($i = 1; $i <= count($arResult['SECTIONS']); $i++) {
        $sectionNum = 0;?>
        <div class="catalog-list__row">
        <? foreach ($arResult['SECTIONS'][$i] as $key => $arSection) {
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
            if ($sectionNum === 0) { ?>
            <? }
            $classNum++; ?>
            <div class="catalog-list__block catalog-list__block_mod<?=$classNum?>" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
                <div class="catalog-list__status">
                    <svg>
                        <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/catalog-icons.svg#checkbox"></use>
                    </svg>
                </div>
                <div class="catalog-list__top">
                    <a href="<?= $arSection['SECTION_PAGE_URL'] ?>">
                        <div class="catalog-list__icon"><?
                                ECHO str_replace('#SITE_TEMPLATE_PATH#', SITE_TEMPLATE_PATH, $arSection['UF_SVG']);
                            ?></div>
                        <div class="catalog-list__name"><?= $arSection['NAME'] ?></div>
                    </a>
                </div>
				<ul class="catalog-list__list">
                    <? foreach ($arSection['CHILD'] as $arSectLvl2){ ?>
                        <li class="catalog-list__item">
                            <a href='<?= $arSectLvl2['SECTION_PAGE_URL'] ?>' class='catalog-list__link'><?= $arSectLvl2['NAME'] ?></a>
                        </li>
                    <? } ?>
</ul>
            </div>
            <? if (max(array_keys($arResult['SECTIONS'][$i])) == $key) { ?>
            <? } ?>
            <? $sectionNum++; ?>
        <? } ?>
        </div>
    <? } ?>
</div>
