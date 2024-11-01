<?php

require_once "../lib/db_connect.php";
require_once "../lib/accessors.php";
require_once "../lib/user_login_tools.php";

function navbar_generator($elements)
{
    $html = '
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">EIW</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">';
    
    foreach ($elements as $element) {
        $html .= '<li class="nav-item active">';
        $html .= '<a class="nav-link" href="' . $element[1] . '">' . $element[0] . '</a>';
        $html .= '</li>';
    }

    $html .= '
                </ul>
            </div>
        </div>
    </nav>
    <script>
        function inIframe() {
            try {
                return window.self !== window.top;
            } catch (e) {
                return true;
            }
        }
        function remove_navbar() {
            let navbar = document.getElementById("navbar");
            navbar.remove();
        }
        if (inIframe()) {
            remove_navbar();
        }
    </script>';

    return $html;
}

function generate_general_navbar()
{
    $elements = [
        ['Home', '../generic/index.php'],
        ['Question Management', '../administrator/list_questions.php'],
        ['Template Management', '../quizzes/list_quiz_templates.php'],
        ['Module Management','../module/list_modules.php'],
        ['Take Quiz', '../quizzes/start_quiz.php'],
        ['Analytics', '../analysis/dashboard.php'],  
        ['Login', '../generic/login.php'],  
        ['Logout', '../generic/logout.php'],  
    ];
    return navbar_generator($elements);
}

function generic_navbar()
{
    $generic_elements = [
        ['Home', '../generic/index.php'],
        ['Login', '../generic/login.php'],
        ['Signup', '../generic/sign_up.php']
    ];

    return navbar_generator($generic_elements);
}

function learner_navbar()
{
    $learner_elements = [
        ['Home', '../generic/index.php'],
        ['Join class', '../classes/join_class.php'],
        ['Logout', '../generic/logout.php']
       
        
    ];

    return navbar_generator($learner_elements);
}

function educator_navbar()
{
    $educator_navbar = [
        ['Home', '../generic/index.php'],
        ['Question Management', '../administrator/list_questions.php'],
        ['Template Management', '../quizzes/list_quiz_templates.php'],
        ['Module Management','../module/list_modules.php'],
        ['Class Management', '../classes/list_classes.php'],
        ['Logout', '../generic/logout.php']
        
    ];

    return navbar_generator($educator_navbar);
}

function generate_navbar()
{
    if(!is_logged_in())
        return generic_navbar();

    if(is_learner())
        return learner_navbar();

    if(is_educator())
        return educator_navbar();
}

echo generate_navbar();
?>
