<?php
//ROUTE PROJECTS
//PATTERN: /projects/...
//URL:?projects=...
//ROUTER projects
//ACTION showAction
if (isset($_GET['projects'])):
    include_once '../app/routers/projects.php';
//ROUTE PAR DEFAUT: Les 10 derniers projets
//PATTERN: /
//URL: ?
//CTRL: projetsController
//Action: indexAction
else:
    include_once '../app/controllers/projectsController.php';
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    \App\Controllers\ProjectsController\indexAction($conn, $page);
endif;