<?php 

use \App\Controllers\ProjectsController;

include_once '../app/controllers/projectsController.php';

switch ($_GET['projects']):
    case 'show':
        ProjectsController\showAction($conn, $_GET['id']);
        break;
    case 'delete':
        ProjectsController\deleteAction($conn, $_GET['id']);
        break;
    case 'add':
        if (isset($_GET['form'])) {
            ProjectsController\addFormAction($conn);
        }
        elseif (isset($_GET['insert'])) {
            ProjectsController\insertAction($conn);
        }
        break;
    default:
        ProjectsController\indexAction($conn);
        break;
endswitch;