import os

import requests

from app.services.score import ScoreService
from app.services.experience import ExperienceService

class AIService:

    def __init__(self):
        self.host = os.getenv(
            "OLLAMA_HOST",
            "http://localhost:11434"
        )

        self.model = "qwen2.5:3b"

    def analyze(
    self,
    text: str,
    job_description: str = ""
) -> dict:

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
                },
                "compatibility": {
                    "type": "object",
                    "properties": {
                        "score": {
                            "type": "integer"
                        },
                        "matching_skills": {
                            "type": "array",
                            "items": {
                                "type": "string"
                            }
                        },
                        "missing_skills": {
                            "type": "array",
                            "items": {
                                "type": "string"
                            }
                        },
                        "strengths": {
                            "type": "array",
                            "items": {
                                "type": "string"
                            }
                        },
                        "recommendations": {
                            "type": "array",
                            "items": {
                                "type": "string"
                            }
                        }
                    }
                }


            },
            "required": [
                "candidate",
                "summary",
                "experience_years",
                "seniority",
                "skills",
                "score",
                "compatibility"
            ]
        }

        if job_description.strip():

            prompt = f"""
You are a senior technical recruiter specialized in IT, DevOps, Cloud and Software Engineering.

Your mission is to compare a candidate's resume with a job description.

Return ONLY valid JSON matching the provided schema.

Rules:

- Respond ONLY in French.
- Never invent information.
- Base your analysis ONLY on the resume and the job description.
- Keep recommendations concise.
- The compatibility score must be between 0 and 100.
- Matching skills must exist in both the CV and the job description.
- Missing skills must be required by the job description but absent from the CV.
- Strengths must explain why the candidate matches the position.
- Recommendations must explain how to improve compatibility.

Resume:

{text}

------------------------------------------------------------

Job Description:

{job_description}

------------------------------------------------------------

Return a JSON object containing:

candidate
- name
- email
- phone
- location
- linkedin

summary
- A professional summary (maximum 2 sentences)

experience_years

seniority

skills
- Flat list of technologies only.

score
- Global resume quality score (0-100)

compatibility
- score (0-100)
- matching_skills (array)
- missing_skills (array)
- strengths (array)
- recommendations (array)
"""

        else:

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

Return ONLY a flat array of professional skills.

Include:

- technologies
- programming languages
- frameworks
- software
- tools
- methodologies
- certifications
- business skills when relevant

Do not group skills.

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

        result["skills"] = sorted(
            set(result.get("skills", []))
        )

        # Calcul des années d'expérience à partir du CV
        result["experience_years"] = ExperienceService.compute(text)

        # Calcul du score
        result["score"] = ScoreService.compute(result)
        result.setdefault(
            "compatibility",
            {
                "score": 0,
                "matching_skills": [],
                "missing_skills": [],
                "strengths": [],
                "recommendations": []
            }
        )

        return result