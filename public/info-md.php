<?php
$mdContent = "# PHP Info Report\n\n";
$mdContent .= "**Generated:** " . date('Y-m-d H:i:s') . "\n\n";
$mdContent .= "## System Information\n\n";
$mdContent .= "- PHP Version: " . PHP_VERSION . "\n";
$mdContent .= "- OS: " . PHP_OS . "\n";
$mdContent .= "- Server: " . $_SERVER['SERVER_SOFTWARE'] ?? 'CLI' . "\n\n";

ob_start();
phpinfo();
$mdContent .= "## Full phpinfo()\n\n```\n" . strip_tags(ob_get_clean()) . "\n```";

file_put_contents('phpinfo_report.md', $mdContent);