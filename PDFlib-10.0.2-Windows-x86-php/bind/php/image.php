<?php
/* 
 * PDFlib client: image example in PHP
 */

/* This is where font/image/PDF input files live. Adjust as necessary. */ 
$searchpath = dirname(dirname(__FILE__)).'/data';

try {
    $p = new PDFlib();

    # This means we must check return values of load_image() etc.
    $p->set_option("errorpolicy=return");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /*  open new PDF file; insert a file name to create the PDF on disk */
    if ($p->begin_document("", "") == 0) {
        die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "image");
    $p->set_info("Author", "Thomas Merz");
    $p->set_info("Title", "image sample");

    $imagefile = "nesrin.jpg";

    $image = $p->load_image("auto", $imagefile, "");
    if (!$image) {
        die("Error: " . $p->get_errmsg());
    }

    /* dummy page size, will be adjusted by $p->fit_image() */
    $p->begin_page_ext(0, 0, "width=a4.width height=a4.height");
    $p->fit_image($image, 0, 0, "adjustpage");
    $p->close_image($image);
    $p->end_page_ext("");

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=image.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in image sample:\n" .
	"[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
	$e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
