<?php
// Small dependency-free XLSX writer. All strings are explicitly typed as text.
function exportXlsx(string $name,array $headers,array $rows): void {
 $file=tempnam(sys_get_temp_dir(),'anita-xlsx-');$zip=new ZipArchive();
 if($zip->open($file,ZipArchive::OVERWRITE)!==true)throw new RuntimeException('Tidak dapat membuat file laporan.');
 $xml=fn($v)=>htmlspecialchars(preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/u','',(string)($v??'')),ENT_XML1|ENT_QUOTES,'UTF-8');
 $sheet='<?xml version="1.0" encoding="UTF-8"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" activePane="bottomLeft" state="frozen"/></sheetView></sheetViews><cols><col min="1" max="30" width="24" customWidth="1"/></cols><sheetData>';
 foreach([$headers,...$rows] as $i=>$row){$sheet.='<row r="'.($i+1).'">';foreach($row as $v)$sheet.='<c t="inlineStr"><is><t xml:space="preserve">'.$xml($v).'</t></is></c>';$sheet.='</row>';}$sheet.='</sheetData></worksheet>';
 $zip->addFromString('[Content_Types].xml','<?xml version="1.0"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/></Types>');
 $zip->addFromString('_rels/.rels','<?xml version="1.0"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
 $zip->addFromString('xl/workbook.xml','<?xml version="1.0"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Laporan" sheetId="1" r:id="rId1"/></sheets></workbook>');
 $zip->addFromString('xl/_rels/workbook.xml.rels','<?xml version="1.0"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/></Relationships>');
 $zip->addFromString('xl/worksheets/sheet1.xml',$sheet);$zip->close();
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');header('Content-Disposition: attachment; filename="'.$name.'.xlsx"');header('Content-Length: '.filesize($file));readfile($file);unlink($file);exit;
}
