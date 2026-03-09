import paramiko
import sys

IP = '192.168.18.210'
USER = 'rizqunaid'
PASS = 'rizqunaid2026'
TOKEN = 'eyJhIjoiMGMyMmQzM2FmYjllOWI5NGMxNzdlYWQ0ZjlhOWZlNGYiLCJ0IjoiNTc3OTRmYmUtOGRhNC00ZjY3LTk5NTAtMmVkZDE1ZmIxNGFjIiwicyI6IlpqTmxNMkl4TWpVdE1UQmlNUzAwTURjNUxXRTRNMkl0WlRJeFkySm1OR0l4TVRZeCJ9'
REMOTE_PATH = '/home/rizqunaid/rizquna.id'

def main():
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(IP, username=USER, password=PASS)

    # 🐳 Definisi New Docker Compose
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
      - ./data/uploads:/var/www/html/wp-content/uploads
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
    # Write to server using cat
    print(">>> 📤 Updating docker-compose.yml on server...")
    # Escape quotes for shell
    content_escaped = compose_content.replace('"', '\\"')
    ssh.exec_command(f'printf "%b" "{compose_content}" > {REMOTE_PATH}/docker-compose.yml')

    print(">>> 🐳 Restarting Stack with Tunnel...")
    ssh.exec_command(f"cd {REMOTE_PATH} && docker-compose down && docker-compose up -d")

    print(">>> ✅ FULL FIX SELESAI!")
    print("Cek status di: https://rizquna.id")
    ssh.close()

if __name__ == "__main__":
    main()
