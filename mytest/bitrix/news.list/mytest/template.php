<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);
?>

<div class="news-list">
    <div id="barba-wrapper">
        <div class="article-list">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                    <a class="article-item article-list__item" href=<?= $arItem["DETAIL_PAGE_URL"]?> data-anim="anim-3">
                <?else:?>
                    <div class="article-item article-list__item" data-anim="anim-3">
                <?endif;?>
                    <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
                        <div class="article-item__background"><img src=<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>
                                data-src="xxxHTMLLINKxxx0.39186223192351520.41491856731872767xxx" alt="" />
                        </div>
                    <?endif;?>
                    <div class="article-item__wrapper">
                        <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                            <div class="article-item__title"><?= $arItem["NAME"]?></div>
                        <?endif;?>
                        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                            <div class="article-item__content"><?= $arItem["PREVIEW_TEXT"] ?></div>
                        <?endif;?>
                    </div>
                <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                    </a>
                <?else:?>
                    </div>
                <?endif;?>
            <?endforeach;?>
        </div>
    </div>
</div>
