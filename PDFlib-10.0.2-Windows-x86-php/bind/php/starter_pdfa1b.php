<?php
/* 
 * PDF/A-1b starter:
 * Create PDF/A-1b conforming output
 *
 * Required data: font file, image file
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';
$imagefile = "nesrin.jpg";
$outfilename = "";

try {
    $p = new PDFlib();


    # This means we must check return values of load_font() etc.
    $p->set_option("errorpolicy=return");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* PDF/A-1a requires Tagged PDF */
    if ($p->begin_document($outfilename, "pdfa=PDF/A-1b:2005") == 0) {
        die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfa1b");

    $p->begin_page_ext(0,0, "width=a4.width height=a4.height");

    $p->fit_textline("PDF/A-1b:2005 starter", 50, 700, 
        "fontname=NotoSerif-Regular fontsize=24");

    # Load an RGB image
    $image = $p->load_image("auto", $imagefile, "");

    if ($image == 0) {
        die("Error: " . $p->get_errmsg());
    }

    /* Place the $image at the bottom of the page */
    $p->fit_image($image, 0.0, 0.0, "scale=0.5");

    $p->end_page_ext("");
    $p->close_image($image);

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfa1b.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfa1b sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
