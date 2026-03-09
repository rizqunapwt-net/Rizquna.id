#!/usr/bin/env pwsh

# Deploy script for Rizquna.id WordPress project
# Usage: .\scripts\deploy.ps1

Write-Host "🚀 Rizquna.id - Deployment Script" -ForegroundColor Cyan
Write-Host "===================================" -ForegroundColor Cyan

# Check if containers exist
$dbRunning = docker ps | Select-String "rizquna_db"
$appRunning = docker ps | Select-String "rizquna_app"

if (-not $dbRunning -or -not $appRunning) {
    Write-Host "⚠️  Containers not running. Starting..." -ForegroundColor Yellow
    docker-compose up -d
    Start-Sleep -Seconds 5
}

# Backup database
Write-Host "💾 Creating database backup..." -ForegroundColor Yellow
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$backupDir = "data/backups"

if (-not (Test-Path $backupDir)) {
    New-Item -ItemType Directory -Path $backupDir -Force | Out-Null
}

docker-compose exec -T db mysqldump -u u9443309_wp827 -pwordpress_password u9443309_wp827 | Out-File "$backupDir/wp827_backup_$timestamp.sql"
Write-Host "✅ Backup created: $backupDir/wp827_backup_$timestamp.sql" -ForegroundColor Green

# Pull latest code (if git repo)
if (Test-Path ".git") {
    Write-Host "📦 Pulling latest code..." -ForegroundColor Yellow
    git pull origin main 2>&1 | Out-Null
    Write-Host "✅ Code updated" -ForegroundColor Green
}

# Restart containers with latest code
Write-Host "🔄 Restarting containers..." -ForegroundColor Yellow
docker-compose down
docker-compose up -d

# Wait for services
Start-Sleep -Seconds 5

# Clear WordPress cache
Write-Host "🧹 Clearing caches..." -ForegroundColor Yellow
docker-compose exec -T app rm -rf /var/www/html/wp-content/cache/* 2>&1 | Out-Null
Write-Host "✅ Cache cleared" -ForegroundColor Green

Write-Host ""
Write-Host "✅ Deployment Complete!" -ForegroundColor Green
Write-Host "===================================" -ForegroundColor Cyan
Write-Host "Website: http://localhost:8088" -ForegroundColor Cyan
Write-Host ""
