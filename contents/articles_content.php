<div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
  <main>

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
                            a.isi,
                            a.created_at,
                            a.id_penulis AS author_id,
                            p.nama AS author
                          FROM tb_artikel a
                          LEFT JOIN tb_author_artikel p ON a.id_penulis = p.id
                          $where_sql
                          ORDER BY a.created_at DESC";
                  $res = mysqli_query($koneksi, $sql);
                  $no = 1;
                  if ($res && mysqli_num_rows($res) > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                      $id = (int) $row['id_artikel'];
                      $title = htmlspecialchars($row['judul']);
                      $body = htmlspecialchars($row['isi']);
                      $excerpt = mb_strlen($row['isi']) > 120 ? htmlspecialchars(mb_substr($row['isi'], 0, 120)) . '...' : htmlspecialchars($row['isi']);
                      $authors = htmlspecialchars($row['author'] ?: 'Unknown');
                      $author_id = (int) ($row['author_id'] ?? 0);
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
                              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Authors: <?= $authors ?></p>
                              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Published: <?= $created ?></p>
                              <hr class="my-3 border-gray-200 dark:border-gray-700">
                              <p class="whitespace-pre-wrap"><?= nl2br($body) ?></p>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!-- Edit Article Modal -->
                      <div id="edit-article-modal-<?= $id ?>" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full">
                        <div class="relative w-full h-full max-w-3xl px-4 md:h-auto">
                          <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                            <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                              <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Edit article</h3>
                              <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-hide="edit-article-modal-<?= $id ?>">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                              </button>
                            </div>
                            <form action="../auth/actions/update_artikel.php" method="POST" class="p-6 space-y-6">
                              <input type="hidden" name="id_artikel" value="<?= $id ?>">
                              <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                <input type="text" name="judul" value="<?= $title ?>" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                              </div>
                              <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
                                <input type="hidden" name="isi" id="edit-isi-<?= $id ?>" value="<?= htmlspecialchars($row['isi'] ?? '') ?>">
                                <div id="edit-editor-<?= $id ?>" data-content="<?= htmlspecialchars($row['isi'] ?? '', ENT_QUOTES) ?>" class="prose max-w-full rounded-lg border border-gray-300 bg-white p-3 dark:bg-gray-700 dark:border-gray-600" style="min-height:160px;"></div>
                              </div>
                              <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Author</label>
                                <select name="id_penulis" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                  <?php foreach ($author_options as $author_row): ?>
                                    <option value="<?= (int)$author_row['id'] ?>" <?= $author_id === (int)$author_row['id'] ? ' selected' : '' ?>><?= htmlspecialchars($author_row['nama']) ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="flex justify-end gap-3 border-t border-gray-200 pt-4 dark:border-gray-700">
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
        <form action="../auth/actions/tambah_artikel.php" method="POST" class="p-6 space-y-6">
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
            <input type="text" name="judul" class="w-full rounded-lg border border-gray-300 bg-gray-50 text-gray-900 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Content</label>
            <input type="hidden" name="isi" id="add-article-isi" value="">
            <div id="add-editor" class="prose max-w-full rounded-lg border border-gray-300 bg-white p-3 dark:bg-gray-700 dark:border-gray-600" style="min-height:160px;"></div>
          </div>
          <div class="flex justify-end gap-3 border-t border-gray-200 pt-4 dark:border-gray-700">
            <button type="button" data-modal-hide="add-article-modal" class="px-4 py-2 rounded-lg bg-gray-600 text-white">Cancel</button>
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 text-white">Create Article</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="module">
    import {
      Editor
    } from 'https://unpkg.com/@tiptap/core?module';
    import StarterKit from 'https://unpkg.com/@tiptap/starter-kit?module';

    const decodeHtml = (str) => {
      const doc = new DOMParser().parseFromString(str, 'text/html');
      return doc.documentElement.textContent;
    };

    // Add editor
    const addEditorEl = document.getElementById('add-editor');
    let addEditor = null;
    if (addEditorEl) {
      addEditor = new Editor({
        element: addEditorEl,
        extensions: [StarterKit],
        content: ''
      });
      const addForm = addEditorEl.closest('form');
      if (addForm) {
        addForm.addEventListener('submit', function(e) {
          const hidden = document.getElementById('add-article-isi');
          if (hidden && addEditor) hidden.value = addEditor.getHTML();
        });
      }
    }

    // Edit editors
    document.querySelectorAll('[id^="edit-editor-"]').forEach((el) => {
      const content = decodeHtml(el.dataset.content || '');
      const editor = new Editor({
        element: el,
        extensions: [StarterKit],
        content: content
      });
      const form = el.closest('form');
      if (form) {
        form.addEventListener('submit', function() {
          const hidden = form.querySelector('input[name="isi"]');
          if (hidden) hidden.value = editor.getHTML();
        });
      }
    });
  </script>