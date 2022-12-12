<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(false);
?>
<div class="popup__wrap">
    <div class="popup__cross cross jsClosePopup">
        <svg>
            <use xlink:href="<?= SITE_TEMPLATE_PATH ?>/template/img/icons.svg#cross"></use>
        </svg>
    </div>
    <? if (!empty($arResult["ERRORS"])) { ?>
        <div class="popup__text"><?
            if (stripos(implode('', $arResult["ERRORS"]), 'название')) {
                echo 'Ошибка. Не заполнены обязательное поле Имя. <br>';
            }
            if (stripos(implode('', $arResult["ERRORS"]), 'телефон')) {
                echo 'Ошибка. Не заполнены обязательное поле Телефон. <br>';
            }
            ?></div>
    <? } ?>
    <? if ($_GET['edit_button'] == $arParams['SUBMIT_NAME']) { ?>
        <div class="popup__wrap">
            <div class="popup__title custom-subtitle">
                Заявка <br> на расчет <br/> материалов отправлена
            </div>
            <div class="popup__text">
                В ближайщее время с Вами свяжется менеджер, который поможет в выборе и ответит на Ваши вопросы.
            </div>
        </div>
    <? } else { ?>
        <form name="iblock_add" action="<?= POST_FORM_ACTION_URI ?>" method="post" enctype="multipart/form-data" onsubmit="yaCounter52700329.reachGoal('zakaz'); return true;"

              class="feedback__form _01">
            <?= bitrix_sessid_post(); ?>
            <div class="popup__form">
                <div class="popup__title custom-subtitle">
                    Заказать звонок
                </div>
                <div class="popup__text">
                    Оставьте, пожалуйста, свои контактные данные, и с Вами свяжется менеджер, который поможет с выбором и ответит на Ваши вопросы.
                </div>
                <div class="popup__row">
                    <label class="popup__item text-label">
                        <input class="text-input" type="text" name="PROPERTY[NAME][0]" value="" required>
                        <span>Имя*</span>
                    </label>
                    <label class="popup__item text-label">
                        <input class="text-input" type="text" name="PROPERTY[22][0]"
                               value="<?= $arResult["ELEMENT_PROPERTIES"]["22"][0]['VALUE'] ?>" required>
                        <span>Телефон*</span>
                    </label>
                </div>
                <div class="popup__row">
                    <label class="popup__item text-label">
                        <input class="text-input" type="text" name="PROPERTY[23][0]"
                               value="<?= $arResult["ELEMENT_PROPERTIES"]["23"][0]['VALUE'] ?>" placeholder="">
                        <span>Город</span>
                    </label>
                    <div class="antibot" data-id="calculate"></div>
                </div>
                  <div class="popup__row">
                    <label class="popup__item text-label _checkbox">
                        <input class="checkbox-input" type="checkbox" required="required">
                        Нажимая кнопку "ОТПРАВИТЬ" я даю согласие на <a href="/politika-konfidentsialnosti/">обработку персональных данных</a>
                    </label>
                </div>
                <input type="submit" value="Отправить" class="big-button popup__submit"
                       name="<?= $arParams['SUBMIT_NAME']; ?>">
            </div>
        </form>
        <script>
            $('.antibot').each(function () {
                $(this).html('<input type="text" style="display:none;" name="antibot_' + $(this).data('id') + '" value="http://ok.ok" required="required" > ');
            });
        </script>
    <? } ?>
</div>