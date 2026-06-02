<div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
  <main>

    <!-- Alert Messages -->
    <?php
    $success_msg = '';
    $error_msg = '';

    if (isset($_GET['created'])) {
      $success_msg = 'Article created successfully!';
    } elseif (isset($_GET['updated'])) {
      $success_msg = 'Article updated successfully!';
    } elseif (isset($_GET['deleted'])) {
      $success_msg = 'Article deleted successfully!';
    } elseif (isset($_GET['error'])) {
      $error_code = $_GET['error'];
      if ($error_code === '1') {
        $error_msg = 'An error occurred. Please fill in all required fields.';
      } elseif ($error_code === '3') {
        $error_msg = 'You do not have permission to perform this action.';
      } else {
        $error_msg = 'An unexpected error occurred.';
      }
    }

    if ($success_msg):
    ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-4 mt-4 relative" role="alert">
        <span class="block sm:inline"><?= htmlspecialchars($success_msg) ?></span>
      </div>
    <?php
    endif;

    if ($error_msg):
    ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-4 mt-4 relative" role="alert">
        <span class="block sm:inline"><?= htmlspecialchars($error_msg) ?></span>
      </div>
    <?php
    endif;
    ?>

    <div class="bg-white block lg:mt-1.5">
      <div class="p-4 w-full border-b dark:bg-gray-800 dark:border-gray-700">
        <div class="mb-4">
          <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
              <li class="inline-flex items-center">
                <a href="#" class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white">
                  <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                  </svg>
                  Home
                </a>
              </li>
              <li>
                <div class="flex items-center">
                  <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                  </svg>
                  <a href="#" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Articles</a>
                </div>
              </li>
              <li>
                <div class="flex items-center">
                  <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">List</span>
                </div>
              </li>
            </ol>
          </nav>
          <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Article Management</h1>
        </div>
        <div class="sm:flex">
          <?php
          require_once __DIR__ . '/../config/koneksi.php';
          $author_sql = "SELECT id, nama FROM tb_author_artikel ORDER BY nama ASC";
          $author_res = mysqli_query($koneksi, $author_sql);
          $author_options = [];
          if ($author_res) {
            while ($author_row = mysqli_fetch_assoc($author_res)) {
              $author_options[] = $author_row;
            }
          }
          $category_sql = "SELECT id, nama FROM tb_kategori_artikel ORDER BY nama ASC";
          $category_res = mysqli_query($koneksi, $category_sql);
          $category_options = [];
          if ($category_res) {
            while ($category_row = mysqli_fetch_assoc($category_res)) {
              $category_options[] = $category_row;
            }
          }
          ?>
          <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
            <form class="lg:pr-3" action="#" method="GET">
              <label for="articles-search" class="sr-only">Search</label>
              <div class="relative mt-1 lg:w-64 xl:w-96">
                <input type="text" name="search" id="articles-search" value="<?= isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '' ?>" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search by title or content">
              </div>
              <?php $filter_author = isset($_GET['author_id']) && $_GET['author_id'] !== '' ? (int)$_GET['author_id'] : null; ?>
              <?php if ($_SESSION['role'] === 'admin'): ?>
                <div class="pl-0 mt-3 sm:px-5 sm:mt-0">
                  <select id="filter-author" name="author_id" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="" <?= is_null($filter_author) ? ' selected' : '' ?>>All Authors</option>
                    <?php
                    foreach ($author_options as $author_row) {
                      $author_id_opt = (int)$author_row['id'];
                      $author_name_opt = htmlspecialchars($author_row['nama']);
                      echo '<option value="' . $author_id_opt . '"' . ($filter_author === $author_id_opt ? ' selected' : '') . '>' . $author_name_opt . '</option>';
                    }
                    ?>
                  </select>
                </div>
              <?php endif; ?>
          </div>
          <button data-modal-target="add-article-modal" data-modal-toggle="add-article-modal" class="text-white bg-blue-600 hover:bg-blue-700 rounded-lg px-5 py-2.5">
            + Add Article
          </button>
        </div>
      </div>

      <div class="flex flex-col">
        <div class="overflow-x-auto">
          <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">
              <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                <thead class="bg-gray-100 dark:bg-gray-700">
                  <tr>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">No</th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Title</th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Author</th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Excerpt</th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Created</th>
                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                  <?php
                  $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                  $author_filter = isset($_GET['author_id']) && $_GET['author_id'] !== '' ? (int)$_GET['author_id'] : null;
                  $conditions = [];
                  if ($author_filter !== null) {
                    $conditions[] = "a.id_penulis = $author_filter";
                  }
                  if ($search !== '') {
                    $search_safe = mysqli_real_escape_string($koneksi, $search);
                    $conditions[] = "(a.judul LIKE '%$search_safe%' OR a.isi LIKE '%$search_safe%')";
                  }
                  $where_sql = count($conditions) > 0 ? 'WHERE ' . implode(' AND ', $conditions) : '';

                  $sql = "SELECT
                            a.id_artikel,
                            a.judul,
                            a.slug,
                            a.ringkasan,
                            a.isi,
                            a.thumbnail,
                            a.id_kategori,
                            a.status,
                            a.tanggal_terbit,
                            a.created_at,
                            a.id_penulis AS author_id,
                            p.nama AS author,
                            k.nama AS kategori
                          FROM tb_artikel a
                          LEFT JOIN tb_author_artikel p ON a.id_penulis = p.id
                          LEFT JOIN tb_kategori_artikel k ON a.id_kategori = k.id
                          $where_sql
                          ORDER BY a.created_at DESC";
                  $res = mysqli_query($koneksi, $sql);
                  $no = 1;
                  if ($res && mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                      $id = (int) $row['id_artikel'];
                      $title = htmlspecialchars($row['judul']);
                      $body = $row['isi'];  // Jangan di-escape, render sebagai HTML
                      $excerpt = mb_strlen($row['isi']) > 120 ? htmlspecialchars(mb_substr(strip_tags($row['isi']), 0, 120)) . '...' : htmlspecialchars(strip_tags($row['isi']));
                      $authors = htmlspecialchars($row['author'] ?: 'Unknown');
                      $author_id = (int) ($row['author_id'] ?? 0);
                      $slug_value = htmlspecialchars($row['slug'] ?? '');
                      $ringkasan_value = htmlspecialchars($row['ringkasan'] ?? '');
                      $thumbnail_value = htmlspecialchars($row['thumbnail'] ?? '');
                      $category_value = (int) ($row['id_kategori'] ?? 0);
                      $category_name = htmlspecialchars($row['kategori'] ?? 'Uncategorized');
                      $status_value = htmlspecialchars($row['status'] ?? 'draft');
                      $tanggal_terbit_value = !empty($row['tanggal_terbit']) ? date('Y-m-d\TH:i', strtotime($row['tanggal_terbit'])) : '';
                      $formatted_publication = !empty($row['tanggal_terbit']) ? date('d M Y H:i', strtotime($row['tanggal_terbit'])) : '-';
                      $created = !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-';
                  ?>
                      <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $no++ ?></td>
                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $title ?></td>
                        <td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400"><?= $authors ?></td>
                        <td class="p-4 text-sm text-gray-500 break-words dark:text-gray-400"><?= $excerpt ?></td>
                        <td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400"><?= $created ?></td>
                        <td class="p-4 space-x-2 whitespace-nowrap">
                          <button type="button" data-modal-target="view-article-modal-<?= $id ?>" data-modal-toggle="view-article-modal-<?= $id ?>" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">View</button>
                          <button type="button" data-modal-target="edit-article-modal-<?= $id ?>" data-modal-toggle="edit-article-modal-<?= $id ?>" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">Edit</button>
                          <button type="button" data-modal-target="delete-article-modal-<?= $id ?>" data-modal-toggle="delete-article-modal-<?= $id ?>" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900">Delete</button>
                        </td>
                      </tr>

                      <!-- View Article Modal -->
                      <div id="view-article-modal-<?= $id ?>" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full">
                        <div class="relative w-full h-full max-w-3xl px-4 md:h-auto">
                          <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                            <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                              <h3 class="text-xl font-semibold text-gray-900 dark:text-white"><?= $title ?></h3>
                              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-hide="view-article-modal-<?= $id ?>">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                              </button>
                            </div>
                            <div class="p-6 space-y-4 text-gray-700 dark:text-gray-300">
                              <?php if ($thumbnail_value !== ''): ?>
                                <div class="mb-4">
                                  <img src="<?= $thumbnail_value ?>" alt="Thumbnail for <?= $title ?>" class="w-full rounded-lg object-cover max-h-72">
                                </div>
                              <?php endif; ?>
                              <div class="grid gap-2 md:grid-cols-2">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Author: <?= $authors ?></p>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Category: <?= $category_name ?></p>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Status: <?= ucfirst($status_value) ?></p>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Published: <?= $formatted_publication ?></p>
                              </div>
                              <?php if ($ringkasan_value !== ''): ?>
                                <div class="p-4 bg-gray-100 rounded-lg dark:bg-gray-900">
                                  <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Ringkasan</strong></p>
                                  <p class="mt-2 text-sm text-gray-600 dark:text-gray-400"><?= $ringkasan_value ?></p>
                                </div>
                              <?php endif; ?>
                              <hr class="my-3 border-gray-200 dark:border-gray-700">
                              <div class="prose prose-sm max-w-none dark:prose-invert">
                                <?= $body ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Edit Article Modal -->
                      <div id="edit-article-modal-<?= $id ?>" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full">
                        <div class="relative w-full h-full max-w-3xl px-4 md:h-auto">
                          <div class="relative bg-white rounded-lg shadow p-5 dark:bg-gray-800">
                            <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                              <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Edit article</h3>
                              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-hide="edit-article-modal-<?= $id ?>">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                              </button>
                            </div>
                            <form action="../auth/actions/update_artikel.php" method="POST" class="edit-article-form p-6 space-y-6" data-article-id="<?= $id ?>">
                              <input type="hidden" name="id_artikel" value="<?= $id ?>">
                              <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                <input type="text" name="judul" value="<?= $title ?>" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                              </div>
                              <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
                                  <input type="text" name="slug" value="<?= $slug_value ?>" placeholder="contoh-artikel-slug" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                  <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Optional. Biarkan kosong untuk mempertahankan atau buat baru dari judul.</p>
                                </div>
                                <div>
                                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                  <select name="id_kategori" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="" <?= $category_value === 0 ? 'selected' : '' ?>>Uncategorized</option>
                                    <?php foreach ($category_options as $category_row): ?>
                                      <option value="<?= (int) $category_row['id'] ?>" <?= $category_value === (int) $category_row['id'] ? 'selected' : '' ?>><?= htmlspecialchars($category_row['nama']) ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                              <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                  <select name="status" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="terbit" <?= $status_value === 'terbit' ? 'selected' : '' ?>>Terbit</option>
                                    <option value="draft" <?= $status_value === 'draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="arsip" <?= $status_value === 'arsip' ? 'selected' : '' ?>>Arsip</option>
                                  </select>
                                </div>
                                <div>
                                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Publish Date</label>
                                  <input type="datetime-local" name="tanggal_terbit" value="<?= $tanggal_terbit_value ?>" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                              </div>
                              <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Thumbnail URL</label>
                                <input type="text" name="thumbnail" value="<?= $thumbnail_value ?>" placeholder="https://example.com/image.jpg" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                              </div>
                              <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ringkasan</label>
                                <textarea name="ringkasan" rows="3" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"><?= $ringkasan_value ?></textarea>
                              </div>
                              <div class="p-3 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                  <span class="font-medium">Author:</span> <?= $authors ?> (cannot be changed)
                                </p>
                              </div>
                              <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
                                <input type="hidden" name="isi" id="edit-isi-<?= $id ?>" value="<?= htmlspecialchars($row['isi'] ?? '') ?>">
                                <div id="edit-editor-<?= $id ?>" class="ql-container ql-snow" data-content="<?= htmlspecialchars($row['isi'] ?? '', ENT_QUOTES) ?>">
                                  <div class="ql-editor" style="min-height: 300px;"></div>
                                </div>
                              </div>
                              <div class="flex justify-end gap-3 mt-4 border-t border-gray-200 pt-4 dark:border-gray-700">
                                <button type="button" data-modal-hide="edit-article-modal-<?= $id ?>" class="px-4 py-2 rounded-lg bg-gray-600 text-white">Cancel</button>
                                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Update Article</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                      <!-- Delete Article Modal -->
                      <div id="delete-article-modal-<?= $id ?>" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full">
                        <div class="relative w-full h-full max-w-md px-4 md:h-auto">
                          <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                            <div class="flex justify-end p-2">
                              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-hide="delete-article-modal-<?= $id ?>">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                              </button>
                            </div>
                            <div class="p-6 pt-0 text-center">
                              <svg class="w-16 h-16 mx-auto text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                              </svg>
                              <h3 class="mt-5 mb-6 text-lg text-gray-500 dark:text-gray-400">Delete the article "<?= $title ?>"?</h3>
                              <form action="../auth/actions/delete_artikel.php" method="POST">
                                <input type="hidden" name="id_artikel" value="<?= $id ?>">
                                <div class="flex justify-center gap-3">
                                  <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base inline-flex items-center px-5 py-2.5 text-center dark:focus:ring-red-900">Yes, delete</button>
                                  <button type="button" data-modal-hide="delete-article-modal-<?= $id ?>" class="text-gray-900 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 border border-gray-200 font-medium inline-flex items-center rounded-lg text-base px-5 py-2.5 text-center dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">Cancel</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                    <?php
                    }
                  } else {
                    ?>
                    <tr>
                      <td colspan="6" class="p-4 text-center text-gray-500 dark:text-gray-400">No articles found.</td>
                    </tr>
                  <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>

  <!-- Add Article Modal -->
  <div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full" id="add-article-modal">
    <div class="relative w-full h-full max-w-3xl px-4 md:h-auto">
      <div class="relative bg-white rounded-lg shadow p-5 dark:bg-gray-800">
        <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Add Article</h3>
          <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-hide="add-article-modal">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>
        <form action="../auth/actions/tambah_artikel.php" method="POST" id="add-article-form" class="p-6 space-y-6">
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" name="judul" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
            <input type="text" name="slug" placeholder="contoh-artikel-slug" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Optional. Jika kosong, slug akan dibuat otomatis dari judul.</p>
          </div>
          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
              <select name="id_kategori" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="">Uncategorized</option>
                <?php foreach ($category_options as $category_row): ?>
                  <option value="<?= (int) $category_row['id'] ?>"><?= htmlspecialchars($category_row['nama']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
              <select name="status" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                <option value="terbit" selected>Terbit</option>
                <option value="draft">Draft</option>
                <option value="arsip">Arsip</option>
              </select>
            </div>
          </div>
          <div class="grid gap-4 md:grid-cols-2">
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Thumbnail URL</label>
              <input type="text" name="thumbnail" placeholder="https://example.com/image.jpg" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Publish Date</label>
              <input type="datetime-local" name="tanggal_terbit" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
              <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong untuk menggunakan waktu saat ini jika status terbit.</p>
            </div>
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ringkasan</label>
            <textarea name="ringkasan" rows="3" placeholder="Ringkasan singkat artikel untuk preview..." class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
          </div>
          <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900 dark:border-blue-700">
            <p class="text-sm text-blue-800 dark:text-blue-200">
              <span class="font-medium">Author:</span> This article will be created under your account (<?= htmlspecialchars($_SESSION['email'] ?? 'Your Name') ?>)
            </p>
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
            <input type="hidden" name="isi" id="add-article-isi" value="">
            <div id="add-editor" class="ql-container ql-snow" style="background: white;">
              <div class="ql-editor" style="min-height: 300px;"></div>
            </div>
          </div>
          <div class="flex justify-end gap-3 border-t border-gray-200 pt-4 dark:border-gray-700">
            <button type="button" data-modal-hide="add-article-modal" class="px-4 py-2 rounded-lg bg-gray-600 text-white">Cancel</button>
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Create Article</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Quill Editor CSS & JS -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

  <script>
    // Initialize editors
    const editors = {};

    function initAddEditor() {
      const container = document.querySelector('#add-editor .ql-editor');
      if (container && !editors['add']) {
        editors['add'] = new Quill('#add-editor', {
          theme: 'snow',
          modules: {
            toolbar: [
              [{
                'header': [1, 2, 3, false]
              }],
              ['bold', 'italic', 'underline', 'strike'],
              ['blockquote', 'code-block'],
              [{
                'list': 'ordered'
              }, {
                'list': 'bullet'
              }],
              ['link', 'image'],
              ['clean']
            ]
          }
        });

        document.getElementById('add-article-form').addEventListener('submit', function(e) {
          const hiddenInput = document.getElementById('add-article-isi');
          hiddenInput.value = editors['add'].root.innerHTML;
        });
      }
    }

    function initEditEditor(id) {
      const editorId = `edit-editor-${id}`;
      const container = document.getElementById(editorId);
      if (container && !editors[id]) {
        const content = container.dataset.content || '';
        editors[id] = new Quill(`#${editorId}`, {
          theme: 'snow',
          modules: {
            toolbar: [
              [{
                'header': [1, 2, 3, false]
              }],
              ['bold', 'italic', 'underline', 'strike'],
              ['blockquote', 'code-block'],
              [{
                'list': 'ordered'
              }, {
                'list': 'bullet'
              }],
              ['link', 'image'],
              ['clean']
            ]
          }
        });
        editors[id].root.innerHTML = content;

        const form = container.closest('form');
        if (form) {
          form.addEventListener('submit', function(e) {
            const hidden = form.querySelector('input[name="isi"]');
            if (hidden) hidden.value = editors[id].root.innerHTML;
          });
        }
      }
    }

    // Listen for modal opens
    document.addEventListener('show.bs.modal', function() {
      setTimeout(initAddEditor, 100);
    });

    // Initialize edit editors when page loads or modals are toggled
    const modalTriggers = document.querySelectorAll('[data-modal-toggle^="edit-article-modal-"]');
    modalTriggers.forEach(trigger => {
      trigger.addEventListener('click', function() {
        const modalId = this.getAttribute('data-modal-toggle');
        const articleId = modalId.replace('edit-article-modal-', '');
        setTimeout(() => initEditEditor(articleId), 100);
      });
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
      initAddEditor();
      document.querySelectorAll('[id^="edit-editor-"]').forEach(el => {
        const id = el.id.replace('edit-editor-', '');
        initEditEditor(id);
      });
    });
  </script>
</div>