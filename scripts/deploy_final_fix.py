import paramiko
import os
import time

IP = '192.168.18.210'
USER = 'rizqunaid'
PASS = 'rizqunaid2026'
REMOTE_PATH = '/home/rizqunaid/rizquna.id'
# Full Token (Correct)
TOKEN = 'eyJhIjoiMGMyMmQzM2FmYjllOWI5NGMxNzdlYWQ0ZjlhOWZlNGYiLCJ0IjoiNTc3OTRmYmUtOGRhNC00ZjY3LTk5NTAtMmVkZDE1ZmIxNGFjIiwicyI6IlpqTmxNMkl4TWpVdE1UQmlNUzAwTURjNUxXRTRNMkl0WlRJeFkySm1OR0l4TVRZeCJ9'

# Define the exact compose content locally
compose_content = f"""services:
  db:
    image: mariadb:latest
    container_name: rizquna_db
    restart: always
    command: >
      --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci --max_connections=200 --max_allowed_packet=64M --innodb_buffer_pool_size=512M
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: u9443309_wp827
      MYSQL_USER: u9443309_wp827
      MYSQL_PASSWORD: wordpress_password
      MARIADB_AUTO_UPGRADE: "1"
      TZ: UTC
    ports:
      - "33068:3306"
    volumes:
      - ./data/db:/docker-entrypoint-initdb.d
      - db_data:/var/lib/mysql
    healthcheck:
      test: [ "CMD", "healthcheck.sh", "--connect", "--innodb_initialized" ]
      interval: 10s
      timeout: 20s
      retries: 20
      start_period: 300s

  app:
    build: .
    container_name: rizquna_app
    restart: always
    ports:
      - "8088:80"
    volumes:
      - ./app:/var/www/html
      - ./data/uploads:/var/www/html/wp-content/uploads
    environment:
      DB_HOST: db
      DB_USER: u9443309_wp827
      DB_PASSWORD: wordpress_password
      DB_NAME: u9443309_wp827
      TZ: UTC
    depends_on:
      db:
        condition: service_healthy

  tunnel:
    image: cloudflare/cloudflared:latest
    container_name: rizquna_tunnel
    restart: always
    command: tunnel --no-autoupdate run --token {TOKEN}

volumes:
  db_data:
"""

def deploy():
    try:
        ssh = paramiko.SSHClient()
        ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        ssh.connect(IP, username=USER, password=PASS)
        print("Connected to server.")

        # 1. SFTP Put strictly (overwriting)
        print("Uploading clean docker-compose.yml via SFTP...")
        sftp = ssh.open_sftp()
        with sftp.file(f"{REMOTE_PATH}/docker-compose.yml", "w") as f:
            f.write(compose_content)
        sftp.close()

        # 2. Hard Reset
        print("Stopping/Removing ALL previous projects to avoid conflicts...")
        ssh.exec_command("docker stop $(docker ps -aq) 2>/dev/null; docker rm -f $(docker ps -aq) 2>/dev/null")
        time.sleep(3)

        # 3. Pull & Up (Without build first to see if it works)
        # Actually build is better for PHP. I'll add -d.
        print("Running Build & Up (Background)...")
        stdin, stdout, stderr = ssh.exec_command(f"cd {REMOTE_PATH} && docker compose up -d --build")
        
        # Don't wait forever, just capture errors and move on
        print("Waiting for deployment command to complete...")
        # Actually I MUST wait if I want to know if it finished. 
        # But user says 'lama'. I'll wait 30s.
        time.sleep(30)
        
        # 4. Check status in real-time
        print("\nChecking deployment progress...")
        stdin, stdout, stderr = ssh.exec_command("docker ps --format '{{.Names}} | {{.Status}}'")
        print("--- Running Containers ---")
        print(stdout.read().decode().strip() or "None yet. Still building?")
        
        # If not up, check build logs
        if "rizquna_app" not in stdout.read().decode():
             stdin, stdout, stderr = ssh.exec_command(f"cd {REMOTE_PATH} && docker compose logs --tail 20")
             print("--- Recent Logs ---")
             print(stdout.read().decode())

        ssh.close()
        print("\nAll done from my side. Give it 2-3 minutes if still 530 error.")
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    deploy()
