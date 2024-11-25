<?php
/* 
 * PDF/X-3 starter:
 * Create PDF/X-3 conforming output
 *
 * Required data: font file, image file, icc profile
 *                (see www.pdflib.com for output intent ICC profiles)
 */

/* This is where the data files are. Adjust as necessary.*/
$searchpath = dirname(dirname(__FILE__)).'/data';
$imagefile = "nesrin.jpg";
$outfilename = "";

try {
    $p = new PDFlib();

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    if ($p->begin_document($outfilename, "pdfx=PDF/X-3:2003") == 0) {
        die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfx3");

    /*
     * You can use one of the Standard output intents (e.g. for SWOP
     * printing) which do not require an ICC profile:

    $p->load_iccprofile("CGATS TR 001", "usage=outputintent");

     * However, if you use ICC or Lab color you must load an ICC
     * profile as output intent:
     */
    if ($p->load_iccprofile("ISOcoated_v2_eci.icc", "usage=outputintent") == -1) {
        printf("Error: %s\n", $p->get_errmsg());
        printf("See www.pdflib.com for output intent ICC profiles.\n");
        return(2);
    }

    $p->begin_page_ext(0,0, "width=a4.width height=a4.height");

    $font = $p->load_font("NotoSerif-Regular", "unicode", "");
    if ($font == 0) {
        die("Error: " . $p->get_errmsg());
    }
    $p->setfont($font, 24);

    $spot = $p->makespotcolor("PANTONE 123 C");
    $p->setcolor("fill", "spot", $spot, 1.0, 0.0, 0.0);
    $p->fit_textline("PDF/X-3:2003 starter", 50, 700, "");

    $image = $p->load_image("auto", $imagefile, "");

    if ($image == 0) {
        die("Error: " . $p->get_errmsg());
    }

    $p->fit_image($image, 0.0, 0.0, "scale=0.5");

    $p->end_page_ext("");

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfx3.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfx3 sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
