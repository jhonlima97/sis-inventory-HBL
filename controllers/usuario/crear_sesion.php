<?php

    $id         = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $nombres    = htmlspecialchars($_POST['nombres'], ENT_QUOTES, 'UTF-8');
    $email      = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $pass_hash  = password_hash($_POST['pass_hash'], PASSWORD_DEFAULT,['cost'=>12]);
    $rol        = htmlspecialchars($_POST['rol'], ENT_QUOTES, 'UTF-8');
    $estado     = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8');

    session_start();

    $_SESSION['S_ID']       = $id;
    $_SESSION['S_NOMBRES']  = $nombres;
    $_SESSION['S_EMAIL']    = $email;
    $_SESSION['S_PASS']     = $pass_hash;
    $_SESSION['S_ROL']      = $rol;
    $_SESSION['S_ESTADO']   = $estado;

?>