<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
?>
<? if ($arResult['SECTIONS']) { ?>
    <ul class="footer__list">
        <? foreach ($arResult['SECTIONS'] as $key => $arSect) {
            $this->AddEditAction($arSect['ID'], $arSect['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSect['ID'], $arSect['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);  ?>
            <li class="footer__item" id="<? echo $this->GetEditAreaId($arSect['ID']); ?>"><a href="<?= $arSect['SECTION_PAGE_URL'] ?>"><?= $arSect['NAME'] ?></a></li>
        <? } ?>
        <li class="footer__item"><a href="/catalog/ograzhdeniya/zabory-iz-profnastila/">Заборы из профнастила</a></li>
    </ul>
<? } ?>