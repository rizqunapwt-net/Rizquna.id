import os, sys, shutil
import paramiko
from scp import SCPClient
from datetime import datetime

# --- SETTINGS ---
IP = "192.168.18.210"
USER = "rizqunaid"
PASS = "rizqunaid2026"
REMOTE_DIR = "/home/rizqunaid/rizquna.id"
LOCAL_DIR = r"E:\THOLIB\wordpress\rizquna.id"

def progress(filename, size, sent):
    sys.stdout.write(f"\r[Transfer] {filename}: {sent/size*100:.2f}%")
    sys.stdout.flush()

def main():
    print(f"[{datetime.now()}] >>> 🚀 Starting Auto-Deploy to {IP}...")
    
    # 1. SSH Connection
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    try:
        ssh.connect(IP, username=USER, password=PASS)
        print(f"[{datetime.now()}] >>> ✅ SSH Connected!")
    except Exception as e:
        print(f"[{datetime.now()}] >>> ❌ SSH Error: {e}")
        return

    # 2. Check Prerequisites
    stdin, stdout, stderr = ssh.exec_command("hostname; docker --version; docker-compose --version")
    print(f"[{datetime.now()}] >>> Server: {stdout.read().decode().strip()}")
    
    # 3. Create Remote Directories
    ssh.exec_command(f"mkdir -p {REMOTE_DIR}/data/db {REMOTE_DIR}/scripts")
    print(f"[{datetime.now()}] >>> ✅ Directories created on server.")

    # 4. SCP Transfer (Large Files first)
    with SCPClient(ssh.get_transport(), progress=progress) as scp:
        # Transfer Core Files
        print(f"\n[{datetime.now()}] >>> 📤 Sending Dockerfile, compose, and .env...")
        for f in ["Dockerfile", "docker-compose.yml", ".env"]:
            if os.path.exists(os.path.join(LOCAL_DIR, f)):
                scp.put(os.path.join(LOCAL_DIR, f), f"{REMOTE_DIR}/{f}")
        
        # Transfer Folders (Rekursif - can be slow for 6GB, but it works)
        print(f"\n[{datetime.now()}] >>> 📤 Sending folder: scripts/")
        scp.put(os.path.join(LOCAL_DIR, "scripts"), f"{REMOTE_DIR}/", recursive=True)

        print(f"\n[{datetime.now()}] >>> 📤 Sending folder: data/db/")
        scp.put(os.path.join(LOCAL_DIR, "data", "db"), f"{REMOTE_DIR}/data/", recursive=True)

        print(f"\n[{datetime.now()}] >>> 📤 Sending folder: app/ (This is huge, please wait)...")
        # In a real scenario, rsync is better, but this script will handle it.
        scp.put(os.path.join(LOCAL_DIR, "app"), f"{REMOTE_DIR}/", recursive=True)

    # 5. Run Docker on Server
    print(f"\n[{datetime.now()}] >>> 🐳 Building and Starting Containers on Server...")
    # Add -d for detached
    cmd = f"cd {REMOTE_DIR} && docker-compose down && docker-compose up -d --build"
    stdin, stdout, stderr = ssh.exec_command(cmd)
    
    # 6. Final Status
    print(f"[{datetime.now()}] >>> ✅ DEPLOYMENT COMPLETE!")
    print(f"Buka browser: http://{IP}:8088")
    
    ssh.close()

if __name__ == "__main__":
    main()
