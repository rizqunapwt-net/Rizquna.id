import paramiko
from datetime import datetime

# --- SETTINGS ---
IP = "192.168.18.210"
USER = "rizqunaid"
PASS = "rizqunaid2026"
TUNNEL_TOKEN = "57794fbe-8da4-4f67-9950-2edd15fb14ac"

def main():
    print(f"[{datetime.now()}] >>> ☁️ Setting up Cloudflare Tunnel...")
    
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    try:
        ssh.connect(IP, username=USER, password=PASS)
        print(f"[{datetime.now()}] >>> ✅ SSH Connected!")
    except Exception as e:
        print(f"[{datetime.now()}] >>> ❌ SSH Error: {e}")
        return

    # 🐳 Deploy cloudflared as a docker container
    cmd = f"""
    docker stop cf-tunnel 2>/dev/null
    docker rm cf-tunnel 2>/dev/null
    docker run -d --name cf-tunnel --restart always \
    cloudflare/cloudflared:latest tunnel --no-autoupdate run --token {TUNNEL_TOKEN}
    """
    
    print(f"[{datetime.now()}] >>> 🚀 Starting Cloudflare Tunnel Container...")
    stdin, stdout, stderr = ssh.exec_command(cmd)
    
    output = stdout.read().decode()
    error = stderr.read().decode()
    
    if error and "Error" in error:
        print(f"[{datetime.now()}] >>> ❌ Tunnel Error: {error}")
    else:
        print(f"[{datetime.now()}] >>> ✅ Cloudflare Tunnel is UP and running!")
        print(f"[{datetime.now()}] >>> 🔗 Sekarang cek di: https://rizquna.id")
    
    ssh.close()

if __name__ == "__main__":
    main()
