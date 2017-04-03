<?php
/**
* base.php - Controller file for RTF generator.
*
* This file is part of Anthologize {@link http://anthologize.org}.
*
* @author One Week | One Tool {@link http://oneweekonetool.org/people/}
*
* Last Modified: Fri Aug 06 15:54:55 CDT 2010
*
* @copyright Copyright (c) 2010 Center for History and New Media,
* George Mason University.
*
* Anthologize is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 3, or (at your option) any
* later version.
*
* Anthologize is distributed in the hope that it will be useful, but
* WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
* or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License
* for more details.
*
* You should have received a copy of the GNU General Public License
* along with Anthologize; see the file license.txt.  If not see
* @link http://www.gnu.org/licenses/.
*
* @package anthologize
*/

include_once(ANTHOLOGIZE_TEIDOM_PATH);
include_once(ANTHOLOGIZE_TEIDOMAPI_PATH);
$anthPluginDir = WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . 'anthologize' . DIRECTORY_SEPARATOR;
require_once($anthPluginDir . 'includes'  . DIRECTORY_SEPARATOR . 'class-anthologizer.php');
require_once($anthPluginDir . 'templates' . DIRECTORY_SEPARATOR . 'rtf' . DIRECTORY_SEPARATOR . 'class-rtf-anthologizer.php' );

$ops = array(
  'includeStructuredSubjects' => false, //Include structured data about tags and categories
  'includeItemSubjects' => false, // Include basic data about tags and categories
  'includeCreatorData' => false, // Include basic data about creators
  'includeStructuredCreatorData' => false, //include structured data about creators
  'includeOriginalPostData' => false, //include data about the original post (true to use tags and categories)
  'checkImgSrcs' => true, //whether to check availability of image sources
  'linkToEmbeddedObjects' => true,
  'indexSubjects' => false,
  'indexCategories' => false,
  'indexTags' => false,
  'indexAuthors' => false,
  'indexImages' => false
);

function getAllPostsByPostParentID($parentID) {
  global $wpdb;
  $sql = "SELECT * FROM wp_posts WHERE post_type='anth_part' AND post_status='draft' AND post_parent=$parentID";
  $posts = $wpdb->get_results($sql);
  
  return $posts;
}

//print_r($_SESSION);
//print_r($ops);
//die;

//$tei = new TeiDom($_SESSION, $ops);
//$api = new TeiApi($tei);
// $rtfer = new RtfAnthologizer($api);
// $rtfer->output();
// die();

require_once 'PHPWord-develop/bootstrap.php';

// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->getCompatibility()->setOoxmlVersion(15);

$paragraphStyleName = 'pStyle';
$phpWord->addParagraphStyle($paragraphStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$bodyStyleName = 'bodyStyle';
$phpWord->addParagraphStyle($bodyStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::DISTRIBUTE));
$phpWord->addTitleStyle(1, array('size' => 20, 'color' => '333333', 'bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$phpWord->addTitleStyle(2, array('size' => 16, 'color' => '666666'));
$phpWord->addTitleStyle(3, array('size' => 14), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$phpWord->addTitleStyle(4, array('size' => 12));
$fontStyle12 = array('spaceAfter' => 60, 'size' => 12);

// First Page
$section = $phpWord->addSection();
$section->addText($_SESSION['post-title'], null, $paragraphStyleName);

// Table of Contents
$section->addPageBreak();
$section->addText('Table of Contents', null, $paragraphStyleName);
$toc = $section->addTOC($fontStyle12);

$sectionContent = $phpWord->addSection(array('pageNumberingStart' => 1));
$footer = $sectionContent->addFooter();
$footer->addPreserveText('{PAGE}', null, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));

$projectID = $_SESSION['project_id'];

//Main Parts
$posts = getAllPostsByPostParentID($projectID);
if(!empty($posts)) {
  foreach ($posts as $post) {
    $sectionContent->addTitle($post->post_title, 1);
    //$sectionContent->addTitle('Subtitle 3.1.1', 3);
    $sectionContent->addText($post->post_content, null, $bodyStyleName);
    
    //Subparts
    $subparts = getAllPostsByPostParentID($post->ID);
    if(!empty($subparts)) {
      foreach ($subparts as $subpart) {
        $sectionContent->addTitle($subpart->post_title, 1);
        $sectionContent->addText($subpart->post_content, null, $bodyStyleName);
      }
    }
    
    $sectionContent->addPageBreak();
  }
}


// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$fileName = $_SESSION['post-title'];
$outputPath = $anthPluginDir . 'templates' . DIRECTORY_SEPARATOR . 'word' . DIRECTORY_SEPARATOR . 'results' . DIRECTORY_SEPARATOR . $fileName . '.docx';
$objWriter->save($outputPath);

// Downloading the document as OOXML file...
header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
header("Content-Disposition: attachment; filename=\"" . basename($outputPath) . "\";");
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($outputPath));
ob_clean();
flush();
readfile($outputPath); //showing the path to the server where the file is to be download
unlink($outputPath);
exit;
?>