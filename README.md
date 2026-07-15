# 🚀 TalentFlow AI

<p align="center">

![Python](https://img.shields.io/badge/Python-3.12-blue?logo=python)
![FastAPI](https://img.shields.io/badge/FastAPI-0.115-009688?logo=fastapi)
![WordPress](https://img.shields.io/badge/WordPress-Plugin-21759B?logo=wordpress)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?logo=docker)
![MariaDB](https://img.shields.io/badge/MariaDB-11-003545?logo=mariadb)
![Ollama](https://img.shields.io/badge/Ollama-Local%20LLM-black)
![License](https://img.shields.io/badge/License-MIT-green)

</p>

<p align="center">

**AI-powered Resume Analysis Platform built with WordPress, FastAPI and Ollama**

Analyze resumes locally using a Large Language Model and provide structured candidate insights.

</p>

---

# ✨ Features

- 📄 Upload PDF resumes
- 🤖 AI-powered resume analysis
- 👤 Candidate profile extraction
- ⭐ Candidate scoring
- 🧠 Skills extraction
- 📋 Professional summary
- 🐳 Dockerized architecture
- 🔒 100% Local AI inference with Ollama

---

# 🏗 Architecture

```text
                +----------------------+
                |      WordPress       |
                | TalentFlow Plugin    |
                +----------+-----------+
                           |
                     REST API
                           |
                +----------v-----------+
                |       FastAPI        |
                | Business Logic API   |
                +----------+-----------+
                           |
                    Ollama REST API
                           |
                +----------v-----------+
                |       Ollama         |
                |      Local LLM       |
                +----------------------+
````

---

# ⚙️ Tech Stack

| Category       | Technologies                          |
| -------------- | ------------------------------------- |
| Backend        | Python, FastAPI                       |
| Frontend       | WordPress, PHP, HTML, CSS, JavaScript |
| AI             | Ollama, Qwen                          |
| Database       | MariaDB                               |
| Infrastructure | Docker, Docker Compose                |
| API            | REST                                  |

---

# 🚀 Quick Start

Clone the repository

```bash
git clone https://github.com/ThomaMart/talentflow-ai.git
cd talentflow-ai
```

Start the application

```bash
docker compose up -d
```

Open:

| Service      | URL                        |
| ------------ | -------------------------- |
| WordPress    | http://localhost:8080      |
| FastAPI Docs | http://localhost:8000/docs |

---

# 📂 Project Structure

```
talentflow-ai/
│
├── api/
│   ├── app/
│   └── uploads/
│
├── wordpress/
│   └── plugins/
│
├── docker-compose.yml
├── README.md
└── LICENSE
```

---

# 📸 Screenshots

Coming soon.

* Resume upload
* AI analysis
* Candidate summary
* Skills detection
* Compatibility analysis

---

# 🛣 Roadmap

## ✅ Version 1

* [x] Resume upload
* [x] AI analysis
* [x] Skills extraction
* [x] Candidate scoring
* [x] Professional summary

## 🚧 Version 2

* [ ] Resume ↔ Job description compatibility
* [ ] Matching score
* [ ] Missing skills detection
* [ ] AI recommendations

## 🔜 Version 3

* [ ] PDF report
* [ ] Analysis history
* [ ] Dashboard improvements

---

# 💡 Why TalentFlow AI?

TalentFlow AI is a portfolio project demonstrating practical experience with:

* FastAPI
* WordPress Plugin Development
* Docker
* REST APIs
* Local LLM Integration
* AI-powered automation
* Clean software architecture

---

# 📄 License

Distributed under the MIT License.