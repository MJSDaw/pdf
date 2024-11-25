<?php
/* PHP interface description for PDFlib
 * Copyright (c) PDFlib GmbH 2009-2022
 *
 * Note that this is only a syntax summary.
 * For complete information please refer to the API reference
 * which is available in the distribution.
 */

class PDFlibException {
/**
 * Get the number of the last thrown exception or the reason for a failed function call.
 *
 * @return int
 */
function get_errnum() {}

/**
 * Get the text of the last thrown exception or the reason for a failed function call.
 *
 * @return string
 */
function get_errmsg() {}

/**
 * Get the name of the API function which threw the last exception or failed.
 *
 * @return string
 */
function get_apiname() {}
};


class PDFlib {


/**
 * Activate a previously created structure element or other content item.
 *
 * @param int $id
 */
function activate_item($id) {}


/**
 * Create a named destination on a page in the document.
 *
 * @param string $name
 * @param string $optlist
 */
function add_nameddest($name, $optlist) {}


/**
 * Add a point to a new or existing path object.
 *
 * @param int $path
 * @param float $x
 * @param float $y
 * @param string $type
 * @param string $optlist
 * @return int  A path handle which can be used in subsequent path-related calls.
 */
function add_path_point($path, $x, $y, $type, $optlist) {}


/**
 * Add a file to a portfolio folder or a package.
 *
 * @param int $folder
 * @param string $filename
 * @param string $optlist
 * @return int  -1 (in PHP: 0) on error, and 1 otherwise.
 */
function add_portfolio_file($folder, $filename, $optlist) {}


/**
 * Add a folder to a new or existing portfolio.
 *
 * @param int $parent
 * @param string $foldername
 * @param string $optlist
 * @return int  A folder handle which can be used in subsequent portfolio-related calls.
 */
function add_portfolio_folder($parent, $foldername, $optlist) {}


/**
 * Add a cell to a new or existing table.
 *
 * @param int $table
 * @param int $column
 * @param int $row
 * @param string $text
 * @param string $optlist
 * @return int  A table handle which can be used in subsequent table-related calls.
 */
function add_table_cell($table, $column, $row, $text, $optlist) {}


/**
 * Create a Textflow object, or add text and explicit options to an existing Textflow.
 *
 * @param int $textflow
 * @param string $text
 * @param string $optlist
 * @return int  A Textflow handle, or -1 (in PHP: 0) on error.
 */
function add_textflow($textflow, $text, $optlist) {}


/**
 * Align the coordinate system with a relative vector.
 *
 * @param float $dx
 * @param float $dy
 */
function align($dx, $dy) {}


/**
 * Draw a counterclockwise circular arc segment.
 *
 * @param float $x
 * @param float $y
 * @param float $r
 * @param float $alpha
 * @param float $beta
 */
function arc($x, $y, $r, $alpha, $beta) {}


/**
 * Draw a clockwise circular arc segment.
 *
 * @param float $x
 * @param float $y
 * @param float $r
 * @param float $alpha
 * @param float $beta
 */
function arcn($x, $y, $r, $alpha, $beta) {}


/**
 * Create a new PDF file subject to various options.
 *
 * @param string $filename
 * @param string $optlist
 * @return int  -1 (in PHP: 0) on error, and 1 otherwise.
 */
function begin_document($filename, $optlist) {}


/**
 * Create a new node in the document part hierarchy (requires PDF/VT or   PDF 2.0).
 *
 * @param string $optlist
 */
function begin_dpart($optlist) {}


/**
 * Start a Type 3 font definition.
 *
 * @param string $fontname
 * @param float $a
 * @param float $b
 * @param float $c
 * @param float $d
 * @param float $e
 * @param float $f
 * @param string $optlist
 */
function begin_font($fontname, $a, $b, $c, $d, $e, $f, $optlist) {}


/**
 * Start a glyph definition for a Type 3 font.
 *
 * @param int $uv
 * @param string $optlist
 */
function begin_glyph_ext($uv, $optlist) {}


/**
 * Open a structure element or other content item with attributes supplied as options.
 *
 * @param string $tagname
 * @param string $optlist
 * @return int  An item handle.
 */
function begin_item($tagname, $optlist) {}


/**
 * Start a layer for subsequent output on the page.
 *
 * @param int $layer
 */
function begin_layer($layer) {}


/**
 * Begin a marked content sequence with optional properties.
 *
 * @param string $tagname
 * @param string $optlist
 */
function begin_mc($tagname, $optlist) {}


/**
 * Add a new page to the document, and specify various options.
 *
 * @param float $width
 * @param float $height
 * @param string $optlist
 */
function begin_page_ext($width, $height, $optlist) {}


/**
 * Start a pattern definition with options.
 *
 * @param float $width
 * @param float $height
 * @param string $optlist
 * @return int  A pattern handle.
 */
function begin_pattern_ext($width, $height, $optlist) {}


/**
 * Start a template definition.
 *
 * @param float $width
 * @param float $height
 * @param string $optlist
 * @return int  A template handle.
 */
function begin_template_ext($width, $height, $optlist) {}


/**
 * Draw a circle.
 *
 * @param float $x
 * @param float $y
 * @param float $r
 */
function circle($x, $y, $r) {}


/**
 * Draw a circular arc segment defined by three points.
 *
 * @param float $x1
 * @param float $y1
 * @param float $x2
 * @param float $y2
 */
function circular_arc($x1, $y1, $x2, $y2) {}


/**
 * Use the current path as clipping path, and terminate the path.
 *
 */
function clip() {}


/**
 * Close an open font handle which has not yet been used in the document.
 *
 * @param int $font
 */
function close_font($font) {}


/**
 * Close vector graphics.
 *
 * @param int $graphics
 */
function close_graphics($graphics) {}


/**
 * Close an image or template.
 *
 * @param int $image
 */
function close_image($image) {}


/**
 * Close all open PDI page handles, and close the input PDF document.
 *
 * @param int $doc
 */
function close_pdi_document($doc) {}


/**
 * Close the page handle and free all page-related resources.
 *
 * @param int $page
 */
function close_pdi_page($page) {}


/**
 * Close the current path.
 *
 */
function closepath() {}


/**
 * Close the path, fill, and stroke it.
 *
 */
function closepath_fill_stroke() {}


/**
 * Close the path, and stroke it.
 *
 */
function closepath_stroke() {}


/**
 * Apply a transformation matrix to the current coordinate system.
 *
 * @param float $a
 * @param float $b
 * @param float $c
 * @param float $d
 * @param float $e
 * @param float $f
 */
function concat($a, $b, $c, $d, $e, $f) {}


/**
 * Print text at the next line.
 *
 * @param string $text
 */
function continue_text($text) {}


/**
 * Convert a string in an arbitrary encoding to a Unicode string in various formats.
 *
 * @param string $inputformat
 * @param string $inputstring
 * @param string $optlist
 * @return string  The converted Unicode string.
 */
function convert_to_unicode($inputformat, $inputstring, $optlist) {}


/**
 * Create a 3D view.
 *
 * @param string $username
 * @param string $optlist
 * @return int  A 3D view handle, or -1 (in PHP: 0) on error.
 */
function create_3dview($username, $optlist) {}


/**
 * Create an action which can be applied to various objects and events.
 *
 * @param string $type
 * @param string $optlist
 * @return int  An action handle.
 */
function create_action($type, $optlist) {}


/**
 * Create an annotation on the current page.
 *
 * @param float $llx
 * @param float $lly
 * @param float $urx
 * @param float $ury
 * @param string $type
 * @param string $optlist
 */
function create_annotation($llx, $lly, $urx, $ury, $type, $optlist) {}


/**
 * Create a DeviceN colorspace with an arbitrary number of color components.
 *
 * @param string $optlist
 * @return int  A DeviceN color space handle, or -1 (in PHP: 0) on error.
 */
function create_devicen($optlist) {}


/**
 * Create a bookmark subject to various options.
 *
 * @param string $text
 * @param string $optlist
 * @return int  A handle for the generated bookmark.
 */
function create_bookmark($text, $optlist) {}


/**
 * Create a new form field or fill an imported form field.
 *
 * @param float $llx
 * @param float $lly
 * @param float $urx
 * @param float $ury
 * @param string $name
 * @param string $type
 * @param string $optlist
 */
function create_field($llx, $lly, $urx, $ury, $name, $type, $optlist) {}


/**
 * Create a form field group subject to various options.
 *
 * @param string $name
 * @param string $optlist
 */
function create_fieldgroup($name, $optlist) {}


/**
 * Create a graphics state object subject to various options.
 *
 * @param string $optlist
 * @return int  A graphic state handle.
 */
function create_gstate($optlist) {}


/**
 * Create a named virtual read-only file from data provided in memory.
 *
 * @param string $filename
 * @param string $data
 * @param string $optlist
 */
function create_pvf($filename, $data, $optlist) {}


/**
 * Create a Textflow object from text contents, inline options, and explicit options.
 *
 * @param string $text
 * @param string $optlist
 * @return int  A Textflow handle, or -1 (in PHP: 0) on error.
 */
function create_textflow($text, $optlist) {}


/**
 * Draw a Bezier curve from the current point, using 3 more control points.
 *
 * @param float $x1
 * @param float $y1
 * @param float $x2
 * @param float $y2
 * @param float $x3
 * @param float $y3
 */
function curveto($x1, $y1, $x2, $y2, $x3, $y3) {}


/**
 * Create a new layer definition.
 *
 * @param string $name
 * @param string $optlist
 * @return int  A layer handle which can be used in subsequent layer-related calls.
 */
function define_layer($name, $optlist) {}


/**
 * Delete a path object.
 *
 * @param int $path
 */
function delete_path($path) {}


/**
 * Delete a named virtual file and free its data structures (but not the contents).
 *
 * @param string $filename
 * @return int  -1 (in PHP: 0) if the virtual file exists but is locked, and 1 otherwise.
 */
function delete_pvf($filename) {}


/**
 * Delete a table and all associated data structures.
 *
 * @param int $table
 * @param string $optlist
 */
function delete_table($table, $optlist) {}


/**
 * Delete a textflow and all associated data structures.
 *
 * @param int $textflow
 */
function delete_textflow($textflow) {}


/**
 * Download data from a network resource and store it in a disk-based or virtual file.
 *
 * @param string $filename
 * @param string $optlist
 * @return int  -1 (in PHP: 0) on error, and 1 otherwise.
 */
function download($filename, $optlist) {}


/**
 * Draw a path object.
 *
 * @param int $path
 * @param float $x
 * @param float $y
 * @param string $optlist
 */
function draw_path($path, $x, $y, $optlist) {}


/**
 * Draw an ellipse.
 *
 * @param float $x
 * @param float $y
 * @param float $rx
 * @param float $ry
 */
function ellipse($x, $y, $rx, $ry) {}


/**
 * Draw an elliptical arc segment from the current point.
 *
 * @param float $x
 * @param float $y
 * @param float $rx
 * @param float $ry
 * @param string $optlist
 */
function elliptical_arc($x, $y, $rx, $ry, $optlist) {}


/**
 * Add a glyph name and/or Unicode value to a custom 8-bit encoding.
 *
 * @param string $encoding
 * @param int $slot
 * @param string $glyphname
 * @param int $uv
 */
function encoding_set_char($encoding, $slot, $glyphname, $uv) {}


/**
 * Close the generated PDF document and apply various options.
 *
 * @param string $optlist
 */
function end_document($optlist) {}


/**
 * Close a node in the document part hierarchy (requires PDF/VT or PDF 2.0).
 *
 * @param string $optlist
 */
function end_dpart($optlist) {}


/**
 * Terminate a Type 3 font definition.
 *
 */
function end_font() {}


/**
 * Terminate a glyph definition for a Type 3 font.
 *
 */
function end_glyph() {}


/**
 * Close a structure element or other content item.
 *
 * @param int $id
 */
function end_item($id) {}


/**
 * Deactivate all active layers.
 *
 */
function end_layer() {}


/**
 * End the least recently opened marked content sequence.
 *
 */
function end_mc() {}


/**
 * Finish a page, and apply various options.
 *
 * @param string $optlist
 */
function end_page_ext($optlist) {}


/**
 * Finish a pattern definition.
 *
 */
function end_pattern() {}


/**
 * Finish a template definition.
 *
 * @param float $width
 * @param float $height
 */
function end_template_ext($width, $height) {}


/**
 * End the current path without filling or stroking it.
 *
 */
function endpath() {}


/**
 * Fill the interior of the path with the current fill color.
 *
 */
function fill() {}


/**
 * Fill a graphics block with variable data according to its properties.
 *
 * @param int $page
 * @param string $blockname
 * @param int $graphics
 * @param string $optlist
 * @return int  -1 (in PHP: 0) on error, and 1 otherwise.
 */
function fill_graphicsblock($page, $blockname, $graphics, $optlist) {}


/**
 * Fill an image block with variable data according to its properties.
 *
 * @param int $page
 * @param string $blockname
 * @param int $image
 * @param string $optlist
 * @return int  -1 (in PHP: 0) on error, and 1 otherwise.
 */
function fill_imageblock($page, $blockname, $image, $optlist) {}


/**
 * Fill a PDF block with variable data according to its properties.
 *
 * @param int $page
 * @param string $blockname
 * @param int $contents
 * @param string $optlist
 * @return int  -1 (in PHP: 0) on error, and 1 otherwise.
 */
function fill_pdfblock($page, $blockname, $contents, $optlist) {}


/**
 * Fill a Textline or Textflow Block with variable data according to its properties.
 *
 */
function fill_stroke() {}


/**
 * Fill a Textline or Textflow Block with variable data according to its properties.
 *
 * @param int $page
 * @param string $blockname
 * @param string $text
 * @param string $optlist
 * @return int  -1 (in PHP: 0) on error, and 1 otherwise.
 */
function fill_textblock($page, $blockname, $text, $optlist) {}


/**
 * Place vector graphics on a content stream, subject to various options.
 *
 * @param int $graphics
 * @param float $x
 * @param float $y
 * @param string $optlist
 */
function fit_graphics($graphics, $x, $y, $optlist) {}


/**
 * Place an image or template on the page, subject to various options.
 *
 * @param int $image
 * @param float $x
 * @param float $y
 * @param string $optlist
 */
function fit_image($image, $x, $y, $optlist) {}


/**
 * Place an imported PDF page on the page subject to various options.
 *
 * @param int $page
 * @param float $x
 * @param float $y
 * @param string $optlist
 */
function fit_pdi_page($page, $x, $y, $optlist) {}


/**
 * Fully or partially place a table on the page.
 *
 * @param int $table
 * @param float $llx
 * @param float $lly
 * @param float $urx
 * @param float $ury
 * @param string $optlist
 * @return string  A string which specifies the reason for returning.
 */
function fit_table($table, $llx, $lly, $urx, $ury, $optlist) {}


/**
 * Format the next portion of a Textflow.
 *
 * @param int $textflow
 * @param float $llx
 * @param float $lly
 * @param float $urx
 * @param float $ury
 * @param string $optlist
 * @return string  A string which specifies the reason for returning.
 */
function fit_textflow($textflow, $llx, $lly, $urx, $ury, $optlist) {}


/**
 * Place a single line of text at position (x, y) subject to various options.
 *
 * @param string $text
 * @param float $x
 * @param float $y
 * @param string $optlist
 */
function fit_textline($text, $x, $y, $optlist) {}


/**
 * Get the name of the API method which threw the last exception or failed.
 *
 * @return string  Name of an API method.
 */
function get_apiname() {}


/**
 * Get the contents of the PDF output buffer.
 *
 * @return string  A buffer full of binary PDF data for consumption by the client.
 */
function get_buffer() {}


/**
 * Get the text of the last thrown exception or the reason of a failed method call.
 *
 * @return string  Text containing the description of the most recent error condition.
 */
function get_errmsg() {}


/**
 * Get the number of the last thrown exception or the reason of a failed method call.
 *
 * @return int  The error code of the most recent error condition.
 */
function get_errnum() {}


/**
 * Retrieve some option or other value.
 *
 * @param string $keyword
 * @param string $optlist
 * @return float  The value of some option value as requested by keyword.
 */
function get_option($keyword, $optlist) {}


/**
 * Retrieve a string value.
 *
 * @param int $idx
 * @param string $optlist
 * @return string  a string identified by a string index returned by another method.
 */
function get_string($idx, $optlist) {}


/**
 * Query detailed information about a loaded font.
 *
 * @param int $font
 * @param string $keyword
 * @param string $optlist
 * @return float  The value of some font property as requested by keyword.
 */
function info_font($font, $keyword, $optlist) {}


/**
 * Format vector graphics and query metrics and other properties.
 *
 * @param int $graphics
 * @param string $keyword
 * @param string $optlist
 * @return float  The value of some graphics metrics as requested by keyword.
 */
function info_graphics($graphics, $keyword, $optlist) {}


/**
 * Format an image and query metrics and other image properties.
 *
 * @param int $image
 * @param string $keyword
 * @param string $optlist
 * @return float  The value of some image metrics as requested by keyword.
 */
function info_image($image, $keyword, $optlist) {}


/**
 * Query information about a matchbox on the current page.
 *
 * @param string $boxname
 * @param int $num
 * @param string $keyword
 * @return float  The value of some matchbox parameter as requested by keyword.
 */
function info_matchbox($boxname, $num, $keyword) {}


/**
 * Query the results of drawing a path object without actually drawing it.
 *
 * @param int $path
 * @param string $keyword
 * @param string $optlist
 * @return float  The value of some geometrical values as requested by keyword.
 */
function info_path($path, $keyword, $optlist) {}


/**
 * Perform formatting calculations for a PDI page and query the resulting metrics.
 *
 * @param int $page
 * @param string $keyword
 * @param string $optlist
 * @return float  The value of some page metrics as requested by keyword.
 */
function info_pdi_page($page, $keyword, $optlist) {}


/**
 * Query properties of a virtual file or the PDFlib Virtual Filesystem (PVF).
 *
 * @param string $filename
 * @param string $keyword
 * @return float  The value of some file parameter as requested by keyword.
 */
function info_pvf($filename, $keyword) {}


/**
 * Query table information related to the most recently placed table instance.
 *
 * @param int $table
 * @param string $keyword
 * @return float  The value of some table parameter as requested by keyword.
 */
function info_table($table, $keyword) {}


/**
 * Query the current state of a Textflow.
 *
 * @param int $textflow
 * @param string $keyword
 * @return float  The value of some Textflow parameter as requested by keyword.
 */
function info_textflow($textflow, $keyword) {}


/**
 * Perform textline formatting without creating output and query the resulting metrics.
 *
 * @param string $text
 * @param string $keyword
 * @param string $optlist
 * @return float  The value of some text metric value as requested by keyword.
 */
function info_textline($text, $keyword, $optlist) {}


/**
 * Draw a line from the current point to another point.
 *
 * @param float $x
 * @param float $y
 */
function lineto($x, $y) {}


/**
 * Load a 3D model from a disk-based or virtual file.
 *
 * @param string $filename
 * @param string $optlist
 * @return int  A 3D handle, or -1 (in PHP: 0) on error.
 */
function load_3ddata($filename, $optlist) {}


/**
 * Load a multimedia asset or file attachment from a file or URL.
 *
 * @param string $type
 * @param string $filename
 * @param string $optlist
 * @return int  An asset handle, or -1 (in PHP: 0) on error.
 */
function load_asset($type, $filename, $optlist) {}


/**
 * Search for a font and prepare it for later use.
 *
 * @param string $fontname
 * @param string $encoding
 * @param string $optlist
 * @return int  A font handle.
 */
function load_font($fontname, $encoding, $optlist) {}


/**
 * Open a disk-based or virtual vector graphics file subject to various options.
 *
 * @param string $type
 * @param string $filename
 * @param string $optlist
 * @return int  A graphics handle, or -1 (in PHP: 0) on error.
 */
function load_graphics($type, $filename, $optlist) {}


/**
 * Search for an ICC profile, and prepare it for later use.
 *
 * @param string $profilename
 * @param string $optlist
 * @return int  A profile handle.
 */
function load_iccprofile($profilename, $optlist) {}


/**
 * Open a disk-based or virtual image file subject to various options.
 *
 * @param string $imagetype
 * @param string $filename
 * @param string $optlist
 * @return int  An image handle, or -1 (in PHP: 0) on error.
 */
function load_image($imagetype, $filename, $optlist) {}


/**
 * Find a built-in spot color name, or make a named spot color from the current fill color.
 *
 * @param string $spotname
 * @return int  A color handle.
 */
function makespotcolor($spotname) {}


/**
 * Add a marked content point with optional properties.
 *
 * @param string $tagname
 * @param string $optlist
 */
function mc_point($tagname, $optlist) {}


/**
 * Set the current point for graphics output.
 *
 * @param float $x
 * @param float $y
 */
function moveto($x, $y) {}


/**
 * Open a disk-based or virtual PDF document and prepare it for later use.
 *
 * @param string $filename
 * @param string $optlist
 * @return int  A PDI document handle.
 */
function open_pdi_document($filename, $optlist) {}


/**
 * Prepare a page for later use with PDF_fit_pdi_page().
 *
 * @param int $doc
 * @param int $pagenumber
 * @param string $optlist
 * @return int  A page handle.
 */
function open_pdi_page($doc, $pagenumber, $optlist) {}


/**
 * Get the value of a pCOS path with type number or boolean.
 *
 * @param int $doc
 * @param string $path
 * @return float  The numerical value of the object identified by the pCOS path.
 */
function pcos_get_number($doc, $path) {}


/**
 * Get the value of a pCOS path with type name, number, string, or boolean.
 *
 * @param int $doc
 * @param string $path
 * @return string  A string with the value of the object identified by the pCOS path.
 */
function pcos_get_string($doc, $path) {}


/**
 * Get the contents of a pCOS path with type stream, fstream, or string.
 *
 * @param int $doc
 * @param string $optlist
 * @param string $path
 * @return string  The unencrypted data contained in the stream or string.
 */
function pcos_get_stream($doc, $optlist, $path) {}


/**
 * Delete a PDF container object.
 *
 * @param int $container
 * @param string $optlist
 */
function poca_delete($container, $optlist) {}


/**
 * Insert a simple or container object in a PDF container object.
 *
 * @param int $container
 * @param string $optlist
 */
function poca_insert($container, $optlist) {}


/**
 * Create a new PDF container object of type dictionary or array and insert objects.
 *
 * @param string $optlist
 * @return int  A container handle which can be used until it is deleted with PDF_poca_delete().
 */
function poca_new($optlist) {}


/**
 * Remove a simple or container object from a PDF container object.
 *
 * @param int $container
 * @param string $optlist
 */
function poca_remove($container, $optlist) {}


/**
 * Process certain elements of an imported PDF document.
 *
 * @param int $doc
 * @param int $page
 * @param string $optlist
 * @return int  -1 (in PHP: 0) on error, and 1 otherwise.
 */
function process_pdi($doc, $page, $optlist) {}


/**
 * Draw a rectangle.
 *
 * @param float $x
 * @param float $y
 * @param float $width
 * @param float $height
 */
function rect($x, $y, $width, $height) {}


/**
 * Restore the most recently saved graphics state from the stack.
 *
 */
function restore() {}


/**
 * Resume a page to add more content to it.
 *
 * @param string $optlist
 */
function resume_page($optlist) {}


/**
 * Rotate the coordinate system.
 *
 * @param float $phi
 */
function rotate($phi) {}


/**
 * Save the current graphics state to a stack.
 *
 */
function save() {}


/**
 * Scale the coordinate system.
 *
 * @param float $sx
 * @param float $sy
 */
function scale($sx, $sy) {}


/**
 * Set one or more graphics appearance options.
 *
 * @param string $optlist
 */
function set_graphics_option($optlist) {}


/**
 * Activate a graphics state object.
 *
 * @param int $gstate
 */
function set_gstate($gstate) {}


/**
 * Fill document information field key with value.
 *
 * @param string $key
 * @param string $value
 */
function set_info($key, $value) {}


/**
 * Define layer relationships.
 *
 * @param string $type
 * @param string $optlist
 */
function set_layer_dependency($type, $optlist) {}


/**
 * Set one or more global options.
 *
 * @param string $optlist
 */
function set_option($optlist) {}


/**
 * Set one or more text filter or text appearance options for simple text output methods.
 *
 * @param string $optlist
 */
function set_text_option($optlist) {}


/**
 * Set the position for simple text output on the page.
 *
 * @param float $x
 * @param float $y
 */
function set_text_pos($x, $y) {}


/**
 * Set the color space and color for the graphics and text state..
 *
 * @param string $fstype
 * @param string $colorspace
 * @param float $c1
 * @param float $c2
 * @param float $c3
 * @param float $c4
 */
function setcolor($fstype, $colorspace, $c1, $c2, $c3, $c4) {}


/**
 * Set the current font in the specified size.
 *
 * @param int $font
 * @param float $fontsize
 */
function setfont($font, $fontsize) {}


/**
 * Set the current linewidth.
 *
 * @param float $width
 */
function setlinewidth($width) {}


/**
 * Explicitly set the current transformation matrix.
 *
 * @param float $a
 * @param float $b
 * @param float $c
 * @param float $d
 * @param float $e
 * @param float $f
 */
function setmatrix($a, $b, $c, $d, $e, $f) {}


/**
 * Define a shading (color gradient) between two or more colors.
 *
 * @param string $type
 * @param float $x0
 * @param float $y0
 * @param float $x1
 * @param float $y1
 * @param float $c1
 * @param float $c2
 * @param float $c3
 * @param float $c4
 * @param string $optlist
 * @return int  A shading handle.
 */
function shading($type, $x0, $y0, $x1, $y1, $c1, $c2, $c3, $c4, $optlist) {}


/**
 * Define a shading pattern using a shading object.
 *
 * @param int $shading
 * @param string $optlist
 * @return int  A pattern handle.
 */
function shading_pattern($shading, $optlist) {}


/**
 * Fill an area with a shading, based on a shading object.
 *
 * @param int $shading
 */
function shfill($shading) {}


/**
 * Print text in the current font and size at the current position.
 *
 * @param string $text
 */
function show($text) {}


/**
 * Print text in the current font at the specified position.
 *
 * @param string $text
 * @param float $x
 * @param float $y
 */
function show_xy($text, $x, $y) {}


/**
 * Skew the coordinate system.
 *
 * @param float $alpha
 * @param float $beta
 */
function skew($alpha, $beta) {}


/**
 * Calculate the width of text in an arbitrary font.
 *
 * @param string $text
 * @param int $font
 * @param float $fontsize
 * @return float  The width of text.
 */
function stringwidth($text, $font, $fontsize) {}


/**
 * Stroke the path with the current color and line width, and clear it.
 *
 */
function stroke() {}


/**
 * Suspend the current page so that it can later be resumed.
 *
 * @param string $optlist
 */
function suspend_page($optlist) {}


/**
 * Translate the origin of the coordinate system.
 *
 * @param float $tx
 * @param float $ty
 */
function translate($tx, $ty) {}

};
?>
