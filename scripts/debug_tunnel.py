import paramiko

IP = '192.168.18.210'
USER = 'rizqunaid'
PASS = 'rizqunaid2026'

def check_status():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(IP, username=USER, password=PASS)

    # Check all containers
    stdin, stdout, stderr = ssh.exec_command('docker ps -a --format "{{.Names}} | {{.Image}} | {{.Status}}"')
    print("--- All Containers ---")
    print(stdout.read().decode())

    # Find the active tunnel container
    stdin, stdout, stderr = ssh.exec_command('docker ps --filter "ancestor=cloudflare/cloudflared" --format "{{.Names}}"')
    active_tunnels = stdout.read().decode().strip().split('\n')
    
    for tunnel in active_tunnels:
        if tunnel:
            print(f"--- Logs for {tunnel} ---")
            stdin, stdout, stderr = ssh.exec_command(f'docker logs {tunnel} | tail -n 50')
            print(stdout.read().decode() + stderr.read().decode())

    ssh.close()

if __name__ == "__main__":
    check_status()
