import paramiko

IP = '192.168.18.210'
USER = 'rizqunaid'
PASS = 'rizqunaid2026'

def check_everything():
    try:
        ssh = paramiko.SSHClient()
        ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        ssh.connect(IP, username=USER, password=PASS)
        print("Connected.")

        # 1. Containers
        stdin, stdout, stderr = ssh.exec_command("docker ps -a --format '{{.Names}} | {{.Image}} | {{.Status}}'")
        print("\n--- ALL CONTAINERS ---")
        print(stdout.read().decode().strip() or "None found.")

        # 2. Images
        stdin, stdout, stderr = ssh.exec_command("docker images --format '{{.Repository}}:{{.Tag}}'")
        print("\n--- ALL IMAGES ---")
        print(stdout.read().decode().strip() or "None found.")

        # 3. Project Directory Content
        stdin, stdout, stderr = ssh.exec_command("ls -F /home/rizqunaid/rizquna.id")
        print("\n--- PROJECT DIRECTORY CONTENT ---")
        print(stdout.read().decode().strip())

        # 4. Compose File Proof (Let's see if it's REALLY correct)
        stdin, stdout, stderr = ssh.exec_command("cat /home/rizqunaid/rizquna.id/docker-compose.yml")
        print("\n--- CURRENT docker-compose.yml ON SERVER ---")
        print(stdout.read().decode().strip())

        ssh.close()
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    check_everything()
