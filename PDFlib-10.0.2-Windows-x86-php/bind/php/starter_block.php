<?php
/*
 * Block starter:
 * Import a PDF page containing Blocks and fill text and image
 * Blocks with some data. For each recipient of the simulated
 * mailing a separate page with personalized information is
 * generated.
 *
 * The Textflow Blocks are processed with variable text lengths in mind:
 * if a Block doesn't fully use its vertical space or requires excess
 * space, the next Block is moved up or down accordingly.
 *
 * Required software: PDFlib Personalization Server (PPS)
 * Required data: Block PDF (template), images, font
 */

/* This is where the data files are. Adjust as necessary. */
$searchpath = dirname(__FILE__, 2).'/data';

/* By default annotations are also imported. In some cases this
 * requires the Noto fonts for creating annotation appearance streams.
 */
$fontpath = dirname(__FILE__, 3). "/resource/font";

$outfile = "";
$infile = "block_template.pdf";

// Description of a single text or image Block
class Block {               
  function __construct($blockname, $contents) {
      // Block name
      $this->name = $blockname; 
      // text Block: array with a string for each recipient
      // image Block: array with image file name for each recipient
      $this->contents = $contents;
  }
};

$number_of_recipients = 3;

// Names and contents of text Blocks
$TextBlocks = array(
    new Block("recipient",
        array(          // address data for each recipient
            "Mr Maurizio Moroni\nStrada Provinciale 124\nReggio Emilia",

            "Ms Dominique Perrier\n25, Rue Lauriston\nParis",

            "Mr Liu Wong\n55 Grizzly Peak Rd.\nButte"
        )),

    new Block("announcement",
        array(           // greeting for each recipient
            "Dear Paper Planes Fan,\n\n" .
            "we are happy to present our <fillcolor=red>best price offer" .
            "<fillcolor=black> especially for you:\n",
            
            "Bonjour,\n\n" .
            "here comes your personal <fillcolor=red>best price offer:\n",
            
            "Dear Paper Folder,\n\n" .
            "here's another exciting new paper plane especially for you. " .
            "We can supply this <fillcolor=red>best price offer" .
            "<fillcolor=black> only for a limited time and in limited quantity. " .
            "Don't hesitate and order your new plane today!\n",
        )),
    
    new Block("specialoffers",
        array(           // personalized offer for each recipient
            "<fillcolor=red>Long Distance Glider<fillcolor=black>\n" .
            "With this paper rocket you can send all your " .
            "messages even when sitting in a hall or in the cinema pretty near " .
            "the back.\n",
            
            "<fillcolor=red>Giant Wing<fillcolor=black>\n" .
            "An unbelievable sailplane! It is amazingly robust and " .
            "can even do aerobatics. But it is best suited to gliding.\n" .
            "This paper arrow can be thrown with big swing. " .
            "We launched it from the roof of a hotel. It stayed in the air a " .
            "long time and covered a considerable distance.\n",
            
            "<fillcolor=red>Super Dart<fillcolor=black>\n" .
            "The super dart can fly giant loops with a radius of 4 " .
            "or 5 meters and cover very long distances. Its heavy cone point is " .
            "slightly bowed upwards to get the lift required for loops.\n"
        )),            

    new Block("goodbye",
        array(          // bye bye phrase for each recipient
            "Visit us on our Web site at <fillcolor=blue>www.kraxi.com<fillcolor=black>!\n\n" .
            "Yours sincerely,\nVictor Kraxi",
            "Make sure to order quickly at <fillcolor=blue>www.kraxi.com<fillcolor=black> " .
            "since we will soon run out of stock!\n\n" .
            "Yours sincerely,\nVictor Kraxi",

            "Make sure to order soon at <fillcolor=blue>www.kraxi.com<fillcolor=black>!\n\n" .
            "Your friendly staff at Kraxi Systems Paper Planes",
        ))
);

// Names and contents of image Block(s)
$ImageBlocks = array(
    new Block("icon",
        array(          // image file name for each recipient
            "plane1.png",
            "plane2.png",
            "plane3.png"
        ))
);


try {
    $p = new pdflib();

    // This means we must check return values of load_font() etc.
    // Set the search path for fonts and images etc.

    $p->set_option("errorpolicy=return SearchPath={{" . $searchpath . "}}");
    $p->set_option("SearchPath={{" . $fontpath . "}}");

    if ($p->begin_document($outfile,
        "destination={type=fitwindow} pagelayout=singlepage") == 0) {
            throw new Exception("Error: " . $p->get_errmsg());
    }

    $p->set_info("Creator", "PDFlib starter sample");
    $p->set_info("Title", "starter_block");

    //  Open the Block template with PDFlib Blocks
    $indoc = $p->open_pdi_document($infile, "");
    if ($indoc == 0) {
        throw new Exception("Error: " . $p->get_errmsg());
    }
    $no_of_input_pages = $p->pcos_get_number($indoc, "length:pages");
    // Preload all pages of the Block template. We assume a small
    // number of input pages and a large number of generated output
    // pages. Therefore it makes sense to keep the input pages
    // open instead of opening them again for each recipient.
    // Add 1 because we use the 1-based page number as array index.

    for ($pageno = 1; $pageno <= $no_of_input_pages; $pageno++){
        // Open the first page and clone the page size 
        $pagehandles[$pageno] = $p->open_pdi_page($indoc, $pageno, "cloneboxes");
        if ($pagehandles[$pageno] == 0) {
            throw new Exception("Error: " . $p->get_errmsg());
        }
    }
   
    // For each recipient: place template page(s) and fill Blocks
    for ($recipient = 0; $recipient < $number_of_recipients; $recipient++) {

        // Process all pages of the template document
        for ($pageno = 1; $pageno <= $no_of_input_pages; $pageno++) {
            // Accumulated unused or excess space in Textflow Blocks:
            // - if positive, the previous Blocks didn't use their space, so
            //   we move up the Block
            // - if negative, the previous Blocks used excess space, so
            //   we move down the Block
            $accumulated_offset_y = 0;

            // Start the next output page. The page size will be
            // replaced with the cloned size of the input page.
            $p->begin_page_ext(0, 0, "width=a4.width height=a4.height");

            // Place the imported page on the output page, and clone all
            // page boxes which are present in the input page; this will
            // override the dummy size used in begin_page_ext().
            $p->fit_pdi_page($pagehandles[$pageno], 0, 0, "cloneboxes");

            // Process all Textflow Blocks
            foreach($TextBlocks as $textblock) {

                // The Textflow Blocks in the template use "fitmethod=nofit"
                // which means we allow the Textflow to overflow the Block.
                $baseopt = "";
                $optlist = $baseopt;

                // pCOS path for the current Block 
                $blockpath = "pages[" . ($pageno-1) . "]/blocks/" . $textblock->name;
                

                // Retrieve y coordinate of the Block's lower left corner
                $lly = $p->pcos_get_number($indoc, $blockpath . "/Rect[1]");

                // Adjust the vertical Block position by accumulated offset
                // and make sure we don't fall off the bottom page edge.
                // Similarly we could adjust the horizontal position.
                $adjusted_lly = $lly + $accumulated_offset_y;
                if ($adjusted_lly < 0) {
                    throw new Exception("Error for recipient " . $recipient . 
                        " (input page " . $pageno . "): " .
                        "Too much text in Textflow Blocks");
                }

                // The "refpoint" option overrides the Blocks's original
                // position. We use relative coordinates (suffix "r") to move
                // the Block up or down if the previous Blocks didn't use up
                // their area or exceeded the Block area.

                $optlist .= " refpoint={ 0r " . $accumulated_offset_y . "r }";

                // Create a matchbox for the Block contents, using the Block name as matchbox name
                $optlist .= " matchbox={name={" . $textblock->name . "}}";

                if ($p->fill_textblock($pagehandles[$pageno], $textblock->name,
                $textblock->contents[$recipient], $optlist) == 0) {

                    print("Warning: " . $p->get_errmsg());
                } else {
                    // Calculate the height which wasn't used inside the Block
                    // or was used in excess outside the Block. This will be used
                    // for adjusting the position of the next Block.
                    
                    if ($p->info_matchbox($textblock->name, 1, "exists") == 1) {
                        // We successfully filled a Textflow Block. Retrieve the bottom edge
                        // of the matchbox which gives the vertical end position of the contents...
                        $content_lly = $p->info_matchbox($textblock->name, 1, "y1");		// (x1, y1) = lower left corner

                        // ...and use the distance from the bottom edge of the Block as offset
                        $accumulated_offset_y += ($content_lly - $adjusted_lly);
                    } else {
                        // If the Block is empty, no corresponding matchbox exists.
                        // We use the Block height as offset to skip the whole Block,
                        // not taking into account possible space between the Blocks.
                        $ury = $p->pcos_get_number($indoc, $blockpath + "/Rect[3]");
                        $accumulated_offset_y += ($ury - $lly);
                    }
                }

            }

            // Process all image Blocks
            foreach ($ImageBlocks as $imageblock) {
                $image = $p->load_image("auto", $imageblock->contents[$recipient], "");
                if ($image == 0) {
                    throw new Exception("Error: " . $p->get_errmsg());
                }

                // Fill image Block
                if ($p->fill_imageblock($pagehandles[$pageno], $imageblock->name, $image, "") == 0)
                    print("Warning: " . $p->get_errmsg());
                $p->close_image($image);
            }
            $p->end_page_ext("");
        }
    }

    // Close the preloaded template pages
    for ($pageno = 1; $pageno <= $no_of_input_pages; $pageno++){
        $p->close_pdi_page($pagehandles[$pageno]);
    }
    $p->close_pdi_document($indoc);

    $p->end_document("");

    $buf = $p->get_buffer();
    $len = strlen($buf);

    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_block.pdf");
    print $buf;

}
catch (PDFlibException $e) {
    die("PDFlib exception occurred in starter_block sample:\n" .
        "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
        $e->get_errmsg() . "\n");
}
catch (Throwable $e) {
    die("PHP exception occurred: " . $e->getMessage() . "\n");
}

$p = 0;
?>
