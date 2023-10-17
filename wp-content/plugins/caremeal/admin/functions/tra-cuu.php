<?php

require_once( '../../../../wp-config.php');
global $wpdb;
// (2) CONNECT TO DATABASE
try {
  $pdo = new PDO(
    "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME,
    DB_USER, DB_PASSWORD, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false ]
  );
} catch (Exception $ex) {
  die($ex->getMessage());
}



// (3) SEARCH
$stmt = $pdo->prepare("(SELECT id, ten, nang_luong, protein, lipid, glucid, anh_av, url, nl_f1, nl_f2, nl_f3, nl_f4, nl_f5, nl_f6 FROM `wp_cm_nguyen_lieu` WHERE `ten` LIKE ?) UNION (SELECT bs_f1, bs_f2, bs_f3, bs_f4, bs_f5, bs_f6, bs_f7, bs_f8, id, ten, nang_luong, protein, lipid, glucid FROM `wp_cm_mon_an` WHERE `ten` LIKE ?)");
$search_key = $_POST['search-tra_cuu'];
if ($search_key == '' || $search_key == ' ') {
    $search_key = 'knxcjkvnjd';
}
$stmt->execute(["%" . $search_key . "%","%" . $search_key . "%"]);
$results = $stmt->fetchAll();
if (isset($_POST['ajax'])) { echo json_encode($results); }