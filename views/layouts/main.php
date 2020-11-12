<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\SbadminAsset;

SbadminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body id="page-top">
<?php $this->beginBody() ?>

<div id="wrapper">

  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-shield-alt"></i>
      </div>
      <div class="sidebar-brand-text mx-3">DPO Tool <sup>0.2</sup></div>
    </a>

    <div class="sidebar-heading mt-3">
      GDPR Contexts
    </div>

    <li class="nav-item">
      <a class="nav-link" href="<?= Url::to(['site/index']) ?>">
        <i class="fas fa-fw fa-play"></i>
        <span>Evaluate Business Process</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?= Url::to(['site/gdprbpmn']) ?>">
        <i class="fas fa-fw fa-play"></i>
        <span>GDPR-BPMN Analyzer</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?= Url::to(['site/dpia']) ?>">
        <i class="fas fa-fw fa-play"></i>
        <span>DPIA</span></a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?= Url::to(['site/breach']) ?>">
        <i class="fas fa-fw fa-play"></i>
        <span>Data Breach</span></a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
      Process Models
    </div>


    <li class="nav-item">
      <a class="nav-link" href="<?= Url::to(['diagram/all']) ?>">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>All BPMN Models</span>
      </a>
    </li>

  </ul>

  <div id="content-wrapper" class="d-flex flex-column">

    <div id="content">

      <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
          <i class="fa fa-bars"></i>
        </button>

        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
          <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>

        <ul class="navbar-nav ml-auto">

          <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-search fa-fw"></i>
            </a>

            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
              <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                  <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </li>

          <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-bell fa-fw"></i>
            </a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
              <h6 class="dropdown-header">
                Alerts Center
              </h6>
              <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
            </div>
          </li>

          <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-envelope fa-fw"></i>
            </a>

            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
              <h6 class="dropdown-header">
                Message Center
              </h6>
              <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
            </div>
          </li>

          <div class="topbar-divider d-none d-sm-block"></div>

          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">User</span>
              <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
            </a>
          </li>

        </ul>

      </nav>

      <div class="container-fluid">
        <?= $content ?>

       
      </div>

      </div>
    </div>

  </div>
    <footer class="sticky-footer bg-white">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright &copy; 2020</span>
        </div>
      </div>
    </footer>
  </div>

</div>

<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="login.html">Logout</a>
      </div>
    </div>
  </div>
</div>
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
