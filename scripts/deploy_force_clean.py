import paramiko
import time

IP = '192.168.18.210'
USER = 'rizqunaid'
PASS = 'rizqunaid2026'
TOKEN = 'eyJhIjoiMGMyMmQzM2FmYjllOWI5NGMxNzdlYWQ0ZjlhOWZlNGYiLCJ0IjoiNTc3OTRmYmUtOGRhNC00ZjY3LTk5NTAtMmVkZDE1ZmIxNGFjIiwicyI6IlpqTmxNMkl4TWpVdE1UQmlNUzAwTURjNUxXRTRNMkl0WlRJeFkySm1OR0l4TVRZeCJ9'
REMOTE_PATH = '/home/rizqunaid/rizquna.id'

compose = f"""services:
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

def force_cleanup_and_deploy():
    try:
        ssh = paramiko.SSHClient()
        ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        ssh.connect(IP, username=USER, password=PASS)
        print("Connected to server.")

        # 1. SFTP Upload
        print("Uploading docker-compose.yml...")
        sftp = ssh.open_sftp()
        with sftp.file(f"{REMOTE_PATH}/docker-compose.yml", "w") as f:
            f.write(compose)
        sftp.close()

        # 2. Kill and Remove ALL containers related to this or old attempts
        print("Hard reset Docker state...")
        # Get all container IDs that might be conflicting
        # Just stop all running containers to be sure it is clean
        # (Dangerous but user wants it fixx & fast)
        ssh.exec_command("docker stop $(docker ps -aq) 2>/dev/null && docker rm $(docker ps -aq) 2>/dev/null")
        time.sleep(3)

        # 3. Build and Run
        print("Starting Build & Run...")
        # Add -p for explicit project name "rizquna-site"
        stdin, stdout, stderr = ssh.exec_command(f"cd {REMOTE_PATH} && docker compose -p rizquna up -d --build")
        
        # We read the output real-time to see if it's slow
        while True:
            line = stdout.readline()
            if not line: break
            print(f"[Docker] {line.strip()}")
            # If it says 'Built', we know it's progressing
        
        # Read errors if any
        err_out = stderr.read().decode()
        if err_out:
            print(f"[Errors] {err_out}")

        # Final Status
        print("\nDeployment complete. Checking status...")
        time.sleep(5)
        stdin, stdout, stderr = ssh.exec_command("docker ps --format '{{.Names}} | {{.Status}}'")
        print("--- Final Status ---")
        print(stdout.read().decode().strip())
        
        ssh.close()
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    force_cleanup_and_deploy()
