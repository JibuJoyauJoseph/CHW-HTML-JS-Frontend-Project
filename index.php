<?php
session_start();
function json_data($name){$path=__DIR__.'/data/'.$name.'.json';if(!file_exists($path))return [];return json_decode(file_get_contents($path),true) ?: [];}
$users=json_data('users');
$roleLabels=['system_admin'=>'System Administrator','national_admin'=>'National Health Administrator','provincial_officer'=>'Provincial Health Officer','district_officer'=>'District Health Officer','sector_supervisor'=>'Sector Health Supervisor','facility_admin'=>'Health Facility Administrator','facility_staff'=>'Health Facility Staff','chw'=>'Community Health Worker','data_clerk'=>'Data Entry Officer','me_officer'=>'Monitoring & Evaluation Officer','auditor'=>'Auditor'];
if(isset($_GET['logout'])){session_destroy();header('Location: index.php');exit;}
if(!isset($_SESSION['user'])){
 if($_SERVER['REQUEST_METHOD']!=='POST'&&!isset($_GET['login'])){include __DIR__.'/includes/landing.php';exit;}
 $error=''; if($_SERVER['REQUEST_METHOD']==='POST'){ $email=strtolower(trim($_POST['email']??''));$password=$_POST['password']??'';foreach($users as $u){if(strtolower($u['email'])===$email && $u['password']===$password){$_SESSION['user']=$u;header('Location: index.php');exit;}}$error='Invalid demo credentials.';}
 include __DIR__.'/includes/login.php';exit;
}
$user=$_SESSION['user'];$page=preg_replace('/[^a-z0-9\-\/]/','',$_GET['page']??'dashboard');
$allowed=['dashboard','chws','households','visits','referrals','reports','report-create','education','events','analytics','users','facilities','locations','audit-logs','import','settings','notifications'];if(!in_array($page,$allowed,true))$page='404';
include __DIR__.'/includes/header.php';
include __DIR__.'/includes/sidebar.php';
?>
<main class="main"><header class="topbar"><button class="mobile-menu" id="menu">☰</button><div><h1><?=htmlspecialchars(ucwords(str_replace(['-','/'],' ',$page)))?></h1><p>Fictional demonstration environment</p></div><div class="top-actions"><a class="icon-button" href="?page=notifications">🔔<span class="dot">3</span></a><div class="user-chip"><span class="avatar"><?=htmlspecialchars(substr($user['name'],0,2))?></span><div><strong><?=htmlspecialchars($user['name'])?></strong><small><?=htmlspecialchars($roleLabels[$user['role']]??$user['role'])?></small></div></div></div></header><div class="content">
<?php
switch($page){
case 'dashboard': include __DIR__.'/pages/dashboard.php';break;
case 'reports': include __DIR__.'/pages/reports.php';break;
case 'report-create': include __DIR__.'/pages/report-create.php';break;
case 'chws': include __DIR__.'/pages/chws.php';break;
case 'households': include __DIR__.'/pages/households.php';break;
case 'visits': include __DIR__.'/pages/visits.php';break;
case 'referrals': include __DIR__.'/pages/referrals.php';break;
case 'education': include __DIR__.'/pages/education.php';break;
case 'events': include __DIR__.'/pages/events.php';break;
case 'users': include __DIR__.'/pages/users.php';break;
case 'facilities': include __DIR__.'/pages/facilities.php';break;
case 'audit-logs': include __DIR__.'/pages/audit-logs.php';break;
case 'analytics': include __DIR__.'/pages/analytics.php';break;
case 'locations': include __DIR__.'/pages/locations.php';break;
case 'notifications': include __DIR__.'/pages/notifications.php';break;
case 'import': include __DIR__.'/pages/import.php';break;
case 'settings': include __DIR__.'/pages/settings.php';break;
default: echo '<div class="empty-page"><span>404</span><h2>Page not found</h2><a class="primary" href="?page=dashboard">Back to dashboard</a></div>';
}
?></div></main></div><script src="assets/js/app.js"></script></body></html>
