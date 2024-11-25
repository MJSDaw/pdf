<?php
/* 
 * PDF/A-2b starter:
 * Create PDF/A-2b conforming output with layers, transparency, annotation and
 * PDF/A attachment.
 *
 * Required data: font file, image file
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';

$imagefile = "zebra.tif";
$attachments = array( "lionel.pdf");

try {
    $p = new pdflib();

    /* This means we must check return values of load_font() etc. */
    $p->set_option("errorpolicy=return");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* Initially display the layer panel and show the full page */
    if ($p->begin_document("",
                "openmode=layers viewerpreferences={fitwindow=true} " .
                "pdfa=PDF/A-2b") == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_pdfa2b");

    /* Define the layers, with only English and image layers switched on. */
    $layer_english = $p->define_layer("English text", "");
    $layer_german = $p->define_layer("German text", "defaultstate=false");
    $layer_french = $p->define_layer("French text", "defaultstate=false");
    $layer_image = $p->define_layer("Images", "");

    /* Define a radio button relationship for the language layers, so only
     * one language can be switched on at a time.
     */
    $optlist = "group={" . $layer_english . " " . $layer_german
                . " " . $layer_french . "}";
    $p->set_layer_dependency("Radiobtn", $optlist);

    $p->begin_page_ext(0,0, "width=a4.width height=a4.height");

    $font = $p->load_font("NotoSerif-Regular", "unicode", "");

    if ($font == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    // Create a Stamp annotation
    $optlist = "iconname=approved contents={PDF/A} font=" . $font;
    $p->create_annotation( 50, 700, 300, 840, "Stamp", $optlist);

    $optlist = sprintf("font=%d fontsize=24", $font);
    
    $p->begin_layer($layer_english);
    $textflow = $p->create_textflow(
                "PDF/A-2b starter sample with layers, transparency, " .
                "annotation and attachment", $optlist);
    $p->fit_textflow($textflow, 50, 650, 550, 700, "");
    $p->delete_textflow($textflow);

    $p->begin_layer($layer_german);
    $textflow = $p->create_textflow(
                "PDF/A-2b Starter-Beispiel mit Ebenen, Transparenz, " .
                "Anmerkung und Anlage", $optlist);
    $p->fit_textflow($textflow, 50, 650, 550, 700, "");
    $p->delete_textflow($textflow);

    $p->begin_layer($layer_french);
    $textflow = $p->create_textflow(
                "PDF/A-2b starter exemple avec des calques, " .
                "transparence, commentaire et attachement", $optlist);
    $p->fit_textflow($textflow, 50, 650, 550, 700, "");
    $p->delete_textflow($textflow);

    $p->begin_layer($layer_image);

    $p->setfont($font, 48);

    $image = $p->load_image("auto", $imagefile, "");

    if ($image == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }

    $width = $p->info_image($image, "width", "");
    $height = $p->info_image($image, "height", "");

    /* Place the image on the page and close it */
    $p->fit_image($image, 0.0, 0.0, "");
    $p->close_image($image);

    /* Place a transparent diagonal stamp across the image area, in
     * different colors
     */
    $optlist = "boxsize={" . $width . " " . $height . "} stamp=ll2ur font=" 
        . $font .  " fillcolor={lab 100 0 0} gstate={opacityfill=0.5}";
    
    $p->begin_layer($layer_english);
    $p->fit_textline("Transparent text", 0, 0, $optlist);

    $p->begin_layer($layer_german);
    $p->fit_textline("Transparenter Text", 0, 0, $optlist);

    $p->begin_layer($layer_french);
    $p->fit_textline("Texte transparent", 0, 0, $optlist);
    
    /* Close all layers */
    $p->end_layer();

    $p->end_page_ext("");

    /* Construct option list with attachment handles. The attachments must
     * be PDF/A-1 or PDF/A-2 files.
     */
    $optlist = "attachments={";
    foreach ($attachments as $attachment) {
        $attachment_handle =
                $p->load_asset("Attachment", $attachment,
                            "description={This is a PDF/A attachment}");

        if ($attachment_handle == 0) {
            throw new Exception("Error loading attachment: " . $p->get_errmsg());
        }

        $optlist .= " " . $attachment_handle;
    }
    $optlist .= "}";
    
    $p->end_document($optlist);

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_pdfa2b.pdf");
    print $buf;
}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pdfa2b sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
