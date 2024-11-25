<?php
/* 
 * pCOS starter:
 * Dump information from an existing PDF document
 *
 * Required software: PDFlib+PDI or PDFlib Personalization Server (PPS)
 * Required data: PDF input file
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';
$pdfinput = "PLOP-datasheet.pdf";
$docoptlist = "requiredmode=minimum";

try {
    $p = new PDFlib();

    # This means we must check return values of load_font() etc.
    $p->set_option("errorpolicy=return");

    $p->set_option("SearchPath={{" . $searchpath . "}}");

    /* We do not create any output document, so no call to
     * begin_document() is required.
     */

    /* Open the input document */
    $doc = $p->open_pdi_document($pdfinput, $docoptlist);
    if ($doc == 0) {
        die("Error: " . $p->get_errmsg());
    }

    /* --------- general information (always available) */

    $pcosmode = $p->pcos_get_string($doc, "pcosmodename");

    printf("   File name: %s<br/>",
        $p->pcos_get_string($doc,"filename"));

    printf(" PDF version: %s<br/>",
        $p->pcos_get_string($doc, "pdfversionstring"));

    printf("  Encryption: %s<br/>",
        $p->pcos_get_string($doc, "encrypt/description"));

    printf("   Master pw: %s<br/>",
        (($p->pcos_get_number($doc, "encrypt/master") != 0) ? "yes":"no"));

    printf("     User pw: %s<br/>",
        (($p->pcos_get_number($doc, "encrypt/user") != 0) ? "yes" : "no"));

    printf("Text copying: %s<br/>",
        (($p->pcos_get_number($doc, "encrypt/nocopy") != 0) ? "no":"yes"));

    printf("  Linearized: %s<br/><br/>",
        (($p->pcos_get_number($doc, "linearized") != 0) ? "yes" : "no"));

    if ($pcosmode == "minimum") {
        printf("Minimum mode: no more information available<br/><br/>");
        exit(0);
    }

    /* --------- more details (requires at least user password) */
    printf("PDF/X status: %s<br/>", $p->pcos_get_string($doc, "pdfx"));

    printf("PDF/A status: %s<br/>", $p->pcos_get_string($doc, "pdfa"));

    $xfa_present = $p->pcos_get_number($doc, "type:/Root/AcroForm/XFA") != 0;
    printf("    XFA data: %s<br/>", $xfa_present ? "yes" : "no");

    printf("  Tagged PDF: %s<br/>",
        (($p->pcos_get_number($doc, "tagged") != 0) ? "yes" : "no"));

    printf("No. of pages: %s<br/>",
        $p->pcos_get_number($doc, "length:pages"));

    printf(" Page 1 size: width=%.3f, height=%.3f<br/>",
         $p->pcos_get_number($doc, "pages[0]/width"),
         $p->pcos_get_number($doc, "pages[0]/height"));

    $count = $p->pcos_get_number($doc, "length:fonts");
    printf("No. of fonts: %s<br/>",  $count);

    for ($i=0; $i < $count; $i++) {
        $fonts = "fonts[" . $i . "]/embedded";
        if ($p->pcos_get_number($doc, $fonts) != 0)
            print("embedded ");
        else
            print("unembedded ");

        $fonts = "fonts[" . $i . "]/type";
        print($p->pcos_get_string($doc, $fonts) . " font ");
        $fonts = "fonts[" . $i . "]/name";
        printf("%s<br/>", $p->pcos_get_string($doc, $fonts));
    }

    printf("<br/>");

    $plainmetadata = $p->pcos_get_number($doc, "encrypt/plainmetadata") != 0;
    
    if ($pcosmode == "restricted" && !$plainmetadata
                && $p->pcos_get_number($doc, "encrypt/nocopy") != 0) {
        print("Restricted mode: no more information available");
        exit(0);
    }

    /* ----- document $info keys and XMP metadata (requires master pw) */

    $count = $p->pcos_get_number($doc, "length:/Info");

    for ($i=0; $i < $count; $i++) {
        $info = "type:/Info[" . $i . "]";
        $objtype = $p->pcos_get_string($doc, $info);

        $info = "/Info[" . $i . "].key";
        $key = $p->pcos_get_string($doc, $info);
        $len = 12 - strlen($key);
        while ($len-- > 0) print(" ");

        print($key . ": ");

        /* $info entries can be stored as string or name objects */
        if ($objtype == "name" || $objtype == "string") {
            $info = "/Info[" . $i . "]";
            printf("'" . $p->pcos_get_string($doc, $info) .  "'<br/>");
        } else {
            $info = "type:/Info[" . $i . "]";
            printf("(" . $p->pcos_get_string($doc, $info) .  " object)<br/>");
        }
    }

    print("<br/>" . "XMP metadata: ");


    $objtype = $p->pcos_get_string($doc, "type:/Root/Metadata");
    if ($objtype == "stream") {
        $contents = $p->pcos_get_stream($doc, "", "/Root/Metadata");
        printf("%d UTF-8 bytes <br/>", strlen($contents));
    } else {
        printf("not present");
    }

    $p->close_pdi_document($doc);

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_pcos sample:<br/>" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "<br/>");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
