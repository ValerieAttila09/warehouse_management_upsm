<?php
require_once __DIR__ . '/config/koneksi.php';

$slug = trim($_GET['slug'] ?? '');
$article = null;
$errorMessage = '';

if ($slug === '') {
  $errorMessage = 'Article tidak ditemukan. Pastikan link artikel valid.';
} else {
  $sql = "SELECT
                a.judul,
                a.slug,
                a.ringkasan,
                a.isi,
                a.thumbnail,
                a.tanggal_terbit,
                p.nama AS author,
                k.nama AS kategori
            FROM tb_artikel a
            LEFT JOIN tb_author_artikel p ON a.id_penulis = p.id
            LEFT JOIN tb_kategori_artikel k ON a.id_kategori = k.id
            WHERE a.status = 'terbit' AND a.slug = ?
            LIMIT 1";

  $stmt = mysqli_prepare($koneksi, $sql);
  if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $slug);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) === 1) {
      $article = mysqli_fetch_assoc($result);
    } else {
      $errorMessage = 'Article yang diminta tidak tersedia atau sudah tidak diterbitkan.';
    }

    mysqli_stmt_close($stmt);
  } else {
    $errorMessage = 'Terjadi kesalahan saat memuat artikel. Silakan coba lagi nanti.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/contents/header.php'; ?>

<body class="bg-slate-950 text-neutral-100">

  <nav class="fixed top-0 w-full bg-slate-900/95 backdrop-blur-md z-50 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center space-x-2">
          <a href="./index.php" class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-cyan-500 rounded-lg flex items-center justify-center google-sans-bold text-slate-900">W</a>
          <a href="./index.php" class="text-xl google-sans-bold">Warehouse</a>
        </div>
        <div class="hidden md:flex space-x-8">
          <a href="./index.php" class="hover:text-emerald-400 transition duration-300">Home</a>
          <a href="./articles.php" class="text-emerald-400 google-sans-semibold transition duration-300">Articles</a>
          <a href="./index.php#features" class="hover:text-emerald-400 transition duration-300">Features</a>
          <a href="./index.php#pricing" class="hover:text-emerald-400 transition duration-300">Pricing</a>
        </div>
        <div class="hidden md:block">
          <a href="./articles.php" class="px-6 py-2 bg-emerald-500 hover:bg-emerald-600 rounded-lg google-sans-semibold transition duration-300">Back to articles</a>
        </div>
        <button id="mobileMenuBtn" class="md:hidden text-neutral-300 hover:text-white">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
  </nav>

  <div id="mobileMenu" class="hidden fixed top-16 left-0 right-0 bg-slate-800 md:hidden z-40 border-b border-slate-700">
    <div class="px-4 py-4 space-y-2">
      <a href="./index.php" class="block px-4 py-2 hover:bg-slate-700 rounded">Home</a>
      <a href="./articles.php" class="block px-4 py-2 text-emerald-400 rounded">Articles</a>
      <a href="./index.php#features" class="block px-4 py-2 hover:bg-slate-700 rounded">Features</a>
      <a href="./index.php#pricing" class="block px-4 py-2 hover:bg-slate-700 rounded">Pricing</a>
      <a href="./articles.php" class="block w-full mt-4 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 rounded text-center google-sans-semibold">Back to articles</a>
    </div>
  </div>

  <main class="pt-28 pb-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
      <?php if ($article === null): ?>
        <section class="rounded-[28px] border border-slate-800/80 bg-slate-900/90 p-12 shadow-[0_20px_40px_rgba(15,23,42,0.16)]">
          <h1 class="text-3xl google-sans-semibold text-white mb-4">Artikel tidak ditemukan</h1>
          <p class="text-slate-400 leading-8 mb-6"><?= htmlspecialchars($errorMessage) ?></p>
          <a href="./articles.php" class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-500 hover:bg-emerald-600 rounded-full text-sm google-sans-semibold text-slate-950 transition duration-300">Kembali ke daftar artikel</a>
        </section>
      <?php else: ?>
        <?php
        $title = htmlspecialchars($article['judul']);
        $author = htmlspecialchars($article['author'] ?: 'Unknown Author');
        $category = htmlspecialchars($article['kategori'] ?: 'General');
        $published = !empty($article['tanggal_terbit']) ? date('d M Y', strtotime($article['tanggal_terbit'])) : 'Unknown date';
        $thumbnail = trim($article['thumbnail']);
        $summary = htmlspecialchars($article['ringkasan'] ?: mb_substr(strip_tags($article['isi']), 0, 180) . '...');
        ?>
        <section class="rounded-[28px] border border-slate-800/80 bg-slate-900/95 overflow-hidden shadow-[0_20px_40px_rgba(15,23,42,0.16)]">
          <?php if ($thumbnail !== ''): ?>
            <div class="h-96 overflow-hidden bg-slate-800">
              <img src="<?= $thumbnail ?>" alt="<?= $title ?>" class="h-full w-full object-cover transition duration-500 hover:scale-105">
            </div>
          <?php endif; ?>
          <div class="p-10 lg:p-12">
            <div class="flex flex-wrap gap-3 mb-6">
              <span class="rounded-full bg-emerald-500/10 px-4 py-2 text-xs uppercase tracking-[0.2em] text-emerald-300"><?= $category ?></span>
              <span class="rounded-full bg-slate-700/80 px-4 py-2 text-xs uppercase tracking-[0.2em] text-slate-300">Published</span>
            </div>
            <h1 class="text-4xl sm:text-5xl google-sans-semibold text-white mb-6"><?= $title ?></h1>
            <p class="text-slate-400 text-lg leading-8 mb-8"><?= $summary ?></p>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between text-sm text-slate-400 mb-10">
              <span>By <?= $author ?></span>
              <span><?= $published ?></span>
            </div>
            <div class="prose prose-invert max-w-none text-slate-100 article-detail-content">
              <?= $article['isi'] ?>
            </div>
            <div class="mt-12">
              <a href="./articles.php" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-800 hover:bg-slate-700 rounded-full text-sm google-sans-semibold text-white transition duration-300">← Back to articles</a>
            </div>
          </div>
        </section>
      <?php endif; ?>
    </div>
  </main>

  <script>
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileMenuBtn && mobileMenu) {
      mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
    }
  </script>
</body>

</html>