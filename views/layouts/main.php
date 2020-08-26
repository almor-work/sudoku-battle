<?php

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
  <meta charset="<?= Yii::$app->charset ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $this->registerCsrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head() ?>
</head>

<body class="d-flex h-100 text-white bg-dark">
  <?php $this->beginBody() ?>
  <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
      <div class="d-flex">
        <h3 class="m-0"><?= Yii::$app->name ?></h3>
        <nav class="nav ml-auto">
          <a class="nav-link js-showTopPlayers" href="#">Top players</a>
        </nav>
      </div>
    </header>

    <main class="py-4 px-md-4">
      <?= $content ?>
    </main>

    <footer class="mt-auto text-white-50 text-center">
      <p>Made by <span class="text-white">Mikhail Chugaev</span> for <a href="https://www.incoma.ru" class="text-white">Incoma</a></p>
    </footer>
  </div>

  <div class="modal fade text-primary" id="modal-topPlayers" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body text-center">
          <h2 class="modal-title" id="exampleModalLabel">Top players</h2>
          <div class="lead pt-4">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">№</th>
                  <th scope="col">Player</th>
                  <th scope="col">Wins</th>
                </tr>
              </thead>
              <tbody class="js-topPlayersTable">
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>