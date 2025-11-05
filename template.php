<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>




<div class="contact-form">
    <div class="contact-form__head">
        <div class="contact-form__head-title"><?=$arResult['FORM_TITLE']?></div>
        <?php if ($arResult["isFormDescription"]): ?>
            <div class="contact-form__head-text"><?=$arResult['FORM_DESCRIPTION']?></div>
        <?php endif; ?>
    </div>
    
    <? if ($arResult["isFormErrors"] == "Y"): ?><?= $arResult["FORM_ERRORS_TEXT"]; ?><? endif; ?>
    
    <?= str_replace('<form', '<form class="contact-form__form"', $arResult["FORM_HEADER"]) ?>
        
        <div class="contact-form__form-inputs">
            <div class="input contact-form__input">
                <label class="input__label" for="medicine_name">
                    <div class="input__label-text">
                        <?= $arResult["QUESTIONS"]["medicine_name"]["CAPTION"] ?>
                        <? if ($arResult["QUESTIONS"]["medicine_name"]["REQUIRED"] == "Y"): ?><?= $arResult["REQUIRED_SIGN"]; ?><? endif; ?>
                            
                    </div>
                    <?= str_replace('<input', '<input class="input__input"', $arResult["QUESTIONS"]["medicine_name"]["HTML_CODE"]) ?>
                    <div class="input__notification">Поле должно содержать не менее 3-х символов</div>
                </label>
        </div>

        <div class="input contact-form__input">
            <label class="input__label" for="medicine_company">
                <div class="input__label-text">
                    <?= $arResult["QUESTIONS"]["medicine_company"]["CAPTION"] ?>
                    <? if ($arResult["QUESTIONS"]["medicine_company"]["REQUIRED"] == "Y"): ?><?= $arResult["REQUIRED_SIGN"]; ?><? endif; ?>
                </div>
                <?= str_replace('<input', '<input class="input__input"', $arResult["QUESTIONS"]["medicine_company"]["HTML_CODE"]) ?>
                <div class="input__notification">Поле должно содержать не менее 3-х символов</div>
                </label>
        </div>

        <div class="input contact-form__input">
            <label class="input__label" for="medicine_email">
                <div class="input__label-text">
                    <?= $arResult["QUESTIONS"]["medicine_email"]["CAPTION"] ?>
                    <? if ($arResult["QUESTIONS"]["medicine_email"]["REQUIRED"] == "Y"): ?><?= $arResult["REQUIRED_SIGN"]; ?><? endif; ?>
                </div>
                <?= str_replace('<input', '<input class="input__input"', $arResult["QUESTIONS"]["medicine_email"]["HTML_CODE"]) ?>
                <div class="input__notification">Неверный формат почты</div>
            </label>
        </div>

        <div class="input contact-form__input">
            <label class="input__label" for="medicine_phone">
                <div class="input__label-text">
                    <?= $arResult["QUESTIONS"]["medicine_phone"]["CAPTION"] ?>
                    <? if ($arResult["QUESTIONS"]["medicine_phone"]["REQUIRED"] == "Y"): ?><?= $arResult["REQUIRED_SIGN"]; ?><? endif; ?>
                </div>
                <?= str_replace('<input', '<input class="input__input"', $arResult["QUESTIONS"]["medicine_phone"]["HTML_CODE"]) ?>
            </label>
        </div>

        <div class="contact-form__form-message">
            <div class="input">
                <label class="input__label" for="medicine_message">
                    <div class="input__label-text">
                        <?= $arResult["QUESTIONS"]["medicine_message"]["CAPTION"] ?>
                        <? if ($arResult["QUESTIONS"]["medicine_message"]["REQUIRED"] == "Y"): ?><?= $arResult["REQUIRED_SIGN"]; ?><? endif; ?>
                    </div>
                    <?= str_replace('<textarea', '<textarea class="input__input"', $arResult["QUESTIONS"]["medicine_message"]["HTML_CODE"]) ?>
                    <div class="input__notification"></div>
                </label>
            </div>
        </div>
            
        <div class="contact-form__bottom">
            <div class="contact-form__bottom-policy">Нажимая &laquo;Отправить&raquo;, Вы&nbsp;подтверждаете, что
                ознакомлены, полностью согласны и&nbsp;принимаете условия &laquo;Согласия на&nbsp;обработку персональных
                данных&raquo;.
            </div>
        <button type="submit" name="web_form_submit" value="Оставить заявку" class="form-button contact-form__bottom-button">
            <div class="form-button__title">Оставить заявку</div>
        </button>


        </div>
    <?= $arResult["FORM_FOOTER"] ?>
</div>


