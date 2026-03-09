# ========================================================
# Deploy Script: Rizquna.id (Local to Local Server)
# ========================================================

$SERVER_IP = "192.168.18.210"
$USERNAME = "rizqunaid"
$REMOTE_PATH = "/home/rizqunaid/rizquna.id"

Write-Host ">>> 🏗️ Menyiapkan Repo di Server..." -ForegroundColor Cyan
ssh $USERNAME@$SERVER_IP "mkdir -p $REMOTE_PATH/app $REMOTE_PATH/data/db"

Write-Host ">>> 📤 Mengirim file Konfigurasi (Dockerfile, Compose, .env)..." -ForegroundColor Yellow
scp Dockerfile docker-compose.yml .env $USERNAME@$SERVER_IP`:$REMOTE_PATH/

Write-Host ">>> 📤 Mengirim folder scripts..." -ForegroundColor Yellow
scp -r scripts $USERNAME@$SERVER_IP`:$REMOTE_PATH/

Write-Host ">>> 📤 Mengirim WordPress Files (app/) - Mungkin butuh waktu lama..." -ForegroundColor Yellow
# Menggunakan -r untuk rekursif. (Jika rsync ada di Windows, ini akan lebih cepat)
scp -r app $USERNAME@$SERVER_IP`:$REMOTE_PATH/

Write-Host ">>> 📤 Mengirim Database Init (data/db/)..." -ForegroundColor Yellow
scp -r data/db $USERNAME@$SERVER_IP`:$REMOTE_PATH/data/

Write-Host ">>> 🐳 Membangun dan Menjalankan Container di Server..." -ForegroundColor Cyan
ssh $USERNAME@$SERVER_IP "cd $REMOTE_PATH && docker-compose down && docker-compose up -d --build"

Write-Host ">>> ✅ DEPLOY SELESAI!" -ForegroundColor Green
Write-Host "Buka di browser: http://$SERVER_IP:8088"
