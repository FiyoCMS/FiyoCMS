<?php
/**
 * Class for limitting query and creating links for paging
 *
 * @version 1.0
 * @author lucky <bogeyman2007@gmail.com>
 * @filesource paging.php
 * @license http://www.gnu.org/licenses/gpl.html
 */

/**
 * Class nicePaging
 */
class paging{
	private $conn;
	private $page;
	private $totalPages;
	private $separator;
	private $maxPages;
	public function __construct($conn=null){
		$this->conn=$conn;
		$this->separator="";
		$this->maxPages=3;
	}
	
	public function setSeparator($char){
		$this->separator=$char;
	}
	
	/**
	 * Method for setting maximum number of links displayed per page
	 *
	 * @access public
	 * @param int $maxPages Maximum number of links
	 */
	public function setMaxPages($maxPages){
		$this->maxPages=$maxPages;
	}
	
	/**
	 * Method for limitting query result based on the requested page and rows per page 
	 *
	 * @access public
	 * @param string $sql The SQL string (without LIMIT)
	 * @param integer $rowsPerPage Displayed rows per page
	 * @return resultset Resultset from query
	 */
	
	public function pagerQuery($table, $rows = '*', $where = null, $order = null, $rowsPerPage){
		if(SEF_URL)
		$_GET['page'] = _Page;
		$page=isset($_GET['page']) ? $_GET['page'] : 1;
		 $sql = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $sql .= ' WHERE '.$where;
        if($order != null)
            $sql .= ' ORDER BY '.$order;
			
		if($this->conn==null)
			$result = mysql_query($sql);
		else
			$result = mysql_query($sql, $this->conn);
		
		if($rowsPerPage<1) $rowsPerPage = 1;
		$totalRows = mysql_num_rows($result);
		$this->totalPages=intval($totalRows/$rowsPerPage) + ($totalRows%$rowsPerPage==0 ? 0 : 1);
		if($this->totalPages<1){
			$this->totalPages=1;
		}
		
		$this->page=intval($page);
		if($this->page<1){
			$this->page=1;
		}
		if($this->page>$this->totalPages){
			$this->page=$this->totalPages;
		}
		
		$this->page-=1;
		if($this->page<0){
			$this->page=0;
		}
		
		$result=mysql_query($sql." LIMIT ".$this->page*$rowsPerPage.", ".$rowsPerPage);
		$this->page+=1;
		
		return $result;
	}
	
	/**
	 * Method for creating the links for paging
	 *
	 * @access public
	 * @param string $link The page name
	 * @return string Links for paging
	 */
	public function createPaging($link){
		$start=((($this->page%$this->maxPages==0) ? ($this->page/$this->maxPages) : intval($this->page/$this->maxPages)+1)-1)*$this->maxPages+1;
		$end=((($start+$this->maxPages-1)<=$this->totalPages) ? ($start+$this->maxPages-1) : $this->totalPages);
		
		$paging='<ul class="paging pagination">';
		if($this->page>1){			
			$paging.='<li><a href="'.str_replace("?","",$link).'" title="First page">&lt;&lt;</a></li>';
			$paging.='<li><a href="'.$link.$this->separator.'page='.($this->page-1).'" title="Previous page">&lt;</a></li>';
		}
		
		if($start>$this->maxPages){
			$paging.='<li><a href="'.$link.$this->separator.'page='.($start-1).'" title="Page '.($start-1).'">...</a></li>';
		}
		
		for($i=$start;$i<=$end;$i++){
			if($this->page==$i){
				$paging.='<li class="current active"><a>'.$i.'</a></li>';
			}
			else if($i == 1){
				$paging.='<li><a href="'.str_replace("?","",$link).'" title="Page '.$i.'">'.$i.'</a></li>';
			}
			else{
				$paging.='<li><a href="'.$link.$this->separator.'page='.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
			}
		}
		
		if($end<$this->totalPages){
			$paging.='<li><a href="'.$link.$this->separator.'page='.($end+1).'" title="Page '.($end+1).'">...</a></li>';
		}
		
		if($this->page<$this->totalPages){
			$paging.='<li><a href="'.$link.$this->separator.'page='.($this->page+1).'" title="Next page">&gt;</a></li>';
			$paging.='<li><a href="'.$link.$this->separator.'page='.$this->totalPages.'" title="Last page">&gt;&gt;</a></li>';
		}
		
		$paging .= '</ul>';
		if($i > 2)
			return $paging;
		else
			return false;
	}
}
?>