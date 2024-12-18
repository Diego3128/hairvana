<?php
// settings, variables and constant variables
// define('TEMPLATES_URL', __DIR__ . '/templates/');
define('FUNCTIONS_URL', __DIR__ . '\\functions.php');
define('IMAGES_DIR', $_SERVER["DOCUMENT_ROOT"] . '/images/');

// function includeTemplate(string $templateName, bool $homePage = false)
// {
//     $templatePath = TEMPLATES_URL . $templateName . '.php';
//     $templatePath = formatSeparator($templatePath);
//     include $templatePath;
// }


function debugAndFormat($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}
//escape HTML
function stzr(string | null $html): string
{
    if (is_null($html)) {
        $html = '';
    }
    $s = htmlspecialchars($html);
    return $s;
}
//check if the user is authenticated
function isAuth()
{
    if (!isset($_SESSION["loggedin"])) {
        return header("location: /");
    }
}
//check if the user is an admin
function isAdmin(): void
{
    isAuth();

    if (!isset($_SESSION["admin"])) header("location: /appointment");
}
