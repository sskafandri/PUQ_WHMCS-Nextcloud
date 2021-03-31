<?php
/*
 +-----------------------------------------------------------------------------------------+
 | This file is part of the WHMCS module. "PUQ_WHMCS-nextcloud"                            |
 | The module allows you to manage the Nextcloud server as a product in the system WHMCS.  |
 | This program is free software: you can redistribute it and/or modify it                 |
 +-----------------------------------------------------------------------------------------+
 | Author: Ruslan Poloviy ruslan.polovyi@puq.pl                                            |
 | Warszawa 03.2021 PUQ sp. z o.o. www.puq.pl                                              |
 +-----------------------------------------------------------------------------------------+
*/
function puqNextcloud_TerminateAccount($params) {
    $postvars = array(
      'hash' => md5($params['serverip'].'|'.$params['customfields']['Api key']),
      'command' => 'SuspendAccount',
    );
    $postdata = http_build_query($postvars);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://' . $params['domain'] . ':3033/');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    $answer = curl_exec($curl);

    if(!$answer){
      $result = 'API connection problem.';
      return $result;
    }

    $results = json_decode($answer, true);
    if ($results['err'] != '0'){
        return $results['error'];
    }

    if($results['msg'] == 'Maintenance mode enabled') {
        $result = "success";
    } else {
        $result = $results['msg'];
    }
    if(!$results['msg']){
      $result = 'API connect problem.';
    }

    return $result;

}

function puqNextcloud_SuspendAccount($params) {

    $postvars = array(
      'hash' => md5($params['serverip'].'|'.$params['customfields']['Api key']),
      'command' => 'SuspendAccount',
    );
    $postdata = http_build_query($postvars);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://' . $params['domain'] . ':3033/');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    $answer = curl_exec($curl);

    if(!$answer){
      $result = 'API connection problem.';
      return $result;
    }

    $results = json_decode($answer, true);
      if ($results['err'] != '0'){
        return $results['error'];
      }

    if($results['msg'] == 'Maintenance mode enabled') {
        $result = "success";
    } else {
        $result = $results['msg'];
    }
    return $result;
}

function puqNextcloud_UnsuspendAccount($params) {
    $postvars = array(
      'hash' => md5($params['serverip'].'|'.$params['customfields']['Api key']),
      'command' => 'UnsuspendAccount',
    );
    $postdata = http_build_query($postvars);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://' . $params['domain'] . ':3033/');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    $answer = curl_exec($curl);
    if(!$answer){
      $result = 'API connection problem.';
      return $result;
    }

    $results = json_decode($answer, true);
      if ($results['err'] != '0'){
        return $results['error'];
      }

    if($results['msg'] == 'Maintenance mode disabled') {
        $result = "success";
    } else {
        $result = $results['msg'];
    }
    return $result;

}


function puqNextcloud_ChangePassword($params) {
    $postvars = array(
      'hash' => md5($params['serverip'].'|'.$params['customfields']['Api key']),
      'command' => 'ChangePassword',
      'username' => $params['username'],
      'password' => $params['password']

    );
    $postdata = http_build_query($postvars);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://' . $params['domain'] . ':3033/');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    $answer = curl_exec($curl);

    if(!$answer){
      $result = 'API connection problem.';
      return $result;
    }

    $results = json_decode($answer, true);

      if ($results['err'] != '0'){
        return $results['error'];
      }

    if($results['msg'] == 'Successfully reset password for '.$params['username']) {
        $result = "success";
    } else {
        $result = $results['msg'];
    }
    return $result;
}

function puqNextcloud_ClientArea($params) {

$code = '
<hr><b>'. Lang::trans('serverusername').'</b> : '. $params['username']. '<br>
<input type="button" value="'. Lang::trans('clickheretologin').'" onClick="window.open(\'https://'.$params['domain'].'\')" />';

    $postvars = array(
      'hash' => md5($params['serverip'].'|'.$params['customfields']['Api key']),
      'command' => 'status',
    );
    $postdata = http_build_query($postvars);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://' . $params['domain'] . ':3033/');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    $answer = curl_exec($curl);
    if(!$answer){
      $fieldsarray = 'API Connection Status: API connection problem.';
      return $fieldsarray;
    }
    $results = json_decode($answer, true);
    if ($results['err'] != '0'){
      $fieldsarray = 'API Connection Status: API answer: '.$results['error'];
      return $fieldsarray;
    }

    $code = $code . '<hr>API Connection Status : <b>API Connection OK</b>';
    $code = $code . '<br><b>Disk status</b><br> Total: '.round($results['msg']['disk_total'] / '1000' / '1024'/ '1024') .' Gb <b>|</b>';
    #$code = $code . 'Free: '.round($results['msg']['disk_free'] / '1000' / '1024'/ '1024') .' Gb , '.round('100' * $results['msg']['disk_free'] / $results['msg']['disk_total']).'%</b>|';
    $code = $code . 'Used: '.round($results['msg']['disk_used'] / '1000' / '1024'/ '1024') .' Gb , '.round('100' * $results['msg']['disk_used'] / $results['msg']['disk_total']).'%</b>|';

    return $code;
}

function puqNextcloud_UsageUpdate($params) {

    $postvars = array(
      'hash' => md5($params['serverip'].'|'.$params['customfields']['Api key']),
      'command' => 'UsageUpdate',
    );
    $postdata = http_build_query($postvars);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://' . $params['domain'] . ':3033/');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    $answer = curl_exec($curl);
    if(!$answer){
      $result = 'API connection problem.';
      return $result;
    }
    $results = json_decode($answer, true);
    if ($results['err'] != '0'){
      return $results['error'];
    }

        update_query("tblhosting",array(
        "diskusage"=>$results['msg']['used']/1000/1000,
        "disklimit"=>$results['msg']['total']/1000/1000,
        "bwusage"=>"0",
        "bwlimit"=>"0",
        "lastupdate"=>"now()",),array("server"=>$params['serverid'], "domain"=>$params['domain']));

}

function puqNextcloud_AdminServicesTabFields($params) {

    $postvars = array(
      'hash' => md5($params['serverip'].'|'.$params['customfields']['Api key']),
      'command' => 'status',
    );
    $postdata = http_build_query($postvars);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://' . $params['domain'] . ':3033/');
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    $answer = curl_exec($curl);
    if(!$answer){
      $fieldsarray = array('API Connection Status' => '<div class="errorbox">API connection problem.</div>');
      return $fieldsarray;
    }
    $results = json_decode($answer, true);
    if ($results['err'] != '0'){
      $fieldsarray = array('API Connection Status' => '<div class="errorbox">API answer: '.$results['error'].'</div>');
      return $fieldsarray;
    }

    $fieldsarray = array(
     'API Connection Status' => '<div class="successbox">API Connection OK</div>',
     'Disk status' => '
                      <b>Total:</b> '.round($results['msg']['disk_total'] / '1000' / '1024'/ '1024') .' Gb <b>|</b>
                      <b>Free:</b> '.round($results['msg']['disk_free'] / '1000' / '1024'/ '1024') .' Gb , '.round('100' * $results['msg']['disk_free'] / $results['msg']['disk_total']).'%<b>|</b>
                      <b>Used:</b> '.round($results['msg']['disk_used'] / '1000' / '1024'/ '1024') .' Gb , '.round('100' * $results['msg']['disk_used'] / $results['msg']['disk_total']).'%<b>|</b>',

    );
    return $fieldsarray;
}

?>
