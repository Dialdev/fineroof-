<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<?if (!empty($arResult)):?>
    <div class="props-table__tabs container-inner">

        <?foreach($arResult as $arItem):
            if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1)
                continue;
            ?>
            <?if($arItem["SELECTED"]):?>
            <div class="props-table__tab jsTab classic-button classic-button_white isActive"><?=$arItem["TEXT"]?></div>
        <?else:?>
            <div class="props-table__tab jsTab classic-button classic-button_white"><?=$arItem["TEXT"]?></div>
        <?endif?>

        <?endforeach?>

    </div>
<?endif?>