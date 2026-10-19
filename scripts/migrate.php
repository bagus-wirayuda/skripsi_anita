<?php
// Additive migration: never replaces existing school data or passwords.
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require_once __DIR__.'/../config/database.php';
$sql = file_get_contents(__DIR__.'/../migrations/001_workflows.sql');
getDB()->multi_query($sql);
do { if ($r=getDB()->store_result()) $r->free(); } while (getDB()->more_results() && getDB()->next_result());
if (!fetchOne("SHOW COLUMNS FROM absensi_siswa LIKE 'jam_keluar'")) query('ALTER TABLE absensi_siswa ADD jam_keluar TIME NULL AFTER jam_masuk');
echo "Migrasi selesai. Data lama dipertahankan.\n";
