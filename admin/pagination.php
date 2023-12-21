<?php

/**
 * Company : Nemosofts
 * Detailed : Software Development Company in Sri Lanka
 * Developer : Thivakaran
 * Contact : thivakaran829@gmail.com
 * Contact : nemosofts@gmail.com
 * Website : https://nemosofts.com
 */

	if ($page == 0){$page = 1;}
	$prev = $page - 1;	
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;					

	$paginate = '';
	if($lastpage > 1){	
		$paginate .= "<ul class='pagination'>";

		if ($page > 1){
			$paginate.= "<li><a href='$targetpage?page=$prev' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
		}else{
			$paginate.= "<li><span aria-hidden='true'>&laquo;</span></li>";	
		}
	
		if ($lastpage < 7 + ($stages * 2)){	
			for ($counter = 1; $counter <= $lastpage; $counter++){
				if ($counter == $page){
					$paginate.= "<li class='active'><span class='active'>$counter</span></li>";
				}else{
					$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
			}
		}else if($lastpage > 5 + ($stages * 2))	{

			if($page < 1 + ($stages * 2))		{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++){
					if ($counter == $page){
						$paginate.= "<li class='active'><span class='active'>$counter</span></li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
				$paginate.= "<li>...</li>";
				$paginate.= "<li><a href='$targetpage?page=$LastPagem1'>$LastPagem1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$lastpage'>$lastpage</a></li>";	
				
			}else if($lastpage - ($stages * 2) > $page && $page > ($stages * 2)){
				$paginate.= "<li><a href='$targetpage?page=1'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2'>2</a></li>";
				$paginate.= "<li>...</li>";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++){
					if ($counter == $page){
						$paginate.= "<li class='active'><span class='active'>$counter</span></li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
				$paginate.= "<li>...</li>";
				$paginate.= "<li><a href='$targetpage?page=$LastPagem1'>$LastPagem1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=$lastpage'>$lastpage</a></li>";
				
			}else{
				$paginate.= "<li><a href='$targetpage?page=1'>1</a></li>";
				$paginate.= "<li><a href='$targetpage?page=2'>2</a></li>";
				$paginate.= "<li>...</li>";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++){
					if ($counter == $page){
						$paginate.= "<li class='active'><span class='active'>$counter</span></li>";
					}else{
						$paginate.= "<li><a href='$targetpage?page=$counter'>$counter</a></li>";}					
				}
			}
		}

		if ($page < $counter - 1){ 
			$paginate.= "<li><a href='$targetpage?page=$next' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";
		}else{
			$paginate.= "<li><span aria-hidden='true'>&raquo;</span></li>";
			}
			
		$paginate.= "</ul>";		
    }
  

echo $paginate;
?>