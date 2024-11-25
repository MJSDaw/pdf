<?php
/* 
 * PDF merge starter:
 * Merge pages from multiple PDF documents (including annotations)
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
$outfilename = "";

$pdffiles = array(
        "markup_annotations.pdf",
        "PLOP-datasheet.pdf",
        "pCOS-datasheet.pdf"
);

try {
    $p = new PDFlib();


    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    $p->set_option("SearchPath={{" . $searchpath . "}}");
    $p->set_option("SearchPath={{" . $fontpath . "}}");

    if ($p->begin_document($outfilename, "") == 0)
        die("Error: " . $p->get_errmsg());

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfmerge");

    foreach ($pdffiles as $pdffile) { 
        /* Open the input PDF */
        $indoc = $p->open_pdi_document($pdffile, "");
        if ($indoc == 0) {
            printf("Error: %s\n", $p->get_errmsg());
            continue;
        }

        $endpage = $p->pcos_get_number($indoc, "length:pages");

        /* Loop over all pages of the input document */
        for ($pageno = 1; $pageno <= $endpage; $pageno++) {
            $page = $p->open_pdi_page($indoc, $pageno, "");

            if ($page == 0) {
                printf("Error: %s\n", $p->get_errmsg());
                continue;
            }
            /* Dummy $page size; will be adjusted later */
            $p->begin_page_ext(10, 10, "");

            /* Create a bookmark with the file name */
            if ($pageno == 1) {
                $p->create_bookmark($pdffile, "");
            }

            /* Place the imported $page on the output $page, and
             * adjust the $page size. If the page contains annotations
             * these are also imported.
             */
            $p->fit_pdi_page($page, 0, 0, "adjustpage");
            $p->close_pdi_page($page);

            $p->end_page_ext("");
        }
        $p->close_pdi_document($indoc);
    }

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfmerge.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfmerge sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
