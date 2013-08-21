<?php
if ($total_num_rows > ROWS_PER_PAGE) {  //  Test whether we need more than one page

	//  First record is the number of rows in a page (ROWS_PER_PAGE), minus the number of rows on all previous pages (pages - 1 times ROWS_PER_PAGE)
	$start_rec = (($page_num - 1) * ROWS_PER_PAGE);  //  First record to selected

	// Number of rows on current page is the lower value of number of records per page 
	// and rows remaining beginning at first page record (total rows in users table minus first row on page.
	$num_page_rows = min(($total_num_rows - $start_rec), ROWS_PER_PAGE);

} else {  // Only one page of data
	$start_rec = 0;
	$num_page_rows = $total_num_rows;
}
?>
