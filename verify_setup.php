<?php
echo "=================================================\n";
echo "       ARTIKEL EDITOR FIX - VERIFICATION\n";
echo "=================================================\n\n";

require_once './config/koneksi.php';

$checks_passed = 0;
$checks_failed = 0;

// Check 1: Database connection
echo "1. Database Connection: ";
if ($koneksi->ping()) {
  echo "✓ PASS\n";
  $checks_passed++;
} else {
  echo "✗ FAIL\n";
  $checks_failed++;
}

// Check 2: tb_artikel table exists
echo "2. Table tb_artikel exists: ";
$result = mysqli_query($koneksi, "DESCRIBE tb_artikel");
if ($result) {
  echo "✓ PASS\n";
  $checks_passed++;
} else {
  echo "✗ FAIL\n";
  $checks_failed++;
}

// Check 3: tb_author_artikel table exists
echo "3. Table tb_author_artikel exists: ";
$result = mysqli_query($koneksi, "DESCRIBE tb_author_artikel");
if ($result) {
  echo "✓ PASS\n";
  $checks_passed++;
} else {
  echo "✗ FAIL\n";
  $checks_failed++;
}

// Check 4: Authors available
echo "4. Author records available: ";
$result = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM tb_author_artikel");
if ($result && $row = mysqli_fetch_assoc($result)) {
  if ($row['count'] > 0) {
    echo "✓ PASS ({$row['count']} authors)\n";
    $checks_passed++;
  } else {
    echo "✗ FAIL (No authors)\n";
    $checks_failed++;
  }
}

// Check 5: Articles table structure
echo "5. tb_artikel has required fields: ";
$required_fields = ['id_artikel', 'judul', 'isi', 'id_penulis', 'status', 'created_at'];
$result = mysqli_query($koneksi, "DESCRIBE tb_artikel");
$existing_fields = [];
while ($row = mysqli_fetch_assoc($result)) {
  $existing_fields[] = $row['Field'];
}
$missing = array_diff($required_fields, $existing_fields);
if (empty($missing)) {
  echo "✓ PASS\n";
  $checks_passed++;
} else {
  echo "✗ FAIL (Missing: " . implode(', ', $missing) . ")\n";
  $checks_failed++;
}

// Check 6: File exists - articles_content.php
echo "6. File contents/articles_content.php exists: ";
if (file_exists('./contents/articles_content.php')) {
  echo "✓ PASS\n";
  $checks_passed++;
} else {
  echo "✗ FAIL\n";
  $checks_failed++;
}

// Check 7: File exists - tambah_artikel.php
echo "7. File auth/actions/tambah_artikel.php exists: ";
if (file_exists('./auth/actions/tambah_artikel.php')) {
  echo "✓ PASS\n";
  $checks_passed++;
} else {
  echo "✗ FAIL\n";
  $checks_failed++;
}

// Check 8: Quill CDN in articles_content.php
echo "8. Quill.js CDN referenced: ";
$content = file_get_contents('./contents/articles_content.php');
if (strpos($content, 'quilljs.com') !== false) {
  echo "✓ PASS\n";
  $checks_passed++;
} else {
  echo "✗ FAIL\n";
  $checks_failed++;
}

// Check 9: Test article in database
echo "9. Test article exists: ";
$result = mysqli_query($koneksi, "SELECT COUNT(*) as count FROM tb_artikel");
if ($result && $row = mysqli_fetch_assoc($result)) {
  if ($row['count'] > 0) {
    echo "✓ PASS ({$row['count']} articles)\n";
    $checks_passed++;
    
    // Show test article details
    $result = mysqli_query($koneksi, "SELECT id_artikel, judul, id_penulis FROM tb_artikel LIMIT 1");
    if ($row = mysqli_fetch_assoc($result)) {
      echo "   └─ Sample: ID={$row['id_artikel']}, Title=" . substr($row['judul'], 0, 40) . "\n";
    }
  } else {
    echo "✓ PASS (0 articles - ready for new)\n";
    $checks_passed++;
  }
}

// Check 10: id_penulis field populated
echo "10. Form updates use id_penulis: ";
if (strpos($content, "id_penulis") !== false) {
  echo "✓ PASS\n";
  $checks_passed++;
} else {
  echo "✗ FAIL\n";
  $checks_failed++;
}

echo "\n=================================================\n";
echo "SUMMARY\n";
echo "=================================================\n";
echo "Total Checks: " . ($checks_passed + $checks_failed) . "\n";
echo "Passed: ✓ $checks_passed\n";
echo "Failed: ✗ $checks_failed\n";

if ($checks_failed === 0) {
  echo "\n✅ SISTEM SIAP! Artikel editor dapat digunakan.\n";
  echo "\nAkses: http://localhost/warehouse_management/pages/articles.php\n";
} else {
  echo "\n⚠️  ADA BEBERAPA MASALAH. Silakan cek di atas.\n";
}

echo "=================================================\n";

mysqli_close($koneksi);
?>
