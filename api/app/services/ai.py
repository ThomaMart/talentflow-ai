import os

import requests

from app.services.skills import SkillClassifier
from app.services.score import ScoreService
from app.services.experience import ExperienceService

class AIService:

    def __init__(self):
        self.host = os.getenv(
            "OLLAMA_HOST",
            "http://localhost:11434"
        )

        self.model = "qwen2.5:3b"

    def analyze(self, text: str) -> dict:

        schema = {
            "type": "object",
            "properties": {
                "candidate": {
                    "type": "object",
                    "properties": {
                        "name": {"type": "string"},
                        "email": {"type": "string"},
                        "phone": {"type": "string"},
                        "location": {"type": "string"},
                        "linkedin": {"type": "string"}
                    }
                },
                "summary": {
                    "type": "string"
                },
                "experience_years": {
                    "type": "integer"
                },
                "seniority": {
                    "type": "string"
                },
                "skills": {
                    "type": "array",
                    "items": {
                        "type": "string"
                    }
                },
                "score": {
                    "type": "integer"
                }
            },
            "required": [
                "candidate",
                "summary",
                "experience_years",
                "seniority",
                "skills",
                "score"
            ]
        }

        prompt = f"""
You are a senior technical recruiter specialized in software engineering, DevOps, embedded systems and telecommunications.

Your task is to extract factual information from the resume.

Return ONLY valid JSON matching the schema.

Rules:

- Respond ONLY in French.
- Never invent information.
- Never use markdown.
- If information is missing, return an empty string.
- Extract only information explicitly present in the CV.

Candidate

Extract:

- full name
- email
- phone
- location
- linkedin

Professional summary

Write a concise executive summary (maximum 2 sentences).

The summary must highlight:

- years of experience
- main expertise
- technical domains
- level of responsibility

Skills

Return ONLY a flat array of technologies.

Example:

[
"Python",
"Docker",
"Linux",
"FastAPI",
"GitHub Actions"
]

Do NOT group skills.

Do NOT create categories.

Do NOT include soft skills.

Do NOT include project management.

Resume:

{text}
"""

        response = requests.post(
            f"{self.host}/api/generate",
            json={
                "model": self.model,
                "prompt": prompt,
                "stream": False,
                "format": schema
            },
            timeout=120
        )

        response.raise_for_status()

        import json

        ollama = response.json()

        result = json.loads(ollama["response"])

        result["skills"] = SkillClassifier.classify(
            result.get("skills", [])
        )

        # Calcul des années d'expérience à partir du CV
        result["experience_years"] = ExperienceService.compute(text)

        # Calcul du score
        result["score"] = ScoreService.compute(result)

        return result