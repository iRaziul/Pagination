<?php

use Raziul\Pagination\Paginator;

require __DIR__ . '/../vendor/autoload.php';

// Translation [Bengali]
Paginator::setLabels([
	'first' => 'প্রথম',
	'last' => 'শেষ',
	'previous' => 'পূর্ববর্তী',
	'next' => 'পরবর্তী',
	'numbers' => ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯']
]);

// Current Page
$page = $_GET['page'] ?? 1;

$total_items = 1000;
$items_per_page = 20;

// Pagination
$pagination = new Paginator($total_items, $items_per_page, $page);
$pagination->firstLastLinks(true);

// Helper to Render HTML
echo $pagination->toHtml();

// Load stylesheet
echo '<link rel="stylesheet" href="./style.css">';
