      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#"><?php print Yii::app()->params["projectname"]?> </a>
            <div class="nav-collapse collapse">
              <ul class="nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configure <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li>
                        <a href="<?php print Yii::app()->createUrl('user'); ?>">Users</a></li>
                      <li>
                          <a href="<?php print Yii::app()->createUrl('rights/authItem/roles'); ?>">Rights</a></li>
                      <li>
                          <a href="<?php print Yii::app()->createUrl('page'); ?>">Pages</a></li>
                    <li class="divider"></li>
                    <li class="nav-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </div>
      </div>
