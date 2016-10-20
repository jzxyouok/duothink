<?php

function mp(){
    $mp_session = session('console');
    if(!$mp_session){
        return null;
    }
    return $mp_session;
}