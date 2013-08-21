<?php

#####  Create the page navigation links

if ($total_num_rows > ROWS_PER_PAGE) {  //  Test whether there is more than one page

	echo "<p>";

	//  Determine total number of pages
	$num_pages = ceil( (float) $total_num_rows / (float) ROWS_PER_PAGE);

	//  Display link to previous page unless current page is first page
	if ($page_num != 1) {
		echo "<a href=\"" . $this_page_name . ".php?page_num=" . ($page_num - 1) . "\">Prev</a>"; 
	}

	//  Display page number list, with links to all but current page
	for ($page = 1; $page <= $num_pages; $page++) {
		if ($page != $page_num) {
			echo "<a href=\"" . $this_page_name . ".php?page_num=$page\"> $page</a>";
		} else {
			echo " $page";
			}
		}

	//  Display link to next page unless current page is last page
	if ($page_num != $num_pages) {
		echo "<a href=\"" . $this_page_name . ".php?page_num=" . ($page_num + 1) . "\"> Next</a>"; 
	}
	echo "</p>";

}
?>