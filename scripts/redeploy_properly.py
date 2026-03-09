import paramiko
import os

IP = '192.168.18.210'
USER = 'rizqunaid'
PASS = 'rizqunaid2026'
TOKEN = 'eyJhIjoiMGMyMmQzM2FmYjllOWI5NGMxNzdlYWQ0ZjlhOWZlNGYiLCJ0IjoiNTc3OTRmYmUtOGRhNC00ZjY3LTk5NTAtMmVkZDE1ZmIxNGFjIiwicyI6IlpqTmxNMkl4TWpVdE1UQmlNUzAwTURjNUxXRTRNMkl0WlRJeFkySm1OR0l4TVRZeCJ9'
REMOTE_PATH = '/home/rizqunaid/rizquna.id'

compose_content = f"""services:
  db:
    image: mariadb:latest
    container_name: rizquna_db
    restart: always
    command: >
      --character-set-server=utf8mb4 
      --collation-server=utf8mb4_unicode_ci 
      --max_connections=200 
      --max_allowed_packet=64M 
      --innodb_buffer_pool_size=512M
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
      - ./data/uploads:/var/www/html/wp-content/uploads
    healthcheck:
      test: ["CMD", "healthcheck.sh", "--connect", "--innodb_initialized"]
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

def upload_and_restart():
    try:
        ssh = paramiko.SSHClient()
        ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        ssh.connect(IP, username=USER, password=PASS)

        print(f">>> Connected to {IP}")

        # SFTP Upload
        sftp = ssh.open_sftp()
        with sftp.file(f'{REMOTE_PATH}/docker-compose.yml', 'w') as f:
            f.write(compose_content)
        sftp.close()
        print(">>> docker-compose.yml uploaded.")

        # Re-verify the file
        stdin, stdout, stderr = ssh.exec_command(f'cat {REMOTE_PATH}/docker-compose.yml')
        verified_content = stdout.read().decode()
        if verified_content.strip() == compose_content.strip():
            print(">>> Verification SUCCESS: File content matches.")
        else:
            print(">>> Verification FAILED: Content mismatch!")
            # print(verified_content)

        # Stop ALL possible conflicting containers
        print(">>> Cleaning up old containers...")
        ssh.exec_command(f'docker stop rizquna_app rizquna_db rizquna_tunnel cf-tunnel cf-tunnel-docker-cloudflared-1 2>/dev/null')
        ssh.exec_command(f'docker rm rizquna_app rizquna_db rizquna_tunnel cf-tunnel cf-tunnel-docker-cloudflared-1 2>/dev/null')

        # Start using docker compose
        print(">>> Starting containers with 'docker compose'...")
        stdin, stdout, stderr = ssh.exec_command(f'cd {REMOTE_PATH} && docker compose up -d')
        print(stdout.read().decode())
        print(stderr.read().decode())

        ssh.close()
        print(">>> Done.")
    except Exception as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    upload_and_restart()
