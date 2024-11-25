<?php
/*
 * Starter sample for fallback fonts
 *
 * Required data: suitable fonts
 */
/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(dirname(__FILE__)).'/data';
$outfile = "";

$llx = 30; $lly = 50; $urx = 800; $ury = 570;

$headers = array( "Use case",
    "Option list for the 'fallbackfonts' option", "Base font",
    "With fallback font" );

class testcase {
    public function __construct($usecase, $fontname, 
            $fallbackoptions, $text) {
        $this->usecase = $usecase;
        $this->fontname = $fontname;
        $this->fallbackoptions = $fallbackoptions;
        $this->text = $text;
    }

    public $usecase;
    public $fontname;
    public $fallbackoptions;
    public $text;
}

$testcases = array(
    new testcase(
        "Add enlarged pictogram", "NotoSerif-Regular", 
        /* U+261E = WHITE RIGHT POINTING INDEX */
        "{fontname=ZapfDingbats forcechars=U+261E fontsize=150% "
                . "textrise=-15%}", "hand symbol: &#x261E;"),

    new testcase(
        "Add enlarged symbol glyph",
        "NotoSerif-Regular",
        "{fontname=Symbol forcechars=U+2663 fontsize=125%}",
        "club symbol: &#x2663;"),
    /*
     * Hebrew characters missing in the font will be pulled from Hebrew
     * font
     */
    new testcase(
        "Add Hebrew characters to Latin font", "NotoSerif-Regular",
        "{fontname=NotoSerifHebrew-Regular}",
        "Hebrew: &#x05D0;"),
);

try {
    $p = new pdflib();

    $p->set_option("searchpath={" . $searchpath . "}");
    $p->set_option("charref=true");
    $p->set_option("glyphcheck=replace");

    /*
     * This means that formatting and other errors will raise an
     * exception. This simplifies our sample code, but is not
     * recommended for production code.
     */
    $p->set_option("errorpolicy=exception");

    /* Set an output path according to the name of the topic */
    if ($p->begin_document($outfile, "") == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
        }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_fallback");

    /* Start Page */
    $p->begin_page_ext(0, 0, "width=a4.height height=a4.width");

    $table = 0;

    /* Table header */
    for ($i = 0; $i < count($headers); $i++) {
        $col = $i + 1;

        $optlist = "fittextline={fontname=NotoSerif-Regular fontsize=10} "
                . "margin=4";
        $table = $p->add_table_cell($table, $col, 1, $headers[$i], $optlist);
    }

    /* Create fallback samples, one use case per row */
    for ($i = 0; $i < count($testcases); $i++) {
        $row = $i + 2;
        $testcase = $testcases[$i];
        $col = 1;

        /* Column 1: description of the use case */
        $optlist = "fittextline={fontname=NotoSerif-Regular fontsize=10} "
                . "margin=4";
        $table = $p->add_table_cell($table, $col++, $row, $testcase->usecase,
                $optlist);

        /* Column 2: reproduce option list literally */
        $optlist = "fittextline={fontname=NotoSerif-Regular fontsize=10} "
                . "margin=4";
        $table = $p->add_table_cell($table, $col++, $row,
                $testcase->fallbackoptions, $optlist);

        /* Column 3: text with base font */
        $optlist = "fittextline={fontname=" . $testcase->fontname
                . ""
                . " fontsize=10 replacementchar=? } margin=4";
        $table = $p->add_table_cell($table, $col++, $row, $testcase->text,
                $optlist);

        /* Column 4: text with base font and fallback fonts */
        $optlist = "fittextline={fontname=" . $testcase->fontname
                . ""
                . " fontsize=10 fallbackfonts={"
                . $testcase->fallbackoptions . "}} margin=4";
        $table = $p->add_table_cell($table, $col++, $row, $testcase->text,
                $optlist);
    }

    /* Place the table */
    $optlist = "header=1 fill={{area=rowodd "
            . "fillcolor={gray 0.9}}} stroke={{line=other}} ";
    $result = $p->fit_table($table, $llx, $lly, $urx, $ury, $optlist);

    if ($result == "_error") {
        throw new Exception("Couldn't place table: " . $p->get_errmsg());
    }

    $p->end_page_ext("");
    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_fallback.pdf");
    print $buf;
}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_fallback sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
