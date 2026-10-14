<?php
// includes/header.php

// 1. Connect to the database
require_once __DIR__ . '/../config/db.php';

// 2. Fetch ALL settings from the schoolDb database into a single array
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// 3. Build the page title dynamically using the array directly
$pageTitle = isset($pageTitle)
    ? $pageTitle . ' | ' . $settings['site_name']
    : $settings['site_name'] . ' - ' . $settings['site_motto'];

// 4. Build the canonical URL dynamically using the array directly
$requestUri   = strtok($_SERVER["REQUEST_URI"] ?? '/', '?');
$canonicalUrl = rtrim($settings['base_url'], '/') . $requestUri;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($pageTitle) ?></title>

    <?php
        $siteLogo = $settings['logo_url'] ?? '/uploads/logo.svg';
        $siteFavicon = $settings['favicon_url'] ?? '/uploads/logo.svg';
    ?>

    <link rel="icon" type="image/svg+xml" href="<?= htmlspecialchars($siteFavicon) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">

    <link rel="stylesheet" href="/assets/css/style.css">

    <script src="/assets/js/main.js" defer></script>
</head>
<body>
    <header class="site-header">
        <a href="/" class="brand" aria-label="<?= htmlspecialchars($settings['site_name'] ?? 'School Home') ?>">
            <img src="<?= htmlspecialchars($siteLogo) ?>" alt="<?= htmlspecialchars($settings['site_name'] ?? 'School') ?> logo" class="site-logo" width="260" height="220">
        </a>
    </header>