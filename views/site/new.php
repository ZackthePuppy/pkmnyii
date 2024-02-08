<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'NEW';
$this->params['breadcrumbs'][] = $this->title;

/**
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the New page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>
 */
?>


<div class="api-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Data from External API:</h2>

            <ul>
                <?php foreach ($data['abilities'] as $item) : ?>
                    <?php foreach ($item as $key => $value) : ?>
                        <?php if (is_array($value)) : ?>
                            <li><?= $key ?>:</li>
                            <ul>
                                <?php foreach ($value as $subKey => $subValue) : ?>
                                    <li><?= $subKey ?>: <?= $subValue ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <li><?= $key ?>: <?= $value ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>

        </div>
    </div>
</div>