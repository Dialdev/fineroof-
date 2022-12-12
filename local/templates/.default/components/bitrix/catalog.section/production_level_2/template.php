<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Context;

$this->setFrameMode(true);

$res = CIBlockSection::GetList(
    ['SORT' => 'ASC'],
    [
        'IBLOCK_ID' => 1,
        'ID'        => $arResult['IBLOCK_SECTION_ID']
    ],
    true,
    ['*']
)->Fetch();

$request = Context::getCurrent()->getRequest();
$brandID = $request->get('brandID');
?><? if($arResult['ITEMS'] && $arResult['DEPTH_LEVEL'] >= 2 && $res['ELEMENT_CNT'] > 0){ ?>
    <div class="inner-page">
        <div class="container">
            <div class="inner-page__wrap catalog-list">
                <div class="catalog-list__detail catalog-section">
                    <div class="catalog-section__top">
                        <div class="container-inner">
                            <div class="catalog-section__wrapper catalog-section__wrapper_brands">
<?/*<h1 class="catalog-section__title inner-subtitle">
                                    <?= $arResult['NAME'] ?>
</h1>*/?>
                                <? foreach ($arResult['UF_BRAND'] as $arItem) {
                                    if ($arItem['ID']) {
                                        $brandCount[] = $arItem['ID'];
                                    }
                                } ?>
                                <? if($brandCount): ?>
                                    <div class="catalog-section__brand">
                                        <div class="catalog-section__supwrap">
                                            <form action="<?= $APPLICATION->GetCurPage(false) ?>" id="brandlist">
                                                <div class="catalog-section__select brand-select">
                                                    <div class="brand-select__left">
                                                        <div class="brand-select__position">
                                                            Все
                                                            <input type="hidden" name="brand" value="">
                                                        </div>
                                                        <?
                                                        foreach ($arResult['UF_BRAND'] as $arItem): ?>
                                                            <div class="brand-select__position">
                                                                <?= $arItem['UF_NAME'] ?>
                                                                <input type="hidden" name="brand" value="<?= $arItem['UF_XML_ID'] ?>">
                                                            </div>
                                                        <? endforeach; ?>
                                                    </div>
                                                    <div class="brand-select__right"></div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="catalog-section__additional">
                                            Выберите производителя
                                        </div>
                                    </div>
                                <? endif; ?>
                            </div>
                        </div>
                    </div>
                    <!--RESTARTBUFFER-->
                    <div class="catalog-section__desc">
                        <div class="container-inner container-inner_min">
                            <? if ($brandID && $request->isAjaxRequest()): ?>
                                <?= $arResult['UF_BRAND'][$brandID]['UF_FULL_DESCRIPTION'] ?>
                            <?/* else: ?>
                                <?= $res['DESCRIPTION'] */?>
                            <? endif; ?>
                        </div>
                    </div>
                    <!--RESTARTBUFFER-->

                    <div class="catalog-section__list">
                        <div class="container-inner container-inner_medium">
                            <div class="catalog-section__wrapper catalog-section__wrapper_items ajax_pagination">
                                <!--RestartBuffer-->
                                <? foreach ($arResult['ITEMS'] as $arItem) {
                                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
                                    <div class="catalog-section__item card-item" id="<? echo $this->GetEditAreaId($arItem['ID']); ?>">



									<!--div class="card-item__top bordered-item"-->
<a href="<?= $arItem['DETAIL_PAGE_URL'] ?>" class="card-item__top bordered-item">
                                            <? $colorCount = count(array_keys($arItem['PROPERTIES']['COLOR']['VALUE'])); ?>
                                            <? if($colorCount): ?>
                                                <div class="card-item__variables">
                                                    <?= $colorCount; ?> цветов<?= textEnd($colorCount, 1); ?> решен<?= textEnd($colorCount, 2); ?>
                                                </div>
                                            <? endif; ?>

                                            <div class="card-item__image">
												<?/*<a href="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" class="fb" data-title="<?= $arItem['NAME'] ?>" data-type="image" data-fancybox="images">
</a>*/?>
<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="">
                                            </div>
                                            <div class="card-item__brand">
  <?
$res = CIBlockSection::GetByID($arItem['IBLOCK_SECTION_ID']);
$ar_res = $res->GetNext();
?>
<? echo $ar_res['NAME']; ?> <?= $arItem['NAME'] ?>
                                            </div>
                                            <div class="card-item__type">
                                                <?= $arItem['PROPERTIES']['SUB_TITLE']['VALUE'] ?>
                                            </div>
                                            <div class="card-item__desc">
                                                <?= $arItem['PREVIEW_TEXT'] ?>
                                            </div>
                                            <? if($arItem['PROPERTIES']['PROPS']['VALUE']){ ?>
                                                <? foreach ($arItem['PROPERTIES']['PROPS']['VALUE'] as $key => $arProps){ ?>
                                                    <div class="card-item__props">
                                                        <div class="card-item__prop card-item__prop_name"><?= $arProps ?></div>
                                                        <div class="card-item__prop"><?= $arItem['PROPERTIES']['PROPS']['DESCRIPTION'][$key] ?></div>
                                                    </div>
                                                <? } ?>
                                            <? } ?>
                                            <? if($arItem['PROPERTIES']['COLOR']['VALUE']){ ?>
                                                <div class="card-item__props card-item__props_colors">
                                                    <? foreach ($arItem['PROPERTIES']['COLOR']['VALUE'] as $color) {?>
                                                        <?$color = substr($color, 0, 1) == '#' ? $color : '#' . $color?>
                                                        <?$color = substr($color, 1, 2) == '#' ? substr($color, 1) : $color?>
                                                        <div class="card-item__color<?= $color == '#ffffff' ? ' card-item__color_white':'' ?>" style='fill: <?=$color?>;'>
                                                            <svg>
                                                                <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/catalog-icons.svg#color-drop"></use>
                                                            </svg>
                                                        </div>
                                                    <? } ?>
                                                </div>
                                            <? } ?>
									</a>
									<!--/div-->
                                        <span class="card-item__price">
                                            <?= is_numeric($arItem['PROPERTIES']['PRICE']['VALUE'])
                                                ? $arItem['PROPERTIES']['PRICE']['VALUE'] . ' ₽ – ШТ.'
                                                : $arItem['PROPERTIES']['PRICE']['VALUE']
                                            ?>        
                                        </span>
                                        <div class="card-item__button classic-button classic-button_green jsOpenPopup" data-target='.jsCallbackForm'
                                        >Купить</div>
                                    </div>
                                <? } ?>
                                <?
                                $paramName = 'PAGEN_'.$arResult['NAV_RESULT']->NavNum;
                                $paramValue = $arResult['NAV_RESULT']->NavPageNomer;
                                $pageCount = $arResult['NAV_RESULT']->NavPageCount;

                                if ($paramValue < $pageCount) {
                                    $paramValue = (int) $paramValue + 1;
                                    $url = htmlspecialcharsbx( $APPLICATION->GetCurPageParam( sprintf('%s=%s', $paramName, $paramValue), array($paramName, 'AJAX_PAGE',)));
                                    echo sprintf('
                                        <div class="ajax-pager-wrap">
                                            <a class="ajax-pager-link inner-photo__button button" data-wrapper-class="ajax_pagination" href="%s">
                                                <div class="catalog-section__pagination">
                                                    Показать следующего производителя «<span class="catalog-section__next">Smart Home</span>»
                                                </div>
                                            </a>
                                        </div>',
                                        $url
                                    );
                                }
                                ?>
                                <!--RestartBuffer-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-block">
        <div class="container container-inner container-inner_min image_resize">
            <?= $arResult['DESCRIPTION'] ?>
        </div>
    </div>
<? } elseif(!$arResult['ITEMS'] && $arResult['DEPTH_LEVEL'] >= 1) { ?>
    <div class="content-block">
        <div class="container container-inner container-inner_min">
            <p style="text-align: center; margin-bottom: 80px">
                К сожелению товары в данной категории отсутствуют.
            </p>
        </div>
    </div>
<? } ?>