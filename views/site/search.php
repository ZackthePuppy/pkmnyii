<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

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

<p>
    Search for???
</p>

<div class="row">
    <div class="col-lg-5">

        <?php $form = ActiveForm::begin(['id' => 'search-form']); ?>

        <?= $form->field($model, 'pkmn')->textInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php if (Yii::$app->session->hasFlash('pkmnNameSubmitted')) : ?>
    <div class="api-index">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-md-6">
                <h2>Data from External API: </h2>

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
<?php elseif (Yii::$app->session->hasFlash('pkmnNameNotFound'))  : ?>
    <div class="alert alert-danger">
        <ul>
                    <li>Not Found. Check the spellings</li>
        </ul>
    </div>
<?php endif ?>