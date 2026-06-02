<div id="main-content" class="relative w-full h-full overflow-y-auto bg-neutral-50 lg:ml-64 dark:bg-neutral-900">
	<main>

		<div class="p-4 bg-white block sm:flex items-center justify-between border-b border-neutral-200 lg:mt-1.5 dark:bg-neutral-800 dark:border-neutral-700">
			<div class="w-full mb-1">
				<div class="mb-4">
					<nav class="flex mb-5" aria-label="Breadcrumb">
						<ol class="inline-flex items-center space-x-1 text-sm google-sans-medium md:space-x-2">
							<li class="inline-flex items-center">
								<a href="#" class="inline-flex items-center text-neutral-700 hover:text-primary-600 dark:text-neutral-300 dark:hover:text-white">
									<svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
										<path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
									</svg>
									Home
								</a>
							</li>
							<li>
								<div class="flex items-center">
									<svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
									</svg>
									<a href="#" class="ml-1 text-neutral-700 hover:text-primary-600 md:ml-2 dark:text-neutral-300 dark:hover:text-white">Products</a>
								</div>
							</li>
							<li>
								<div class="flex items-center">
									<svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
									</svg>
									<span class="ml-1 text-neutral-400 md:ml-2 dark:text-neutral-500" aria-current="page">List</span>
								</div>
							</li>
						</ol>
					</nav>
					<h1 class="text-xl google-sans-semibold text-neutral-900 sm:text-2xl dark:text-white">All Products</h1>
				</div>
				<div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-neutral-100 sm:mb-0 dark:divide-neutral-700">
					<form class="lg:pr-3" action="#" method="GET">
						<label for="products-search" class="sr-only">Search</label>
						<div class="relative mt-1 lg:w-64 xl:w-96">
							<input
								type="text"
								name="search"
								id="products-search"
								value="<?= isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '' ?>"
								class="bg-neutral-800 border border-neutral-700 text-neutral-300 text-sm rounded-md outline-none ring-1 ring-transparent focus:bg-neutral-900/50 focus:border-green-600 focus:ring-green-700 block w-full py-2 px-3 placeholder-neutral-500 transition-all"
								placeholder="Search products by name or SKU">
						</div>
					</form>
					<?php if ($_SESSION['role'] === 'admin'): ?>
						<?php $filter_user = isset($_GET['owner_user_id']) && $_GET['owner_user_id'] !== '' ? (int)$_GET['owner_user_id'] : null; ?>
						<div class="pl-0 mt-3 sm:px-5 sm:mt-0 sm:mx-2">
							<!-- <label for="filter-user" class="block mb-2 text-sm google-sans-medium text-neutral-900 dark:text-white">Filter by User:</label> -->
							<select id="filter-user" name="owner_user_id" class="bg-neutral-50 border border-neutral-300 text-neutral-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2.5 dark:bg-neutral-700 dark:border-neutral-600 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
								<option value="" <?= is_null($filter_user) ? ' selected' : '' ?>>All Users</option>
								<?php
								require_once __DIR__ . '/../config/koneksi.php';
								$user_sql = "SELECT id_user, first_name, last_name FROM tb_user WHERE status = 1 ORDER BY first_name ASC";
								$user_res = mysqli_query($koneksi, $user_sql);
								if ($user_res) {
									while ($user_row = mysqli_fetch_assoc($user_res)) {
										$user_id = (int)$user_row['id_user'];
										$user_name = htmlspecialchars($user_row['first_name'] . ' ' . $user_row['last_name']);
										echo '<option value="' . $user_id . '"' . ($filter_user === $user_id ? ' selected' : '') . '>' . $user_name . '</option>';
									}
								}
								?>
							</select>
						</div>
					<?php endif; ?>
					<button
						data-modal-target="add-product-modal"
						data-modal-toggle="add-product-modal"
						class="text-green-100 bg-green-700 hover:bg-green-800 border border-green-700 hover:border-neutral-600 rounded-lg px-4 py-1.5">
						+ Add Product
					</button>
				</div>
			</div>
		</div>

		<div class="flex flex-col">
			<div class="overflow-x-auto">
				<div class="inline-block min-w-full align-middle">
					<div class="overflow-hidden shadow">
						<table class="min-w-full divide-y divide-neutral-200 table-fixed dark:divide-neutral-600">
							<thead class="bg-neutral-100 dark:bg-neutral-700">
								<tr>
									<th scope="col" class="p-4 text-xs google-sans-medium text-left text-neutral-500 uppercase dark:text-neutral-400">No</th>
									<th scope="col" class="p-4 text-xs google-sans-medium text-left text-neutral-500 uppercase dark:text-neutral-400">Product Name</th>
									<th scope="col" class="p-4 text-xs google-sans-medium text-left text-neutral-500 uppercase dark:text-neutral-400">SKU</th>
									<th scope="col" class="p-4 text-xs google-sans-medium text-left text-neutral-500 uppercase dark:text-neutral-400">Owner</th>
									<th scope="col" class="p-4 text-xs google-sans-medium text-left text-neutral-500 uppercase dark:text-neutral-400">Category</th>
									<th scope="col" class="p-4 text-xs google-sans-medium text-left text-neutral-500 uppercase dark:text-neutral-400">Price</th>
									<th scope="col" class="p-4 text-xs google-sans-medium text-left text-neutral-500 uppercase dark:text-neutral-400">Stock</th>
									<th scope="col" class="p-4 text-xs google-sans-medium text-left text-neutral-500 uppercase dark:text-neutral-400">Created</th>
									<th scope="col" class="p-4 text-xs google-sans-medium text-left text-neutral-500 uppercase dark:text-neutral-400">Actions</th>
								</tr>
							</thead>
							<tbody class="bg-white divide-y divide-neutral-200 dark:bg-neutral-800 dark:divide-neutral-700">
								<?php
								require_once __DIR__ . '/../config/koneksi.php';
								$filter_user = isset($_GET['owner_user_id']) && $_GET['owner_user_id'] !== '' ? (int)$_GET['owner_user_id'] : null;
								$search = isset($_GET['search']) ? trim($_GET['search']) : '';

								$current_user_id = (int) $_SESSION['user_id'];
								$conditions = [];
								if ($filter_user !== null) {
									$conditions[] = "p.owner_user_id = $filter_user";
								} elseif ($_SESSION['role'] !== 'admin') {
									$conditions[] = "p.owner_user_id = $current_user_id";
								}
								if ($search !== '') {
									$search_safe = mysqli_real_escape_string($koneksi, $search);
									$conditions[] = "(p.nama LIKE '%$search_safe%' OR p.sku LIKE '%$search_safe%')";
								}
								$where_sql = '';
								if (count($conditions) > 0) {
									$where_sql = 'WHERE ' . implode(' AND ', $conditions);
								}

								$sql = "SELECT
									p.id_produk,
									p.owner_user_id,
									p.sku,
									p.nama,
									p.harga,
									p.id_kategori,
									p.deskripsi,
									p.stok,
									p.created_at,

									u.first_name,
									u.last_name,

									k.nama_kategori

								FROM tb_produk p

								LEFT JOIN tb_user u
									ON p.owner_user_id = u.id_user

								LEFT JOIN tb_kategori_produk k
									ON p.id_kategori = k.id_kategori

								$where_sql

								ORDER BY p.created_at DESC";
								$res = mysqli_query($koneksi, $sql);
								$no = 1;
								if ($res && mysqli_num_rows($res) > 0) {
									while ($row = mysqli_fetch_assoc($res)) {
										$id = htmlspecialchars($row['id_produk']);
										$sku = htmlspecialchars($row['sku']);
										$nama = htmlspecialchars($row['nama']);
										$harga = number_format($row['harga'], 0, ',', '.');
										$kategori = htmlspecialchars($row['nama_kategori']);
										$stok = $row['stok'];
										$owner_name = htmlspecialchars(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''));
										$created = date('d M Y', strtotime($row['created_at'] ?? 'now'));
										$deskripsi = htmlspecialchars($row['deskripsi'] ?? '');
								?>
										<tr class="hover:bg-neutral-100 dark:hover:bg-neutral-700" data-product-id="<?= $id ?>" data-product-name="<?= $nama ?>" data-product-sku="<?= $sku ?>" data-product-owner="<?= htmlspecialchars($row['owner_user_id']) ?>">
											<td class="p-4 text-base google-sans-medium text-neutral-900 whitespace-nowrap dark:text-white"><?php echo $no++ ?></td>
											<td class="p-4 text-base google-sans-medium text-neutral-900 whitespace-nowrap dark:text-white"><?= $nama ?></td>
											<td class="p-4 text-base google-sans-medium text-neutral-900 whitespace-nowrap dark:text-white"><?= $sku ?></td>
											<td class="p-4 text-sm text-neutral-500 whitespace-nowrap dark:text-neutral-400"><?= $owner_name ?: 'Unknown' ?></td>
											<td class="p-4 text-sm text-neutral-500 whitespace-nowrap dark:text-neutral-400"><?= $kategori ?></td>
											<td class="p-4 text-base google-sans-medium text-neutral-900 whitespace-nowrap dark:text-white">Rp<?= $harga ?></td>
											<td class="p-4 text-base google-sans-medium text-neutral-900 whitespace-nowrap dark:text-white">
												<?php if ($stok > 0): ?>
													<span class="text-green-600 google-sans-semibold"><?= $stok ?></span>
												<?php else: ?>
													<span class="text-red-600 google-sans-semibold">Out of Stock</span>
												<?php endif; ?>
											</td>
											<td class="p-4 text-sm text-neutral-500 whitespace-nowrap dark:text-neutral-400"><?= $created ?></td>
											<td class="p-4 space-x-2 whitespace-nowrap flex items-center gap-3">
												<button type="button" data-modal-target="view-product-modal" data-modal-toggle="view-product-modal" class="inline-flex items-center px-3 py-2 text-sm google-sans-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" data-product-deskripsi="<?= $deskripsi ?>">
													<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
														<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
														<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
													</svg> View
												</button>

												<!-- Update modal toggle -->
												<button data-modal-target="update-modal-<?= $id ?>" data-modal-toggle="update-modal-<?= $id ?>" class="text-white flex items-center gap-2 bg-brand box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs google-sans-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none" type="button">
													<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
														<path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
													</svg>
													<span class="">Edit</span>
												</button>

												<!-- Update Modal -->
												<div id="update-modal-<?= $id ?>" tabindex="-1" aria-hidden="true" class="rounded-lg fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full">
													<div class="relative p-4 w-full max-w-2xl max-h-full">
														<!-- Modal content -->
														<form action="../auth/actions/update_produk.php" method="POST" class="relative bg-neutral-primary-soft border border-default rounded-base shadow-sm p-4 md:p-6">
															<!-- Modal header -->
															<div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
																<h3 class="text-white text-lg google-sans-medium text-heading">
																	<?= $nama ?>
																</h3>
																<button type="button" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="update-modal-<?= $id ?>">
																	<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
																		<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
																	</svg>
																	<span class="sr-only">Close modal</span>
																</button>
															</div>
															<!-- Modal body -->
															<div class="space-y-4 py-4">
																<input type="hidden" name="id_produk" value="<?= $id ?>">
																<div>
																	<label class="block mb-2 text-sm google-sans-medium text-white">
																		Product Name
																	</label>
																	<input
																		type="text"
																		name="nama"
																		value="<?= $nama ?>"
																		class="w-full rounded-lg border border-neutral-600 bg-neutral-700 text-white p-2.5"
																		required>
																</div>
																<div>
																	<label class="block mb-2 text-sm google-sans-medium text-white">
																		SKU
																	</label>
																	<input
																		type="text"
																		name="sku"
																		value="<?= $sku ?>"
																		class="w-full rounded-lg border border-neutral-600 bg-neutral-700 text-white p-2.5"
																		required>
																</div>
																<div>
																	<label class="block mb-2 text-sm google-sans-medium text-white">
																		Category
																	</label>
																	<select
																		name="id_kategori"
																		class="w-full rounded-lg border border-neutral-600 bg-neutral-700 text-white p-2.5">

																		<?php
																		$kategori_sql = mysqli_query(
																			$koneksi,
																			"SELECT * FROM tb_kategori_produk ORDER BY nama_kategori ASC"
																		);

																		while ($kat = mysqli_fetch_assoc($kategori_sql)):
																		?>
																			<option
																				value="<?= $kat['id_kategori'] ?>"
																				<?= $kat['id_kategori'] == $row['id_kategori'] ? 'selected' : '' ?>>
																				<?= htmlspecialchars($kat['nama_kategori']) ?>
																			</option>
																		<?php endwhile; ?>
																	</select>
																</div>
																<div>
																	<label class="block mb-2 text-sm google-sans-medium text-white">
																		Price
																	</label>
																	<input
																		type="number"
																		name="harga"
																		value="<?= $row['harga'] ?>"
																		class="w-full rounded-lg border border-neutral-600 bg-neutral-700 text-white p-2.5"
																		required>
																</div>
																<div>
																	<label class="block mb-2 text-sm google-sans-medium text-white">
																		Stock
																	</label>
																	<input
																		type="number"
																		name="stok"
																		value="<?= $stok ?>"
																		class="w-full rounded-lg border border-neutral-600 bg-neutral-700 text-white p-2.5"
																		required>
																</div>
																<div>
																	<label class="block mb-2 text-sm google-sans-medium text-white">
																		Description
																	</label>
																	<textarea
																		name="deskripsi"
																		rows="4"
																		class="w-full rounded-lg border border-neutral-600 bg-neutral-700 text-white p-2.5"><?= htmlspecialchars($row['deskripsi']) ?></textarea>
																</div>
															</div>
															<!-- Modal footer -->
															<div class="flex items-center border-t border-default space-x-4 pt-4 md:pt-5">
																<button
																	type="button"
																	data-modal-hide="update-modal-<?= $id ?>"
																	class="px-4 py-2 rounded-lg bg-neutral-600 text-white">
																	Cancel
																</button>
																<button
																	type="submit"
																	class="px-4 py-2 rounded-lg bg-green-600 text-white">
																	Update Product
																</button>
															</div>
														</form>
													</div>
												</div>

												<form
													action="../auth/actions/delete_produk.php"
													method="POST"
													onsubmit="return confirm('Yakin ingin menghapus produk ini?');">

													<input
														type="hidden"
														name="id_produk"
														value="<?= $id ?>">

													<button
														type="submit"
														class="text-white bg-red-600 hover:bg-red-700 rounded-lg px-3 py-2">
														Delete
													</button>

												</form>
											</td>
										</tr>
								<?php
									}
								} else {
									echo '<tr><td colspan="8" class="p-4 text-center text-neutral-500 dark:text-neutral-400">No products found</td></tr>';
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
		<div class="relative bg-white rounded-lg shadow dark:bg-neutral-800">
			<!-- Modal header -->
			<div class="flex items-start justify-between p-5 border-b rounded-t dark:border-neutral-700">
				<h3 class="text-xl google-sans-semibold dark:text-white">Product Details</h3>
				<button type="button" class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-neutral-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-neutral-700 dark:hover:text-white" data-modal-toggle="view-product-modal">
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

<div
	id="add-product-modal"
	tabindex="-1"
	aria-hidden="true"
	class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">

	<div class="relative w-full max-w-2xl h-full md:h-auto">
		<div class="relative bg-white rounded-lg shadow dark:bg-neutral-800">
			<div class="flex justify-between items-center p-5 border-b dark:border-neutral-700">
				<h3 class="text-xl google-sans-semibold text-white">
					Add Product
				</h3>
				<button
					type="button"
					data-modal-hide="add-product-modal">
					✕
				</button>
			</div>
			<form action="../auth/actions/tambah_produk.php" method="POST">
				<div class="p-6 space-y-4">
					<div>
						<label>SKU</label>
						<input
							type="text"
							name="sku"
							class="w-full border rounded-lg p-2"
							required>
					</div>
					<div>
						<label>Product Name</label>
						<input
							type="text"
							name="nama"
							class="w-full border rounded-lg p-2"
							required>
					</div>
					<div>
						<label>Category</label>
						<select
							name="id_kategori"
							class="w-full border rounded-lg p-2"
							required>

							<?php
							$kategori = mysqli_query(
								$koneksi,
								"SELECT * FROM tb_kategori_produk ORDER BY nama_kategori ASC"
							);

							while ($kat = mysqli_fetch_assoc($kategori)):
							?>
								<option value="<?= $kat['id_kategori'] ?>">
									<?= htmlspecialchars($kat['nama_kategori']) ?>
								</option>
							<?php endwhile; ?>
						</select>
					</div>
					<div>
						<label>Price</label>
						<input
							type="number"
							name="harga"
							class="w-full border rounded-lg p-2"
							required>
					</div>
					<div>
						<label>Stock</label>
						<input
							type="number"
							name="stok"
							class="w-full border rounded-lg p-2"
							required>
					</div>
					<div>
						<label>Description</label>
						<textarea
							name="deskripsi"
							rows="4"
							class="w-full border rounded-lg p-2"></textarea>
					</div>
				</div>
				<div class="flex justify-end gap-2 p-5 border-t dark:border-neutral-700">
					<button
						type="button"
						data-modal-hide="add-product-modal"
						class="px-4 py-2 bg-neutral-500 text-white rounded-lg">
						Cancel
					</button>
					<button
						type="submit"
						class="px-4 py-2 bg-green-600 text-white rounded-lg">
						Save Product
					</button>
				</div>
			</form>
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
							<label class="block text-sm google-sans-medium text-neutral-900 dark:text-white">Product Name</label>
							<p class="text-neutral-700 dark:text-neutral-300">${nama}</p>
						</div>
						<div>
							<label class="block text-sm google-sans-medium text-neutral-900 dark:text-white">SKU</label>
							<p class="text-neutral-700 dark:text-neutral-300">${sku}</p>
						</div>
						<div>
							<label class="block text-sm google-sans-medium text-neutral-900 dark:text-white">Description</label>
							<p class="text-neutral-700 dark:text-neutral-300">${deskripsi}</p>
						</div>
					</div>
				`;
				}
			});
		});
	});
</script>