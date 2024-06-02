<?php

function construct() {
    load('lib','user');
    load('lib','validate');
}
function indexAction() {
    load_view('index');
}

