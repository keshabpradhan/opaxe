<?php

function checkLoggedIn(){
    if (!isLoggedIn()){
        header("Location: http://www.rscmme.com");
    }
}

function isLoggedIn(){
    if (isset($_SESSION['login']) && isset($_SESSION['username']))
        return true;
    else
        return false;

}
checkLoggedIn();