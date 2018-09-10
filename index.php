<?php
function text_read_word($input_file){	
	 $word_strip_texts = ''; 
         $found_texts = ''; 	
	if(!$input_file || !file_exists($input_file)) return false;	
	$zip = zip_open($input_file);	
	if (!$zip || is_numeric($zip)) return false;
	while ($zip_entry = zip_read($zip)) {
		if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
		if (zip_entry_name($zip_entry) != "word/document.xml") continue;
		$found_texts .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));	
		zip_entry_close($zip_entry);
	}
	zip_close($zip);
	$found_texts = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $found_texts);
	$found_texts = str_replace('</w:r></w:p>', "\r\n", $found_texts);
	$word_strip_texts = nl2br(strip_tags($found_texts,''));
	return $word_strip_texts;
}
?>

<?php
$found_texts = text_read_word('tempf.docx');
if($found_texts !== false) {		
	echo nl2br($found_texts);	
}
else {
	echo 'Cant Read that file.';
}
?>
