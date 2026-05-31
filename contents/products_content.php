<div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
	<main>

		<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
			<div class="w-full mb-1">
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
									<a href="#" class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Products</a>
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
					<h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">All Products</h1>
				</div>
				<div class="sm:flex">
					<div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
						<form class="lg:pr-3" action="#" method="GET">
							<label for="products-search" class="sr-only">Search</label>
							<div class="relative mt-1 lg:w-64 xl:w-96">
								<input type="text" name="search" id="products-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search products by name or SKU">
							</div>
						</form>
						<div class="pl-0 mt-3 sm:pl-2 sm:mt-0">
							<label for="filter-user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter by User:</label>
							<select id="filter-user" name="owner_user_id" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
								<option value="">All Users</option>
								<?php
								require_once __DIR__ . '/../config/koneksi.php';
								$user_sql = "SELECT id_user, first_name, last_name FROM tb_user WHERE status = 1 ORDER BY first_name ASC";
								$user_res = mysqli_query($koneksi, $user_sql);
								if ($user_res) {
									while ($user_row = mysqli_fetch_assoc($user_res)) {
										$user_id = htmlspecialchars($user_row['id_user']);
										$user_name = htmlspecialchars($user_row['first_name'] . ' ' . $user_row['last_name']);
										echo '<option value="' . $user_id . '">' . $user_name . '</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="flex flex-col">
			<div class="overflow-x-auto">
				<div class="inline-block min-w-full align-middle">
					<div class="overflow-hidden shadow">
						<table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
							<thead class="bg-gray-100 dark:bg-gray-700">
								<tr>
									<th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Product Name</th>
									<th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">SKU</th>
									<th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Owner</th>
									<th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Category</th>
									<th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Price</th>
									<th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Stock</th>
									<th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Created</th>
									<th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Actions</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
								<?php
								$filter_user = isset($_GET['owner_user_id']) && $_GET['owner_user_id'] !== '' ? (int)$_GET['owner_user_id'] : null;
								$search = isset($_GET['search']) ? trim($_GET['search']) : '';

								$sql = "SELECT p.id_produk, p.owner_user_id, p.sku, p.nama, p.harga, p.kategori, p.deskripsi, p.stok, p.created_at, 
										u.first_name, u.last_name 
										FROM tb_produk p 
										LEFT JOIN tb_user u ON p.owner_user_id = u.id_user 
										WHERE 1=1";
								
								if ($filter_user !== null) {
									$sql .= " AND p.owner_user_id = " . $filter_user;
								}

								if (!empty($search)) {
									$sql .= " AND (p.nama LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%' OR p.sku LIKE '%" . mysqli_real_escape_string($koneksi, $search) . "%')";
								}

								$sql .= " ORDER BY p.created_at DESC";

								$res = mysqli_query($koneksi, $sql);
								if ($res && mysqli_num_rows($res) > 0) {
									while ($row = mysqli_fetch_assoc($res)) {
										$id = htmlspecialchars($row['id_produk']);
										$sku = htmlspecialchars($row['sku']);
										$nama = htmlspecialchars($row['nama']);
										$harga = number_format($row['harga'], 0, ',', '.');
										$kategori = htmlspecialchars($row['kategori']);
										$stok = $row['stok'];
										$owner_name = htmlspecialchars(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''));
										$created = date('d M Y', strtotime($row['created_at'] ?? 'now'));
										$deskripsi = htmlspecialchars($row['deskripsi'] ?? '');
								?>
										<tr class="hover:bg-gray-100 dark:hover:bg-gray-700" data-product-id="<?= $id ?>" data-product-name="<?= $nama ?>" data-product-sku="<?= $sku ?>" data-product-owner="<?= htmlspecialchars($row['owner_user_id']) ?>">
											<td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $nama ?></td>
											<td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"><?= $sku ?></td>
											<td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400"><?= $owner_name ?: 'Unknown' ?></td>
											<td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400"><?= $kategori ?></td>
											<td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">Rp<?= $harga ?></td>
											<td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
												<?php if ($stok > 0): ?>
													<span class="text-green-600 font-semibold"><?= $stok ?></span>
												<?php else: ?>
													<span class="text-red-600 font-semibold">Out of Stock</span>
												<?php endif; ?>
											</td>
											<td class="p-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400"><?= $created ?></td>
											<td class="p-4 space-x-2 whitespace-nowrap">
												<button type="button" data-modal-target="view-product-modal" data-modal-toggle="view-product-modal" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" data-product-deskripsi="<?= $deskripsi ?>">
													<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
														<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
														<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
													</svg> View
												</button>
											</td>
										</tr>
								<?php
									}
								} else {
									echo '<tr><td colspan="8" class="p-4 text-center text-gray-500 dark:text-gray-400">No products found</td></tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</main>
</div>

<!-- View Product Modal -->
<div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full" id="view-product-modal">
	<div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
		<!-- Modal content -->
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
			<!-- Modal header -->
			<div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
				<h3 class="text-xl font-semibold dark:text-white">Product Details</h3>
				<button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-toggle="view-product-modal">
					<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
					</svg>
				</button>
			</div>
			<!-- Modal body -->
			<div class="p-6 space-y-6">
				<div id="product-details-content">
					<!-- Content will be populated by JS -->
				</div>
			</div>
		</div>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
	// Handle filter change
	document.getElementById('filter-user')?.addEventListener('change', (e) => {
		const userId = e.target.value;
		const url = new URL(window.location);
		if (userId) {
			url.searchParams.set('owner_user_id', userId);
		} else {
			url.searchParams.delete('owner_user_id');
		}
		window.location = url.toString();
	});

	// Handle view product button
	document.querySelectorAll('[data-modal-target="view-product-modal"]').forEach(btn => {
		btn.addEventListener('click', (e) => {
			const tr = btn.closest('tr');
			if (!tr) return;
			
			const nama = tr.dataset.productName || '';
			const sku = tr.dataset.productSku || '';
			const owner = tr.dataset.productOwner || '';
			const deskripsi = btn.dataset.productDeskripsi || 'No description available';
			
			const content = document.getElementById('product-details-content');
			if (content) {
				content.innerHTML = `
					<div class="grid grid-cols-1 gap-4">
						<div>
							<label class="block text-sm font-medium text-gray-900 dark:text-white">Product Name</label>
							<p class="text-gray-700 dark:text-gray-300">${nama}</p>
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-900 dark:text-white">SKU</label>
							<p class="text-gray-700 dark:text-gray-300">${sku}</p>
						</div>
						<div>
							<label class="block text-sm font-medium text-gray-900 dark:text-white">Description</label>
							<p class="text-gray-700 dark:text-gray-300">${deskripsi}</p>
						</div>
					</div>
				`;
			}
		});
	});
});
</script>
