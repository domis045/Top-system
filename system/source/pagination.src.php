<?php

class Pagination {
	var $page;
	var $size;
	var $total_records;
	var $link;
	
	function Pagination($page = null, $size = null, $total_records = null) {
		$this->page = $page;
		$this->size = $size;
		$this->total_records = $total_records;
	}
	
	function setPage($page) {
		$this->page = 0+$page;
	}
	
	function setSize($size) {
		$this->size = 0+$size;
	}
	
	function setTotalRecords($total) {
		$this->total_records = 0+$total;
	}

	function setLink($url) {
		$this->link = $url;
	}
	
	function getLimitSql() {
		$sql = "LIMIT " . $this->getLimit();
		return $sql;
	}
		
	function getLimit() {
		if ($this->total_records == 0)
			$lastpage = 0;
		else 
			$lastpage = ceil($this->total_records/$this->size);
		
		$page = $this->page;		
		
		if ($this->page < 1)
			$page = 1;
		else if ($this->page > $lastpage && $lastpage > 0)
			$page = $lastpage;
		else 
			$page = $this->page;
		
		$sql = ($page - 1) * $this->size . "," . $this->size;
		
		return $sql;
	}
	
	function create_links() {
		$totalItems = $this->total_records;
		$perPage = $this->size;
		$currentPage = $this->page;
		$link = $this->link;
		
		$totalPages = floor($totalItems / $perPage);
		$totalPages += ($totalItems % $perPage != 0) ? 1 : 0;

		if ($totalPages < 1 || $totalPages == 1)
			return null;

		$output = null;
				
		$loopStart = 1; 
		$loopEnd = $totalPages;

		if ($totalPages > 5) {
			if ($currentPage <= 3) {
				$loopStart = 1;
				$loopEnd = 5;
			} else if ($currentPage >= $totalPages - 2) {
				$loopStart = $totalPages - 4;
				$loopEnd = $totalPages;
			} else {
				$loopStart = $currentPage - 2;
				$loopEnd = $currentPage + 2;
			}
		}
		
		if ($loopStart != 1)
			$output .= sprintf('<li class="disabledpage"><a href="' . $link . '"></a></li>', '1');
		
		if (!$currentPage)
			$currentPage = 1;
		
		for ($i = $loopStart; $i <= $loopEnd; $i++) {
			$to_p = $i * $perPage;
			$from_p = ($i == 1) ? 1 : $to_p - $perPage;
			
			if ($i == $currentPage)
				$output .= '<li><a href="#" class="currentpage">' . $from_p . ' - ' . $to_p . '</a></li> ';
			else 
				$output .= sprintf('<li><a href="' . $link . '">', $i) . $from_p . ' - ' . $to_p . '</a></li> ';
		}

		return '<div class="pagination"><ul>' . $output . '</ul></div>';
	}
}

?>