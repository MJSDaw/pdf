<?php
/* 
 * PDF/X-4 starter:
 * Create PDF/X-4 conforming output with layers and transparency
 *
 * A low-level layer is created for each of several languages, as well
 * as an image layer. 
 *
 * The document contains transparent text which is allowed in
 * PDF/X-4, but not earlier PDF/X standards.
 *
 * Required data: font file, image file, ICC output intent profile
 *                (see www.pdflib.com for output intent ICC profiles)
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';

$imagefile = "zebra.tif";


try {
    $p = new pdflib();

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    if ($p->begin_document("", "pdfx=PDF/X-4") == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfx4");

    if ($p->load_iccprofile("ISOcoated_v2_eci.icc", "usage=outputintent") == 0) {
        print("Error: " . $p->get_errmsg() . "\n");
        print("See www.pdflib.com for output intent ICC profiles.\n");
        return(2);
    }

    /*
     * Define the layers; "defaultstate" specifies whether or not
     * the layer is visible when the page is opened.
     */

    $layer_english = $p->define_layer("English text", "defaultstate=true");
    $layer_german = $p->define_layer("German text", "defaultstate=false");
    $layer_french = $p->define_layer("French text", "defaultstate=false");

    /* 
     * Define a radio button relationship for the language layers.
     */

    $optlist = "group={" . $layer_english . " " . $layer_german
                . " " . $layer_french . "}";
    $p->set_layer_dependency("Radiobtn", $optlist);

    $layer_image = $p->define_layer("Images", "defaultstate=true");
    
    $p->begin_page_ext(0,0, "width=a4.width height=a4.height");

    $font = $p->load_font("NotoSerif-Regular", "unicode", "");

    if ($font == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->setfont($font, 24);

    $p->begin_layer($layer_english);

    $p->fit_textline("PDF/X-4 starter sample with layers", 50, 700, "");

    $p->begin_layer($layer_german);
    $p->fit_textline("PDF/X-4 Starter-Beispiel mit Ebenen", 50, 700, "");

    $p->begin_layer($layer_french);
    $p->fit_textline("PDF/X-4 Starter exemple avec des calques", 50, 700, "");

    $p->begin_layer($layer_image);

    $image = $p->load_image("auto", $imagefile, "");
    if ($image == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    /* Place the image on the page */
    $p->fit_image($image, (double) 0.0, (double) 0.0, "");
    /* Place a diagonal stamp across the image area */
    $width = $p->info_image($image, "width", "");
    $height = $p->info_image($image, "height", "");

    $optlist = "boxsize={" . $width . " " . $height . "} font=" . $font . 
        " stamp=ll2ur fillcolor={lab 100 0 0} gstate={opacityfill=0.5}";
    $p->fit_textline("Zebra", 0, 0, $optlist);

    $p->close_image($image);

    /* Close all layers */
    $p->end_layer();

    $p->end_page_ext("");

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfx4.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfx4 sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
