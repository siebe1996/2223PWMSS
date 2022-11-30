<?php

require_once('../../vendor/autoload.php');
require_once('../../config/database.php');
require_once('../../src/Services/DatabaseConnector.php');

$conn = \Services\DatabaseConnector::getConnection();

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/templates');
$twig = new \Twig\Environment(
	$loader,
	[
		'cache' => __DIR__ . '/../../storage/cache',
		'auto_reload' => true
	]
);

$verificationCode = isset($_GET['verificationCode']) ? $_GET['verificationCode'] : '';
$userId = isset($_GET['userId']) ? $_GET['userId'] : '';

$errorMsg = [];

if (trim($verificationCode) !== '' && trim($userId) !== '') {
	$stmt = $conn->prepare('SELECT verification_code,verified FROM users WHERE id = ?');
	$result = $stmt->executeQuery([$userId]);
	$user = $result->fetchAssociative();
	print_r($dbVerificationCode);
	if ($user['verified'] == 1) {
		array_push($errorMsg, 'Je bent al geverifieerd');
	} else if ($dbVerificationCode === $verificationCode) {
		$stmt = $conn->prepare('UPDATE users SET verified=1 WHERE id = ?');
		$result = $stmt->executeStatement([$userId]);
		echo 'email geverifieerd';
	} else {
		array_push($errorMsg, 'Er liep iets fout, vraag bij [account > verifieer je email] een nieuwe email aan');
	}
} else {
	header('location: login.php');
	exit();
}

$tpl = $twig->load('pages/verification.twig');
echo $tpl->render([
	'errorMsg' => $errorMsg
]);
