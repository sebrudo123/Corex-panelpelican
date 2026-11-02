<p align="center">
  <img width="60%" src="public/corex-logo-horizontal.svg" alt="Corex Panel Logo">
</p>

# Corex Panel

**Next-Generation Game Server & Container Infrastructure Platform.**

Corex Panel is a high-performance, commercial-ready game server management and container orchestration platform engineered for hosting providers, gaming networks, and communities. Each instance runs inside isolated Docker containers with real-time resource quotas (cgroups v2), zero-swap memory isolation, and native multi-architecture support (**ARM64 & x86_64**).

---

## ⚡ Key Highlights

- **Multi-Architecture Native:** First-class support for Linux ARM64 (Ampere Altra, Apple Silicon Crostini, Graviton) and x86_64 dedicated nodes.
- **Modern Control Panel:** Powered by Laravel 11 and Filament Admin with rich dark-mode telemetry.
- **Docker-Isolated Engines:** Seamless deployment for Minecraft (Paper, Velocity, Purpur), FiveM (txAdmin / FXServer), Node.js, Python, and SteamCMD titles.
- **Granular Security:** RBAC with customizable roles, 2FA (TOTP + WebAuthn Passkeys), and per-server chroot jail SFTP.
- **Integrated Database Provisioning:** Automatic dedicated MariaDB / PostgreSQL database generation for tenant game servers.

---

## 🚀 Quick Setup with Docker

### Prerequisites
- Docker Engine 24.0+ and Docker Compose v2.20+
- Multi-arch support (`linux/amd64` or `linux/arm64`)

```bash
# Clone the repository
git clone https://github.com/sebrudo123/Corex-panelpelican.git corex-panel
cd corex-panel

# Copy environment configuration
cp .env.example .env

# Launch the stack
docker compose up -d
```

---

## 📄 License
Licensed under the GNU Affero General Public License v3.0 (AGPLv3).
