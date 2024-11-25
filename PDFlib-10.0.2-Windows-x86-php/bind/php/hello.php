<?php
/* 
 * PDFlib client: hello example in PHP
 */

try {
    $searchpath = "../data";
    $p = new PDFlib();

    # This means we must check return values of load_font() etc.
    $p->set_option("errorpolicy=return");

    /* Set the search path for font files */
    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /*  open new PDF file; insert a file name to create the PDF on disk */
    if ($p->begin_document("", "") == 0) {
        die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "hello.php");
    $p->set_info("Author", "Rainer Schaaf");
    $p->set_info("Title", "Hello world (PHP)!");

    $p->begin_page_ext(0, 0, "width=a4.width height=a4.height");

    $fontopt =
        "fontname=NotoSerif-Regular fontsize=24";

    $p->fit_textline("Hello world!", 50, 700, $fontopt);
    $p->fit_textline("(says PHP)",  50, 676, $fontopt);

    $p->end_page_ext("");


    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=hello.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in hello sample:\n" .
	"[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
	$e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
