<?php
/* 
 * PDFlib client: fill Blocks with PPS to create a business card
 * Required software: PDFlib Personalization Server (PPS)
 */

$infile = "boilerplate.pdf";

/* This is where font/image/PDF input files live. Adjust as necessary.
 * Note that this directory must also contain the font files.
 */
$searchpath = dirname(__FILE__, 2).'/data';

/* By default annotations are also imported. In some cases this
 * requires the Noto fonts for creating annotation appearance streams.
 */
$fontpath = dirname(__FILE__, 3). "/resource/font";

$dataset = array(  "name"          => "Victor Kraxi",
        "business.title"           => "Chief Paper Officer",
        "business.address.line1"   => "17, Aviation Road",
        "business.address.city"    => "Paperfield",
        "business.telephone.voice" => "phone +1 234 567-89",
        "business.telephone.fax"   => "fax +1 234 567-98",
        "business.email"           => "victor@kraxi.com",
        "business.homepage"        => "www.kraxi.com"
    );

try {
    $p = new PDFlib();

    # This means we must check return values of load_font() etc.
    /* Set the search path for fonts and PDF files */
    $p->set_option("errorpolicy=return SearchPath={{" . $searchpath . "}}");
    $p->set_option("SearchPath={{" . $fontpath . "}}");

    /*  open new PDF file; insert a file name to create the PDF on disk */
    if ($p->begin_document("", "") == 0) {
    die("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "businesscard");
    $p->set_info("Author", "Thomas Merz");
    $p->set_info("Title", "PDFlib Block processing sample");

    $blockcontainer = $p->open_pdi_document($infile, "");
    if ($blockcontainer == 0){
        die ("Error: " . $p->get_errmsg());
    }

    /* Loop over all pages of the input document */
    $pagecount = $p->pcos_get_number($blockcontainer, "length:pages");

    for ($pageno = 1; $pageno <= $pagecount; $pageno++){
        $page = $p->open_pdi_page($blockcontainer, $pageno, "");
        if ($page == 0){
            die ("Error: " . $p->get_errmsg());
        }

        $p->begin_page_ext(20, 20, "");        /* dummy page size */

        /* This will adjust the page size to the size of the input page */
        $p->fit_pdi_page($page, 0, 0, "adjustpage");

        /* Fill all text Blocks with dynamic data */
        foreach ($dataset as $key => $value){
            if ($p->fill_textblock($page, $key, $value,
                "") == 0) {
                printf("Warning: %s\n ", $p->get_errmsg());
            }
        }

        $p->end_page_ext("");
        $p->close_pdi_page($page);
    }

    $p->end_document("");
    $p->close_pdi_document($blockcontainer);

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=businesscard.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in businesscard sample:\n" .
    "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
    $e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
