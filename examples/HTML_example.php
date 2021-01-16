<?php

use Raziul\Pagination\Paginator;

require __DIR__ . '/../vendor/autoload.php';

$total_items = 1500;
$items_perpage = 20;
$current_page = (int) ($_GET['page'] ?? 1);

$pagination = new Paginator($total_items, $items_perpage, $current_page);

// Pagination in HTML

$html = '<ul class="pagination">';

// First
if ($pagination->onFirstPage()) {
	$html .= '<li class="page-item disabled"><span class="page-link">First</span></li>';
} else {
	$html .= '<li class="page-item"><a class="page-link" href="' . $pagination->firstPageUrl() . '">First</a></li>';
}

// Prev
if ($pagination->hasPreviousPage()) {
	$html .= '<li class="page-item"><a class="page-link" href="' . $pagination->previousPageUrl() . '">Prev</a></li>';
} else {
	$html .= '<li class="page-item disabled"><span class="page-link">Prev</span></li>';
}

foreach ($pagination->numericPages() as $page) {
	if ($page['is_current']) {
		$html .= '<li class="page-item active"><span class="page-link">' . $page['number'] . '</span></li>';
	} else {
		$html .= '<li class="page-item"><a class="page-link" href="' . $page['url'] . '">' . $page['number'] . '</a></li>';
	}
}

// Next
if ($pagination->hasNextPage()) {
	$html .= '<li class="page-item"><a class="page-link" href="' . $pagination->nextPageUrl() . '">Next</a></li>';
} else {
	$html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
}

// Last
if ($pagination->onLastPage()) {
	$html .= '<li class="page-item disabled"><span class="page-link">Last</span></li>';
} else {
	$html .= '<li class="page-item"><a class="page-link" href="' . $pagination->lastPageUrl() . '">Last</a></li>';
}

$html .= '</ul>';

echo $html;

echo "Showing {$pagination->firstItem()} to {$pagination->lastItem()} of {$pagination->totalItems()} entries";


// Stylesheet
echo '<link rel="stylesheet" href="./style.css">';
