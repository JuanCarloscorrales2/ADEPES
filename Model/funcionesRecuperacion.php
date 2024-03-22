<?php

function generarToken(){
    return md5(uniqid(mt_rand(), false));
}




