<?php
/*
 * PDF impose:
 * Import all pages from one more existing PDFs, and place col x row pages 
 * on each sheet of the output PDF (imposition). If there are annotations
 * on an imported page these are also imported and scaled or rotated as
 * required.
 * 
 * Required software: PDFlib+PDI or PDFlib Personalization Server (PPS)
 * Required data: PDF documents
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(__FILE__, 2).'/data';

/* By default annotations are also imported. In some cases this
 * requires the Noto fonts for creating annotation appearance streams.
 */
$fontpath = dirname(__FILE__, 3). "/resource/font";
$outfile = "";
$title = "PDF Impose";

$pdffiles = array(
    "markup_annotations.pdf",
    "PLOP-datasheet.pdf",
    "pCOS-datasheet.pdf"
);
$col = 0;
$row = 0;
$scale = 1;          // scaling factor of a page
$rowheight;      // row height for the page to be placed
$colwidth;       // column width for the page to be placed
$sheetwidth = 595;   // width of the sheet
$sheetheight = 842;  // height of the sheet
$maxcols = 2; $maxrows = 2;    // maxcols x maxrows pages will be placed on one sheet

try {
    $p = new pdflib();

    $p->set_option("searchpath={" . $searchpath . "}");
    $p->set_option("searchpath={" . $fontpath . "}");

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    if ($p->begin_document($outfile, "") == 0)
        throw new Exception("Error: " . $p->get_errmsg());

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", $title );
    
    /* ---------------------------------------------------------------------
     * Define the sheet width and height, the number of maxrows and columns
     * and calculate the scaling factor and cell dimensions for the 
     * multi-page imposition.
     * ---------------------------------------------------------------------
     */
    if ($maxrows > $maxcols)
        $scale = 1.0 / $maxrows;
    else
        $scale = 1.0 / $maxcols;

    $rowheight = $sheetheight * $scale;
    $colwidth = $sheetwidth * $scale;

    $pageopen = false; // is a page open that must be closed?
    
    /* Loop over all input documents */
    for ($i=0; $i < count($pdffiles); $i++) {

        /* Open the input PDF */
        $indoc = $p->open_pdi_document($pdffiles[$i], "");
        if ($indoc == 0){
            print("Error: " . $p->get_errmsg());
            continue;
        }

        $endpage = $p->pcos_get_number($indoc, "length:pages");
        
        /* Loop over all pages of the input document */
        for ($pageno = 1; $pageno <= $endpage; $pageno++) {
            $page = $p->open_pdi_page($indoc, $pageno, "");

            if ($page == 0) {
                print("Error: " . $p->get_errmsg());
                continue;
            }
            
            /* Start a new page */
            if (!$pageopen) {
                $p->begin_page_ext($sheetwidth, $sheetheight, "");
                $pageopen = true;
            }
           
            /* The save/restore pair is required to get an independent
             * clipping area for each mini page. Note that clipping
             * is not required for the imported pages, but affects
             * the rectangle around each page. Without clipping we
             * would have to move the rectangle a bit inside the
             * imported page to avoid drawing outside its area.
             */
            $p->save();

            // Clipping path for the rectangle
            $p->rect($col * $colwidth, $sheetheight - ($row + 1) * $rowheight,
                $colwidth, $rowheight);
            $p->clip();

            $optlist = "boxsize {" . $colwidth . " " . $rowheight . "} fitmethod meet";
                
            $p->fit_pdi_page($page, $col * $colwidth, 
                $sheetheight - ($row + 1) * $rowheight, $optlist);

            $p->close_pdi_page($page);
            
            /* Draw a frame around the mini page */ 
            $p->set_graphics_option("linewidth=" . $scale);
            $p->rect($col * $colwidth, $sheetheight - ($row + 1) * $rowheight,
                $colwidth, $rowheight);
            $p->stroke();
           
            $p->restore();
            // Start a new row if the current row is full
            $col++;
            if ($col == $maxcols) {
                $col = 0;
                $row++;
            }
            // Close the page if it is full
            if ($row == $maxrows) {
                $row = 0;
                $p->end_page_ext("");
                $pageopen = false;
            }
        }
        $p->close_pdi_document($indoc);
    }
    
    if ($pageopen) {
        $p->end_page_ext("");
    }
    
    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfimpose.pdf");
    print $buf;


}

catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfimpose sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;

?>
