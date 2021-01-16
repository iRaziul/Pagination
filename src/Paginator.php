<?php

namespace Raziul\Pagination;

/**
 * Paginator - Just another pagination library for PHP.
 * 
 * @author Raziul Islam <raziul.cse@gmail.com>
 * @link https://raziulislam.com
 * @package Raziul\Pagination
 * @version 1.0
 */
class Paginator
{
	const NUMBER_PLACEHOLDER = '{{PAGE}}';

	/**
	 * Base (first) page number.
	 *
	 * @var integer
	 */
	const BASE_PAGE = 1;

	/**
	 * Total items to paginate
	 *
	 * @var integer
	 */
	private $items;

	/**
	 * The number of items to be shown per page.
	 *
	 * @var integer
	 */
	private $itemsPerPage = 1;

	/**
	 * Current page number
	 *
	 * @var integer
	 */
	private $currentPage;

	/**
	 * The number of links to display on each side of current page link.
	 *
	 * @var integer
	 */
	private $adjacent = 2;

	/**
	 * State of the first and last page links.
	 *
	 * @var boolean
	 */
	private $showFirstLastLinks = false;

	/**
	 * Current page url.
	 *
	 * @var string
	 */
	private $pageUrl = '?page={{PAGE}}';

	/**
	 * Labels for the links
	 *
	 * @var array
	 */
	private static $labels = [
		'first' => 'First',
		'last' => 'Last',
		'next' => 'Next',
		'previous' => 'Previous',
		'goto' => 'Goto page {{PAGE}}',
		'numbers' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
	];


	/**
	 * Create Paginator instance
	 *
	 * @param integer $totalItems		Number of total items.
	 * @param integer $perPage			Number of items to show per page.
	 * @param integer $currentPage		Current page number.
	 */
	public function __construct(int $totalItems, int $perPage, int $currentPage)
	{
		$this->setItems($totalItems)
			->setPerPage($perPage)
			->setCurrentPage($currentPage);
	}

	/**
	 * Set total items for the pagination.
	 *
	 * @param integer $items
	 * @return $this
	 */
	public function setItems(int $items)
	{
		$this->items = $items;
		return $this;
	}

	/**
	 * Set the number of items to be shown per page.
	 *
	 * @param integer $perPage
	 * @return $this
	 */
	public function setPerPage(int $itemsPerPage)
	{
		$this->itemsPerPage = max(1, $itemsPerPage);
		return $this;
	}

	/**
	 * Set the current page number.
	 *
	 * @param integer $currentPage
	 * @return $this
	 */
	public function setCurrentPage(int $currentPage)
	{
		$this->currentPage = max(1, $currentPage);
		return $this;
	}

	/**
	 * Set the labels to be used in pagination links.
	 *
	 * @param array $labels
	 * @return void
	 */
	public static function setLabels(array $labels)
	{
		static::$labels = array_replace(static::$labels, $labels);
	}

	/**
	 * Set page URL to be used for pagination links.
	 *
	 * @param string $url
	 * @return $this
	 */
	public function setPageUrl(string $url)
	{
		$this->pageUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
		return $this;
	}

	/**
	 * Set the number of links to displayed on each side of current page link.
	 *
	 * @param integer $count
	 * @return $this
	 */
	public function setAdjacent(int $count)
	{
		$this->adjacent = $count;
		return $this;
	}

	/**
	 * Show/Hide first last page links.
	 *
	 * @param boolean $state
	 * @return $this
	 */
	public function firstLastLinks(bool $state = true)
	{
		$this->showFirstLastLinks = $state;
		return $this;
	}

	/**
	 * Returns the first page number.
	 *
	 * @return integer
	 */
	public function firstPage()
	{
		return self::BASE_PAGE;
	}

	/**
	 * Returns the last available page number.
	 *
	 * @return integer
	 */
	public function lastPage()
	{
		return (int) ceil($this->items / $this->itemsPerPage);
	}

	/**
	 * Returns current page number.
	 *
	 * @return integer
	 */
	public function currentPage()
	{
		return $this->currentPage;
	}

	/**
	 * Returns the number of items to shown per page.
	 *
	 * @return integer
	 */
	public function perPage()
	{
		return $this->itemsPerPage;
	}

	/**
	 * Returns the offset number for current page.
	 *
	 * @return integer
	 */
	public function offset()
	{
		return ($this->currentPage - 1) * $this->itemsPerPage;
	}

	/**
	 * Returns the URL for a given page number.
	 *
	 * @param integer $page
	 * @return string
	 */
	public function url(int $page)
	{
		return str_replace(self::NUMBER_PLACEHOLDER, max(1, $page), $this->pageUrl);
	}

	/**
	 * Returns the URL for the first page.
	 *
	 * @return string
	 */
	public function firstPageUrl()
	{
		return $this->url(self::BASE_PAGE);
	}

	/**
	 * Returns the URL for the last page.
	 *
	 * @return string
	 */
	public function lastPageUrl()
	{
		return $this->url($this->lastPage());
	}

	/**
	 * Returns the URL for the next page.
	 *
	 * @return string|null
	 */
	public function nextPageUrl()
	{
		if ($this->hasNextPage()) {
			return $this->url($this->currentPage + 1);
		}
	}

	/**
	 * Returns the URL for the previous page.
	 *
	 * @return string|null
	 */
	public function previousPageUrl()
	{
		if ($this->hasPreviousPage()) {
			return $this->url($this->currentPage - 1);
		}
	}

	/**
	 * Get the number of the first item in the slice.
	 *
	 * @return integer
	 */
	public function firstItem()
	{
		return $this->items > 0 ? $this->offset() + 1 : 0;
	}

	/**
	 * Get the number of the last item in the slice.
	 *
	 * @return integer
	 */
	public function lastItem()
	{
		return $this->items > 0 ? ($this->firstItem() + $this->itemsPerPage - 1) : 0;
	}

	/**
	 * Returns the number of total items.
	 *
	 * @return integer
	 */
	public function totalItems()
	{
		return (int) $this->items;
	}

	/**
	 * Determine if there are enough items to split into multiple pages.
	 *
	 * @return boolean
	 */
	public function hasPages()
	{
		return $this->items > $this->itemsPerPage;
	}

	/**
	 * Determine if there are previous pages or not.
	 *
	 * @return boolean
	 */
	public function hasPreviousPage()
	{
		return $this->currentPage > self::BASE_PAGE;
	}

	/**
	 * Determine if there are more pages or not.
	 *
	 * @return boolean
	 */
	public function hasNextPage()
	{
		return $this->currentPage < $this->lastPage();
	}

	/**
	 * Determine if currently on the first page or not.
	 *
	 * @return boolean
	 */
	public function onFirstPage()
	{
		return $this->currentPage === self::BASE_PAGE;
	}

	/**
	 * Determine if currently on the last page or not.
	 *
	 * @return boolean
	 */
	public function onLastPage()
	{
		return $this->currentPage >= $this->lastPage();
	}

	/**
	 * Returns the pagination data as array.
	 *
	 * @return array
	 */
	public function toArray()
	{
		return [
			'current_page' => $this->currentPage(),
			'from' => $this->firstItem(),
			'to' => $this->lastItem(),
			'per_page' => $this->perPage(),
			'first_page_url' => $this->firstPageUrl(),
			'last_page_url' => $this->lastPageUrl(),
			'next_page_url' => $this->nextPageUrl(),
			'prev_page_url' => $this->previousPageUrl(),
		];
	}

	/**
	 * Returns the pagination data as json string.
	 *
	 * @return string
	 */
	public function toJson()
	{
		return json_encode($this->toArray());
	}

	/**
	 * Returns an array of numeric pages.
	 *
	 * @return array
	 */
	public function numericPages()
	{
		$start = max(self::BASE_PAGE, $this->currentPage - $this->adjacent);
		$end = $this->adjacent * 2 + self::BASE_PAGE;

		if ($this->currentPage - $this->adjacent > self::BASE_PAGE) {
			$end = $this->currentPage + $this->adjacent;
		}

		$start = min($start, $this->lastPage() - $this->adjacent * 2);
		$end = min($end, $this->lastPage());

		$pages = [];
		for ($i = $start; $i <= $end; ++$i) {
			$pages[] = [
				'number' => $i,
				'url' => $this->url($i),
				'is_current' => $this->currentPage === $i
			];
		}

		return $pages;
	}

	/**
	 * Render HTML
	 *
	 * @param string $before
	 * @param string $after
	 * @return string
	 */
	public function toHtml($before = '<ul class="pagination">', $after = '</ul>')
	{
		$html = $before;

		// First
		if ($this->showFirstLastLinks && ($this->currentPage - $this->adjacent) > self::BASE_PAGE) {
			$html .= '<li class="page-item"><a class="page-link" href="' . $this->firstPageUrl() . '">' . self::$labels['first'] . '</a></li>';
		}

		// Prev
		if ($this->hasPreviousPage()) {
			$html .= '<li class="page-item"><a class="page-link" href="' . $this->previousPageUrl() . '" rel="prev">' . self::$labels['previous'] . '</a></li>';
		} else {
			$html .= '<li class="page-item disabled" aria-disabled="true"><span class="page-link" aria-hidden="true">' . self::$labels['previous'] . '</span></li>';
		}

		// Numeric Pages
		foreach ($this->numericPages() as $page) {
			// i18n numbers
			$id = str_ireplace(array_keys(self::$labels['numbers']), self::$labels['numbers'], $page['number']);

			if ($page['is_current']) {
				$html .= '<li class="page-item active" aria-current="page"><span class="page-link">' . $id . '</span></li>';
			} else {
				$html .= '<li class="page-item"><a class="page-link" href="' . $page['url'] . '">' . $id . '</a></li>';
			}
		}

		// Next
		if ($this->hasNextPage()) {
			$html .= '<li class="page-item"><a class="page-link" href="' . $this->nextPageUrl() . '" rel="next">' . self::$labels['next'] . '</a></li>';
		} else {
			$html .= '<li class="page-item disabled" aria-disabled="true"><span class="page-link" aria-hidden="true">' . self::$labels['next'] . '</span></li>';
		}

		// Last
		if ($this->showFirstLastLinks && $this->currentPage < ($this->lastPage() - $this->adjacent)) {
			$html .= '<li class="page-item"><a class="page-link" href="' . $this->lastPageUrl() . '">' . self::$labels['last'] . '</a></li>';
		}

		$html .= $after;

		return $html;
	}
}
