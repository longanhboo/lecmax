<?php
final class Paginationf {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 10;
	public $url = '';
	public $text = '';
	//public $text = 'Showing {start} to {end} of {total} ({pages} Pages)';
	//public $text_first = '|&lt;';
	public $text_first = '';
	//public $text_last = '&gt;|';
	public $text_last = '';
	//public $text_next = '&gt;';
	public $text_next = '';
	//public $text_prev = '&lt;';
	public $text_prev = '';
	public $style_links = 'links';
	public $style_results = 'page_pro';
	public $style = 'results';
	//page_pro
	
	public function render() {
		$total = $this->total;
		//$output = '';
		if ($this->page < 1) {
			$page = 1;
			$output = '';
		} else {
			$page = $this->page;
			
			
		}
		
		$limit = $this->limit;
		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);
		
		$output = '';
		
		/*
		<a href="#" class="page-prev page-dis">Prev</a>
		<a href="#" class="page-next">Next</a>
		*/
		$href = '#';
		if($page>1)
		{
			$href = str_replace('{page}', $page-1, $this->url) . $this->text_first;	
			$output .= '<a href="' . $href . '" class="page-prev" id="prev">Previous</a>';
		}elseif($total>4)
		{
			$output .= '<a style="opacity:0.5" class="page-prev page-dis" id="prev">Previous</a>';
		}

		/*
		if ($num_pages > 1) {
				
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);
			
				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}
						
				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}
			
			
			for ($i = $start; $i <= $end; $i++) {
				if($page == $i)
					$currentpage = '<b>'.$i.'</b>';
				else
					$currentpage = $i;
				//if ($page == $i) {
					//$output .= ' <b>' . $i . '</b> ';
				//} else {
					if($i==$end)
						$tmp='';
					else
						$tmp = '<span>|</span>';
					$output .= ' <a href="' . str_replace('{page}', $i, $this->url) . '" class="cons-page">' . $currentpage . '</a>'. $tmp.'  ';
				//}	
			}
		}
		*/
		$href = "#";
		if (($page)*4 < $total)
		{
			$href = str_replace('{page}', $page+1, $this->url);
			$output .= ' <a href="'.$href.'" class="page-next" id="next">Next</a> ';
		}elseif($total>4)
		{
			$output .= ' <a style="opacity:0.5" class="page-next page-dis" id="next">Next</a> ';
		}
		$find = array(
		              '{start}',
		              '{end}',
		              '{total}',
		              '{pages}'
		              );
		
		$replace = array(
		                 ($total) ? (($page - 1) * $limit) + 1 : 0,
		                 ((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
		                 $total, 
		                 $num_pages
		                 );
		
		return $output;
	}
}
?>