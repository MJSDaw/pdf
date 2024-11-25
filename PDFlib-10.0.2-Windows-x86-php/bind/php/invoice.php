<?php
/* 
 * PDFlib+PDI client: invoice generation demo
 * Required software: PDFlib+PDI or PDFlib Personalization Server (PPS)
 */

$x_table = 55;
$tablewidth = 475;

$y_address = 682;
$x_salesrep = 455;
$y_invoice = 542;
$imagesize = 90;

$fontsize = 11;
$fontsizesmall = 9;

$fontname= "NotoSerif-Regular";
$basefontoptions = "";


/* -----------------------------------
* Place company stationery as background
* -----------------------------------
*/
function create_stationery($p)
{
    global $basefontoptions, $x_table, $y_address, $fontsize, $fontsizesmall, 
        $x_salesrep, $imagesize;
    $sender =
        "Kraxi Systems, Inc. &#x2022; 17, Aviation Road &#x2022; Paperfield";
    $stationeryfontname= "NotoSerif-Regular";

    $stationeryfilename = "kraxi_logo.pdf";

    $y_company_logo = 748;

    $senderfull =
        "17, Aviation Road\n" .
        "Paperfield<nextline leading=50%><nextparagraph leading=120%>" .
        "Phone 7079-4301\n" .
        "Fax 7079-4302<nextline leading=50%><nextparagraph leading=120%>" .
        "info@kraxi.com\n" .
        "www.kraxi.com\n";

    $stationery = $p->open_pdi_document($stationeryfilename, "");
    $page = $p->open_pdi_page($stationery, 1, "");

    $p->fit_pdi_page($page, 0, $y_company_logo,
            "boxsize={595 85} position={65 center}");
    $p->close_pdi_page($page);
    $p->close_pdi_document($stationery);

    $optlist =  $basefontoptions . " fontsize=" . $fontsizesmall . 
        " fontname=" . $stationeryfontname . " charref=true";
    $p->fit_textline($sender, $x_table, $y_address + $fontsize,
            $optlist);

    /* ----------------------------------
    * Print full company contact details
    * -----------------------------------
    */
    $optlist = $basefontoptions . " fontname=" . $stationeryfontname . 
    " leading=125% fillcolor={cmyk 0.64 0.55 0.52 0.27}";
    $tf = $p->create_textflow($senderfull, $optlist);
    $p->fit_textflow($tf, $x_salesrep, $y_address,
            $x_salesrep+$imagesize, $y_address + 150, "verticalalign=bottom");
    $p->delete_textflow($tf);
}

/* -----------------------------------
* Place address and header text
* -----------------------------------
*/
function create_header($p)
{
    global $basefontoptions, $x_table, $y_address, $tablewidth, $fontsize, 
    $fontsizesmall, $x_salesrep, $imagesize, $y_invoice; 

    $salesrepfilename = "sales_rep4.jpg";
    $salesrepname = "Lucy Irwin";
    $salesrepcaption = "Local sales rep:";
    $invoiceheader = "INVOICE 2012-03";

    $address =
        "John Q. Doe\n" .
        "255 Customer Lane\n" .
        "Suite B\n" .
        "12345 User Town\n" .
        "Everland";


    /* -----------------------------------
    * Print address
    * -----------------------------------
    */
    $optlist = $basefontoptions . " leading=120%";

    $tf = $p->create_textflow($address, $optlist);
    $p->fit_textflow($tf,
            $x_table, $y_address, $x_table+$tablewidth/2, $y_address-100, "");
    $p->delete_textflow($tf);

    /* -----------------------------------
    * Place name and image of local sales rep
    * -----------------------------------
    */
    $optlist = $basefontoptions . " fontsize=" . $fontsizesmall;
    $p->fit_textline($salesrepcaption, $x_salesrep, $y_address-$fontsizesmall,
            $optlist);
    $p->fit_textline($salesrepname, $x_salesrep, $y_address-2*$fontsizesmall,
            $optlist);

    $salesrepimage = $p->load_image("auto", $salesrepfilename, "");

    $optlist = "boxsize={" . $imagesize . " " .  $imagesize . "} fitmethod=meet";
    $p->fit_image($salesrepimage,
            $x_salesrep, $y_address-3*$fontsizesmall-$imagesize, $optlist);
    $p->close_image($salesrepimage);

    /* -----------------------------------
    * Print the header and date
    * -----------------------------------
    */

    /* Add a bookmark with the header text */
    $p->create_bookmark($invoiceheader, "");

    $optlist =  $basefontoptions;
    $p->fit_textline($invoiceheader, $x_table, $y_invoice, $optlist);

    $date = date("F j, Y");

    $optlist =  "position {100 0} " . $basefontoptions;
    $p->fit_textline($date, $x_table+$tablewidth, $y_invoice, $optlist);
}


/* This is where font/image/PDF input files live. Adjust as necessary. */
$searchpath = dirname(__FILE__, 2).'/data';

/* By default annotations are also imported. In some cases this
 * requires the Noto fonts for creating annotation appearance streams.
 */
$fontpath = dirname(__FILE__, 3). "/resource/font";

$closingtext =
"Terms of payment: <fillcolor={rgb 1 0 0}>30 days net. " .
"<fillcolor={gray 0}>90 days warranty starting at the day of sale. " .
"This warranty covers defects in workmanship only. " .
"Kraxi Systems, Inc. will, at its option, repair or replace the " .
"product under the warranty. This warranty is not transferable. " .
"No returns or exchanges will be accepted for wet products.";

class articledata {
    function __construct($name, $price, $quantity) {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

}

$dataset = array(
    new articledata( "Super Kite",		20,	2),
    new articledata( "Turbo Flyer",	40,	5),
    new articledata( "Giga Trash",		180,	1),
    new articledata( "Bare Bone Kit",	50,	3),
    new articledata( "Nitty Gritty",	20,    10),
    new articledata( "Pretty Dark Flyer",	75,	1),
    new articledata( "Free Gift",		0,	1),
);

$headers = array(
    "ITEM", "DESCRIPTION", "QUANTITY", "PRICE", "AMOUNT"
);

$alignments = array(
    "right", "left", "right", "right", "right"
);

try {
    $pagecount = 0;

    /* create a new PDFlib object */
    $p = new PDFlib();

    $p->set_option("SearchPath={{" . $searchpath . "}}");
    $p->set_option("SearchPath={{" . $fontpath . "}}");

    /* This mean we don't have to check error return values, but will
    * get an exception in case of runtime problems.
    */
    $p->set_option("errorpolicy=exception");

    $p->begin_document("", "");

    $p->set_info("Creator", "invoice");
    $p->set_info("Author", "Thomas Merz");
    $p->set_info("Title", "PDFlib invoice generation demo");

        $basefontoptions = "fontname=" . $fontname . " fontsize=" . 
            $fontsize . "";

        /* -----------------------------------
        * Create and place table with article list
        * -----------------------------------
        */
        /* ---------- Header row */
        $row = 1;
        $tbl = 0; 

        for ($col=1; $col <= count($headers); $col++)
        {
            $optlist =  "fittextline={position={" . $alignments[$col-1] . 
                " center} " . $basefontoptions . "} margin=2";
            $tbl = $p->add_table_cell($tbl, $col, $row, $headers[$col-1], 
            $optlist);
        }
        $row++;

        /* ---------- Data rows: one for each article */
        $total = 0;

        for ($i = 0; $i <  count($dataset); $i++) {
            $sum = $dataset[$i]->price * $dataset[$i]->quantity;
            $col = 1;

            /* column 1: ITEM */
            $buf = sprintf("%d", $i + 1);
            $optlist = "fittextline={position={" . $alignments[$col-1] . 
                " center} " . $basefontoptions . "} margin=2";
            $tbl = $p->add_table_cell($tbl, $col++, $row, $buf, $optlist);

            /* column 2: DESCRIPTION */
            $optlist = "fittextline={position={" . $alignments[$col-1] . 
                " center} " . $basefontoptions . "} colwidth=50% margin=2";
            $tbl = $p->add_table_cell($tbl, $col++, $row, $dataset[$i]->name,
                    $optlist);

            /* column 3: QUANTITY */
            $buf = sprintf("%d", $dataset[$i]->quantity);
            $optlist = "fittextline={position={" . $alignments[$col-1] . 
                " center} " . $basefontoptions . "} margin=2";
            $tbl = $p->add_table_cell($tbl, $col++, $row, $buf, $optlist);

            /* column 4: PRICE */
            $buf =  sprintf("%.2f", $dataset[$i]->price);
            $optlist = "fittextline={position={" . $alignments[$col-1] . 
                " center} " . $basefontoptions . "} margin=2";
            $tbl = $p->add_table_cell($tbl, $col++, $row, $buf, $optlist);

            /* column 5: AMOUNT */
            $buf = sprintf("%.2f", $sum);
            $optlist = "fittextline={position={" . $alignments[$col - 1] . 
                " center} " . $basefontoptions . " " . "} margin=2";
            $tbl = $p->add_table_cell($tbl, $col++, $row, $buf, $optlist);

            $total += $sum;
            $row++;
        }

        /* ---------- Print total in the rightmost column */
        $buf = sprintf("%.2f", $total);
        $optlist = "fittextline={position={" .
            $alignments[count($headers) - 1] . " center} " .
            $basefontoptions . "} margin=2";
        $tbl = $p->add_table_cell($tbl, count($headers), $row++, $buf, $optlist);


        /* ---------- Footer row with terms of payment */
        $optlist = $basefontoptions . " alignment=justify leading=120%";
        $tf = $p->create_textflow($closingtext, $optlist);

        $optlist = "rowheight=1 margin=2 margintop=" . 2*$fontsize . 
            " textflow=" . $tf . " colspan= " . count($headers);
        $tbl = $p->add_table_cell($tbl, 1, $row++, "", $optlist);


        /* ---------- Place the table instance(s), creating pages as required */
        do {

            $p->begin_page_ext(0, 0, "width=a4.width height=a4.height");

            if (++$pagecount == 1)
            {
                create_stationery($p);
                create_header($p);
                $top = $y_invoice - 3*$fontsize;
            }
            else
            {
                $top = 50;
            }

            /* Place the table on the page; Shade every other row. */
            $optlist =  "header=1 fill={{area=rowodd fillcolor={gray 0.9}}} ";

            $result = $p->fit_table($tbl,
                    $x_table, $top, $x_table+$tablewidth, 20, $optlist);

            if ($result == "_error") {
                throw new Exception("Couldn't place table: "
                    . $p->get_errmsg());
            }

            $p->end_page_ext("");
        } while ($result == "_boxfull");

        $p->delete_table($tbl, "");

        $p->end_document("");

        $buf = $p->get_buffer();
        $len = strlen($buf);
    
        header("Content-type: application/pdf");
        header("Content-Length: $len");
        header("Content-Disposition: inline; filename=invoice.pdf");
        print $buf;
    }

catch (PDFlibException $e) {
    die("PDFlib exception occurred in invoice sample:\n" .
	"[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
	$e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
