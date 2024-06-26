<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Draw
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

/**
 * @var \phpOMS\Views\View $this
 */

$image = $this->data['image'];

echo $this->data['nav']->render(); ?>

<div class="row">
    <div class="col-xs-12">
        <section class="box wf-100">
            <div class="inner">
                <form id="drawForm" action="<?= \phpOMS\Uri\UriFactory::build('{/api}draw?{?}&csrf={$CSRF}'); ?>" method="POST">
                    <div class="ipt-wrap">
                        <div class="ipt-first"><input type="text" id="iTitle" name="title" class="wf-100" value="<?= $this->printHtml($image->getMedia()->getName()); ?>"></div>
                        <div class="ipt-second"><input name="save-draw" type="submit" value="<?= $this->getHtml('Save', '0', '0'); ?>"></div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box wf-100">
            <div class="tabview tab-1">
                <ul class="tab-links">
                    <li><label for="c-tab-1"><?= $this->getHtml('Start'); ?></label>
                    <li><label for="c-tab-2"><?= $this->getHtml('Layout'); ?></label>
                </ul>
                <div class="tab-content">
                    <input type="radio" id="c-tab-1" name="tabular-1" checked>
                    <div class="tab">
                        <ul class="h-list">
                            <li><i class="g-icon">save</i>
                            <li><i class="g-icon">download</i>
                            <li><i class="g-icon">undo</i>
                            <li><i class="g-icon">redo</i>
                            <li><i class="g-icon">edit</i>
                            <li><i class="g-icon">brush</i>
                            <li><i class="g-icon">ink_eraser</i>
                            <li><i class="g-icon">remove</i>
                            <li><i class="g-icon">check_box_outline_blank</i>
                            <li><i class="g-icon">circle</i>
                            <li><i class="g-icon">format_color_fill</i>
                            <li><i class="g-icon">menu</i>
                            <li><i class="g-icon">format_size</i>
                        </ul>
                    </div>
                    <input type="radio" id="c-tab-2" name="tabular-1">
                    <div class="tab">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="m-draw">
            <section class="box wf-100" style="height: 30%;">
                <div class="inner resizable">
                    <canvas data-src="<?= $this->printHtml($this->request->uri->getBase() . $image->getMedia()->getPath()); ?>" id="canvasImage resizable" name="image" form="drawForm"></canvas>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <section class="box wf-100">
            <div class="inner">
                <form>
                    <table class="layout">
                        <tr><td colspan="2"><label><?= $this->getHtml('Permission'); ?></label>
                        <tr><td><select name="permission">
                                    <option>
                                </select>
                        <tr><td colspan="2"><label><?= $this->getHtml('GroupUser'); ?></label>
                        <tr><td><input id="iPermission" name="group" type="text"><td><button><?= $this->getHtml('Add', '0', '0'); ?></button>
                    </table>
                </form>
            </div>
        </section>
    </div>
</div>