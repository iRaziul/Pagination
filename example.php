<?php

use Raziul\Pagination\Paginator;

require __DIR__ . '/vendor/autoload.php';

// Translation [Bengali]
Paginator::setLabels([
	'first' => 'প্রথম',
	'last' => 'শেষ',
	'previous' => 'পূর্ববর্তী',
	'next' => 'পরবর্তী',
	'numbers' => ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯']
]);

// Pagination
$items = 1540;
$perPage = 30;
$page = $_GET['page'] ?? 1;
$pagination = new Paginator($items, $perPage, $page);
$pagination->firstLastLinks(true);

// Helper to Render HTML
echo $pagination->toHtml();

// Pagination in HTML
/* 
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
 */
?>
<style>
	body {
		margin: 0 auto;
		font-family: Roboto;
		font-size: 14px;
		display: grid;
		place-content: center;
	}

	a {
		text-decoration: none;
	}

	.pagination {
		padding: 8px 12px;
		background-color: #fff;
	}

	.pagination .page-item {
		list-style: none;
		display: inline-block;
		margin: 4px;
	}

	.pagination .page-item .page-link {
		padding: 8px 12px;
		border: 1px solid #e0e0e0;
		border-radius: 4px;
		color: #444;
	}

	.pagination .page-item.active .page-link {
		background-color: #5e35b1;
		border-color: #5e35b1;
		color: #fff;
	}

	.pagination .page-item.disabled .page-link {
		color: #888;
		cursor: not-allowed;
	}

	.pagination .page-item:not(.active) .page-link:hover {
		background-color: #e0e0e0;
	}
</style>