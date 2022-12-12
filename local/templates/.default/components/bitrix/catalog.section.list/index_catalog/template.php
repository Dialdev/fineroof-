<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
?>

<div class="catalog-index__container">
<? foreach ($arResult['SECTIONS'] as $key => $arSection) {
    $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
?>

      <a href="<?= $arSection['SECTION_PAGE_URL'] ?>" class="catalog__item" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
            <span class="catalog__subwrap">
                <span class="catalog__picture"><?
                    if ($arSection['~UF_SVG']) {
                        ECHO str_replace('#SITE_TEMPLATE_PATH#', SITE_TEMPLATE_PATH, $arSection['~UF_SVG']);
                    } else {
                        ECHO "<img src=\"{$arSection['PICTURE']['SRC']}\" alt=\"\">";
                    }
                ?></span>
                <span class="catalog__name"><?= $arSection['NAME'] ?></span>
            </span>
        </a>

    <?/* if ($key === 0 || $key === 3 || $key === 6) { ?>
    <div class="catalog__row">
    <? } ?>
     <a href="<?= $arSection['SECTION_PAGE_URL'] ?>" class="catalog__item" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
            <span class="catalog__subwrap">
                <span class="catalog__picture"><?
                    if ($arSection['~UF_SVG']) {
                        ECHO str_replace('#SITE_TEMPLATE_PATH#', SITE_TEMPLATE_PATH, $arSection['~UF_SVG']);
                    } else {
                        ECHO "<img src=\"{$arSection['PICTURE']['SRC']}\" alt=\"\">";
                    }
                ?></span>
                <span class="catalog__name"><?= $arSection['NAME'] ?></span>
            </span>
        </a>
    <? if ($key === 2 || $key === 5 || $key === (count($arResult['SECTIONS']) - 1)) { ?>
    </div>
    <? } */?>
<? } ?>
</div>