<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Context;

$this->setFrameMode(true);

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = ["CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')];

$request = Context::getCurrent()->getRequest();
$brandID = $request->get('brandID');
$arItem = $arResult['SECTIONS'][0];
?>
<? if (!$brandID && $arParams['FILTER_VALUE'] === $arItem[$arParams['FILTER_NAME']]) {
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], $strSectionEdit);
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams); ?>
    <div class="catalog-section__item card-item"
         id="<? echo $this->GetEditAreaId($arItem['ID']); ?>">
        <a href="<?= $arItem['SECTION_PAGE_URL'] ?>"
           class="card-item__top bordered-item">
            <div class="card-item__image">
                <img src="<?= $arItem['PICTURE']['SRC'] ?>" alt="">
            </div>
            <div class="card-item__brand">
                <?= $arItem['NAME'] ?>
            </div>
            <div class="card-item__type">
                <?= $arItem['UF_SUB_TITLE'] ?>
            </div>
            <div class="card-item__desc">
                <?= TruncateText($arItem['DESCRIPTION'], 100) ?>
            </div>
        </a>
        <? if ($arItem['UF_PRICE']): ?>
            <div class="card-item__button classic-button classic-button_green"
            >От <?= is_numeric($arItem['UF_PRICE'])
                    ? $arItem['UF_PRICE'] . ' ₽ – ШТ.'
                    : $arItem['UF_PRICE'] ?>
            </div>
        <? else: ?>
            <div class="card-item__button classic-button classic-button_green"
            >От <?= is_numeric($arItem['ELEMENT_PRICE'])
                    ? $arItem['ELEMENT_PRICE'] . ' ₽ – ШТ.'
                    : $arItem['ELEMENT_PRICE'] ?>
            </div>
        <? endif; ?>
    </div>
<? } ?>