# ====== Sinkronisasi Penuh dari GitHub ======
# Langkah 1: Pastikan kamu di branch main (ubah kalau branch utamamu lain)
git checkout main || git checkout master

# Langkah 2: Ambil update terbaru dari remote repository (GitHub)
git fetch origin

# Langkah 3: Buat backup branch lokal dulu (jika kamu ingin jaga cadangan)
git branch backup-lokal-$(date +%Y%m%d-%H%M%S)

# Langkah 4: Reset semua perubahan agar identik dengan remote
git reset --hard origin/main || git reset --hard origin/master

# Langkah 5: Hapus semua file/folder yang tidak dilacak Git
git clean -fd

# Langkah 6: Hapus branch remote yang sudah tidak ada
git fetch --prune

# Langkah 7: (Opsional) Tampilkan status akhir
echo "✅ Repo lokal sekarang identik dengan GitHub."
git status
